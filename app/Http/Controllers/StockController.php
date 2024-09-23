<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Category;
use App\Models\Item;
use App\Models\Stock;
use App\Models\StockItem;
use App\Models\Supplier;
use App\Models\TempStock;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StockController extends Controller
{
    public function index()
    {
        $stockList = Stock::with(['supplier:id,name', 'branches:id,name', 'stockItem' => function ($query) {
            $query->select('stock_id', DB::raw("GROUP_CONCAT(items.name SEPARATOR ', ') as item_names"))
                ->join('items', 'items.id', '=', 'stock_items.item_id') // Join items table
                ->groupBy('stock_items.stock_id'); // Group by stock_id to concatenate item names related to the stock
        }])->get();

        return view('pages.stock.stock-list', compact('stockList'));
    }

    public function getItem($id)
    {
        $item = Item::where('category_id', $id)->get();

        return response()->json($item);
    }

    public function getSubTotal($id)
    {
        $item = Item::where('id', $id)->first();

        return response()->json($item->purchase_cost);
    }

    public function addTempStock(Request $request)
    {
        $items = Item::where('id', $request->item_id)->first();
        $category = Category::where('id', $request->category_id)->first();
        $allCategory = Category::toBase()->get()->toArray();
        $cost = $items->purchase_cost;
        $discount = 0;
        if (! empty($request->discount)) {
            $discount = $request->discount;
        }
        $total_cost = ($cost * $request->quantity) - $discount;
        $subTotal = 0;
        $tempStock = TempStock::toBase()->get();
        foreach ($tempStock as $key => $value) {
            $subTotal += $value->total_cost;
        }
        $stock = TempStock::create([
            'branch_id' => intval($request->branch),
            'category_id' => $request->category_id,
            'item_id' => $request->item_id,
            'quantity' => $request->quantity,
            'cost' => $cost,
            'discount' => $request->discount,
            'total_cost' => $total_cost,
        ]);

        return [
            'category' => $category->name,
            'item' => $items->name,
            'quantity' => $stock->quantity,
            'cost' => number_format($stock->cost, 2),
            'discount' => number_format($stock->discount, 2),
            'total_cost' => number_format($stock->total_cost, 2),
            'sub_total' => number_format($subTotal + $stock->total_cost, 2),
            'id' => $stock->id,
            'all_category' => $allCategory,
        ];

    }

    public function create()
    {
        $supplierList = Supplier::toBase()->get();
        $categoryList = Category::toBase()->get();
        $itemList = Item::toBase()->get();
        $branches = Branch::get();

        //        $stock = $this->getStock();

        return view('pages.stock.create-stock', compact('supplierList', 'branches', 'categoryList', 'itemList'));
    }

    public function getStock($branch_id)
    {
        $branchId = $branch_id;
        $tempStockList = TempStock::where('branch_id', $branchId)->get();
        $categories = Category::where('branch_id', $branchId)->get();
        $stock = [];
        $subTotal = 0;
        foreach ($tempStockList as $tempStock) {
            $category = Category::where('id', $tempStock->category_id)->first();
            $item = Item::where('id', $tempStock->item_id)->first();
            $subTotal += $tempStock->total_cost;
            $temp['category'] = $category?->name;
            $temp['item'] = $item?->name;
            $temp['quantity'] = $tempStock->quantity;
            $temp['cost'] = number_format($tempStock->cost, 2);
            $temp['discount'] = number_format($tempStock->discount, 2);
            $temp['total_cost'] = number_format($tempStock->total_cost, 2);
            $temp['sub_total'] = number_format($subTotal, 2);
            $temp['id'] = $tempStock->id;

            array_push($stock, $temp);

        }

        return response()->json(['categories' => $categories, 'stock' => $stock]);
        //        return $stock;
    }

    public function deleteTempStock()
    {
        TempStock::truncate();

        return true;
    }

    public function deleteItem($id)
    {
        $tempItem = TempStock::all();
        $subTotal = 0;
        foreach ($tempItem as $key => $value) {
            $subTotal += $value->total_cost;
        }
        $item = TempStock::find($id);
        $subTotal = $subTotal - $item->total_cost;
        $item->delete();

        return number_format($subTotal, 2);
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $tempStock = TempStock::get();
            $subTotal = TempStock::sum('total_cost');
            $final_total = $subTotal - $request->discount;
            //add data to stock table
            $stock = Stock::create([
                'branch_id' => $request->branch,
                'stock_no' => $request->purchase_order_no,
                'supplier_id' => $request->supplier,
                'build_date' => $request->build_date,
                'sub_total' => $subTotal,
                'discount' => $request->discount,
                'branch' => $request->branch,
                'final_total' => $final_total,
            ]);
            foreach ($tempStock as $temp) {
                $stocks = new StockItem;
                $stocks->category_id = $temp->category_id;
                $stocks->stock_id = $stock->id;
                $stocks->item_id = $temp->item_id;
                $stocks->discount = $temp->discount;
                $stocks->quantity = $temp->quantity;
                $stocks->cost = $temp->cost;
                $stocks->total = $temp->total_cost;
                $stocks->save();
                $temp->delete();
            }

            DB::commit();

            return response()->json(['success', 'Stock added successfully']);
        } catch (Exception $e) {
            DB::rollBack();
            dd($e->getMessage());

            return back()->with('error', 'Something went wrong');

        }

    }
}
