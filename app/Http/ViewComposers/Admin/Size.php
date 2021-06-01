<?php

namespace App\Http\ViewComposers\Admin;

use Illuminate\View\View;
use App\Vendor\Product\Models\Sizes;

class Size
{
    static $composed;

    public function __construct(Sizes $size)
    {
        $this->size = $size;
    }

    public function compose(View $view)
    {

        if(static::$composed)
        {
            return $view->with('size', static::$composed);
        }

        static::$composed = $this->size->where('active', 1)->get();

        $view->with('size', static::$composed);

    }
}
