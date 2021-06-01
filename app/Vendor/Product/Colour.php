<?php

namespace App\Vendor\Product;

use App\Models\Products\ShirtsColours as DBColour;
use \Debugbar;

class Colour
{
    protected $rel_parent;

    function __construct(DBColour $colours)
    {
        $this->colours = $colours;
    }

    public function setParent($rel_parent)
    {
        $this->rel_parent = $rel_parent;
    }

    public function getParent()
    {
        return $this->rel_parent;
    }


    public function store($colour_id, $product_id)
    {  

        
        foreach($colour_id as $colour_id_element => $value){

        $colours[] = $this->colours->updateOrCreate([
                'colour_id' => $value,
                'product_id' => $product_id,
                'active' => 1,
                ]);
        }

        return $colours;
    }

    public function show($product_id)
    {
        return DBColour::getValues($this->colours, $product_id)->pluck('colour_id')->all();  
    }

    public function delete($key)
    {
        if (DBLocale::getValues($this->rel_parent, $key)->count() > 0) {

            DBLocale::getValues($this->rel_parent, $key)->delete();   
        }
    }

    public function getIdByLanguage($key){ 
        return DBLocale::getIdByLanguage($this->rel_parent, $this->language, $key)->pluck('value','tag')->all();
    }

    public function getAllByLanguage(){ 

        $items = DBLocale::getAllByLanguage($this->rel_parent, $this->language)->get()->groupBy('key');

        $items =  $items->map(function ($item) {
            return $item->pluck('value','tag');
        });

        return $items;
    }
}