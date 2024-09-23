<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Customer;
use App\Models\District;
use App\Models\Province;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $userRoleId = auth()->user()->role_id;

        $query = Customer::query();
        if ($request->has('branch_id')) {
            $query->where('branch_id', $request->input('branch_id'));
        } else {
            $query->with(['branches:id,name']);
        }
        $customerList = $query->get();

        return view('pages.customer.customer-list', compact('customerList', 'userRoleId'));
    }

    public function store(Request $request)
    {
        $userRole = auth()->user()->role_id;
        if ($userRole == 1) {
            $branchId = $request['branch'];
        } else {
            $branchId = auth()->user()->branch_id;
        }
        $customer = Customer::create([
            'branch_id' => $branchId,
            'first_name' => $request['first_name'],
            'last_name' => $request['last_name'],
            'email' => $request['email'],
            'nic' => $request['nic'],
            'phone' => $request['phone'],
            'address' => $request['address'],
            'province' => $request['province'],
            'district' => $request['district'],
        ]);

        return response()->json(['customer' => $customer]);
        //        return back()->with('success', 'Customer created successfully');

    }

    public function create()
    {
        $customerList = Customer::toBase()->get();
        $provinces = Province::all();
        $districts = District::all();
        $branches = Branch::get();

        return view('pages.customer.create-customer', compact('provinces', 'branches', 'customerList', 'districts'));
    }

    public function edit($id)
    {
        $customer = Customer::find($id);
        $provinces = Province::all();
        $districts = District::all();

        return view('pages.customer.edit-customer', compact('customer', 'provinces', 'districts'));
    }

    public function update($id, Request $request)
    {
        $customer = Customer::find($id);
        $customer->update([
            'first_name' => $request['first_name'],
            'last_name' => $request['last_name'],
            'email' => $request['email'],
            'nic' => $request['nic'],
            'phone' => $request['phone'],
            'address' => $request['address'],
            'province' => $request['province'],
            'district' => $request['district'],
        ]);

        return back()->with('success', 'Customer updated successfully');

    }

    public function destroy($id)
    {
        $customer = Customer::find($id);
        $customer->delete();

        return response()->json(['success', 'Customer deleted successfully']);

    }
}
