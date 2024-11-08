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
        font-family: 'Poppins', sans-serif;
        background-color: #f4f6f9;
    }

    /* Flex container for image and login form */
    .flex-container {
        display: flex;
        max-width: 1000px;
        width: 100%;
        height: 600px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        border-radius: 15px;
        overflow: hidden;
        background-color: #ffffff;
    }

    /* Image container styling */
    .image-container {
        width: 50%;
        background-size: cover;
        background-position: center;
        transition: background-image 1s ease-in-out;
    }

    /* Form box styling */
    .logreg-box {
        width: 50%;
        padding: 40px;
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

    /* Facebook and Google buttons styling */
    .social-buttons {
        margin-top: 15px;
        display: flex;
        justify-content: center;
        gap: 30px;
    }

    .loginBtn {
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 10px;
        color: #FFF;
        border: none;
        border-radius: 5px;
        font-size: 16px;
        cursor: pointer;
        width: 48%;
    }

    .loginBtn--facebook {
        background-color: #4267b2;
        font-size: 34px;
        width: 60px;
    }

    .loginBtn--google {
        background-color: #DD4B39;
        font-size: 34px;
        width: 60px;
    }

    .loginBtn--facebook:hover {
        background-color: #365899;
    }

    .loginBtn--google:hover {
        background-color: #E74B37;
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
    @media (max-width: 768px) {
        .flex-container {
            flex-direction: column;
        }

        .image-container {
            width: 100%;
            height: 200px;
        }

        .logreg-box {
            width: 100%;
        }
    }

    .social-login-container {
        text-align: center;
        margin-top: 20px;
    }

    .social-login-label {
        font-size: 16px;
        color: #666;
        margin-bottom: 10px;
    }
</style>

<div class="containers login">
    <div class="flex-container">
        <div class="image-container" id="imageContainer"></div>

        <div class="logreg-box">
            <div class="forms-box login">
                <form action="{{route('login')}}" id="loginForm" method="post" autocomplete="on"
                    enctype="multipart/form-data">
                    @csrf
                    <h2>Sign In</h2>
                    <div class="input-box">
                        <span class="icon"><i class='bx bxs-envelope'></i></span>
                        <input type="text" required name="logname" placeholder=" ">
                        <label>Email or Username</label>
                    </div>
                    <div class="input-box">
                        <span class="icon"><i class='bx bxs-lock'></i></span>
                        <input type="password" required name="logpassword" placeholder=" ">
                        <label>Password</label>
                    </div>
                    <a href="{{route('forgot')}}">Forgot password</a>
                    <br><br>
                    <button id="loginButton" name="login" class="btn">Sign In</button>
                </form>
                <div class="social-login-container">
                    <p class="social-login-label">Log in with</p>
                    <div class="social-buttons">
                        <button class="loginBtn loginBtn--facebook"
                            onclick="window.location='{{ route('auth.facebook') }}'">
                            <i class="fa-brands fa-facebook"></i>
                        </button>
                        <button class="loginBtn loginBtn--google"
                            onclick="window.location='{{ route('auth.google') }}'">
                            <i class="fa-brands fa-google"></i>
                        </button>
                    </div>
                </div>


                <div class="login-register">
                    <p>Don't have an account? <a href="{{route('register')}}" class="register-links">Sign up</a></p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Array of image URLs for the rotating background
    const images = [
        "{{ asset('images/bg2.jpg') }}",
        "{{ asset('images/bg3.jpg') }}",
        "{{ asset('images/bg4.jpg') }}"
    ];


    let currentIndex = 0;
    const imageContainer = document.getElementById('imageContainer');

    // Function to change the background image every 5 seconds
    function changeImage() {
        imageContainer.style.backgroundImage = `url(${images[currentIndex]})`;
        currentIndex = (currentIndex + 1) % images.length;
    }

    // Initial call to set the first image
    changeImage();

    // Set interval to change image every 5 seconds
    setInterval(changeImage, 5000);
</script>

@endsection