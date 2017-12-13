@extends('layouts.clients')

@section('content')
    <div class="page-header">
        <h1 class="no-margin">Home</h1>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-8">
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Magnam ad perferendis, esse quod corporis non est. Debitis, vitae provident ea, rerum tenetur, eveniet esse est qui ducimus voluptatem, sunt odit!</p>
            </div>
            <div class="col-sm-4">
                <div class="alert alert-success">
                    <h4 data-load="date" class="no-margin"></h4>
                    <h2 data-load="time" class="no-margin"></h2>
                </div>
            </div>
        </div>
    </div>
@endsection
