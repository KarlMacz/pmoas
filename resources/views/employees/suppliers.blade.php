@extends('layouts.employees')

@section('meta')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('resources')
    <script src="{{ asset('js/custom/employees/suppliers.js') }}"></script>
@endsection

@section('content')
    <div class="page-header">
        <h1 class="no-margin">Suppliers</h1>
        <div>View All Suppliers</div>
    </div>
    <div class="container-fluid">
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>Name</th>
                    <th width="15%"></th>
                </tr>
            </thead>
            <tbody>
                @if($suppliers->count() > 0)
                    @foreach($suppliers as $supplier)
                        <tr>
                            <td>{{ $supplier->name }}</td>
                            <td class="text-center">
                                <a href="{{ route('employees.get.suppliers_edit', $supplier->id) }}" class="btn btn-success btn-xs"><span class="fa fa-pencil fa-fw"></span> Edit</a>
                                <button class="delete-supplier-button btn btn-danger btn-xs" data-id="{{ $supplier->id }}"><span class="fa fa-trash fa-fw"></span> Delete</button>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td class="text-center" colspan="6">No suppliers found.</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
@endsection

@section('modals')
    <div id="delete-supplier-modal" class="modal fade">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Delete Supplier</h4>
                </div>
                <div class="modal-body">Are you sure you want to delete this supplier?</div>
                <div class="modal-footer">
                    <button type="button" class="yes-button btn btn-success btn-sm"><span class="fa fa-plus fa-fw"></span> Yes</button>
                    <button type="button" class="no-button btn btn-danger btn-sm"><span class="fa fa-times fa-fw"></span> No</button>
                </div>
            </div>
        </div>
    </div>
@endsection
