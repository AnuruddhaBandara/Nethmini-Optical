<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class StockItem extends Model
{
    use HasFactory;

    protected $fillable = ['stock_id', 'category_id', 'item_id', 'quantity', 'cost', 'discount', 'total'];

    public function items(): HasOne
    {
        return $this->hasOne(Item::class, 'id', 'item_id');
    }
}
