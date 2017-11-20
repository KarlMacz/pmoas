@extends('layouts.clients')

@section('meta')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('resources')
    <script src="{{ asset('js/custom/clients/contracts.js') }}"></script>
@endsection

@section('content')
    <div class="page-header">
        <h1 class="no-margin">Contracts</h1>
    </div>
    <div class="container-fluid">
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th width="10%">ID</th>
                    <th>Type</th>
                    <th>Date Created</th>
                    <th width="10%"></th>
                </tr>
            </thead>
            <tbody>
                @if($contracts->count() > 0)
                    @foreach($contracts as $contract)
                        <tr>
                            <td class="text-center">{{ $contract->id }}</td>
                            <td class="text-center">{{ $contract->type }}</td>
                            <td class="text-center">{{ date('F d, Y (h:i A)', strtotime($contract->created_at)) }}</td>
                            <td>
                                <button class="view-contract-button btn btn-primary btn-xs" data-id="{{ $contract->id }}"><span class="fa fa-eye fa-fw"></span> View</button>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td class="text-center" colspan="5">No contracts found.</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
@endsection
