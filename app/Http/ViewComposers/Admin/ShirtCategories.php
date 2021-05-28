<?php

namespace App\Http\ViewComposers\Admin;

use Illuminate\View\View;
use App\Models\Products\ShirtsCategory;

class ShirtCategories
{
    static $composed;

    public function __construct(ShirtsCategory $shirts_categories)
    {
        $this->shirts_categories = $shirts_categories;
    }

    public function compose(View $view)
    {

        if(static::$composed)
        {
            return $view->with('shirts_categories', static::$composed);
        }

        static::$composed = $this->shirts_categories->where('active', 1)->orderBy('name', 'asc')->get();

        $view->with('shirts_categories', static::$composed);

    }
}
