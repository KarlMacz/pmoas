<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CartItems extends Model
{
    protected $guarded = [];

    public function cart() {
        return $this->belongsTo('App\Carts', 'cart_id');
    }

    public function product() {
        return $this->belongsTo('App\Products', 'product_id');
    }
}
