@extends('layouts.employees')

@section('meta')
    <meta name="main-route" content="{{ url('/') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('resources')
    <script src="{{ asset('js/custom/employees/reports.js') }}"></script>
@endsection

@section('content')
    <div class="page-header">
        <h1 class="no-margin">Reports</h1>
        <div>Supplier Report</div>
    </div>
    <div class="container-spacious">
        <div class="form-group text-right">
            <button type="button" class="generate-report-button btn btn-primary" data-type="supplier"><span class="fa fa-refresh fa-fw"></span> Generate Report</button>
        </div>
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>File</th>
                    <th width="10%"></th>
                </tr>
            </thead>
            <tbody>
                @if(count($reports) > 0)
                    @foreach($reports as $report)
                        @if($report !== '.gitignore')
                            <tr>
                                <td>{{ $report }}</td>
                                <td class="text-center">
                                    <button class="view-report-button btn btn-primary btn-xs" data-type="supplier" data-id="{{ $report }}"><span class="fa fa-th-list fa-fw"></span> View</button>
                                </td>
                            </tr>
                        @endif
                    @endforeach
                @else
                    <tr>
                        <td class="text-center" colspan="6">No reports found.</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
@endsection
