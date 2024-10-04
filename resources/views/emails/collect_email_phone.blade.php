@extends('layouts.app')

@section('title', 'Contact Info')

@section('content')
<!-- CSS for profile picture, form layout, and button styles -->
<style>
    body {
        font-family: 'Poppins', sans-serif;
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    .gradient-background {
        /* background: linear-gradient(135deg, #7b2ff7, #f107a3); */
        height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 0 20px;
    }

    .containers {
        width: 100%;
        max-width: 400px;
        background-color: #fff;
        padding: 40px;
        border-radius: 10px;
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
        text-align: center;
    }

    h2 {
        font-size: 28px;
        margin-bottom: 15px;
        font-weight: 700;
        color: #333;
    }

    p {
        font-size: 16px;
        margin-bottom: 25px;
        color: #777;
    }

    /* Profile Picture Container */
    .profile-picture-container {
        width: 150px;
        height: 150px;
        margin: 0 auto 20px;
        position: relative;
        display: flex;
        justify-content: center;
        align-items: center;
        border: 2px dashed #007bff;
        border-radius: 50%;
    }

    .profile-picture {
        width: 100%;
        height: 100%;
        border-radius: 50%;
        object-fit: cover;
    }

    .form-group {
        margin-bottom: 20px;
        text-align: left;
    }

    label {
        font-size: 14px;
        font-weight: 500;
        color: #555;
        margin-bottom: 8px;
        display: block;
    }

    .form-control {
        width: 100%;
        padding: 15px;
        font-size: 16px;
        border: 2px solid #ddd;
        border-radius: 8px;
        outline: none;
        background: transparent;
        transition: border-color 0.3s ease-in-out;
    }

    .form-control:focus {
        border-color: #007bff;
        background-color: #f5faff;
    }

    /* Button styling */
    .btn-primary {
        background: linear-gradient(to left, rgba(11, 136, 147, 0.712), rgba(54, 0, 51, 0.74));
        color: white;
        padding: 12px 40px;
        border: none;
        border-radius: 30px;
        font-size: 18px;
        font-weight: 600;
        cursor: pointer;
        transition: background-color 0.3s ease-in-out;
        width: 100%;
    }

    .btn-primary:hover {
        background-color: #0056b3;
    }

    /* Custom file input */
    .profile-picture-label {
        display: inline-block;
        margin-top: 10px;
        padding: 10px 30px;
        background: linear-gradient(to left, rgba(11, 136, 147, 0.712), rgba(54, 0, 51, 0.74));
        color: white;
        border-radius: 30px;
        cursor: pointer;
        transition: background-color 0.3s ease-in-out;
    }

    .profile-picture-label:hover {
        background-color: #0056b3;
    }

    #profile_picture {
        display: none;
    }
</style>

<div class="gradient-background">
    <div class="containers">
        <h2>Complete Your Registration</h2>
        <p>Please enter your email and phone number to complete your registration.</p>

        <!-- Profile picture preview -->
        <div class="profile-picture-container">
            <img id="profilePicturePreview" class="profile-picture" src="https://via.placeholder.com/150"
                alt="Profile Picture">
        </div>

        <!-- Registration form -->
        <form method="POST" action="{{ route('collect.email.phone') }}" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="user_id" value="{{ $user->id }}">

            <!-- Profile Picture File input -->
            <div class="form-group">
                <label for="profile_picture" class="profile-picture-label">Upload Profile Picture</label>
                <input type="file" name="profile_picture" id="profile_picture" accept="image/*" class="form-control"
                    onchange="previewImage(event)">
            </div>

            <!-- Email Input -->
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" class="form-control" required>
            </div>

            <!-- Phone Number Input -->
            <div class="form-group">
                <label for="phone_number">Phone Number</label>
                <input type="text" name="phone_number" class="form-control" required>
            </div>

            <!-- Continue Button -->
            <button type="submit" class="btn-primary">Continue</button>
        </form>
    </div>
</div>

<!-- Script for image preview -->
<script>
    function previewImage(event) {
        const reader = new FileReader();
        reader.onload = function () {
            const output = document.getElementById('profilePicturePreview');
            output.src = reader.result;
        };
        reader.readAsDataURL(event.target.files[0]);
    }
</script>

@endsection