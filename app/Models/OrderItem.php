<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = ['order_id', 'category_id', 'item_id', 'quantity', 'sale_price', 'discount', 'total'];

    public function category(): HasOne
    {
        return $this->hasOne(Category::class, 'id', 'category_id');
    }

    public function items(): HasOne
    {
        return $this->hasOne(Item::class, 'id', 'item_id');
    }
}
