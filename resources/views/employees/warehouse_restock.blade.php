@extends('layouts.employees')

@section('content')
    <div class="page-header">
        <h1 class="no-margin">Warehouse Management</h1>
        <div>Re-stock</div>
    </div>
    <div class="container-spacious">
        @include('partials.flash')
        <form action="{{ route('employees.post.warehouse_restock', $product->id) }}" method="POST">
            {{ csrf_field() }}
            <div class="form-group">
                <label>Product Name:</label>
                <input type="text" class="form-control" value="{{ $product->name }}" readonly>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="quantity-field">Quantity:</label>
                        <input type="number" name="quantity" id="quantity-field" class="form-control" min="1" placeholder="Quantity" required>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="expiration-date-field">Expiration Date:</label>
                        <input type="date" name="expiration_date" id="expiration-date-field" class="form-control" placeholder="Expiration Date" required>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="supplier-field">Supplier:</label>
                <select name="supplier" class="form-control" id="supplier-field" required>
                    <option value="" selected disabled>Select an option...</option>
                    @foreach($suppliers as $supplier)
                        <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group text-right">
                <button class="btn btn-success" type="submit"><span class="fa fa-plus fa-fw"></span> Re-stock</button>
            </div>
        </form>
    </div>
@endsection
