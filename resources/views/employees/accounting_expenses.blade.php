@extends('layouts.employees')

@section('content')
    <div class="page-header">
        <h1 class="no-margin">Accounting</h1>
        <div>Expenses</div>
    </div>
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Product(s) Returned</th>
                <th>Total Amount</th>
            </tr>
        </thead>
        <tbody>
            <?php
                $totalExpenses = 0;
                $ctr = 0;
            ?>
            @if($transactions->count() > 0)
                @foreach($transactions as $transaction)
                    <?php
                        $totalExpenses += $transaction->total_amount_cancelled;

                        if($transaction->cancellations->count() > 0) {
                            $ctr++;
                        }
                    ?>
                    @if($transaction->cancellations->count() > 0)
                        <tr>
                            <td>{{ $transaction->id }}</td>
                            <td>
                                @foreach($transaction->cancellations as $cancellation)
                                    <div>{{ $cancellation->product->name }} (x{{ $cancellation->quantity }})</div>
                                @endforeach
                            </td>
                            <td>Php {{ $transaction->total_amount_cancelled }}</td>
                        </tr>
                    @endif
                @endforeach
            @endif
        </tbody>
        <tfoot>
            <tr>
                <td class="text-right" colspan="2">Total Expenses:</td>
                <td>Php {{ $totalExpenses }}</td>
            </tr>
        </tfoot>
    </table>
@endsection
