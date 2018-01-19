@extends('layouts.master')

@section('content')
    <div class="container">
        <div class="text-center">
            <?php
                exec("mode " . env('COM_PORT') . " BAUD=" . env('COM_BAUD_RATE') . " PARITY=n DATA=8 xon=off");
                $port = fopen(env('COM_PORT'), 'w+');

                fwrite($port, "AT+CREG=1\r");
                sleep(2);

                // echo nl2br(fread($port, 128));

                fwrite($port, "AT+CMGF=1\r");
                sleep(2);

                // echo nl2br(fread($port, 128));

                fwrite($port, "AT+CMGS=\"" . $phoneNumber . "\"\r");
                sleep(1);
                fwrite($port, $message . chr(26));
                sleep(2);

                // echo nl2br(fread($port, 128));

                fclose($port);
            ?>
        </div>
    </div>
@endsection
