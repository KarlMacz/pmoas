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
                    }

                    foreach($stocks as $stock) {
                        $totalExpenses += $stock->total_amount;
                    }
                ?>
                <tr>
                    <td>
                        <h2>Total Earnings:</h2>
                    </td>
                    <td>
                        <h2>Php <span class="pull-right">{{ $totalEarnings }}</span></h2>
                    </td>
                </tr>
                <tr>
                    <td>
                        <h2>Total Expenses:</h2>
                    </td>
                    <td>
                        <h2>Php <span class="pull-right">{{ $totalExpenses }}</span></h2>
                    </td>
                </tr>
                <tr>
                    <td class="text-right">
                        <h2>Total Income:</h2>
                    </td>
                    <td>
                        <h2>Php <span class="pull-right">{{ $totalEarnings - $totalExpenses }}</span></h2>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
@endsection
