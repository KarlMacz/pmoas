@extends('layouts.employees')

@section('resources')
    <script src="{{ asset('js/custom/maintenance/index.js') }}"></script>
@endsection

@section('content')
    <div class="page-header">
        <h1 class="no-margin">Maintenance</h1>
    </div>
    <div class="container-fluid">
        @include('partials.flash')
        <div class="row">
            <div class="col-sm-6">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <div class="panel-title">Back-Up Database</div>
                    </div>
                    <div class="panel-body">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>File</th>
                                    <th width="10%"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(count($backupDatabaseFiles) > 0)
                                    @foreach($backupDatabaseFiles as $databaseFile)
                                        @if($databaseFile !== '.gitignore')
                                            <tr>
                                                <td>{{ $databaseFile }}</td>
                                                <td class="text-center">
                                                    <a href="{{ route('maintenance.get.database', $databaseFile) }}" class="btn btn-primary btn-xs">Download</a>
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                @else
                                    <tr>
                                        <td class="text-center" colspan="6">No databases found.</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                    <div class="panel-footer">
                        <form action="{{ route('maintenance.post.backup') }}" method="POST">
                            {{ csrf_field() }}
                            <input type="hidden" name="id" value="{{ hash('sha256', date('Y-m-d') . '_database') }}">
                            <div class="form-group text-right no-margin">
                                <button type="submit" class="btn btn-primary btn-sm"><span class="fa fa-database fa-fw"></span> Create Back-Up</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <div class="panel-title">Back-Up Files</div>
                    </div>
                    <div class="panel-body">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>File</th>
                                    <th width="10%"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(count($backupSystemFiles) > 0)
                                    @foreach($backupSystemFiles as $systemFile)
                                        @if($systemFile !== '.gitignore')
                                            <tr>
                                                <td>{{ $systemFile }}</td>
                                                <td class="text-center">
                                                    <a href="{{ route('maintenance.get.files', $systemFile) }}" class="btn btn-primary btn-xs">Download</a>
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                @else
                                    <tr>
                                        <td class="text-center" colspan="6">No databases found.</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                    <div class="panel-footer">
                        <form action="{{ route('maintenance.post.backup') }}" method="POST">
                            {{ csrf_field() }}
                            <input type="hidden" name="id" value="{{ hash('sha256', date('Y-m-d') . '_files') }}">
                            <div class="form-group text-right no-margin">
                                <button type="submit" class="btn btn-primary btn-sm"><span class="fa fa-server fa-fw"></span> Create Back-Up</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
