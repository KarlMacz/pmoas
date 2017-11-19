@extends('layouts.employees')

@section('content')
    <div class="page-header">
        <h1 class="no-margin">Dashboard</h1>
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
                <h3 class="column-header">Audit Trail</h3>
                <div class="list-group">
                    @foreach($logs as $index => $log)
                        <div class="list-group-item{{ ($index === 0 ? ' active' : '') }}">
                            <h4 class="list-group-item-heading">{{ date('F d, Y (h:i A)', strtotime($log->created_at)) }}</h4>
                            <p class="list-group-item-text">{{ $log->account->user_info->first_name . ' ' . $log->account->user_info->last_name . ' ' . $log->action }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
