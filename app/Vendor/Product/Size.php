<?php

namespace App\Vendor\Product;

use App\Models\Products\ShirtsSizes as DBSize;
use Illuminate\Http\Request;
use \Debugbar;

class Size
{
    protected $rel_parent;

    function __construct(DBSize $size)
    {
        $this->size = $size;
    }

    public function setParent($rel_parent)
    {
        $this->rel_parent = $rel_parent;
    }

    public function getParent()
    {
        return $this->rel_parent;
    }


    public function store($sizes, $product_id)
    {  

        foreach($sizes as $size){

            $sizes[] = $this->size->updateOrCreate([
                'id' => request('id')],[
                'size_id' => $size,
                'product_id' => $product_id,
                'active' => 1,
                ]);
                // Debugbar::info($sizes);
           
        }

        return $size;
        // Debugbar::info($size);
    }

    public function show($product_id)
    {
        return DBSize::getValues($this->size, $product_id)->pluck('size_id')->all();  
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