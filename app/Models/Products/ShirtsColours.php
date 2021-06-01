<?php

namespace App\Models\Products;
use App\Vendor\Product\Models\Colours;


use Illuminate\Database\Eloquent\Model;

class ShirtsColours extends Model
{
    protected $table = 't_shirts_colours';
    protected $guarded = [];

    public function colours()
    {
        return $this->hasMany(Colours::class, 'id', 'colour_id');
    } 

    public function shirts_colours()
    {
        return $this->hasMany(ShirtColours::class, 'colour_id');
    }

    public function scopeGetValues($query, $product_id, $colour_id){

        return $query->where('product_id', $product_id)
            ->where('colour_id', $colour_id);
    }
}
