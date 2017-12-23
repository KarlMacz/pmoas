<?php
    use App\Http\Controllers\PhpSerial;

    function isOk($formula) {
        return ($formula ? 'OK' : 'ERROR');
    }

    $data = '';
    $comPort = 'COM6';
    $baud = env('COM_BAUD_RATE', 9600);

    $serial = new PhpSerial;
    $serial->_os = strtolower(env('PC_OS'));

    $serial->deviceSet($comPort);
    // $serial->confBaudRate(115200);
    // $serial->confCharacterLength(8);
    // $serial->confStopBits(1);
    // $serial->confParity('none');
    // $serial->confFlowControl('none');
    $serial->_exec('mode ' . $comPort . ' BAUD=' . $baud . ' PARITY=n DATA=8 STOP=1 xon=off octs=off rts=off dtr=on');
    $isOpen = $serial->deviceOpen();

    if($isOpen) {
        // $serial->sendMessage("AT+CMGF=1" . chr(13), 2);
        // $data .= $serial->readPort();
        // $serial->sendMessage("AT+CMGS=\"" . $phoneNumber . "\"" . chr(13), 2);
        // $data .= $serial->readPort();
        // $serial->sendMessage("This is a sample message. Sent by " . config('company.name') . ".", 2);
        // $data .= $serial->readPort();
        // $serial->sendMessage(chr(26));
        // $data .= $serial->readPort();

        $serial->sendMessage("AT+CMGF=1\r\n", 3);
        $serial->sendMessage("AT+CMGS=\"" . $phoneNumber . "\"\r\n", 3);
        $serial->sendMessage("Bal\r\n", 3);
        $serial->sendMessage(chr(26) . "\r\n", 3);

        sleep(6);
        var_dump($serial->readPort());

        $serial->deviceClose();
    } else {
        echo 'Unable to open device.';
    }
?>