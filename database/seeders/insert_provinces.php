<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class insert_provinces extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('province')->insert([
            ['id' => 1, 'name_en' => 'Western', 'name_si' => 'බස්නාහිර', 'name_ta' => 'மேல்'],
            ['id' => 2, 'name_en' => 'Central', 'name_si' => 'මධ්‍යම', 'name_ta' => 'மத்திய'],
            ['id' => 3, 'name_en' => 'Southern', 'name_si' => 'දකුණු', 'name_ta' => 'தென்'],
            ['id' => 4, 'name_en' => 'North Western', 'name_si' => 'වයඹ', 'name_ta' => 'வட மேல்'],
            ['id' => 5, 'name_en' => 'Sabaragamuwa', 'name_si' => 'සබරගමුව', 'name_ta' => 'சபரகமுவ'],
            ['id' => 6, 'name_en' => 'Eastern', 'name_si' => 'නැගෙනහිර', 'name_ta' => 'கிழக்கு'],
            ['id' => 7, 'name_en' => 'Uva', 'name_si' => 'ඌව', 'name_ta' => 'ஊவா'],
            ['id' => 8, 'name_en' => 'North Central', 'name_si' => 'උතුරු මැද', 'name_ta' => 'வட மத்திய'],
            ['id' => 9, 'name_en' => 'Northern', 'name_si' => 'උතුරු', 'name_ta' => 'வட'],
        ]);
    }
}
