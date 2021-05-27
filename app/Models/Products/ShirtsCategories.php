<?php

namespace App\Models\Products;

use Illuminate\Database\Eloquent\Model;

class ShirtsCategories extends Model
{
    protected $table = 't_shirts_categories';
    protected $guarded = [];

    public function products()
    {
        return $this->hasMany(Products::class, 'category_id');
    }


}
