<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Carbon\Carbon;

class Clients extends Model
{
    protected $guarded = [];

    public function age() {
        return Carbon::createFromFormat('Y-m-d', $this->birth_date)->age;
    }

    public function account() {
        return $this->belongsTo('App\Accounts', 'account_id');
    }
}
