<?php
    use lepiaf\SerialPort\SerialPort;
    use lepiaf\SerialPort\Parser\SeparatorParser;
    use lepiaf\SerialPort\Configure\TTYConfigure;

    $configure = new TTYConfigure();

    // $configure->removeOption('9600');
    $configure->setOption(env('COM_BAUD_RATE'));

    $serialPort = new SerialPort(new SeparatorParser(), $configure);

    $serialPort->open(env('COM_PORT'));

    while($data = $serialPort->read()) {
        if($data === 'OK') {
            $serialPort->write("AT\n\r");
            // $serialPort->write('AT+CMGF=1\r');
            // $serialPort->write('AT+CMGS="' . $phoneNumber . '"\r' . $message . chr(26) . '\r');
            $serialPort->close();
        }
    }
?>