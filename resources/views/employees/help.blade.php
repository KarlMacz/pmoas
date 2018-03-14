@extends('layouts.employees')

@section('meta')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('resources')
    <script src="{{ asset('js/custom/employees/help.js') }}"></script>
@endsection

@section('content')
    <div class="page-header">
        <h1 class="no-margin">Help</h1>
        <div>Frequently Asked Questions (FAQ)</div>
    </div>
    <div class="container-fluid">
        <div class="form-group text-right">
            <a href="{{ route('employees.get.help_add') }}" class="btn btn-primary"><span class="fa fa-plus fa-fw"></span> Add</a>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <h4>Frequently Asked Questions for Employees</h4>
                <div class="list-group">
                    @if($employee_helps->count() > 0)
                        @foreach($employee_helps as $employee_help)
                            <div class="list-group-item">
                                <div class="text-right" style="border-bottom: 1px solid #eee; padding-bottom: 10px; margin-bottom: 10px;">
                                    <button class="delete-help-button btn btn-danger btn-xs" data-id="{{ $employee_help->id }}"><span class="fa fa-close fa-fw"></span> Delete</button>
                                </div>
                                <h4>{{ $employee_help->question }}</h4>
                                <p>{{ $employee_help->answer }}</p>
                            </div>
                        @endforeach
                    @else
                        <div class="list-group-item text-center">No results found.</div>
                    @endif
                </div>
            </div>
            <div class="col-sm-6">
                <h4>Frequently Asked Questions for Client</h4>
                <div class="list-group">
                    @if($client_helps->count() > 0)
                        @foreach($client_helps as $client_help)
                            <div class="list-group-item">
                                <div class="text-right" style="border-bottom: 1px solid #eee; padding-bottom: 10px; margin-bottom: 10px;">
                                    <button class="delete-help-button btn btn-danger btn-xs" data-id="{{ $client_help->id }}"><span class="fa fa-close fa-fw"></span> Delete</button>
                                </div>
                                <h4>{{ $client_help->question }}</h4>
                                <p>{{ $client_help->answer }}</p>
                            </div>
                        @endforeach
                    @else
                        <div class="list-group-item text-center">No results found.</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@section('modals')
    <div id="delete-help-modal" class="modal fade">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Delete Frequently Asked Question</h4>
                </div>
                <div class="modal-body">Are you sure you want to delete this frequently asked question?</div>
                <div class="modal-footer">
                    <button type="button" class="yes-button btn btn-success btn-sm"><span class="fa fa-plus fa-fw"></span> Yes</button>
                    <button type="button" class="no-button btn btn-danger btn-sm"><span class="fa fa-times fa-fw"></span> No</button>
                </div>
            </div>
        </div>
    </div>
@endsection
