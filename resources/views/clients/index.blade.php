@extends('layouts.clients')

@section('content')
    <div class="page-header">
        <h1 class="no-margin">Home</h1>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-8"></div>
            <div class="col-sm-4">
                <div class="alert alert-success">
                    <h4 data-load="date" class="no-margin"></h4>
                    <h2 data-load="time" class="no-margin"></h2>
                </div>
            </div>
        </div>
    </div>
@endsection
