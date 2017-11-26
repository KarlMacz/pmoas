@extends('layouts.master')

@section('content')
    <div id="homepage-header" class="casket">
        <div class="casket-content" style="width: 400px;">
            <div class="text-left" style="margin-bottom: 10px;">
                <a href="{{ route('home.get.index') }}" class="btn btn-primary btn-sm"><span class="fa fa-arrow-left fa-fw"></span> Go Back</a>
            </div>
            <div class="card card-success">
                <div class="card-header">Login</div>
            </div>
            <div class="card">
                <div class="card-content">
                    @include('partials.flash')
                    <form action="{{ route('auth.post.login') }}" method="POST">
                        {{ csrf_field() }}
                        <div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}">
                            <label for="username-field">Username:</label>
                            <input type="text" name="username" id="username-field" class="form-control" value="{{ old('username') }}" placeholder="Username" required autofocus>
                            @if ($errors->has('username'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('username') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password-field">Password:</label>
                            <input type="password" name="password" id="password-field" class="form-control" placeholder="Password" required>
                            @if ($errors->has('password'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </div>
                        <!-- <div class="form-group" style="padding: 0 15px;">
                            <div class="checkbox">
                                <label>
                                    <strong><input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me</strong>
                                </label>
                            </div>
                        </div> -->
                        <div class="form-group text-right">
                            <button class="btn btn-success" type="submit"><span class="fa fa-sign-in fa-fw"></span> Login</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="btn-group btn-group-justified btn-group-sm">
                <a href="{{ route('auth.get.forgot_password_step_one') }}" class="btn btn-primary"><span class="fa fa-asterisk fa-fw"></span> Forgot Password</a>
                <a href="{{ route('auth.get.register') }}" class="btn btn-primary"><span class="fa fa-plus fa-fw"></span> Register</a>
            </div>
        </div>
    </div>
@endsection
