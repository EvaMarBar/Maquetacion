<?php

namespace App\Vendor\Product;

use App\Vendor\Product\Models\Product as DBProduct;
use \Debugbar;

class Product
{
    protected $rel_parent;

    function __construct(DBProduct $product)
    {
        $this->product = $product;
    }

    public function setParent($rel_parent)
    {
        $this->rel_parent = $rel_parent;
    }

    public function getParent()
    {
        return $this->rel_parent;
    }


    public function store($product, $specification_id)
    {  
        $price = ($product['original_price']*(1-($product['discount']/100)))*(1+($product['taxes']/100));


        $product[] = $this->product->updateOrCreate([
                'id' => request('id'),
                'specifications_id' => $specification_id],[
                'original_price'=>$product['original_price'],
                'discount'=>$product['discount'],
                'taxes' =>$product['taxes'],
                'price' => $price,
                'visible' => request('visible'),
                'active' => 1,
                    
            ]);

        return $product;
    }

    public function show($product_id)
    {
        return DBProduct::getValues($product_id)->pluck('original_price','price')->all();  
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