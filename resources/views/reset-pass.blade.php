@extends('layouts.app')

@section('title', 'Reset Password')

@section('content')
<style>
    .containers {
        /* width: 100%; */
        height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .reset-container {
        background: #fff;
        padding: 2rem;
        border-radius: 8px;
        width: 100%;
        max-width: 400px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        text-align: center;
    }

    h2 {
        margin-bottom: 1rem;
        color: #333;
    }

    .input-group {
        margin-bottom: 1rem;
        text-align: left;
    }

    .input-group label {
        display: block;
        font-size: 0.9rem;
        color: #555;
        margin-bottom: 0.3rem;
    }

    .input-group input {
        width: 100%;
        padding: 0.8rem;
        border: 1px solid #ddd;
        border-radius: 5px;
        font-size: 1rem;
    }

    .input-group input:focus {
        outline: none;
        border-color: #0984e3;
        box-shadow: 0 0 5px rgba(9, 132, 227, 0.3);
    }

    .submit-btn {
        background: #0984e3;
        color: #fff;
        padding: 0.8rem;
        border: none;
        border-radius: 5px;
        width: 100%;
        cursor: pointer;
        font-size: 1rem;
        transition: background 0.3s ease;
    }

    .submit-btn:hover {
        background: #74b9ff;
    }

    .error-message {
        color: #e74c3c;
        font-size: 0.9rem;
        margin-bottom: 1rem;
    }
</style>
<div class="containers">
    <div class="reset-container">
        <h2>Reset Your Password</h2>

        <form action="{{ route('password.update') }}" method="POST">
            @csrf
            <!-- Password Input -->
            <div class="input-group">
                <label for="password">New Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            <input type="hidden" name="user_id" value="{{ $user->id }}">

            <!-- Confirm Password Input -->
            <div class="input-group">
                <label for="password_confirmation">Confirm New Password</label>
                <input type="password" id="password_confirmation" name="password_confirmation" required>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="submit-btn">Reset Password</button>
        </form>
    </div>
</div>
@endsection