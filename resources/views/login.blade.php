@extends('layouts.app')

@section('title', 'Login')

@section('content')

<style>
    /* Main container styling */
    .containers.login {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
        /* background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%); */
        font-family: 'Poppins', sans-serif;
    }

    /* Form box styling */
    .logreg-box {
        background-color: #ffffff;
        padding: 40px;
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        max-width: 400px;
        width: 100%;
    }

    .forms-box h2 {
        text-align: center;
        font-size: 26px;
        color: #333;
        margin-bottom: 30px;
        font-weight: 600;
    }

    /* Input field styling */
    .input-box {
        position: relative;
        margin-bottom: 30px;
    }

    .input-box input {
        width: 100%;
        padding: 12px 40px;
        font-size: 16px;
        border: none;
        border-bottom: 2px solid #ccc;
        background: none;
        outline: none;
        color: #333;
        transition: border-color 0.3s ease-in-out;
    }

    .input-box input:focus {
        border-color: #2575fc;
    }

    .input-box label {
        position: absolute;
        top: 0;
        left: 40px;
        color: #666;
        pointer-events: none;
        transition: 0.3s ease;
    }

    .input-box input:focus+label,
    .input-box input:not(:placeholder-shown)+label {
        top: -20px;
        left: 40px;
        font-size: 12px;
        color: #2575fc;
    }

    /* Input icons styling */
    .input-box .icon {
        position: absolute;
        left: 10px;
        top: 12px;
        font-size: 20px;
        color: #2575fc;
    }

    /* Button styling */
    .btn {
        width: 100%;
        padding: 12px;
        background: linear-gradient(to left, rgba(11, 136, 147, 0.712), rgba(54, 0, 51, 0.74));
        color: #fff;
        border: none;
        border-radius: 25px;
        cursor: pointer;
        font-size: 16px;
        font-weight: 600;
        transition: background-color 0.3s ease-in-out;
    }

    .btn:hover {
        background-color: #1c63da;
    }

    /* Facebook button styling */
    .btn.facebook {
        background-color: #4267b2;
        margin-top: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .btn.facebook i {
        margin-right: 10px;
    }

    .btn.facebook:hover {
        background-color: #365899;
    }

    /* Register link styling */
    .login-register {
        text-align: center;
        margin-top: 20px;
    }

    .login-register p {
        font-size: 14px;
        color: #666;
    }

    .register-links {
        color: #2575fc;
        font-weight: 600;
        text-decoration: none;
    }

    .register-links:hover {
        text-decoration: underline;
    }

    /* Responsive design */
    @media (max-width: 500px) {
        .logreg-box {
            padding: 20px;
        }
    }
</style>

<div class="containers login">
    <div class="logreg-box">
        <div class="forms-box login">
            <form action="{{route('login')}}" id="loginForm" method="post" autocomplete="on"
                enctype="multipart/form-data">
                @csrf
                <h2>Sign In</h2>
                <div class="input-box">
                    <span class="icon"><i class='bx bxs-envelope'></i></span>
                    <input type="text" required name='logname' placeholder=" ">
                    <label>Username</label>
                </div>
                <div class="input-box">
                    <span class="icon"><i class='bx bxs-lock'></i></span>
                    <input type="password" required name="logpassword" placeholder=" ">
                    <label>Password</label>
                </div>
                <button id="loginButton" name="login" class="btn">Sign In</button>
                <br><br>
                <a href="{{ route('facebook.login') }}" class="btn facebook">
                    <i class="fab fa-facebook-f fa-fw"></i>
                    Login with Facebook
                </a>
                <div class="login-register">
                    <p>Don't have an account? <a href="{{route('register')}}" class="register-links">Sign up</a></p>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection