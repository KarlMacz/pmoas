<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>{{ config('company.name') }}</title>
    <style>
        * {
            font-family: 'Helvetica', sans-serif;
        }
        
        h1, h2, h3, h4, h5, h6 {
            font-weight: thin;
        }

        .pagenum:before {
            content: counter(page);
        }

        .table {
            border: 1px solid #18bc9c;
            border-spacing: none;
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

        .table th, .table td {
            padding: 5px 10px;
            box-sizing: border-box;
        }

        .table td {
            font-size: 0.75em;
        }

        .header {
            margin-bottom: 50px;
            text-align: center;
        }

        .footer {
            border-top: 1px solid #222;
            color: #777;
            font-size: 10px;
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
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
            height: 65px;
        }
    </style>
</head>
<body>
    <div class="header">
        <img class="logo" src="img/logo.png">
        <h1 class="no-margin">{{ config('company.name') }}</h1>
        <h3 class="no-margin">Delivery Report</h3>
    </div>
    <div class="footer">
        <script type="text/php">
            if(isset($pdf)) {
                $font = Font_Metrics::get_font('helvetica', '');
                $pageText = 'Page {PAGE_NUM} of {PAGE_COUNT}';
                $x = $pdf->get_width() - Font_Metrics::get_text_width($pageText, $font, 7) + 52;
                $y = $pdf->get_height() - 32;
                $pdf->page_text($x, $y, $pageText, $font, 7, [.467, .467, .467]);
                $pdf->page_text(37, $y, 'This is a system generated contract.', $font, 7, [.467, .467, .467]);
            }
        </script>
    </div>
    <div class="body">
        <table class="table">
            <thead>
                <tr>
                    <th>Client</th>
                    <th>Product(s)</th>
                    <th width="20%">Date & Time Delivered</th>
                </tr>
            </thead>
            <tbody>
                @if($transactions->count() > 0)
                    @foreach($transactions as $transaction)
                        <tr>
                            <td>{{ $transaction->account->user_info->first_name . ' ' . $transaction->account->user_info->last_name }}</td>
                            <td>
                                @foreach($transaction->orders as $order)
                                    <div>{{ $order->product->name }} (x{{ $order->quantity }})</div>
                                @endforeach
                            </td>
                            <td>{{ $transaction->datetime_delivered }}</td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td class="text-center" colspan="3">No results found.</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</body>
</html>
