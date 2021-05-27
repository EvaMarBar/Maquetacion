<?php

namespace App\Models\Products;

use Illuminate\Database\Eloquent\Model;

class ShirtsSpecifications extends Model
{
    protected $table = 't_shirts_specifications';
    protected $guarded = [];

    public function products()
    {
        return $this->hasOne(Products::class, 'specifications_id');
    }

}
