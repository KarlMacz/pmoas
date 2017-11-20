<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    protected $guarded = [];

    public function transaction() {
        return $this->belongsTo('App\Transactions', 'transaction_id');
    }

    public function product() {
        return $this->belongsTo('App\Products', 'product_id');
    }
}
