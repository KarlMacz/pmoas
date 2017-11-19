@extends('layouts.employees')

@section('content')
    <div class="page-header">
        <h1 class="no-margin">Company Clients</h1>
        <div>Register Company Client</div>
    </div>
    <div class="container-spacious">
        @include('partials.flash')
        <form action="{{ route('employees.post.company_clients_register') }}" method="POST">
            {{ csrf_field() }}
            <div class="row">
                <div class="col-sm-4">
                    <div class="form-group{{ $errors->has('first_name') ? ' has-error' : '' }}">
                        <label for="first-name-field">First Name:</label>
                        <input type="text" name="first_name" id="first-name-field" class="form-control" value="{{ old('first_name') }}" placeholder="First Name" required>
                        @if ($errors->has('first_name'))
                            <span class="help-block">
                                <strong>{{ $errors->first('first_name') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group{{ $errors->has('middle_name') ? ' has-error' : '' }}">
                        <label for="middle-name-field">Middle Name:</label>
                        <input type="text" name="middle_name" id="middle-name-field" class="form-control" value="{{ old('middle_name') }}" placeholder="Middle Name">
                        @if ($errors->has('middle_name'))
                            <span class="help-block">
                                <strong>{{ $errors->first('middle_name') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group{{ $errors->has('last_name') ? ' has-error' : '' }}">
                        <label for="last-name-field">Last Name:</label>
                        <input type="text" name="last_name" id="last-name-field" class="form-control" value="{{ old('last_name') }}" placeholder="Last Name" required>
                        @if ($errors->has('last_name'))
                            <span class="help-block">
                                <strong>{{ $errors->first('last_name') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-8">
                    <div class="form-group{{ $errors->has('address') ? ' has-error' : '' }}">
                        <label for="address-field">Address:</label>
                        <input type="text" name="address" id="address-field" class="form-control" value="{{ old('address') }}" placeholder="Address" required>
                        @if ($errors->has('address'))
                            <span class="help-block">
                                <strong>{{ $errors->first('address') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group{{ $errors->has('contact_number') ? ' has-error' : '' }}">
                        <label for="contact-number-field">Contact Number:</label>
                        <input type="text" name="contact_number" id="contact-number-field" class="form-control" value="{{ old('contact_number') }}" placeholder="Contact Number" required>
                        @if ($errors->has('contact_number'))
                            <span class="help-block">
                                <strong>{{ $errors->first('contact_number') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-3">
                    <div class="form-group{{ $errors->has('birth_date') ? ' has-error' : '' }}">
                        <label for="birth-date-field">Birth Date:</label>
                        <input type="date" name="birth_date" id="birth-date-field" class="form-control" value="{{ old('birth_date') }}" placeholder="Birth Date" required>
                        @if ($errors->has('birth_date'))
                            <span class="help-block">
                                <strong>{{ $errors->first('birth_date') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group{{ $errors->has('gender') ? ' has-error' : '' }}">
                        <label for="gender-field">Gender:</label>
                        <select name="gender" class="form-control" id="gender-field" required>
                            <option value="" selected disabled>Select an option...</option>
                            <option value="Male"{{ (old('gender') === 'Male' ? ' selected' : '') }}>Male</option>
                            <option value="Female"{{ (old('gender') === 'Female' ? ' selected' : '') }}>Female</option>
                        </select>
                        @if ($errors->has('gender'))
                            <span class="help-block">
                                <strong>{{ $errors->first('gender') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group{{ $errors->has('company') ? ' has-error' : '' }}">
                        <label for="company-field">Company:</label>
                        <input type="text" name="company" id="company-field" class="form-control" value="{{ old('company') }}" placeholder="Company" required>
                        @if ($errors->has('company'))
                            <span class="help-block">
                                <strong>{{ $errors->first('company') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
            </div>
            <div class="form-group text-right">
                <button class="btn btn-success" type="submit"><span class="fa fa-plus fa-fw"></span> Register</button>
            </div>
        </form>
    </div>
@endsection
