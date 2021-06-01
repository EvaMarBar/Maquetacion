<?php

namespace App\Vendor\Product\Models;

use Illuminate\Database\Eloquent\Model;
use App\Vendor\Locale\Models\LocaleSlugSeo;
use App\Vendor\Image\Models\ImageResized;
use App;

class Product extends Model
{
    protected $table = 't_products';
    protected $guarded = [];

    public function scopeGetValues($query, $key){

        return $query->where('id', $key);
    }

}
