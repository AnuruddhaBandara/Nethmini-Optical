<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TempStock extends Model
{
    use HasFactory;

    protected $table = 'temp_stock';

    protected $fillable = [
        'branch_id',
        'category_id',
        'item_id',
        'quantity',
        'cost',
        'discount',
        'total_cost',
    ];
}
