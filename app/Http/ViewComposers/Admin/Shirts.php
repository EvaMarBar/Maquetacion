<?php

namespace App\Http\ViewComposers\Admin;

use Illuminate\View\View;
use App\Models\Products\Shirt;

class Shirts
{
    static $composed;

    public function __construct(Shirt $shirt)
    {
        $this->shirt = $shirt;
    }

    public function compose(View $view)
    {

        if(static::$composed)
        {
            return $view->with('shirts', static::$composed);
        }

        static::$composed = $this->shirt->where('active', 1)->get();

        $view->with('shirts', static::$composed);

    }
}
