@extends('layouts.employees')

@section('meta')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('resources')
    <script src="{{ asset('js/custom/employees/products.js') }}"></script>
@endsection

@section('content')
    <div class="page-header">
        <h1 class="no-margin">Products Catalogue</h1>
        <div>View All Products</div>
    </div>
    <div class="container-fluid">
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th width="20%">Image</th>
                    <th width="20%">Name</th>
                    <th width="25%">Description</th>
                    <th width="10%">Quantity Available</th>
                    <th width="10%">Price</th>
                    <th width="15%"></th>
                </tr>
            </thead>
            <tbody>
                @if($products->count() > 0)
                    @foreach($products as $product)
                        <tr>
                            <td class="text-center">
                                @if($product->image)
                                    <img src="{{ asset('uploads/' . $product->image) }}" style="width: 100%;">
                                @else
                                    No Image Available
                                @endif
                            </td>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->description }}</td>
                            <td class="text-center">{{ $product->remaining_quantity }}</td>
                            <td class="text-center">Php {{ $product->price_per_piece }}</td>
                            <td class="text-center">
                                <a href="{{ route('employees.get.products_edit', $product->id) }}" class="btn btn-success btn-xs"><span class="fa fa-pencil fa-fw"></span> Edit</a>
                                <button class="delete-product-button btn btn-danger btn-xs" data-id="{{ $product->id }}"><span class="fa fa-trash fa-fw"></span> Delete</button>
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
    <div id="delete-product-modal" class="modal fade">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Delete Product</h4>
                </div>
                <div class="modal-body">Are you sure you want to delete this product?</div>
                <div class="modal-footer">
                    <button type="button" class="yes-button btn btn-success btn-sm"><span class="fa fa-plus fa-fw"></span> Yes</button>
                    <button type="button" class="no-button btn btn-danger btn-sm"><span class="fa fa-times fa-fw"></span> No</button>
                </div>
            </div>
        </div>
    </div>
@endsection
