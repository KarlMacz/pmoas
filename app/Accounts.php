<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

use App\Passwords;

class Accounts extends Model implements
    AuthenticatableContract,
    AuthorizableContract,
    CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword;

    protected $guarded = [];
    public $timestamps = true;

    public function user_info() {
        if($this->role === 'Employee') {
            return $this->hasOne('App\Employees', 'account_id');
        } else {
            return $this->hasOne('App\Clients', 'account_id');
        }
    }

    public function password_info() {
        $password = Passwords::where('identifier', hash('sha256', $this->username))->first();

        return $password->password;
    }
}
