@extends('layouts.employees')

@section('content')
    <div class="page-header">
        <h1 class="no-margin">Accounting</h1>
        <div>Income</div>
    </div>
    <div class="container-spacious">
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th></th>
                    <th width="30%">Amount</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $totalEarnings = 0;
                    $totalExpenses = 0;

                    foreach($transactions as $transaction) {
                        $totalEarnings += $transaction->total_amount;

                        if($transaction->cancellations->count() > 0) {
                            $totalExpenses += $transaction->total_amount_cancelled;
                        }
                    }
                ?>
                <tr>
                    <td>
                        <h3 class="no-margin">Total Earnings:</h3>
                    </td>
                    <td>
                        <h3 class="no-margin">Php <span class="pull-right">{{ $totalEarnings }}</span></h3>
                    </td>
                </tr>
                <tr>
                    <td>
                        <h3 class="no-margin">Total Expenses:</h3>
                    </td>
                    <td>
                        <h3 class="no-margin">Php <span class="pull-right">{{ $totalExpenses }}</span></h3>
                    </td>
                </tr>
                <tr>
                    <td class="text-right">
                        <h3 class="no-margin">Total Income:</h3>
                    </td>
                    <td>
                        <h3 class="no-margin">Php <span class="pull-right">{{ $totalEarnings - $totalExpenses }}</span></h3>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
@endsection
