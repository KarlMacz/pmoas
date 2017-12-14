<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transactions extends Model
{
    protected $guarded = [];

    public function account() {
        return $this->belongsTo('App\Accounts', 'account_id');
    }

    public function orders() {
        return $this->hasMany('App\Orders', 'transaction_id');
    }

    public function cancellations() {
        return $this->hasMany('App\Cancellations', 'transaction_id');
    }
}
