<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $userRoleId = auth()->user()->role_id;

        $query = Category::query();
        if ($request->has('branch_id')) {
            $query->where('branch_id', $request->input('branch_id'));
        } else {
            $query->with(['branches:id,name']);
        }

        $categoryList = $query->get();

        return view('pages.category.category-list', compact('categoryList', 'userRoleId'));
    }

    public function edit($id)
    {
        $category = Category::find($id);

        return view('pages.category.edit-category', compact('category'));
    }

    public function store(Request $request)
    {
        $userRole = auth()->user()->role_id;
        if ($userRole == 1) {
            $branchId = $request['branch'];
        } else {
            $branchId = auth()->user()->branch_id;
        }

        Category::create([
            'branch_id' => $branchId,
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return back()->with('success', 'Category created successfully');
    }

    public function create()
    {
        $branches = Branch::get();

        return view('pages.category.create-category', compact('branches'));
    }

    public function update(Request $request, $id)
    {
        $category = Category::find($id);
        $category->update([
            'name' => $request->name,
            'description' => $request->description ?? '',
        ]);

        return back()->with('success', 'Category updated successfully');
    }

    public function destroy($id)
    {
        $category = Category::find($id);
        $category->delete();

        return response()->json(['success', 'Category deleted successfully']);
    }
}
