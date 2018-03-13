@extends('layouts.employees')

@section('meta')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('resources')
    <script src="{{ asset('js/custom/employees/employees.js') }}"></script>
@endsection

@section('content')
    <div class="page-header">
        <h1 class="no-margin">Employees</h1>
        <div>View All Employees</div>
    </div>
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th width="10%">ID</th>
                <th>Name</th>
                <th>E-mail Address</th>
                <th>Contact Number</th>
                <th>Position</th>
                <th width="10%"></th>
            </tr>
        </thead>
        <tbody>
            @foreach($employees as $employee)
                <tr>
                    <td>{{ $employee->id }}</td>
                    <td>{{ $employee->user_info->first_name . ' ' . $employee->user_info->last_name }}</td>
                    <td>{{ $employee->email }}</td>
                    <td>{{ $employee->user_info->contact_number }}</td>
                    <td>{{ $employee->user_info->position }}</td>
                    <td class="text-center">
                        @if(Auth::user()->user_info->position === 'Administrator')
                            <a href="{{ route('employees.get.employees_edit', $employee->id) }}" class="btn btn-success btn-xs"><span class="fa fa-pencil fa-fw"></span> Edit</a>
                            <button class="delete-employee-button btn btn-danger btn-xs" data-id="{{ $employee->id }}"><span class="fa fa-trash fa-fw"></span> Delete</button>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection

@section('modals')
    <div id="delete-employee-modal" class="modal fade">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Delete Employee</h4>
                </div>
                <div class="modal-body">Are you sure you want to delete this employee?</div>
                <div class="modal-footer">
                    <button type="button" class="yes-button btn btn-success btn-sm"><span class="fa fa-plus fa-fw"></span> Yes</button>
                    <button type="button" class="no-button btn btn-danger btn-sm"><span class="fa fa-times fa-fw"></span> No</button>
                </div>
            </div>
        </div>
    </div>
@endsection
