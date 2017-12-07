@extends('layouts.employees')

@section('meta')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('resources')
    <script src="{{ asset('js/custom/employees/documents.js') }}"></script>
@endsection

@section('content')
    <div class="page-header">
        <h1 class="no-margin">Contract Management</h1>
        <div>Document Management</div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-8">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Document</th>
                            <th width="30%"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($documents->count() > 0)
                            @foreach($documents as $document)
                                <tr>
                                    <td>{{ $document->filename }}</td>
                                    <td class="text-center">
                                        <button class="delete-document-button btn btn-danger btn-xs" data-id="{{ $document->id }}"><span class="fa fa-trash fa-fw"></span> Delete</button>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td class="text-center" colspan="2">No documents found.</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
            <div class="col-sm-4">
                @include('partials.flash')
                <form action="{{ route('employees.post.contract_documents_add', $contract->id) }}" method="POST" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <input type="hidden" name="id" value="{{ $contract->id }}">
                    <div class="form-group">
                        <input type="file" name="document" class="form-control">
                    </div>
                    <div class="form-group text-right">
                        <button class="btn btn-success" type="submit"><span class="fa fa-plus fa-fw"></span> Add</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('modals')
    <div id="delete-document-modal" class="modal fade">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Delete Document</h4>
                </div>
                <div class="modal-body">Are you sure you want to delete this document?</div>
                <div class="modal-footer">
                    <button type="button" class="yes-button btn btn-success btn-sm"><span class="fa fa-plus fa-fw"></span> Yes</button>
                    <button type="button" class="no-button btn btn-danger btn-sm"><span class="fa fa-times fa-fw"></span> No</button>
                </div>
            </div>
        </div>
    </div>
@endsection
