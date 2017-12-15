@extends('layouts.employees')

@section('content')
    <div class="page-header">
        <h1 class="no-margin">Customer Data or Accounts</h1>
        <div>View All Clients</div>
    </div>
    <div class="container-fluid">
        <?php
            use lepiaf\SerialPort\SerialPort;
            use lepiaf\SerialPort\Parser\SeparatorParser;
            use lepiaf\SerialPort\Configure\TTYConfigure;

            $serialPort = new SerialPort(new SeparatorParser(), new TTYConfigure());

            $serialPort->open("COM3");

            while($data = $serialPort->read()) {
                echo $data . "\n";

                if($data === "OK") {
                    $serialPort->write("1\n");
                    $serialPort->close();
                }
            }
        ?>
    </div>
@endsection
