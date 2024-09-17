@extends('layouts.app')

@section('title', 'Login')

@section('content')


<div class="containers login">

    <div class="logreg-box">
        <div class="forms-box login">
            <form action="{{route('login')}}" id="loginForm" method="post" autocomplete=""
                enctype="multipart/form-data">
                @csrf
                <h2>Sign In</h2>
                <div class="input-box">
                    <span class="icon"><i class='bx bxs-envelope'></i></span>
                    <input type="text" required name='logname'>
                    <label>Username</label>
                </div>
                <div class="input-box">
                    <span class="icon"><i class='bx bxs-lock'></i></span>
                    <input type="password" required name="logpassword">
                    <label>Password</label>
                </div>
                <button id="loginButton" name="login" class="btn">Sign In</button>
                <div class="login-register">
                    <p>Don't have an account? <a href="{{route('register')}}" class="register-links">Sign up</a></p>
                </div>
            </form>
        </div>

    </div>
</div>


@endsection