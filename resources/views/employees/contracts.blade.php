@extends('layouts.employees')

@section('meta')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('resources')
    <script src="{{ asset('js/custom/employees/contracts.js') }}"></script>
@endsection

@section('content')
    <div class="page-header">
        <h1 class="no-margin">Contract Management</h1>
        <div>Enterprise Contract Control</div>
    </div>
    <div class="container-fluid">
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th width="20%">Client Name</th>
                    <th width="10%">Contract Type</th>
                    <th width="15%">Holdback Amount</th>
                    <th width="15%">Maximum Amount</th>
                    <th width="10%">Mode of Payment</th>
                    <th width="30%"></th>
                </tr>
            </thead>
            <tbody>
                @if($contracts->count() > 0)
                    @foreach($contracts as $contract)
                        <tr>
                            <td>{{ $contract->contractee->user_info->first_name . ' ' . $contract->contractee->user_info->last_name }}</td>
                            <td class="text-center">{{ $contract->type }}</td>
                            <td>Php {{ $contract->holdback_amount }}</td>
                            <td>Php {{ $contract->maximum_amount }}</td>
                            <td class="text-center">{{ $contract->mode_of_payment }}</td>
                            <td class="text-center">
                                <button class="view-contract-button btn btn-primary btn-xs" data-id="{{ hash('sha256', $contract->id) }}"><span class="fa fa-th-list fa-fw"></span> View</button>
                                <a href="{{ route('employees.get.contract_documents', $contract->id) }}" class="btn btn-info btn-xs"><span class="fa fa-th-list fa-fw"></span> Manage Documents</a>
                                <button class="delete-contract-button btn btn-danger btn-xs" data-id="{{ $contract->id }}"><span class="fa fa-trash fa-fw"></span> Delete</button>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td class="text-center" colspan="6">No contracts found.</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
@endsection

@section('modals')
    <div id="delete-contract-modal" class="modal fade">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Delete Contracts</h4>
                </div>
                <div class="modal-body">Are you sure you want to delete this contract?</div>
                <div class="modal-footer">
                    <button type="button" class="yes-button btn btn-success btn-sm"><span class="fa fa-plus fa-fw"></span> Yes</button>
                    <button type="button" class="no-button btn btn-danger btn-sm"><span class="fa fa-times fa-fw"></span> No</button>
                </div>
            </div>
        </div>
    </div>
@endsection
