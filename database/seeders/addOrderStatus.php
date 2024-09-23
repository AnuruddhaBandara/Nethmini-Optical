<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class addOrderStatus extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('order_status')->insert([
            [
                'name' => 'Pending',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Processed',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Delivered',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Canceled',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

    }
}
