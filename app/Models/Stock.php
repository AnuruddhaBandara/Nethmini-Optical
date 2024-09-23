<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Stock extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'branch_id',
        'stock_no',
        'supplier_id',
        'sub_total',
        'discount',
        'build_date',
        'final_total',
    ];

    public function supplier(): HasOne
    {
        return $this->HasOne(Supplier::class, 'id', 'supplier_id');
    }

    public function stockItem(): HasOne
    {
        return $this->hasOne(StockItem::class, 'stock_id', 'id');
    }

    public function branches(): HasOne
    {
        return $this->hasOne(Branch::class, 'id', 'branch_id');
    }

    public function stockItems()
    {
        return $this->hasMany(StockItem::class);
    }
}
