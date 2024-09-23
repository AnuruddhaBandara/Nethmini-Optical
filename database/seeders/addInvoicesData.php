<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class addInvoicesData extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('invoices')->insert([
            [
                'type' => 'Without Payment',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'type' => 'Half Payment',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'type' => 'Full Payment',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
