<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContractRules extends Model
{
    protected $guarded = [];

    public function contract() {
        return $this->belongsTo('App\Contracts', 'contract_id');
    }
}
