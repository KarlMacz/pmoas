@extends('layouts.employees')

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
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
