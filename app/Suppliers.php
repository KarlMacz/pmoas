<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Suppliers extends Model
{
    protected $guarded = [];

    public function stock() {
        return $this->hasMany('App\Stocks', 'supplier_id');
    }
}
