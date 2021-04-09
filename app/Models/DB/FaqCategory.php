<?php

namespace App\Models\DB;

class FaqCategory extends DBModel
{

    protected $table = 't_faqs_category';

    public function faqs()
    {
        return $this->hasMany(Faq::class, 'category_id');
    }

}
