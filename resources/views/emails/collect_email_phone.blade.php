<!-- resources/views/auth/collect_email_phone.blade.php -->

@extends('layouts.app')

@section('title', 'Contact Info')

@section('content')
<!-- CSS for circular profile picture and layout -->
<style>
    .containers {
        width: 100%;
        max-width: 400px;
        margin: 0 auto;
        text-align: center;
    }

    .profile-picture-container {
        width: 150px;
        height: 150px;
        margin: 0 auto 20px;
        position: relative;
    }

    .profile-picture {
        width: 100%;
        height: 100%;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid #ddd;
    }

    .form-group {
        margin-bottom: 15px;
    }

    label {
        display: block;
        text-align: left;
        margin-bottom: 5px;
    }

    .form-control {
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 4px;
    }

    .btn {
        background-color: #007bff;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }

    .btn:hover {
        background-color: #0056b3;
    }
</style>
<div class="containers">
    <h2>Complete Your Registration</h2>
    <p>Please enter your email and phone number to complete your registration.</p>

    <!-- Circular div for profile picture preview -->
    <div class="profile-picture-container">
        <img id="profilePicturePreview" class="profile-picture" src="https://via.placeholder.com/150"
            alt="Profile Picture">
    </div>

    <form method="POST" action="{{ route('collect.email.phone') }}" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="user_id" value="{{ $user->id }}">

        <!-- File input for profile picture -->
        <div class="form-group">
            <label for="profile_picture">Profile Picture</label>
            <input type="file" name="profile_picture" id="profile_picture" accept="image/*" class="form-control"
                onchange="previewImage(event)">
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="phone_number">Phone Number</label>
            <input type="text" name="phone_number" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Continue</button>
    </form>
</div>

<!-- Add this script for image preview -->
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