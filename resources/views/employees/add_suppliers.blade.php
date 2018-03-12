@extends('layouts.employees')

@section('resources')
    <script src="{{ asset('js/custom/employees/add_products.js') }}"></script>
@endsection

@section('content')
    <div class="page-header">
        <h1 class="no-margin">Suppliers</h1>
        <div>Add Supplier</div>
    </div>
    <div class="container-spacious">
        @include('partials.flash')
        <form action="{{ route('employees.post.suppliers_add') }}" method="POST">
            {{ csrf_field() }}
            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                <label for="name-field">Name:</label>
                <input type="text" name="name" id="name-field" class="form-control" value="{{ old('name') }}" placeholder="Name" required autofocus>
                @if ($errors->has('name'))
                    <span class="help-block">
                        <strong>{{ $errors->first('name') }}</strong>
                    </span>
                @endif
            </div>
            <div class="form-group text-right">
                <button class="btn btn-success" type="submit"><span class="fa fa-plus fa-fw"></span> Add</button>
            </div>
        </form>
    </div>
@endsection
