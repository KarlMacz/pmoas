@extends('layouts.clients')

@section('content')
    <div class="page-header">
        <h1 class="no-margin">Return Products</h1>
        <div>Process Form</div>
    </div>
    <div class="container-spacious">
        @include('partials.flash')
        <form action="{{ route('clients.post.products_return_process', $transaction->id) }}" method="POST">
            {{ csrf_field() }}
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th width="25%">Quantity</th>
                    </tr>
                </thead>
                <tbody>
                    @if($transaction)
                        @foreach($transaction->orders as $index => $order)
                            <tr>
                                <td>
                                    <input type="hidden" name="id[]" class="form-control" value="{{ $order->product->id }}">
                                    <div class="form-group">
                                        <input type="text" class="form-control" value="{{ $order->product->name }}" readonly>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group{{ $errors->has('quantity' . $index) ? ' has-error' : '' }}">
                                        <input type="number" name="quantity[]" class="form-control" value="{{ old('quantity.' . $index) }}" min="0" max="{{ $order->quantity }}" placeholder="Quantity" required>
                                        @if ($errors->has('quantity.' . $index))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('quantity' . $index) }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="2" class="text-center">No products found.</td>
                        </tr>
                    @endif
                </tbody>
            </table>
            <div class="form-group text-right">
                <button class="btn btn-danger" type="submit"><span class="fa fa-reply fa-fw"></span> Return Product(s)</button>
            </div>
        </form>
    </div>
@endsection
