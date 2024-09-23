<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Supplier extends Model
{
    use HasFactory;

    protected $fillable = [
        'branch_id',
        'name',
        'address',
        'phone',
        'email',
        'province',
        'district',
    ];

    public function branches(): HasOne
    {
        return $this->hasOne(Branch::class, 'id', 'branch_id');
    }
}
