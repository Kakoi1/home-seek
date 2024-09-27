<!-- resources/views/auth/email_verification.blade.php -->

@extends('layouts.app')

@section('title', 'Email Verification')

@section('content')

<div class="containers">
    <h2>Email Verification</h2>
    <p>We sent a verification code to your email. Please enter the code below to verify your email address.</p>

    <form method="POST" action="{{ route('verify.email') }}">
        @csrf
        <input type="hidden" name="user_id" value="{{ $user->id }}">
        <div class="form-group">
            <label for="verification_code">Verification Code</label>
            <input type="text" name="verification_code" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Verify Email</button>
    </form>
</div>
@endsection