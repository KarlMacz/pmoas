@extends('layouts.clients')

@section('content')
    <div class="page-header">
        <h1 class="no-margin">Search</h1>
        <div>Display Search Results</div>
    </div>
    <div class="container-spacious">
        <div class="text-right">Showing results for <strong>{{ Input::get('search') }}</strong>.</div>
        <h3>Products</h3>
        <div class="list-group">
            @if($products->count() > 0)
                @foreach($products as $product)
                    <div class="list-group-item">
                        <h2>{{ $product->name }}</h2>
                        <h4 class="no-margin">Product ID No. {{ sprintf('%010d', $product->id) }}</h4>
                        <h4 style="margin: 15px 0;">{{ $product->description }}</h4>
                        <h4 class="text-right no-margin">Php {{ $product->price_per_piece }} per item.</h4>
                    </div>
                @endforeach
            @else
                <div class="list-group-item text-center">No results found.</div>
            @endif
        </div>
    </div>
@endsection
