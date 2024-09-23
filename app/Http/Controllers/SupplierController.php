<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\District;
use App\Models\Province;
use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function index(Request $request)
    {
        $userRoleId = auth()->user()->role_id;
        $query = Supplier::query();
        if ($request->has('branch_id')) {
            $query->where('branch_id', $request->input('branch_id'));
        } else {
            $query->with(['branches:id,name']);
        }
        $supplierList = $query->get();

        return view('pages.supplier.supplier-list', compact('supplierList', 'userRoleId'));
    }

    public function store(Request $request)
    {
        Supplier::create([
            'branch_id' => $request['branch'],
            'name' => $request['name'],
            'address' => $request['address'],
            'phone' => $request['phone'],
            'email' => $request['email'],
            'province' => $request['province'],
            'district' => $request['district'],
        ]);

        return back()->with('success', 'Supplier created successfully');

    }

    public function create()
    {
        $provinces = Province::all();
        $districts = District::all();
        $branches = Branch::get();

        return view('pages.supplier.create-supplier', compact('provinces', 'districts', 'branches'));
    }

    public function edit($id)
    {
        $supplier = Supplier::find($id);
        $provinces = Province::all();
        $districts = District::all();

        return view('pages.supplier.edit-supplier', compact('supplier', 'provinces', 'districts'));
    }

    public function update($id, Request $request)
    {
        $supplier = Supplier::find($id);
        $supplier->update([
            'name' => $request['name'],
            'address' => $request['address'],
            'phone' => $request['phone'],
            'email' => $request['email'],
            'province' => $request['province'],
            'district' => $request['district'],
        ]);

        return back()->with('success', 'Supplier updated successfully');
    }

    public function destroy($id)
    {
        $supplier = Supplier::find($id);
        $supplier->delete();

        return response()->json(['success', 'Supplier deleted successfully']);

    }
}
