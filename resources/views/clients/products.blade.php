@extends('layouts.clients')

@section('meta')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('resources')
    <script src="{{ asset('js/custom/clients/products.js') }}"></script>
@endsection

@section('content')
    <div class="page-header">
        <h1 class="no-margin">Products Catalogue</h1>
    </div>
    <div class="container-fluid">
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
                @if($products->count() > 0)
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
                            <td class="text-center">{{ $product->remaining_quantity }}</td>
                            <td class="text-center">Php {{ $product->price_per_piece }}</td>
                            <td class="text-center">
                                @if($product->remaining_quantity > 0)
                                    <button class="add-to-cart-button btn btn-primary btn-xs" data-id="{{ $product->id }}"><span class="fa fa-plus fa-fw"></span> Add to cart</button>
                                @else
                                    Out of stock.
                                @endif
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td class="text-center" colspan="6">No products found.</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
@endsection

@section('modals')
    <div id="add-to-cart-modal" class="modal fade">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">...</h4>
                </div>
                <div class="modal-body">...</div>
                <div class="modal-footer">
                    <button type="button" class="yes-button btn btn-success btn-sm"><span class="fa fa-plus fa-fw"></span> Add</button>
                    <button type="button" class="no-button btn btn-danger btn-sm"><span class="fa fa-times fa-fw"></span> Cancel</button>
                </div>
            </div>
        </div>
    </div>
@endsection
