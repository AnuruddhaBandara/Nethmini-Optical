<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Category;
use App\Models\Customer;
use App\Models\District;
use App\Models\InstallmentPayment;
use App\Models\Item;
use App\Models\LensDetail;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Province;
use App\Models\StockItem;
use App\Models\TempOrder;
use Barryvdh\DomPDF\Facade\Pdf;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $userRoleId = auth()->user()->role_id;

        $orderList = Order::with(['customer:id,first_name,last_name,email,phone,nic', 'branches:id,name', 'orderItem' => function ($query) {
            $query->select('order_id', DB::raw("GROUP_CONCAT(items.name SEPARATOR ', ') as item_names"))
                ->join('items', 'items.id', '=', 'order_items.item_id') // Join items table
                ->groupBy('order_items.order_id');
        }]);
        if ($request->has('branch_id')) {
            $orderList->where('branch_id', $request->branch_id);
        }
        $orderList = $orderList->get();

        return view('pages.order.order-list', compact('orderList', 'userRoleId'));
    }

    public function addLensFee(Request $request)
    {
        $userRole = auth()->user()->role_id;
        if ($userRole == 1) {
            $branchId = $request['branch'];
        } else {
            $branchId = auth()->user()->branch_id;
        }
        $tempOrders = TempOrder::where('branch_id', $branchId)->get();
        $orders = [];
        $subTotal = 0;
        if (! empty($tempOrders)) {
            foreach ($tempOrders as $key => $value) {
                $subTotal += $value['total_sale_price'];
                $orders[] = [
                    'category_id' => $value->category_id,
                    'item_id' => $value->item_id,
                    'quantity' => $value->quantity,
                    'sale_price' => $value->sale_price,
                    'discount' => $value->discount,
                    'total_sale_price' => $value->total_sale_price,
                ];
            }
        }
        //branch id

        $lensDetails = LensDetail::create([
            'lens_name' => $request->lens_detail,
            'lens_price' => $request->lens_fee,
            'quantity' => $request->quantity,
            'discount' => $request->lens_discount,
            'lens_cost' => $request->lens_cost,
            'branch_id' => $branchId,
            'is_draft' => 0,

        ]);
        $lens = LensDetail::whereNull('order_id')->where('branch_id', $branchId)->get();
        foreach ($lens as $key => $value) {
            $lensTotal = ($value->lens_price * $value->quantity) - $value->discount;
            $subTotal += $lensTotal;
        }

        return [
            'lens_name' => $lensDetails->lens_name,
            'lens_price' => number_format($lensDetails->lens_price, 2),
            'discount' => number_format($lensDetails->discount, 2),
            'lens_id' => $lensDetails->id,
            'lens_quantity' => $lensDetails->quantity,
            'lens_total' => number_format(($lensDetails->lens_price * $lensDetails->quantity) - $lensDetails->discount, 2),
            'temp_orders' => $orders,
            'sub_total' => number_format($subTotal, 2),
        ];

    }

    public function create(Request $request)
    {
        $customerList = Customer::query();
        $categoryList = Category::query();
        $itemList = Item::query();
        $branchId = auth()->user()->branch_id;
        if ($request->has('branch_id')) {
            $customerList->where('branch_id', $request->input('branch_id'));
            $categoryList->where('branch_id', $request->input('branch_id'));
            $itemList->where('branch_id', $request->input('branch_id'));
        } else {
            $categoryList->where('branch_id', $branchId);

        }

        $customerList = $customerList->get();
        $categoryList = $categoryList->get();
        $itemList = $itemList->get();
        $provinces = Province::toBase()->get();
        $districts = District::toBase()->get();
        $branches = Branch::get();
        $userRole = auth()->user()->role_id;

        return view('pages.order.create-order', compact('userRole', 'branchId', 'customerList', 'branches', 'categoryList', 'itemList', 'provinces', 'districts'));
    }

    public function addTempOrders(Request $request)
    {
        //branch id
        $userRole = auth()->user()->role_id;
        if ($userRole == 1) {
            $branchId = $request['branch'];
        } else {
            $branchId = auth()->user()->branch_id;
        }
        $items = Item::where(['id' => $request->item_id, 'branch_id' => $branchId])->first();
        $category = Category::where('id', $request->category_id)->first();
        $allCategory = Category::toBase()->get()->toArray();
        $salePrice = $items->selling_price;
        $discount = 0;
        if (! empty($request->discount)) {
            $discount = $request->discount;
        }
        $totalSalePrice = ($salePrice * $request->quantity) - $discount;
        $subTotal = 0;
        $tempOrder = TempOrder::where('branch_id', $branchId)->get();
        foreach ($tempOrder as $key => $value) {
            $subTotal += $value->total_sale_price;
        }

        $order = TempOrder::create([
            'branch_id' => $branchId,
            'category_id' => $request->category_id,
            'item_id' => $request->item_id,
            'quantity' => $request->quantity,
            'sale_price' => $salePrice,
            'discount' => $request->discount ?? 0.00,
            'total_sale_price' => $totalSalePrice,
        ]);
        $lensDetails = LensDetail::whereNull('order_id')->where('branch_id', $branchId)->get();
        $details = [];
        $lensSubTotal = 0;
        foreach ($lensDetails as $key => $value) {
            $lensSubTotal += ($value->lens_price * $value->quantity) - $value->discount;
            $details[] = [
                'id' => $value->id,
                'lens_name' => $value->lens_name,
                'lens_price' => $value->lens_price,
                'discount' => $value->discount,
                'lens_quantity' => $value->quantity,
                'lens_total' => number_format(($value->lens_price * $value->quantity) - $value->discount, 2),
            ];
        }

        return [
            'category' => $category->name,
            'item' => $items->name,
            'quantity' => $order->quantity,
            'cost' => number_format($order->sale_price, 2),
            'discount' => number_format($order->discount, 2),
            'total_cost' => number_format($order->total_sale_price, 2),
            'sub_total' => number_format($subTotal + $order->total_sale_price + $lensSubTotal, 2),
            'id' => $order->id,
            'all_category' => $allCategory,
            'lens_details' => $details,
        ];
    }

    public function getOrderDetails($branchId)
    {
        $categories = Category::where('branch_id', $branchId)->get();
        $order = TempOrder::where('branch_id', $branchId)->get();
        $lensDetails = LensDetail::whereNull('order_id')->where('branch_id', $branchId)->get();
        $subTotal = 0;
        $details = [];
        if (! empty($lensDetails)) {
            foreach ($lensDetails as $key => $value) {
                $subTotal += ($value->lens_price * $value->quantity) - $value->discount;
                $details[] = [
                    'id' => $value->id,
                    'lens_name' => $value->lens_name,
                    'lens_price' => $value->lens_price,
                    'lens_quantity' => $value->quantity,
                    'discount' => $value->discount,
                    'lens_total' => number_format(($value->lens_price * $value->quantity) - $value->discount, 2),
                ];

            }

        }
        $orders = [];
        if (! empty($order)) {
            foreach ($order as $key => $value) {
                $items = Item::where('id', $value->item_id)->first();
                $category = Category::where('id', $value->category_id)->first();
                $subTotal += $value['total_sale_price'];
                $orders[] = [
                    'category' => $category->name,
                    'item' => $items->name,
                    'quantity' => $value->quantity,
                    'sale_price' => $value->sale_price,
                    'discount' => $value->discount,
                    'total_sale_price' => $value->total_sale_price,
                    'id' => $value->id,
                ];
            }

        }

        return [
            'temp_orders' => $orders,
            'sub_total' => number_format($subTotal, 2),
            'lens_details' => $details,
            'categories' => $categories,
        ];
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $userRole = auth()->user()->role_id;
            if ($userRole == 1) {
                $branchId = $request['branch'];
            } else {
                $branchId = auth()->user()->branch_id;
            }

            $order = Order::create([
                'invoice_number' => $this->generateInvoiceNumber(),
                'branch_id' => $branchId,
                'customer_id' => $request->customer,
                'discount' => $request->discount,
                'final_total' => $request->finalTotal,
                'sub_total' => $request->subTotal,
                'payment_received' => $request->paymentReceived,
                'remaining_payment' => $request->remainingPayment,
                'payment_method' => $request->paymentMethod,
                'remark' => $request->remark,
                'status' => 1,

            ]);

            $orderItems = TempOrder::where('branch_id', $request->branch)->get();
            foreach ($orderItems as $key => $value) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'category_id' => $value->category_id,
                    'item_id' => $value->item_id,
                    'quantity' => $value->quantity,
                    'sale_price' => $value->sale_price,
                    'discount' => $value->discount,
                    'total' => $value->total_sale_price,
                ]);
                $value->delete();
            }

            $lensDetails = LensDetail::whereNull('order_id')->where('branch_id', $request->branch)->get();
            foreach ($lensDetails as $key => $value) {
                $value->update([
                    'order_id' => $order->id,
                ]);
            }

            DB::commit();

            return response()->json(['success', 'Order created successfully']);
        } catch (Exception $e) {
            DB::rollBack();
            dd($e->getMessage());
        }

    }

    public function generateInvoiceNumber()
    {
        // Get the latest order
        $latestOrder = Order::latest()->first();

        // Set the starting invoice number, e.g., 'INV0001'
        if (! $latestOrder) {
            return 'INV0001';
        }

        // Extract the number part of the last invoice number (remove "INV")
        $lastInvoiceNumber = intval(substr($latestOrder->invoice_number, 3));

        // Increment the number and format it with leading zeros
        return 'INV'.str_pad($lastInvoiceNumber + 1, 4, '0', STR_PAD_LEFT);
    }

    public function update(Request $request, $id)
    {
        $order = Order::find($id);
        if (! $order) {
            return response()->json(['success' => false, 'message' => 'Order not found'], 404);
        }

        $order->status = $request->status;
        $order->save();

        return response()->json(['success' => true, 'message' => 'Status updated successfully']);
    }

    public function view($id)
    {
        $orderDetails = Order::with(['branches:id,name', 'customer:id,first_name,last_name,email,phone,nic'])
            ->where('id', $id)
            ->first();
        $orderItems = OrderItem::with(['category:id,name', 'items:id,name'])->where('order_id', $id)->get();
        $lensDetails = LensDetail::where('order_id', $id)->get();
        $invoiceType = DB::table('invoices')->get();

        return view('pages.order.view-order', compact('invoiceType', 'orderItems', 'orderDetails', 'lensDetails'));
    }

    public function edit($id)
    {
        $orderDetails = Order::with(['branches:id,name', 'customer:id,first_name,last_name,email,phone,nic'])
            ->where('id', $id)
            ->first();
        $orderItems = OrderItem::with(['category:id,name', 'items:id,name'])->where('order_id', $id)->get();
        $lensDetails = LensDetail::where('order_id', $id)->get();

        $orderStatus = DB::table('order_status')->get();

        return view('pages.order.edit-order', compact('id', 'orderStatus', 'orderItems', 'orderDetails', 'lensDetails'));
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            $order = Order::find($id);

            if (! empty($order)) {
                $orderItem = OrderItem::where('order_id', $id)->get();
                if (! empty($orderItem)) {
                    foreach ($orderItem as $item) {
                        $item->delete();
                    }
                }
                $lensDetail = LensDetail::where('order_id', $id)->delete();
                if (! empty($lensDetail)) {
                    foreach ($lensDetail as $lens) {
                        $lens->delete();
                    }
                }
                $order->delete();
                DB::commit();

                return response()->json(['success', 'Order deleted successfully']);
            }

        } catch (Exception $e) {
            DB::rollBack();
            dd($e->getMessage());
        }
    }

    public function deleteItem($id, $type)
    {
        $lensSubTotal = 0;
        $itemSubTotal = 0;
        if ($type == 'lens') {
            $lensDetail = LensDetail::find($id);
            $lensDetails = LensDetail::whereNull('order_id')->where('branch_id', $lensDetail->branch_id)->get();

            foreach ($lensDetails as $key => $value) {
                $lensTotal = ($value['lens_price'] * $value['quantity']) - $value['discount'];
                $lensSubTotal += $lensTotal;
            }
            $tempItem = TempOrder::where('branch_id', $lensDetail->branch_id)->get();
            foreach ($tempItem as $key => $value) {
                $itemSubTotal += $value->total_sale_price;
            }
            $total = ($lensDetail->lens_price * $lensDetails->quantity) - $lensDetail->discount;
            $subTotal = ($lensSubTotal + $itemSubTotal) - $total;
            $lensDetail->delete();
        } else {
            $item = TempOrder::find($id);
            $tempItem = TempOrder::where('branch_id', $item->branch_id)->get();
            foreach ($tempItem as $key => $value) {
                $itemSubTotal += $value->total_sale_price;
            }
            $lensDetails = LensDetail::whereNull('order_id')->where('branch_id', $item->branch_id)->get();

            foreach ($lensDetails as $key => $value) {
                $lensTotal = ($value['lens_price'] * $value['quantity']) - $value['discount'];
                $lensSubTotal += $lensTotal;
            }
            $total = $item->total_sale_price;
            $subTotal = ($lensSubTotal + $itemSubTotal) - $total;
            $item->delete();
        }

        return number_format($subTotal, 2);
    }

    public function deleteTempOrder($branchId, Request $request)
    {
        if ($request->has('branch_id')) {
            $branch_idd = $request->branch_id;
        } else {
            $branch_idd = $branchId;
        }
        TempOrder::where('branch_id', $branch_idd)->delete();
        LensDetail::where('branch_id', $branch_idd)->whereNull('order_id')->delete();

        return back()->with('success', 'Order deleted successfully');
    }

    public function addPaymentBalance($id, Request $request)
    {
        $order = Order::find($id);
        if (! empty($order)) {
            InstallmentPayment::create([
                'order_id' => $order->id,
                'amount' => $request->paymentAmount,
                'payment_date' => $request->paymentDate,
            ]);
            $order->update([
                'remaining_payment' => $order->remaining_payment - $request->paymentAmount,
                'payment_received' => $order->payment_received + $request->paymentAmount,
            ]);

            return response()->json(['success' => true, 'message' => 'balance payment updated successfully']);
        }

        return response()->json(['error' => true, 'message' => 'Something went wrong']);

    }

    public function downloadInvoice(Request $request)
    {
        $invoiceId = $request->input('invoice_id'); //invoice type id
        $orderId = $request->input('order_id');
        $order = Order::find($orderId);
        $orderItem = OrderItem::with(['items:id,name'])->where('order_id', $orderId)->get();
        $customerDetails = Customer::where('id', $order->customer_id)->first();
        $lensDetails = LensDetail::where('order_id', $orderId)->get();
        $pdf = Pdf::loadView('pdf.half-payment-invoice', compact('order', 'lensDetails', 'orderItem', 'customerDetails'));

        return $pdf->download($order->invoice_number.'.pdf')
            ->header('Content-Type', 'application/pdf');
    }

    public function checkStockAvailability($itemId)
    {
        $soldDataQuery = OrderItem::select('item_id', DB::raw('SUM(quantity) as stock_out'))
            ->join('orders', 'orders.id', '=', 'order_items.order_id')
            ->where('item_id', $itemId)
            ->groupBy('item_id')->first();
        //        dd($soldDataQuery);

        $stockDataQuery = StockItem::select('item_id', DB::raw('SUM(quantity) as stock_in'))
            ->join('stocks', 'stocks.id', '=', 'stock_items.stock_id')
            ->where('item_id', $itemId)
            ->groupBy('item_id')->first();

        $soldOut = $soldDataQuery->stock_out ?? 0;
        $stockIn = $stockDataQuery->stock_in ?? 0;
        $stockAvailable = intval($stockIn) - intval($soldOut);

        return $stockAvailable;

    }
}
