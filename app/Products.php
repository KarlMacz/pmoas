<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    protected $guarded = [];

    public function stocks() {
        return $this->hasMany('App\Stocks', 'product_id');
    }
}
