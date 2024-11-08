@extends('layouts.app')

@section('title', 'Forgot Password')

@section('content')

<style>
    /* Global Styles */
    .containers {
        /* width: 100%; */
        height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    /* Card Styles */
    .cardo {
        background: #fff;
        width: 100%;
        max-width: 400px;
        padding: 2rem;
        border-radius: 8px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
        text-align: center;
    }

    /* Form Styles */
    h2 {
        margin-bottom: 1rem;
        color: #2575fc;
    }

    .form-group {
        margin-bottom: 1.5rem;
        text-align: left;
    }

    .form-label {
        font-weight: bold;
        font-size: 0.9rem;
        color: #555;
        display: block;
        margin-bottom: 0.3rem;
    }

    .form-control {
        width: 100%;
        padding: 0.75rem;
        font-size: 1rem;
        border-radius: 4px;
        border: 1px solid #ddd;
        outline: none;
        box-sizing: border-box;
    }

    .form-control:focus {
        border-color: #2575fc;
    }

    /* Button Styles */
    .btn {
        padding: 12px;
        background: linear-gradient(to left, rgba(11, 136, 147, 0.712), rgba(54, 0, 51, 0.74));
        color: #fff;
        border: none;
        cursor: pointer;
        font-size: 16px;
        font-weight: 600;
        transition: background-color 0.3s ease-in-out;
    }

    .btn:hover {
        background-color: #e23e3f;
    }

    /* Link Styles */
    .form-footer {
        margin-top: 1rem;
        font-size: 0.9rem;
    }

    .form-footer a {
        color: #2575fc;
        text-decoration: none;
    }

    .form-footer a:hover {
        text-decoration: underline;
    }
</style>

<div class="containers">
    <div class="cardo">
        <h2>Forgot Password?</h2>
        <p>Enter your email to receive a password reset Code.</p>

        <form action="{{ route('forgot.pass') }}" method="POST">
            @csrf
            <input type="hidden" name="reset_password" value="true">
            <div class="form-group">
                <label for="email" class="form-label">Email Address</label>
                <input type="email" id="email" name="email" class="form-control" required autofocus>
            </div>

            <button type="submit" class="btn">Send Reset Link</button>
        </form>

        <div class="form-footer">
            <a href="{{ route('login') }}">Back to Login</a>
        </div>
    </div>
</div>
@endsection