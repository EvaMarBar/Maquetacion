<?php

namespace App\Models\Products;

use Illuminate\Database\Eloquent\Model;

class ShirtsCategory extends Model
{
    protected $table = 't_shirts_categories';
    protected $guarded = [];

    public function shirts()
    {
        return $this->hasMany(Products::class, 'category_id');
    }


}
