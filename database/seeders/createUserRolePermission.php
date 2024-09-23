<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class createUserRolePermission extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Permission::create(['name' => 'add_category', 'guard_name' => 'web']);
        Permission::create(['name' => 'edit_category', 'guard_name' => 'web']);
        Permission::create(['name' => 'delete_category', 'guard_name' => 'web']);

        Permission::create(['name' => 'add_item', 'guard_name' => 'web']);
        Permission::create(['name' => 'edit_item', 'guard_name' => 'web']);
        Permission::create(['name' => 'delete_item', 'guard_name' => 'web']);

        Permission::create(['name' => 'add_customer', 'guard_name' => 'web']);
        Permission::create(['name' => 'edit_customer', 'guard_name' => 'web']);
        Permission::create(['name' => 'delete_customer', 'guard_name' => 'web']);

        Permission::create(['name' => 'add_suppler', 'guard_name' => 'web']);
        Permission::create(['name' => 'edit_suppler', 'guard_name' => 'web']);
        Permission::create(['name' => 'delete_suppler', 'guard_name' => 'web']);

        Permission::create(['name' => 'add_stock', 'guard_name' => 'web']);
        Permission::create(['name' => 'edit_stock', 'guard_name' => 'web']);
        Permission::create(['name' => 'delete_stock', 'guard_name' => 'web']);

        Permission::create(['name' => 'add_orders', 'guard_name' => 'web']);
        Permission::create(['name' => 'edit_orders', 'guard_name' => 'web']);
        Permission::create(['name' => 'delete_orders', 'guard_name' => 'web']);

        Permission::create(['name' => 'add_admin', 'guard_name' => 'web']);
        Permission::create(['name' => 'edit_admin', 'guard_name' => 'web']);
        Permission::create(['name' => 'delete_admin', 'guard_name' => 'web']);

        Permission::create(['name' => 'view_dashboard', 'guard_name' => 'web']);

        Permission::create(['name' => 'view_report', 'guard_name' => 'web']);

        Permission::create(['name' => 'view_setting', 'guard_name' => 'web']);

        //create role and assign permission

        $role = Role::create(['name' => 'admin']);
        $role->syncPermissions(['add_category', 'edit_category', 'delete_category', 'add_item', 'edit_item', 'delete_item', 'add_customer', 'edit_customer', 'delete_customer', 'add_suppler', 'edit_suppler', 'delete_suppler', 'add_stock', 'edit_stock', 'delete_stock', 'add_orders', 'edit_orders', 'delete_orders', 'add_admin', 'edit_admin', 'delete_admin', 'view_dashboard', 'view_report', 'view_setting']);

        $role = Role::create(['name' => 'branch_operator']);
        $role->syncPermissions(['add_stock', 'add_orders', 'edit_orders', 'add_suppler', 'edit_suppler', 'add_customer', 'edit_customer', 'add_item', 'edit_item', 'add_category', 'edit_category']);
    }
}
