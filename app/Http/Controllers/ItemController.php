<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Category;
use App\Models\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function index(Request $request)
    {
        $userRoleId = auth()->user()->role_id;

        $query = Item::query();
        if ($request->has('branch_id')) {
            $query->where('branch_id', $request->input('branch_id'));
        } else {
            $query->with(['branches:id,name']);
        }
        $itemList = $query->get();

        return view('pages.item.item-list', compact('itemList', 'userRoleId'));
    }

    public function store(Request $request)
    {
        $userRole = auth()->user()->role_id;
        if ($userRole == 1) {
            $branchId = $request['branch'];
        } else {
            $branchId = auth()->user()->branch_id;
        }
        $item = Item::create([
            'branch_id' => $branchId,
            'category_id' => $request->category_id,
            'name' => $request->name,
            'purchase_cost' => $request->purchase_cost,
            'selling_price' => $request->selling_price,
            'brand' => $request->brand ?? '',
            'color' => $request->color ?? '',
            'description' => $request->description ?? '',

        ]);
        if ($request->hasFile('file')) {
            $imageName = time().'-'.uniqid().'.'.$request->file->extension();
            $request->file->move(public_path('uploads/item_image'), $imageName);

            $item->image = $imageName;
            $item->save();
        }

        return back()->with('success', 'Item created successfully');
    }

    public function create(Request $request)
    {
        $categoryList = Category::query();
        if ($request->has('branch_id')) {
            $categoryList = Category::where('branch_id', $request->input('branch_id'));
        }
        $categoryList = $categoryList->get();
        $branches = Branch::get();

        return view('pages.item.create-item', compact('categoryList', 'branches'));
    }

    public function edit($id)
    {
        $item = Item::find($id);
        $selectedCategory = Category::where('id', $item->category_id)->first();
        $categoryList = Category::all();

        return view('pages.item.edit-item', compact('item', 'categoryList', 'selectedCategory'));
    }

    public function update(Request $request, $id)
    {
        $item = Item::find($id);
        $item->update([
            'category_id' => $request->category_id,
            'name' => $request->name,
            'purchase_cost' => $request->purchase_cost,
            'selling_price' => $request->selling_price,
            'brand' => $request->brand ?? '',
            'color' => $request->color ?? '',
            'description' => $request->description ?? '',

        ]);
        if ($request->hasFile('file')) {
            $imageName = time().'-'.uniqid().'.'.$request->file->extension();
            $request->file->move(public_path('uploads/item_image'), $imageName);
            $item->image = $imageName;
            $item->save();
        }

        return back()->with('success', 'Item updated successfully');
    }

    public function destroy($id)
    {
        $item = Item::find($id);
        $item->delete();

        return response()->json(['success', 'Item deleted successfully']);

    }

    public function getCategoriesByBranch($branchId)
    {
        $categories = Category::where('branch_id', $branchId)->get();

        return response()->json($categories);
    }
}
