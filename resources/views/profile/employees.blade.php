@extends('layouts.employees')

@section('content')
    <div class="page-header">
        <div class="profiler no-margin">
            <div class="title">{{ Auth::user()->user_info->first_name . ' ' . Auth::user()->user_info->last_name }}</div>
            <div class="title-sub">{{ Auth::user()->user_info->address }}</div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-8 col-sm-offset-2">
                @include('partials.flash')
                <form action="{{ route('profile.post.update_account') }}" method="POST">
                    {{ csrf_field() }}
                    <div class="panel panel-primary">
                        <div class="panel-heading">Account Information</div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}">
                                        <label for="username-field">Username:</label>
                                        <input type="text" name="username" id="username-field" class="form-control" placeholder="Username" value="{{ $profile->username }}" required>
                                        @if ($errors->has('username'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('username') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                        <label for="email-field">E-mail Address:</label>
                                        <input type="email" name="email" id="email-field" class="form-control" placeholder="E-mail Address" value="{{ $profile->email }}" required>
                                        @if ($errors->has('email'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('email') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="panel-footer text-right">
                            <button class="btn btn-success btn-sm" type="submit"><span class="fa fa-check fa-fw"></span> Save Changes</button>
                        </div>
                    </div>
                </form>
                <form action="{{ route('profile.post.update_password') }}" method="POST">
                    {{ csrf_field() }}
                    <div class="panel panel-primary">
                        <div class="panel-heading">Change Password</div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group{{ $errors->has('old_password') ? ' has-error' : '' }}">
                                        <label for="old-password-field">Old Password:</label>
                                        <input type="password" name="old_password" id="old-password-field" class="form-control" placeholder="Old Password" required>
                                        @if ($errors->has('old_password'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('old_password') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group{{ $errors->has('new_password') ? ' has-error' : '' }}">
                                        <label for="new-password-field">New Password:</label>
                                        <input type="password" name="new_password" id="new-password-field" class="form-control" placeholder="New Password" required>
                                        @if ($errors->has('new_password'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('new_password') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6 col-sm-offset-6">
                                    <div class="form-group">
                                        <label for="confirm-password-field">Confirm New Password:</label>
                                        <input type="password" name="new_password_confirmation" id="confirm-password-field" class="form-control" placeholder="Confirm New Password" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="panel-footer text-right">
                            <button class="btn btn-success btn-sm" type="submit"><span class="fa fa-check fa-fw"></span> Save Changes</button>
                        </div>
                    </div>
                </form>
                <form action="{{ route('profile.post.update_info') }}" method="POST">
                    {{ csrf_field() }}
                    <div class="panel panel-primary">
                        <div class="panel-heading">Background Information</div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group{{ $errors->has('first_name') ? ' has-error' : '' }}">
                                        <label for="first-name-field">First Name:</label>
                                        <input type="text" name="first_name" id="first-name-field" class="form-control" placeholder="First Name" value="{{ $profile->user_info->first_name }}" required>
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
                                        <input type="text" name="middle_name" id="middle-name-field" class="form-control" placeholder="Middle Name" value="{{ $profile->user_info->middle_name }}">
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
                                        <input type="text" name="last_name" id="last-name-field" class="form-control" placeholder="Last Name" value="{{ $profile->user_info->last_name }}" required>
                                        @if ($errors->has('last_name'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('last_name') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group{{ $errors->has('birth_date') ? ' has-error' : '' }}">
                                        <label for="birth-date-field">Birth Date:</label>
                                        <input type="date" name="birth_date" id="birth-date-field" class="form-control" value="{{ $profile->user_info->birth_date }}" placeholder="Birth Date" required>
                                        @if ($errors->has('birth_date'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('birth_date') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group{{ $errors->has('gender') ? ' has-error' : '' }}">
                                        <label for="gender-field">Gender:</label>
                                        <select name="gender" class="form-control" id="gender-field" required>
                                            <option value="" selected disabled>Select an option...</option>
                                            <option value="Male"{{ ($profile->user_info->gender === 'Male' ? ' selected' : '') }}>Male</option>
                                            <option value="Female"{{ ($profile->user_info->gender === 'Female' ? ' selected' : '') }}>Female</option>
                                        </select>
                                        @if ($errors->has('gender'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('gender') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group{{ $errors->has('address') ? ' has-error' : '' }}">
                                        <label for="address-field">Address:</label>
                                        <input type="text" name="address" id="address-field" class="form-control" placeholder="Address" value="{{ $profile->user_info->address }}" required>
                                        @if ($errors->has('address'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('address') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group{{ $errors->has('contact_number') ? ' has-error' : '' }}">
                                        <label for="contact-number-field">Contact Number:</label>
                                        <input type="text" name="contact_number" id="contact-number-field" class="form-control" placeholder="Contact Number" value="{{ $profile->user_info->contact_number }}" required>
                                        @if ($errors->has('contact_number'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('contact_number') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="panel-footer text-right">
                            <button class="btn btn-success btn-sm" type="submit"><span class="fa fa-check fa-fw"></span> Save Changes</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
