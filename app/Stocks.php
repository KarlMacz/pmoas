<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stocks extends Model
{
    protected $guarded = [];

    public function product() {
        return $this->belongsTo('App\Products', 'product_id');
    }
}
