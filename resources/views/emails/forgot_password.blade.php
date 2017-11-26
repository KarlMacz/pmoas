@extends('layouts.emails')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">Forgot Password</div>
            <div class="card-content">
                <div class="text-center" style="margin-bottom: 10px;">
                    <img src="{{ asset('img/logo.gif') }}">
                </div>
                <h3>Dear {{ $account->user_info->first_name . ' ' . $account->user_info->last_name }},</h3>
                <p>It appears that you forgot your password. Don't worry, we got you covered. Here's your account information:</p>
                <p><strong>Username</strong>: {{ $account->username }}</p>
                <p><strong>Password</strong>: {{ $password }}</p>
                <p>We recommend you to delete this email after reading it.</p>
                <p class="text-right">
                    Sincerely,<br>
                    Essential Ingredients Specialist Provider Inc.
                </p>
            </div>
        </div>
        <h5 class="text-center">Please do not reply to this email.</h5>
    </div>
@endsection
