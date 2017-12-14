@extends('layouts.clients')

@section('content')
    <div class="page-header">
        <h1 class="no-margin">Home</h1>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-8">
                <h3 class="column-header">Active Order(s)</h3>
                @if($transactions->count() > 0)
                    @foreach($transactions as $transaction)
                        @if($transaction->delivery_status === 'Dispatched')
                            <div class="alert alert-success">
                                <h2 class="no-margin">Transaction ID No. {{ sprintf('%010d', $transaction->id) }}</h2>
                                <h4 style="margin: 15px 0;">
                                    <ul>
                                        @foreach($transaction->orders as $order)
                                            <li>{{ $order->product->name }} (x{{ $order->quantity }})</li>
                                        @endforeach
                                    </ul>
                                </h4>
                                <h4 class="text-right no-margin">Dispatched last {{ date('F d, Y (h:i A)', strtotime($transaction->datetime_delivered)) }}</h4>
                            </div>
                        @else
                            <div class="alert alert-info">
                                <h2 class="no-margin">Transaction ID No. {{ sprintf('%010d', $transaction->id) }}</h2>
                                <h4 style="margin: 15px 0;">
                                    <ul>
                                        @foreach($transaction->orders as $order)
                                            <li>{{ $order->product->name }} (x{{ $order->quantity }})</li>
                                        @endforeach
                                    </ul>
                                </h4>
                                <div class="text-center">
                                    @if($transaction->amount_paid >= $transaction->total_amount)
                                        @if($transaction->payment_method === 'PayPal')
                                            <form action="{{ route('payments.post.paypal_payment') }}" method="POST">
                                                {{ csrf_field() }}
                                                <input type="hidden" name="id" value="{{ $transaction->id }}">
                                                <button type="submit" class="btn btn-info btn-xs"><span class="fa fa-paypal"></span> PayPal</button>
                                            </form>
                                        @endif
                                    @endif
                                </div>
                                <h4 class="text-right no-margin">Pending</h4>
                            </div>
                        @endif
                    @endforeach
                @else
                    <div class="alert alert-primary">
                        <h4 class="text-center no-margin">No active orders found.</h4>
                    </div>
                @endif
            </div>
            <div class="col-sm-4">
                <div class="alert alert-success">
                    <h4 data-load="date" class="no-margin"></h4>
                    <h2 data-load="time" class="no-margin"></h2>
                </div>
            </div>
        </div>
    </div>
@endsection
