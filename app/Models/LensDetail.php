<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LensDetail extends Model
{
    use HasFactory;

    protected $fillable = ['order_id', 'quantity', 'is_draft', 'branch_id', 'lens_name', 'lens_price', 'discount', 'lens_cost'];
}
