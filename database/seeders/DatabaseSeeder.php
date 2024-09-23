<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([insert_provinces::class]);
        $this->call([insert_districts::class]);
        $this->call([createBranchDataSeeder::class]);
        $this->call([createUserRolePermission::class]);
        $this->call([createViewPermission::class]);
        $this->call([addOrderStatus::class]);
        $this->call([addInvoicesData::class]);

    }
}
