@extends('layouts.employees')

@section('content')
    <div class="page-header">
        <h1 class="no-margin">Products</h1>
        <div>Edit Product</div>
    </div>
    <div class="container-spacious">
        @include('partials.flash')
        <form action="{{ route('employees.post.products_edit', $product->id) }}" method="POST">
            {{ csrf_field() }}
            <div class="row">
                <div class="col-sm-4">
                    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                        <label for="product-name-field">Product Name:</label>
                        <input type="text" name="name" id="product-name-field" class="form-control" value="{{ (old('name') ? old('name') : $product->name) }}" placeholder="Product Name" required autofocus>
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
                        <input type="number" name="price" id="price-field" class="form-control" min="1" value="{{ (old('price') ? old('price') : $product->price_per_piece) }}" placeholder="Price" required>
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
                        <input type="number" name="min_pieces" id="min-pieces-field" class="form-control" min="1" value="{{ (old('min_pieces') ? old('min_pieces') : $product->minimum_pieces_per_bulk) }}" placeholder="Minimum pieces per bulk order" required>
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
                        <textarea name="description" id="description-field" cols="30" rows="10" class="form-control" maxlength="1000" placeholder="Description" style="resize: none;" required>{{ (old('description') ? old('description') : $product->description) }}</textarea>
                        @if ($errors->has('description'))
                            <span class="help-block">
                                <strong>{{ $errors->first('description') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
            </div>
            <div class="form-group text-right">
                <button class="btn btn-success" type="submit"><span class="fa fa-check fa-fw"></span> Save Changes</button>
            </div>
        </form>
    </div>
@endsection
