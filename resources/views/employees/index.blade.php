@extends('layouts.employees')

@section('content')
    <div class="page-header">
        <h1 class="no-margin">Dashboard</h1>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-8">
                <h3 class="column-header">
                    <span>Pending Client Order(s)</span>
                    @if($pendingTransactions->count() > 0)
                        <a href="{{ route('employees.get.orders') }}" class="btn btn-primary btn-xs pull-right"><span class="fa fa-reply fa-fw"></span> Go to Client Orders</a>
                    @endif
                </h3>
                @if($pendingTransactions->count() > 0)
                    @foreach($pendingTransactions as $transaction)
                        @if($transaction->delivery_status === 'Pending')
                            <div class="alert{{ ($transaction->amount_paid === $transaction->total_amount ? ' alert-success' : ' alert-danger') }}">
                                <h3 class="no-margin">Transaction ID No. {{ sprintf('%010d', $transaction->id) }}</h3>
                                <h5 class="no-margin">Payment Method: {{ $transaction->payment_method }}</h5>
                                <h5 style="margin: 15px 0;">
                                    <div style="margin: 0 0 5px 10px;">
                                        <strong>Product(s):</strong>
                                    </div>
                                    <ul>
                                        @foreach($transaction->orders as $order)
                                            <li>{{ $order->product->name }} (x{{ $order->quantity }})</li>
                                        @endforeach
                                    </ul>
                                </h5>
                                <h5 class="text-right no-margin">
                                    @if($transaction->amount_paid === $transaction->total_amount)
                                        <span>Paid</span>
                                    @else
                                        <span>Not yet paid</span>
                                    @endif
                                </h5>
                            </div>
                        @endif
                    @endforeach
                @else
                    <div class="alert alert-primary">
                        <h5 class="text-center no-margin">No pending client orders found.</h5>
                    </div>
                @endif
                <br>
                <h3 class="column-header">
                    <span>Dispatched Client Order(s)</span>
                    @if($dispatchedTransactions->count() > 0)
                        <a href="{{ route('employees.get.orders') }}" class="btn btn-primary btn-xs pull-right"><span class="fa fa-reply fa-fw"></span> Go to Client Orders</a>
                    @endif
                </h3>
                @if($dispatchedTransactions->count() > 0)
                    @foreach($dispatchedTransactions as $transaction)
                        @if($transaction->delivery_status === 'Dispatched')
                            <div class="alert alert-info">
                                <h3 class="no-margin">Transaction ID No. {{ sprintf('%010d', $transaction->id) }}</h3>
                                <h5 style="margin: 15px 0;">
                                    <div style="margin: 0 0 5px 10px;">
                                        <strong>Product(s):</strong>
                                    </div>
                                    <ul>
                                        @foreach($transaction->orders as $order)
                                            <li>{{ $order->product->name }} (x{{ $order->quantity }})</li>
                                        @endforeach
                                    </ul>
                                </h5>
                                <h5 class="text-right no-margin">Dispatched last {{ date('F d, Y (h:i A)', strtotime($transaction->datetime_delivered)) }}</h5>
                            </div>
                        @endif
                    @endforeach
                @else
                    <div class="alert alert-primary">
                        <h5 class="text-center no-margin">No dispatched client orders found.</h5>
                    </div>
                @endif
            </div>
            <div class="col-sm-4">
                <div class="alert alert-success">
                    <h4 data-load="date" class="no-margin"></h4>
                    <h2 data-load="time" class="no-margin"></h2>
                </div>
                <h3 class="column-header">Audit Trail</h3>
                <div style="overflow-y: scroll; padding-right: 5px; max-height: 400px;">
                    <div class="list-group">
                        @foreach($logs as $index => $log)
                            @if($log->account->role === 'Employee')
                                <div class="list-group-item{{ ($index === 0 ? ' active' : '') }}">
                                    <h4 class="list-group-item-heading">{{ date('F d, Y (h:i A)', strtotime($log->created_at)) }}</h4>
                                    <p class="list-group-item-text">{{ $log->account->user_info->first_name . ' ' . $log->account->user_info->last_name . ' ' . $log->action }}</p>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
