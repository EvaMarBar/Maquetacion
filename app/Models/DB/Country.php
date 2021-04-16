<?php

namespace App\Models\DB;

class Country extends DBModel
{

    protected $table = 't_countries';

    public function clients()
    {
        return $this->hasMany(Client::class, 'country_id');
    }

}
