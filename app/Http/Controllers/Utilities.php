<?php

namespace App\Http\Controllers;

use lepiaf\SerialPort\SerialPort;
use lepiaf\SerialPort\Parser\SeparatorParser;
use lepiaf\SerialPort\Configure\TTYConfigure;

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

    public function sendSms($phoneNumber, $message) {
        if(env('COM_PORT', null) !== null) {
            // $output = '';

            exec("mode " . env('COM_PORT') . " BAUD=" . env('COM_BAUD_RATE') . " PARITY=n DATA=8 xon=off");
            $port = fopen(env('COM_PORT'), 'w+');

            fwrite($port, "AT+CREG=1\r");
            sleep(2);

            // $output .= nl2br(fread($port, 128));

            fwrite($port, "AT+CMGF=1\r");
            sleep(2);

            // $output .= nl2br(fread($port, 128));

            fwrite($port, "AT+CMGS=\"" . $phoneNumber . "\"\r");
            sleep(1);
            fwrite($port, $message . chr(26));
            sleep(2);

            // $output .= nl2br(fread($port, 128));

            fclose($port);

            // return $output;
        }
    }
}
