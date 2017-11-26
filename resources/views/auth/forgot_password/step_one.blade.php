@extends('layouts.master')

@section('content')
    <div id="homepage-header" class="casket">
        <div class="casket-content" style="width: 400px;">
            <div class="text-left" style="margin-bottom: 10px;">
                <a href="{{ route('auth.get.login') }}" class="btn btn-primary btn-sm"><span class="fa fa-arrow-left fa-fw"></span> Go Back</a>
            </div>
            <div class="card card-success">
                <div class="card-header">Forgot Password</div>
            </div>
            <div class="card">
                <div class="card-header">Step 1</div>
                <div class="card-content">
                    @include('partials.flash')
                    <form action="{{ route('auth.post.forgot_password_step_one') }}" method="POST">
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
                        <div class="form-group text-right">
                            <button class="btn btn-success" type="submit"><span class="fa fa-arrow-right fa-fw"></span> Next</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
