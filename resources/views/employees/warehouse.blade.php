@extends('layouts.employees')

@section('meta')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('resources')
    <script src="{{ asset('js/custom/employees/products.js') }}"></script>
@endsection

@section('content')
    <div class="page-header">
        <h1 class="no-margin">Warehouse Management</h1>
    </div>
    <div class="container-fluid">
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th width="20%">Image</th>
                    <th>Name</th>
                    <th width="10%">Quantity Available</th>
                    <th width="15%">Quantity Critical Level</th>
                    <th width="15%"></th>
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
                            <td class="text-center">{{ $product->remaining_quantity }}</td>
                            <td class="text-center">{{ $product->quantity_critical_level }}</td>
                            <td class="text-center">
                                <a href="{{ route('employees.get.warehouse_restock', $product->id) }}" class="btn btn-info btn-xs"><span class="fa fa-plus fa-fw"></span> Re-stock</a>
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
