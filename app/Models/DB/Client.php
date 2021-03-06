<?php

namespace App\Models\DB;

class Client extends DBModel
{

    protected $table = 't_clients';

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

}
