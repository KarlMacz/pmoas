<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contracts extends Model
{
    protected $guarded = [];

    public function contractor() {
        return $this->belongsTo('App\Accounts', 'contractor_id');
    }

    public function contractee() {
        return $this->belongsTo('App\Accounts', 'contractee_id');
    }
}
