<?php

namespace App\Http\ViewComposers\Admin;

use Illuminate\View\View;
use App\Models\Products\ShirtSpecification;

class ShirtSpecifications
{
    static $composed;

    public function __construct(ShirtSpecification $specifications)
    {
        $this->specifications = $specifications;
    }

    public function compose(View $view)
    {

        if(static::$composed)
        {
            return $view->with('shirts_categories', static::$composed);
        }

        static::$composed = $this->specifications->where('active', 1)->get();

        $view->with('shirts_specifications', static::$composed);

    }
}
