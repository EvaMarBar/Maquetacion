<?php

namespace App\Models\Products;

use Illuminate\Database\Eloquent\Model;

class ShirtsPricing extends Model
{
    protected $table = 't_shirts_pricing';
    protected $guarded = [];

    
    public function products()
    {
        return $this->hasMany(Products::class, 'pricind_id');
    }
}
