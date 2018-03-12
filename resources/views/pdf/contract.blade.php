<!DOCTYPE html>
<html lang="en">
<head>
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
        <h3 class="no-margin">{{ $contract->type }} Contract</h3>
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
            <tbody>
                <tr>
                    <td width="25%" class="text-right">Client's Name:</td>
                    <td>{{ $contract->contractee->user_info->first_name . ' ' . $contract->contractee->user_info->last_name }}</td>
                </tr>
                <tr>
                    <td width="25%" class="text-right">Contractor's Name:</td>
                    <td>{{ $contract->contractor->user_info->first_name . ' ' . $contract->contractor->user_info->last_name }}</td>
                </tr>
                <tr>
                    <td width="25%" class="text-right">Contract Lifespan:</td>
                    <td>{{ date('F d, Y', strtotime($contract->lifespan_start)) . ' - ' . date('F d, Y', strtotime($contract->lifespan_end)) }}</td>
                </tr>
                <tr>
                    <td width="25%" class="text-right">Maximum Amount:</td>
                    <td>{{ $contract->maximum_amount }}</td>
                </tr>
                <tr>
                    <td width="25%" class="text-right">Holdback Amount:</td>
                    <td>{{ $contract->holdback_amount }}</td>
                </tr>
                <tr>
                    <td width="25%" class="text-right">Mode of Payment:</td>
                    <td>{{ $contract->mode_of_payment }}</td>
                </tr>
                <tr>
                    <td width="25%" class="text-right">Structure:</td>
                    <td>{{ $contract->structure }}</td>
                </tr>
                <tr>
                    <td width="25%" class="text-right">Rules / Prohibitions:</td>
                    <td>
                        @if($contract->rules->count() > 0)
                            @foreach($contract->rules as $rule)
                                <div>{{ $rule->rule }}</div>
                            @endforeach
                        @endif
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</body>
</html>
