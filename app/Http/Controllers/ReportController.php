<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\LensDetail;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Stock;
use App\Models\StockItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index() {}

    public function getAllSales(Request $request)
    {
        $branches = Branch::all();
        // Filter by branch, date range, etc., from request inputs
        $branchId = $request->input('branch_id');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        // Query Orders with optional filters
        $orders = Order::with('customer', 'branch')
            ->when($branchId, function ($query, $branchId) {
                return $query->where('branch_id', $branchId);
            })
            ->when($startDate && $endDate, function ($query) use ($startDate, $endDate) {
                return $query->whereBetween('created_at', [$startDate, $endDate]);
            })
            ->get();
        // Total sales
        $totalSales = $orders->sum('final_total');
        // Total discount
        $totalDiscount = $orders->sum('discount');
        // Total payment received
        $totalPaymentReceived = $orders->sum('payment_received');
        // Remaining payments
        $totalRemainingPayments = $orders->sum('remaining_payment');

        // Pass data to the view
        return view('pages.report.sale-report', [
            'orders' => $orders,
            'totalSales' => $totalSales,
            'totalDiscount' => $totalDiscount,
            'totalPaymentReceived' => $totalPaymentReceived,
            'totalRemainingPayments' => $totalRemainingPayments,
            'branchId' => $branchId,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'branches' => $branches,
        ]);
    }

    public function getInventoryReport(Request $request)
    {
        // Filter by branch, date range, etc., from request inputs
        $branchId = $request->input('branch_id');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        // Query Stocks with optional filters
        $stocks = Stock::with(['branches', 'supplier', 'stockItems'])
            ->when($branchId, function ($query, $branchId) {
                return $query->where('branch_id', $branchId);
            })
            ->when($startDate && $endDate, function ($query) use ($startDate, $endDate) {
                return $query->whereBetween('created_at', [$startDate, $endDate]);
            })
            ->get();

        // Total inventory value (sum of all stock totals)
        $totalInventoryValue = $stocks->sum('final_total');
        $branches = Branch::all();

        // Pass data to the view
        return view('pages.report.inventory-report', [
            'stocks' => $stocks,
            'totalInventoryValue' => $totalInventoryValue,
            'branchId' => $branchId,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'branches' => $branches,
        ]);
    }

    public function getStockManagementReport(Request $request)
    {
        $branchId = $request->get('branch_id', 0);
        $stockDataQuery = StockItem::select('item_id', DB::raw('SUM(quantity) as stock_in'))
            ->join('stocks', 'stocks.id', '=', 'stock_items.stock_id');

        // If a specific branch is selected, filter by branch_id
        if ($branchId != 0) {
            $stockDataQuery->where('stocks.branch_id', $branchId);
        }

        $stockData = $stockDataQuery->groupBy('item_id')->get();

        // Fetch sold items (order items), with optional branch filter
        $soldDataQuery = OrderItem::select('item_id', DB::raw('SUM(quantity) as stock_out'))
            ->join('orders', 'orders.id', '=', 'order_items.order_id');

        if ($branchId != 0) {
            $soldDataQuery->where('orders.branch_id', $branchId);
        }

        $soldData = $soldDataQuery->groupBy('item_id')->get();

        // Map the sold data by item_id for easier comparison
        $soldMap = $soldData->keyBy('item_id');
        // Calculate available stock
        $availableStock = $stockData->map(function ($stock) use ($soldMap) {
            $stockOut = $soldMap->get($stock->item_id)->stock_out ?? 0;
            $stock->available_stock = $stock->stock_in - $stockOut;

            return $stock;
        });
        $branches = Branch::all();

        return view('pages.report.stock-management-report', [
            'availableStock' => $availableStock,
            'soldMap' => $soldMap,
            'branches' => $branches,
            'branchId' => $branchId,
        ]);
    }

    public function profitLossReport(Request $request)
    {
        // Get optional filters from request (e.g., by branch or date range)
        $branchId = $request->input('branch_id');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        // Get total revenue, costs, and discounts from items
        $itemFinancials = OrderItem::select(
            DB::raw('SUM(order_items.sale_price * order_items.quantity) as total_revenue'),
            DB::raw('SUM(items.purchase_cost * order_items.quantity) as total_cost'),
            DB::raw('SUM(order_items.discount) as total_discount')
        )
            ->join('items', 'order_items.item_id', '=', 'items.id')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->when($branchId, function ($query, $branchId) {
                return $query->where('orders.branch_id', $branchId);
            })
            ->when($startDate && $endDate, function ($query) use ($startDate, $endDate) {
                return $query->whereBetween('orders.created_at', [$startDate, $endDate]);
            })
            ->first();

        // Get total revenue, costs, and discounts from lenses
        $lensFinancials = LensDetail::select(
            DB::raw('SUM(lens_price * quantity) as total_revenue'),
            DB::raw('SUM(lens_cost * quantity) as total_cost'),
            DB::raw('SUM(lens_details.discount) as total_discount')
        )
            ->join('orders', 'lens_details.order_id', '=', 'orders.id')
            ->when($branchId, function ($query, $branchId) {
                return $query->where('orders.branch_id', $branchId);
            })
            ->when($startDate && $endDate, function ($query) use ($startDate, $endDate) {
                return $query->whereBetween('orders.created_at', [$startDate, $endDate]);
            })
            ->first();

        // Total Financials (Items + Lenses)
        $totalRevenue = $itemFinancials->total_revenue + $lensFinancials->total_revenue;
        $totalCost = $itemFinancials->total_cost + $lensFinancials->total_cost;
        $totalDiscount = $itemFinancials->total_discount + $lensFinancials->total_discount;
        $totalProfit = $totalRevenue - $totalCost;
        $branches = Branch::all();

        // Pass data to the view
        return view('pages.report.profit-loss-report', [
            'totalRevenue' => $totalRevenue,
            'totalCost' => $totalCost,
            'totalProfit' => $totalProfit,
            'totalDiscount' => $totalDiscount,
            'branchId' => $branchId,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'branches' => $branches,
        ]);

    }
}
