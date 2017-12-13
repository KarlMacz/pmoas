@extends('layouts.emails')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">Account Verification</div>
            <div class="card-content">
                <div class="text-center" style="margin-bottom: 10px;">
                    <img src="{{ asset('img/logo.gif') }}">
                </div>
                <h3>Dear {{ $account->user_info->first_name . ' ' . $account->user_info->last_name }},</h3>
                <p>Welcome to Essential Ingredients Specialist Provider Inc.</p>
                <p>Your account has been created. But in order to use your account, we need you to verify the account registered under your e-mail address.</p>
                <p><strong>Username</strong>: {{ $account->username }}</p>
                <p><strong>Password</strong>: {{ $password }}</p>
                <div class="text-center">
                    <a href="{{ route('auth.get.verification', ['code' => $account->verification_code]) }}" class="btn btn-primary">Verify Account</a>
                </div>
                <p class="text-right">
                    Sincerely,<br>
                    Essential Ingredients Specialist Provider Inc.
                </p>
            </div>
        </div>
        <h5 class="text-center">Please do not reply to this email.</h5>
    </div>
@endsection
