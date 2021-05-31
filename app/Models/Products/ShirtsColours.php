<?php

namespace App\Models\Products;

use Illuminate\Database\Eloquent\Model;

class ShirtsColours extends Model
{
    protected $table = 't_shirts_colours';
    protected $guarded = [];

    public function shirts_colours()
    {
        return $this->hasMany(ShirtColours::class, 'colour_id');
    }
}
