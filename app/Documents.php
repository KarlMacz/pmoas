<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Documents extends Model
{
    protected $guarded = [];

    public function contract() {
        return $this->belongsTo('App\Contracts', 'contract_id');
    }
}
