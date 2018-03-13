@extends('layouts.employees')

@section('meta')
    <meta name="main-route" content="{{ url('/') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('resources')
    <script src="{{ asset('js/custom/employees/client_orders.js') }}"></script>
@endsection

@section('content')
    <div class="page-header">
        <h1 class="no-margin">Client Orders</h1>
    </div>
    <div class="container-fluid">
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th width="20%">Client Name</th>
                    <th>Product(s)</th>
                    <th width="10%">Total Amount</th>
                    <th width="10%">Payment Method</th>
                    <th width="10%">Is Paid</th>
                    <th width="10%">Delivery Status</th>
                    <th width="20%"></th>
                </tr>
            </thead>
            <tbody>
                @if($transactions->count() > 0)
                    @foreach($transactions as $transaction)
                        <tr>
                            <td>{{ $transaction->account->user_info->first_name . ' ' . $transaction->account->user_info->last_name }}</td>
                            <td>
                                @foreach($transaction->orders as $order)
                                    <div>{{ $order->product->name }} (x{{ $order->quantity }})</div>
                                @endforeach
                            </td>
                            <td class="text-center">Php {{ $transaction->total_amount }}</td>
                            <td class="text-center">{{ $transaction->payment_method }}</td>
                            <td class="text-center">{{ ($transaction->amount_paid === $transaction->total_amount ? 'Yes' : 'No') }}</td>
                            <td class="text-center">{{ $transaction->delivery_status }}</td>
                            <td class="text-center">
                                @if($transaction->delivery_status === 'Pending')
                                    @if($transaction->payment_method === 'PayPal')
                                        @if($transaction->amount_paid === $transaction->total_amount)
                                            <button class="confirm-transaction-button btn btn-primary btn-xs" data-id="{{ $transaction->id }}"><span class="fa fa-check fa-fw"></span> Confirm</button>
                                        @endif
                                    @else
                                        <button class="confirm-transaction-button btn btn-primary btn-xs" data-id="{{ $transaction->id }}"><span class="fa fa-check fa-fw"></span> Confirm</button>
                                    @endif
                                    <button class="delete-transaction-button btn btn-danger btn-xs" data-id="{{ $transaction->id }}"><span class="fa fa-trash fa-fw"></span> Delete</button>
                                @elseif($transaction->delivery_status === 'Dispatched')
                                    <button class="print-transaction-receipt-button btn btn-info btn-xs" data-id="{{ $transaction->id }}"><span class="fa fa-print fa-fw"></span> Print Receipt</button>
                                    <button class="mark-transaction-button btn btn-primary btn-xs" data-id="{{ $transaction->id }}"><span class="fa fa-check fa-fw"></span> Mark as Delivered</button>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td class="text-center" colspan="7">No products found.</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
@endsection


@section('modals')
    <div id="confirm-transaction-modal" class="modal fade">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Confirm Transaction</h4>
                </div>
                <div class="modal-body">
                    Are you sure you want to confirm this transaction? Confirming transaction means all products specified are ready to be delivered to the client.<br><br>
                    For transactions that used PayPal as a payment method, confirming transaction also means that payment has already been made.
                </div>
                <div class="modal-footer">
                    <button type="button" class="yes-button btn btn-success btn-sm"><span class="fa fa-plus fa-fw"></span> Yes</button>
                    <button type="button" class="no-button btn btn-danger btn-sm"><span class="fa fa-times fa-fw"></span> No</button>
                </div>
            </div>
        </div>
    </div>
    <div id="mark-transaction-modal" class="modal fade">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Mark Transaction as Delivered</h4>
                </div>
                <div class="modal-body">
                    Are you sure you want to mark this transaction? Marking transaction means all products has been delivered to the client.
                </div>
                <div class="modal-footer">
                    <button type="button" class="yes-button btn btn-success btn-sm"><span class="fa fa-plus fa-fw"></span> Yes</button>
                    <button type="button" class="no-button btn btn-danger btn-sm"><span class="fa fa-times fa-fw"></span> No</button>
                </div>
            </div>
        </div>
    </div>
    <div id="delete-transaction-modal" class="modal fade">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Delete Transaction</h4>
                </div>
                <div class="modal-body">Are you sure you want to delete this transaction? All products ordered will be cancelled.</div>
                <div class="modal-footer">
                    <button type="button" class="yes-button btn btn-success btn-sm"><span class="fa fa-plus fa-fw"></span> Yes</button>
                    <button type="button" class="no-button btn btn-danger btn-sm"><span class="fa fa-times fa-fw"></span> No</button>
                </div>
            </div>
        </div>
    </div>
@endsection
