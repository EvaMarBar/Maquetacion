<?php

namespace App\Models\Products;

use Illuminate\Database\Eloquent\Model;
use App\Vendor\Product\Models\Sizes;

class ShirtsSizes extends Model
{
    protected $table = 't_shirts_sizes';
    protected $guarded = [];

    // protected $size = [
    //     'size_id' => 'array',
    // ];

    public function sizes()
    {
        return $this->hasOne(Sizes::class, 'id', 'size_id');
    }

    public function shirts_sizes()
    {
        return $this->hasMany(Product::class, 'id', 'product_id');
    }

    public function scopeGetValues($query, $size_id, $product_id){

        return $query->where('size_id', $size_id)
            ->where('product_id', $product_id);
    }

}
