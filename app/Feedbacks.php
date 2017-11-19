<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Feedbacks extends Model
{
    protected $guarded = [];
    
    public function account() {
        return $this->belongsTo('App\Accounts', 'account_id');
    }
}
