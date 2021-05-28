<?php

namespace App\Http\ViewComposers\Admin;

use Illuminate\View\View;
use App\Models\Products\Colours;

class Colour
{
    static $composed;

    public function __construct(Colours $colour)
    {
        $this->colour = $colour;
    }

    public function compose(View $view)
    {

        if(static::$composed)
        {
            return $view->with('colour', static::$composed);
        }

        static::$composed = $this->colour->where('active', 1)->get();

        $view->with('colour', static::$composed);

    }
}
