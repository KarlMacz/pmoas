@extends('layouts.clients')

@section('meta')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('resources')
    <script src="{{ asset('js/custom/clients/products.js') }}"></script>
@endsection

@section('content')
    <div class="page-header">
        <h1 class="no-margin">Products</h1>
    </div>
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th width="20%">Image</th>
                <th width="20%">Name</th>
                <th width="30%">Description</th>
                <th width="10%">Quantity Available</th>
                <th width="10%">Price</th>
                <th width="10%"></th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $product)
                <tr>
                    <td class="text-center">
                        @if($product->image)
                            <img src="{{ asset('img/' . $product->image) }}">
                        @else
                            No Image Available
                        @endif
                    </td>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->description }}</td>
                    <td class="text-center">
                        <?php
                            $stockQuantity = 0;

                            foreach($product->stocks as $stock) {
                                $stockQuantity += $stock->quantity;
                            }

                            echo $stockQuantity;
                        ?>
                    </td>
                    <td class="text-center">Php {{ $product->price_per_piece }}</td>
                    <td class="text-center">
                        <button class="add-to-cart-button btn btn-primary btn-xs" data-id="{{ $product->id }}"><span class="fa fa-plus fa-fw"></span> Add to cart</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection

@section('modals')
    <div id="add-to-cart-modal" class="modal fade">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add to Cart</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="quantity-field">Quantity:</label>
                        <input type="number" name="quantity" id="quantity-field" class="form-control" min="1" placeholder="Quantity">
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="yes-button btn btn-success btn-sm"><span class="fa fa-plus fa-fw"></span> Add</button>
                    <button class="no-button btn btn-danger btn-sm"><span class="fa fa-times fa-fw"></span> Cancel</button>
                </div>
            </div>
        </div>
    </div>
    <div id="loading-modal" class="modal fade">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <div style="margin-bottom: 10px;"><span class="fa fa-spinner fa-pulse fa-3x"></span></div>
                    <h4 class="no-margin">Please Wait...</h4>
                </div>
            </div>
        </div>
    </div>
@endsection
