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
        max-width: 500px;
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
        display: flex;
        flex-direction: column;
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
        height: auto
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
        margin: 10px auto;
        padding: 10px 30px;
        background: linear-gradient(to left, rgba(11, 136, 147, 0.712), rgba(54, 0, 51, 0.74));
        color: white;
        border-radius: 30px;
        width: 215px;
        cursor: pointer;
        transition: background-color 0.3s ease-in-out;
    }

    .profile-picture-label:hover {
        background-color: #0056b3;
    }

    #profile_picture {
        display: none;
    }

    .wrapper-radio {
        display: flex;
        gap: 20px;
        align-items: center;
        justify-content: center;
        margin-bottom: 20px;
    }

    .wrapper-radio .option {
        background: #fff;
        padding: 10px 20px;
        border-radius: 8px;
        border: 2px solid lightgrey;
        cursor: pointer;
        display: flex;
        align-items: center;
        transition: all 0.3s ease;
    }

    .wrapper-radio .option .dot {
        height: 20px;
        width: 20px;
        background: #d9d9d9;
        border-radius: 50%;
        margin-right: 10px;
        position: relative;
    }

    .wrapper-radio .option .dot::before {
        content: "";
        position: absolute;
        top: 4px;
        left: 4px;
        width: 12px;
        height: 12px;
        background: linear-gradient(to left, rgba(11, 136, 147, 0.712), rgba(54, 0, 51, 0.74));
        border-radius: 50%;
        opacity: 0;
        transform: scale(1.5);
        transition: all 0.3s ease;
    }

    #option-1:checked~.option-1,
    #option-2:checked~.option-2 {
        border-color: white;
        background: linear-gradient(to left, rgba(11, 136, 147, 0.712), rgba(54, 0, 51, 0.74));
    }

    #option-1:checked~.option-1 .dot,
    #option-2:checked~.option-2 .dot {
        background: #fff;
    }

    #option-1:checked~.option-1 .dot::before,
    #option-2:checked~.option-2 .dot::before {
        opacity: 1;
        transform: scale(1);
    }

    .wrapper-radio .option span {
        font-size: 16px;
        color: #808080;
    }

    #option-1:checked~.option-1 span,
    #option-2:checked~.option-2 span {
        color: #fff;
    }

    .info-icon {
        display: inline-block;
        margin-left: 5px;
        color: #007bff;
        /* Change color as needed */
        cursor: pointer;
        position: relative;
    }

    .info-icon:hover::after {
        content: attr(title);
        position: absolute;
        left: 0;
        bottom: 20px;
        /* Adjust as needed */
        background: #fff;
        border: 1px solid #ccc;
        padding: 5px;
        border-radius: 3px;
        white-space: nowrap;
        z-index: 10;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        font-size: 12px;
        /* Adjust font size as needed */
    }
</style>

<div class="gradient-background">
    <div class="containers">
        <h2>Complete Your Registration</h2>
        <p>Please enter Additional information to complete your registration.</p>

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

            @if ($user->fb_id)
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" class="form-control" required>
                </div>
            @endif
            <div class="input-b">
                <label for="wrapper">Sign up as:</label>
                <span class="info-icon"
                    title="Choose 'Tenant' if you are renting a property, or 'Owner' if you own a property.">?</span>
                <div class="wrapper-radio" id="wrapper">
                    <input type="radio" hidden name="role" id="option-1" value="tenant" onclick="toggleOwnerInputs()">
                    <input type="radio" hidden name="role" id="option-2" value="owner" onclick="toggleOwnerInputs()">
                    <label for="option-1" class="option option-1">
                        <div class="dot"></div>
                        <span>Tenant</span>
                    </label>
                    <label for="option-2" class="option option-2">
                        <div class="dot"></div>
                        <span>Owner</span>
                    </label>
                </div>
            </div>

            <div id="owner-inputs" style="display: none;">
                <div class="form-group">
                    <label for="valid-id">Upload Valid ID:</label>
                    <input type="file" id="valid-id" name="valid_id" class="form-control" accept="image/*">
                </div>
                <div class="form-group">
                    <label for="business-permit">Upload Business Permit:</label>
                    <input type="file" id="business-permit" name="business_permit" class="form-control"
                        accept="image/*">
                </div>
                <br>
            </div>

            <!-- Phone Number Input -->
            <div class="form-group">
                <label for="phone_number">Phone Number</label>
                <input type="text" name="phone_number" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="phone_number">Address</label>
                <input type="text" name="address" class="form-control" required>
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
<script>
    function toggleOwnerInputs() {
        const isOwner = document.getElementById('option-2').checked;
        const ownerInputs = document.getElementById('owner-inputs');
        ownerInputs.style.display = isOwner ? 'block' : 'none';
    }
</script>

@endsection