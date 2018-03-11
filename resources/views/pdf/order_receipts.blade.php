<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>{{ config('company.name') }}</title>
    <style>
        * {
            font-family: 'Helvetica', sans-serif;
        }

        body {
            font-size: 15px;
        }
        
        h1, h2, h3, h4, h5, h6 {
            font-weight: normal;
        }

        div.beautify {
            margin-bottom: 2px;
        }

        .pagenum:before {
            content: counter(page);
        }

        .table {
            border: 1px solid #18bc9c;
            border-spacing: none;
            margin: 5px 0;
            overflow: hidden;
            width: 100%;
        }

        .table thead > tr {
            background: #18bc9c;
            color: white;
        }

        .table tbody > tr:nth-child(even) {
            background: white;
        }

        .table tbody > tr:nth-child(odd) {
            background: #eee;
        }

        .table tfoot > tr {
            background: white;
        }

        .table th, .table td {
            position: relative;
            padding: 5px 10px;
            box-sizing: border-box;
        }

        .table td {
            font-size: 0.75em;
        }

        .no-margin {
            margin: 0;
        }

        .full-width {
            width: 100%;
        }

        .gap-top {
            margin-top: 5px;
        }

        .gap-bottom {
            margin-bottom: 5px;
        }

        .gap-left {
            margin-left: 5px;
        }

        .gap-right {
            margin-right: 5px;
        }

        .pull-left {
            float: left;
        }

        .pull-right {
            float: right;
        }

        .text-left {
            text-align: left;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .logo {
            height: 50px;
        }

        .receipt {
            border: 1px solid #ccc;
            border-radius: 4px;
            padding: 25px;
        }

        .receipt .header {
            border-bottom: 1px solid #ccc;
            padding-bottom: 10px;
            margin-bottom: 25px;
        }

        .receipt .header .logo {
            float: left;
        }

        .receipt .content {
            padding: 5px 10px;
        }

        .receipt .content > .left,
        .receipt .content > .right {
            display: inline-block;
            vertical-align: top;
            box-sizing: border-box;
        }

        .receipt .content > .left {
            width: 30%;
        }

        .receipt .content > .right {
            width: 70%;
        }

        .receipt .footer {
            border-top: 1px solid #ccc;
            font-size: 0.75em;
            padding-top: 10px;
            margin-top: 25px;
        }

        .cut-mark {
            border: 1px dashed #ccc;
            padding: 15px;
        }
    </style>
</head>
<body>
    <div class="cut-mark">
        <div class="receipt">
            <div class="header">
                <img class="logo" src="img/logo.png">
                <h2 class="no-margin">{{ config('company.name') }}</h2>
                <h4 class="no-margin">{{ config('company.address') }}</h4>
            </div>
            <div class="content">
                <div class="left">
                    <h5 class="no-margin">Buyer:</h5>
                    <h3 class="no-margin">{{ $transaction->account->user_info->first_name . ' ' . $transaction->account->user_info->last_name }}</h3>
                    <br>
                    <h5 class="no-margin">Employee:</h5>
                    <h3 class="no-margin">{{ Auth::user()->user_info->first_name . ' ' . Auth::user()->user_info->last_name }}</h3>
                    <br>
                    <h6 class="no-margin">Your feedback is important to us. Call (+632) 654 9807 to 09 or visit {{ url('/') }}</h6>
                </div>
                <div class="right">
                    <div class="beautify">Transaction No.: {{ sprintf('%010d', $transaction->id) }}</div>
                    <div class="beautify">Transaction Date: {{ date('m/d/Y H:i:s', strtotime($transaction->created_at)) }}</div>
                    <div class="beautify">Payment Method: {{ $transaction->payment_method }}</div>
                    <table class="table">
                        <thead>
                            <tr>
                                <th width="15%">Qty</th>
                                <th>Item</th>
                                <th width="30%">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $total_amount = 0;
                            ?>
                            @if($transaction->orders->count() > 0)
                                @foreach($transaction->orders as $order)
                                    <?php
                                        $total_amount += $order->product->price_per_piece * $order->quantity;
                                    ?>
                                    <tr>
                                        <td class="text-right">x{{ $order->quantity }}</td>
                                        <td>{{ $order->product->name }}</td>
                                        <td class="text-right">Php {{ ($order->product->price_per_piece * $order->quantity) }}</td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td class="text-center" colspan="3">No items found.</td>
                                </tr>
                            @endif
                        </tbody>
                        <tfoot>
                            <tr>
                                <th class="text-right" colspan="2">Total:</th>
                                <th class="text-right">Php {{ $total_amount }}</th>
                            </tr>
                        </tfoot>
                    </table>
                    <div class="beautify">Delivery Date: {{ date('m/d/Y H:i:s', strtotime($transaction->datetime_delivered)) }}</div>
                </div>
            </div>
            <div class="footer text-right">Thank you very much. This serves as an Official Receipt.</div>
        </div>
    </div>
</body>
</html>
