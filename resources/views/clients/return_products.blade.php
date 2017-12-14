@extends('layouts.clients')

@section('content')
    <div class="page-header">
        <h1 class="no-margin">Return Products</h1>
    </div>
    <div class="container-fluid">
        @include('partials.flash')
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th width="10%">ID</th>
                    <th>Transaction Date</th>
                    <th>Product(s) Ordered</th>
                    <th>Product(s) Returned</th>
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
                            <td>
                                @if($transaction->cancellations->count() > 0)
                                    @foreach($transaction->cancellations as $cancellation)
                                        <div>{{ $cancellation->product->name }} (x{{ $cancellation->quantity }})</div>
                                    @endforeach
                                @else
                                    <div class="text-center">None</div>
                                @endif
                            </td>
                            <td class="text-center">{{ $transaction->payment_method }}</td>
                            <td class="text-center">{{ $transaction->delivery_status }}</td>
                            <td class="text-center">
                                @if($transaction->cancellations->count() === 0)
                                    <a href="{{ route('clients.get.products_return_process', $transaction->id) }}" class="btn btn-danger btn-xs""><span class="fa fa-reply fa-fw"></span> Return</a>
                                @else
                                    <div class="text-center">No actions needed to perform.</div>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td class="text-center" colspan="7">No transactions found.</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
@endsection
