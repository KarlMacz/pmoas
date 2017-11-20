<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Carts extends Model
{
    protected $guarded = [];

    public function account() {
        return $this->belongsTo('App\Accounts', 'account_id');
    }

    public function items() {
        return $this->hasMany('App\CartItems', 'cart_id');
    }
}
