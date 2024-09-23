<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TempOrder extends Model
{
    use HasFactory;

    protected $fillable = ['branch_id', 'category_id', 'item_id', 'quantity', 'sale_price', 'discount', 'total_sale_price'];
}
