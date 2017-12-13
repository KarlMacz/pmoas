@extends('layouts.clients')

@section('meta')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('resources')
    <script src="{{ asset('js/custom/clients/shopping_cart.js') }}"></script>
@endsection

@section('content')
    <div class="page-header">
        <h1 class="no-margin">Shopping Cart</h1>
    </div>
    <div class="container-fluid">
        @include('partials.flash')
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th width="20%">Image</th>
                    <th width="35%">Name</th>
                    <th width="10%">Quantity to Buy</th>
                    <th width="10%">Price per Piece</th>
                    <th width="15%">Sub-total</th>
                    <th width="10%"></th>
                </tr>
            </thead>
            <tbody>
                @if($cart)
                    <?php
                        $totalAmount = 0;
                    ?>
                    @foreach($cart->items as $cartItem)
                        <tr>
                            <td class="text-center">
                                @if($cartItem->product->image)
                                    <img src="{{ asset('img/' . $cartItem->product->image) }}">
                                @else
                                    No Image Available
                                @endif
                            </td>
                            <td>{{ $cartItem->product->name }}</td>
                            <td class="text-center">{{ $cartItem->quantity }}</td>
                            <td class="text-center">Php {{ $cartItem->product->price_per_piece }}</td>
                            <td class="text-right">Php {{ $cartItem->quantity * $cartItem->product->price_per_piece }}</td>
                            <td class="text-center">
                                <button class="remove-from-cart-button btn btn-danger btn-xs" data-id="{{ $cartItem->id }}"><span class="fa fa-trash fa-fw"></span> Remove</button>
                            </td>
                        </tr>
                        <?php
                            $totalAmount += $cartItem->quantity * $cartItem->product->price_per_piece;
                        ?>
                    @endforeach
                @else
                    <tr>
                        <td class="text-center" colspan="6">No products found.</td>
                    </tr>
                @endif
            </tbody>
            @if($cart)
                <tfoot>
                    <tr>
                        <th class="text-right" colspan="4">Total:</th>
                        <th class="text-right">Php {{ $totalAmount }}</th>
                    </tr>
                </tfoot>
            @endif
        </table>
        @if($cart->items->count() > 0)
            <hr>
            <form action="{{ route('clients.post.orders_add') }}" method="POST">
                {{ csrf_field() }}
                <div class="form-group{{ $errors->has('payment_method') ? ' has-error' : '' }}">
                    <label for="payment-method-field">Payment Method:</label>
                    <select name="payment_method" id="payment-method-field" class="form-control" required>
                        <option value="" selected disabled>Select an option...</option>
                        <option value="Cash on Delivery">Cash on Delivery</option>
                        <option value="PayPal">PayPal</option>
                    </select>
                    @if ($errors->has('payment_method'))
                        <span class="help-block">
                            <strong>{{ $errors->first('payment_method') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group text-right">
                    <button type="submit" class="btn btn-primary"><span class="fa fa-check fa-fw"></span> Order Product(s)</button>
                </div>
            </form>
        @endif
    </div>
@endsection
