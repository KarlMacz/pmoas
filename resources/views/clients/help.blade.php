@extends('layouts.clients')

@section('content')
    <div class="page-header">
        <h1 class="no-margin">Help</h1>
        <div>Frequently Asked Questions (FAQ)</div>
    </div>
    <div class="container-spacious">
        <div class="list-group">
            @if($helps->count() > 0)
                @foreach($helps as $help)
                    <div class="list-group-item">
                        <h4>{{ $help->question }}</h4>
                        <p>{{ $help->answer }}</p>
                    </div>
                @endforeach
            @else
                <div class="list-group-item text-center">No results found.</div>
            @endif
        </div>
    </div>
@endsection
