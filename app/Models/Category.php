<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'branch_id'];

    public function branches(): HasOne
    {
        return $this->hasOne(Branch::class, 'id', 'branch_id');
    }
}
