<?php

namespace App\Http\Controllers;

use App\Accounts;
use App\Logs;

trait Utilities
{
    public function generateRandomDigit($length = 5) {
        $randomDigit = '';

        for($i = 0; $i < $length; $i++) {
            $randomDigit .= mt_rand(0, 9);
        }

        return $randomDigit;
    }

    public function generateUsername($role = null) {
        $username = null;

        if($role) {
            $isAvailable = false;

            while(!$isAvailable) {
                if($role === 'Employee') {
                    $username = 'employee' . $this->generateRandomDigit();
                } else {
                    $username = 'client' . $this->generateRandomDigit();
                }

                $account = Accounts::where('username', $username)->first();

                if(!$account) {
                    $isAvailable = true;
                }
            }
        }

        return $username;
    }

    public function generatePassword($length = 10) {
        $alphaNumeric = '012345679aAbBcCdDeEfFgGhHiIjJkKlLmMnNoOpPqQrRsStTuUvVwWxXyYzZ';
        $password = '';

        for($i = 0; $i < $length; $i++) {
            $password .= substr($alphaNumeric, mt_rand(0, 60), 1);
        }

        return $password;
    }

    public function createLog($id = null, $status = null, $action = null) {
        if($id && $status && $action) {
            $lastLog = Logs::where('account_id', $id)->where('status', $status)->where('action', $action)->orderBy('created_at', 'desc')->first();

            if(!$lastLog) {
                return Logs::create([
                    'account_id' => $id,
                    'status' => $status,
                    'action' => $action
                ]);
            } else {
                return null;
            }
        } else {
            return null;
        }
    }
}
