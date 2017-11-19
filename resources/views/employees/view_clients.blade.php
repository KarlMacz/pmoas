@extends('layouts.employees')

@section('content')
    <div class="page-header">
        <h1 class="no-margin">Company Clients</h1>
        <div>View All Company Clients</div>
    </div>
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th width="10%">ID</th>
                <th>Name</th>
                <th>Birth Date</th>
                <th>Age</th>
                <th>Address</th>
                <th>Contact Number</th>
                <th>Type</th>
                <th>Company</th>
            </tr>
        </thead>
        <tbody>
            @foreach($clients as $client)
                <tr>
                    <td>{{ $client->id }}</td>
                    <td>{{ $client->user_info->first_name . ' ' . $client->user_info->last_name }}</td>
                    <td>{{ date('F d, Y', strtotime($client->user_info->birth_date)) }}</td>
                    <td>{{ $client->user_info->age() }}</td>
                    <td>{{ $client->user_info->address }}</td>
                    <td>{{ $client->user_info->contact_number }}</td>
                    <td>{{ $client->user_info->type }}</td>
                    <td>{{ $client->user_info->company }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
