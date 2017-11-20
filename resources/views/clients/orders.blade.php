@extends('layouts.clients')

@section('meta')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('resources')
    <script src="{{ asset('js/custom/clients/shopping_cart.js') }}"></script>
@endsection

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
                    <th width="20%">Status</th>
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
                                <ul class="no-margin">
                                    @foreach($transaction->orders as $order)
                                        <li>{{ $order->product->name }} <strong>{{ $order->quantity }}</strong></li>
                                    @endforeach
                                </ul>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td class="text-center" colspan="5">No transactions found.</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
@endsection
