<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = ['invoice_number', 'branch_id', 'customer_id', 'sub_total', 'discount', 'final_total', 'payment_received', 'remaining_payment', 'payment_method', 'remark', 'status'];

    public function customer(): HasOne
    {
        return $this->HasOne(Customer::class, 'id', 'customer_id');
    }

    public function orderItem(): HasOne
    {
        return $this->hasOne(OrderItem::class, 'order_id', 'id');
    }

    public function branches(): HasOne
    {
        return $this->hasOne(Branch::class, 'id', 'branch_id');
    }

    public function lensDetails(): HasOne
    {

        return $this->hasOne(LensDetail::class, 'order_id', 'id');
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
}
