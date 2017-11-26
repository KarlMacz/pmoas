@extends('layouts.master')

@section('content')
    <div id="homepage-header" class="casket">
        <div class="casket-content" style="width: 400px;">
            <div class="text-left" style="margin-bottom: 10px;">
                <a href="{{ route('auth.get.forgot_password_step_one') }}" class="btn btn-primary btn-sm"><span class="fa fa-arrow-left fa-fw"></span> Go Back</a>
            </div>
            <div class="card card-success">
                <div class="card-header">Forgot Password</div>
            </div>
            <div class="card">
                <div class="card-header">Step 2</div>
                <div class="card-content">
                    @include('partials.flash')
                    <form action="{{ route('auth.post.forgot_password_step_two') }}" method="POST">
                        {{ csrf_field() }}
                        <input type="hidden" name="username" value="{{ $account->username }}">
                        <div class="form-group">
                            <label for="question-field">Question:</label>
                            <input type="text" id="question-field" class="form-control" value="{{ $account->user_info->secret_question }}" readonly>
                        </div>
                        <div class="form-group{{ $errors->has('answer') ? ' has-error' : '' }}">
                            <label for="answer-field">Answer:</label>
                            <input type="text" name="answer" id="answer-field" class="form-control" value="{{ old('answer') }}" placeholder="Username" required autofocus>
                            @if ($errors->has('answer'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('answer') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group text-right">
                            <button class="btn btn-success" type="submit"><span class="fa fa-send fa-fw"></span> Send</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
