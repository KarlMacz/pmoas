<?php
    use App\Http\Controllers\PhpSerial;

    function isOk($formula) {
        return ($formula ? 'OK' : 'ERROR');
    }

    $serial = new PhpSerial();
    $serial->_os = 'windows';

    $serial->deviceSet('COM4');
    $serial->confBaudRate(9600);
    $serial->deviceOpen('w+');

    stream_set_timeout($serial->_dHandle, 10);

    $serial->sendMessage("AT+CREG=1\n\r");

    var_dump($serial->readPort());
    echo '<br>';

    $serial->sendMessage("AT+CMGF=1\n\r", 2);

    var_dump($serial->readPort());
    echo '<br>';

    $serial->sendMessage("AT+CMGS=\"09068563348\"\n\r", 2);
    
    var_dump($serial->readPort());
    echo '<br>';

    $serial->sendMessage("Test Message. " . date('Y-m-d H:i:s') . chr(26), 2);
    
    var_dump($serial->readPort());
    echo '<br>';

    $serial->deviceClose();
?>