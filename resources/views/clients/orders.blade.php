@extends('layouts.clients')

@section('content')
    <div class="page-header">
        <h1 class="no-margin">Orders</h1>
    </div>
    <div class="container-fluid">
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th width="10%">ID</th>
                    <th>Transaction Date</th>
                    <th>Product(s)</th>
                    <th width="15%">Payment Method</th>
                    <th width="15%">Status</th>
                    <th width="10%"></th>
                </tr>
            </thead>
            <tbody>
                @if($transactions->count() > 0)
                    @foreach($transactions as $transaction)
                        <tr>
                            <td class="text-center">{{ $transaction->id }}</td>
                            <td class="text-center">{{ date('F d, Y (h:i A)', strtotime($transaction->created_at)) }}</td>
                            <td>
                                @foreach($transaction->orders as $order)
                                    <div>{{ $order->product->name }} (x{{ $order->quantity }})</div>
                                @endforeach
                            </td>
                            <td class="text-center">{{ $transaction->payment_method }}</td>
                            <td class="text-center">{{ $transaction->delivery_status }}</td>
                            <td class="text-center">
                                @if($transaction->amount_paid !== $transaction->total_amount)
                                    @if($transaction->payment_method === 'PayPal')
                                        <form action="{{ route('payments.post.paypal_payment') }}" method="POST">
                                            {{ csrf_field() }}
                                            <input type="hidden" name="id" value="{{ $transaction->id }}">
                                            <button type="submit" class="btn btn-info btn-xs"><span class="fa fa-paypal"></span> PayPal</button>
                                        </form>
                                    @endif
                                @endif
                                @if($transaction->delivery_status === 'Delivered')
                                    <button class="mark-transaction-button btn btn-primary btn-xs" data-id="{{ $transaction->id }}"><span class="fa fa-check fa-fw"></span> Mark as Delivered</button>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td class="text-center" colspan="6">No transactions found.</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
@endsection
