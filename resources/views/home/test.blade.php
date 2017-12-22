@extends('layouts.employees')

@section('content')
    <div class="page-header">
        <h1 class="no-margin">Test Page</h1>
    </div>
    <div class="container-fluid">
        <?php
            /*use lepiaf\SerialPort\SerialPort;
            use lepiaf\SerialPort\Parser\SeparatorParser;
            use lepiaf\SerialPort\Configure\TTYConfigure;

            $configure = new TTYConfigure();

            $configure->removeOption('9600');
            $configure->setOption(env('COM_BAUD_RATE'));

            $serialPort = new SerialPort(new SeparatorParser(), $configure);

            $serialPort->open(env('COM_PORT'));

            while($data = $serialPort->read()) {
                if($data === 'OK') {
                    $serialPort->write('AT+CMGF=1\r');
                    $serialPort->write('AT+CMGS="' . $phoneNumber . '"\r' . $message . chr(26) . '\r');
                    $serialPort->close();
                }
            }*/
        ?>
        <div class="alert alert-info">Check your phone for SMS.</div>
    </div>
@endsection
