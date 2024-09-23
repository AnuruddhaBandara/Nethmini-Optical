<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class createViewPermission extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Permission::create(['name' => 'view_category', 'guard_name' => 'web']);
        Permission::create(['name' => 'view_item', 'guard_name' => 'web']);
        Permission::create(['name' => 'view_customer', 'guard_name' => 'web']);
        Permission::create(['name' => 'view_suppler', 'guard_name' => 'web']);
        Permission::create(['name' => 'view_stock', 'guard_name' => 'web']);
        Permission::create(['name' => 'view_orders', 'guard_name' => 'web']);
        Permission::create(['name' => 'view_admin', 'guard_name' => 'web']);

        $roles = Role::where('name', 'admin')->first();
        $roles->givePermissionTo('view_category');
        $roles->givePermissionTo('view_item');
        $roles->givePermissionTo('view_customer');
        $roles->givePermissionTo('view_suppler');
        $roles->givePermissionTo('view_stock');
        $roles->givePermissionTo('view_orders');
        $roles->givePermissionTo('view_admin');

        $roles = Role::where('name', 'branch_operator')->first();
        $roles->givePermissionTo('view_orders');
        $roles->givePermissionTo('view_suppler');
        $roles->givePermissionTo('view_customer');
        $roles->givePermissionTo('view_item');
        $roles->givePermissionTo('view_category');
        $roles->givePermissionTo('view_setting');
    }
}
