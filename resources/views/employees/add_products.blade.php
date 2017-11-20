@extends('layouts.employees')

@section('resources')
    <script src="{{ asset('js/custom/employees/add_products.js') }}"></script>
@endsection

@section('content')
    <div class="page-header">
        <h1 class="no-margin">Products</h1>
        <div>Add Product</div>
    </div>
    <div class="container-spacious">
        @include('partials.flash')
        <form action="{{ route('employees.post.products_add') }}" method="POST">
            {{ csrf_field() }}
            <div class="row">
                <div class="col-sm-4">
                    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                        <label for="product-name-field">Product Name:</label>
                        <input type="text" name="name" id="product-name-field" class="form-control" value="{{ old('name') }}" placeholder="Product Name" required autofocus>
                        @if ($errors->has('name'))
                            <span class="help-block">
                                <strong>{{ $errors->first('name') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group{{ $errors->has('price') ? ' has-error' : '' }}">
                        <label for="price-field">Price:</label>
                        <input type="number" name="price" id="price-field" class="form-control" min="1" value="{{ old('price') }}" placeholder="Price" required>
                        @if ($errors->has('price'))
                            <span class="help-block">
                                <strong>{{ $errors->first('price') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group{{ $errors->has('min_pieces') ? ' has-error' : '' }}">
                        <label for="min-pieces-field">Minimum pieces per bulk order:</label>
                        <input type="number" name="min_pieces" id="min-pieces-field" class="form-control" min="1" value="{{ old('min_pieces') }}" placeholder="Minimum pieces per bulk order" required>
                        @if ($errors->has('min_pieces'))
                            <span class="help-block">
                                <strong>{{ $errors->first('min_pieces') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                        <label for="description-field">Description:</label>
                        <textarea name="description" id="description-field" cols="30" rows="10" class="form-control" maxlength="1000" placeholder="Description" style="resize: none;" required>{{ old('description') }}</textarea>
                        @if ($errors->has('description'))
                            <span class="help-block">
                                <strong>{{ $errors->first('description') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
            </div>
            <div class="well">
                <div style="margin-bottom: 10px;">
                    <button type="button" class="add-stock-button btn btn-primary btn-sm"><span class="fa fa-plus fa-fw"></span> Add Stock</button>
                </div>
                <div id="stocks-fieldset">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <div class="input-group">
                                    <label for="quantity-field" class="input-group-addon">Quantity:</label>
                                    <input type="number" name="quantity[]" id="quantity-field" class="form-control" min="1" placeholder="Quantity" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <div class="input-group">
                                    <label for="expiration-date-field" class="input-group-addon">Expiration Date:</label>
                                    <input type="date" name="expiration_date[]" id="expiration-date-field" class="form-control" placeholder="Expiration Date" required>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group text-right">
                <button class="btn btn-success" type="submit"><span class="fa fa-plus fa-fw"></span> Add</button>
            </div>
        </form>
    </div>
@endsection
