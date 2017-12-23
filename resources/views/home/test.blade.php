<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('company.name') }}</title>
</head>
<body>
    <div>
        <?php
            use App\Http\Controllers\PhpSerial;

            $data = '';

            $serial = new PhpSerial();
            $serial->_os = strtolower(env('PC_OS'));

            $serial->deviceSet(env('COM_PORT'));
            $serial->confBaudRate(env('COM_BAUD_RATE'));
            $serial->confParity('none');
            $serial->confCharacterLength(8);
            $serial->confStopBits(1);
            $serial->confFlowControl('none');
            $serial->deviceOpen('w+');

            $serial->sendMessage("AT+CMGF=1" . chr(13), 2);
            $data .= $serial->readPort();
            $serial->sendMessage("AT+CMGS=\"" . $phoneNumber . "\"" . chr(13), 2);
            $data .= $serial->readPort();
            $serial->sendMessage("This is a sample message. Sent by " . config('company.name') . ".", 2);
            $data .= $serial->readPort();
            $serial->sendMessage(chr(26));
            $data .= $serial->readPort();

            $serial->deviceClose();

            var_dump($data);
        ?>
    </div>
</body>
</html>
