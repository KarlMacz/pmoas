@extends('layouts.employees')

@section('content')
    <div class="page-header">
        <h1 class="no-margin">Accounting</h1>
        <div>Sales</div>
    </div>
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Product(s)</th>
                <th>Total Amount</th>
            </tr>
        </thead>
        <tbody>
            <?php
                $totalEarnings = 0;
            ?>
            @if($transactions->count() > 0)
                @foreach($transactions as $transaction)
                    <?php
                        $totalEarnings += $transaction->total_amount;
                    ?>
                    <tr>
                        <td>{{ $transaction->id }}</td>
                        <td>
                            @foreach($transaction->orders as $order)
                                <div>{{ $order->product->name }} (x{{ $order->quantity }})</div>
                            @endforeach
                        </td>
                        <td>Php {{ $transaction->total_amount }}</td>
                    </tr>
                @endforeach
            @endif
        </tbody>
        <tfoot>
            <tr>
                <td class="text-right" colspan="2">Total Earnings:</td>
                <td>Php {{ $totalEarnings }}</td>
            </tr>
        </tfoot>
    </table>
@endsection
