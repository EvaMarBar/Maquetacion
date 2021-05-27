<?php

namespace App\Models\Products;

use Illuminate\Database\Eloquent\Model;

class ShirtsSizes extends Model
{
    protected $table = 't_shirts_sizes';
    protected $guarded = [];

    public function shirts_sizes()
    {
        return $this->hasMany(Sizes::class, 'size_id');
    }
}
