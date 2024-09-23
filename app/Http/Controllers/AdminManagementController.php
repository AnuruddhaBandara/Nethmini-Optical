<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\updateUserRequest;
use App\Models\Branch;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class AdminManagementController extends Controller
{
    public function index()
    {
        $users = User::with(['rolesData', 'branch'])->get();

        return view('pages.admin-management.admin-list', compact('users'));
    }

    public function create()
    {
        $branches = DB::table('branches')->get();
        $roles = Role::all();

        return view('pages.admin-management.create-admin', compact('branches', 'roles'));
    }

    public function store(CreateUserRequest $request)
    {
        $userDetails = new User([
            'name' => $request['first_name'] ?? '',
            'first_name' => $request['first_name'] ?? '',
            'last_name' => $request['last_name'] ?? '',
            'phone' => $request['phone'] ?? '',
            'email' => $request['email'] ?? '',
            'password' => Hash::make($request['password']),
            'role_id' => $request['role_id'] ?? '',
            'branch_id' => $request['branch'],
            'status' => 1,
        ]);
        $userDetails->save();
        $userDetails->assignRole($request['role_id']);

        return back()->with('success', 'Successfully added!');
    }

    public function edit($id)
    {
        $user = User::find($id);
        $branches = Branch::get();
        $roles = Role::all();
        $selectRoles = Role::where('id', $user->role_id)->first();
        $selectBranch = Branch::where('id', $user->branch_id)->first();

        return view('pages.admin-management.edit-admin', compact('user', 'roles', 'branches', 'selectRoles', 'selectBranch'));
    }

    public function update(updateUserRequest $request, $id)
    {
        $user = User::find($id);
        $user->update([
            'name' => $request['first_name'] ?? '',
            'first_name' => $request['first_name'] ?? '',
            'last_name' => $request['last_name'] ?? '',
            'phone' => $request['phone'] ?? '',
            'email' => $request['email'] ?? '',
            'role_id' => $request['role_id'] ?? '',
            'branch_id' => $request['branch'],
            'status' => $request['status'] ?? 0,
            'password' => Hash::make($request['password']),
        ]);

        return back()->with('success', 'Successfully added!');

    }
}
