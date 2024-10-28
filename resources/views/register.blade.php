@extends('layouts.app')

@section('title', 'Register')

@section('content')
<style>
    /* Main container styling */
    .register-wrapper {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
        /* background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%); */
        font-family: 'Poppins', sans-serif;
    }

    /* Form box styling */
    .containers.register {
        background-color: #ffffff;
        padding: 50px;
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        max-width: 900px;
        width: 100%;
    }

    .logreg-box h2 {
        text-align: center;
        font-size: 28px;
        color: #333;
        margin-bottom: 40px;
        font-weight: 700;
        letter-spacing: 1px;
    }

    /* Profile picture container */
    .profile-pic-container {
        text-align: center;
        margin-bottom: 30px;
        position: relative;
    }

    #profile-pic-preview {
        border-radius: 50%;
        object-fit: cover;
        border: 5px solid #007bff;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
    }

    .upload-btn {
        margin-top: 15px;
        background: linear-gradient(to left, rgba(11, 136, 147, 0.712), rgba(54, 0, 51, 0.74));
        color: white;
        padding: 10px 25px;
        border-radius: 25px;
        cursor: pointer;
        font-size: 16px;
        font-weight: 500;
        transition: background-color 0.3s ease-in-out;
    }

    .upload-btn:hover {
        background-color: #0056b3;
    }

    /* Input section */
    .input-section {
        display: flex;
        flex-direction: row;
        gap: 20px;
        justify-content: space-evenly;
    }

    .input-box {
        position: relative;
        margin-bottom: 20px;
    }

    .input-box input,
    .input-box select {
        width: 100%;
        padding: 15px 45px 15px 10px;
        font-size: 16px;
        border: 2px solid #ddd;
        border-radius: 8px;
        background: none;
        outline: none;
        color: #333;
        transition: border-color 0.3s ease-in-out, background-color 0.3s;
    }

    .input-box input:focus {
        border-color: #2575fc;
        background-color: #f5faff;
    }

    .input-box label {
        position: absolute;
        top: -15px;
        left: 20px;
        font-size: 14px;
        color: #555;
        background: #fff;
        padding: 0 5px;
    }

    /* Button styling */
    .submit-section {
        text-align: center;
        margin-top: 30px;
    }

    input[type="file"] {
        padding: 15px 0px 15px 10px !important;
    }

    .btn-owner {
        background: linear-gradient(to left, rgba(11, 136, 147, 0.712), rgba(54, 0, 51, 0.74));
        color: white;
        padding: 12px 40px;
        border: none;
        border-radius: 30px;
        cursor: pointer;
        font-size: 18px;
        font-weight: 600;
        transition: background-color 0.3s ease-in-out;
    }

    .btn-owner:hover {
        background-color: #0056b3;
    }

    .register-wrapper p {
        text-align: center;
        font-size: 14px;
        color: #666;
    }

    .register-wrapper a {
        color: #2575fc;
        font-weight: 600;
        text-decoration: none;
    }

    .register-wrapper a:hover {
        text-decoration: underline;
    }


    /* Responsive design */
    @media (max-width: 700px) {
        .containers.register {
            padding: 25px;
        }

        .input-section {
            display: flex;
            flex-direction: column;
        }

        #profile-pic-preview {
            width: 150px;
            height: 150px;
        }
    }

    /* Updated wrapper-radio styling */
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
<br>
<br><br>
<div class="register-wrapper">
    <div class="containers register">
        <div class="logreg-box">
            <h2>Sign Up</h2>
            <form id="register-form" enctype="multipart/form-data">
                @csrf

                <!-- Profile Picture Preview -->
                <div class="profile-pic-container">
                    <img id="profile-pic-preview" src="{{ asset('https://via.placeholder.com/200x200') }}"
                        alt="Profile Picture" width="200px" height="200px" />
                    <br>
                    <input type="file" id="profile_picture" accept="image/png, image/gif, image/jpeg"
                        name="profile_picture" style="display: none;" />
                    <label for="profile_picture" class="upload-btn">Upload Profile Picture</label>
                </div>

                <!-- Input fields -->
                <div class="input-section">
                    <div>
                        <div class="input-box">
                            <input type="text" id="name" name="name" required>
                            <label for="name">Full Name</label>
                        </div>

                        <div class="input-box">
                            <input type="email" id="email" name="email" required>
                            <label for="email">Email Address</label>
                        </div>

                        <div class="input-box">
                            <input type="text" id="username" name="username" required>
                            <label for="username">Username</label>
                        </div>



                        <div class="input-box">
                            <input type="text" id="phone" name="phone">
                            <label for="phone">Phone Number</label>
                        </div>

                        <div class="input-box">
                            <input type="text" id="address" name="address">
                            <label for="address">Address</label>
                        </div>
                    </div>
                    <div>
                        <div class="input-b">
                            <label for="wrapper">Sign up as:</label>
                            <span class="info-icon"
                                title="Choose 'Tenant' if you are renting a property, or 'Owner' if you own a property.">?</span>
                            <div class="wrapper-radio" id="wrapper">
                                <input type="radio" hidden name="role" id="option-1" value="tenant"
                                    onclick="toggleOwnerInputs()">
                                <input type="radio" hidden name="role" id="option-2" value="owner"
                                    onclick="toggleOwnerInputs()">
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
                            <div class="input-box">
                                <label for="valid-id">Upload Valid ID:</label>
                                <input type="file" id="valid-id" name="valid_id" accept="image/*">
                            </div>
                            <div class="input-box">
                                <label for="business-permit">Upload Business Permit:</label>
                                <input type="file" id="business-permit" name="business_permit" accept="image/*">
                            </div>
                            <br>
                        </div>

                        <div class="input-box">
                            <input type="password" id="password" name="password" required>
                            <label for="password">Password</label>
                        </div>

                        <div class="input-box">
                            <input type="password" id="password_confirmation" name="password_confirmation" required>
                            <label for="password_confirmation">Confirm Password</label>
                        </div>
                    </div>
                </div>


                <!-- Register button -->
                <div class="submit-section">
                    <button class="btn btn-owner" id="tenant">Register</button>
                    <br>
                    <br>
                    <p>Already have an account? <a href="{{route('login')}}">Sign In</a></p>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    window.routes = {
        emailUrl: "{{ route('send.email', ':user') }}"
    }
</script>
<script>
    // Image preview function
    document.getElementById('profile_picture').addEventListener('change', function (e) {
        const reader = new FileReader();
        reader.onload = function (event) {
            document.getElementById('profile-pic-preview').src = event.target.result;
        };
        reader.readAsDataURL(e.target.files[0]);
    });

    $(document).ready(function () {
        $('#tenant').on('click', function (e) {
            e.preventDefault(); // Prevent form submission
            submitForm($('#register-form')); // Pass the correct form ID
        });



        function submitForm(form) {
            emailRedirect = window.routes.emailUrl;
            $.ajax({
                url: '{{ route("register") }}',
                method: 'POST',
                data: new FormData(form[0]),
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    console.log(response.data);
                    Swal.fire({
                        title: 'Success!',
                        text: response.message || 'Registration successful',
                        icon: 'success',
                        confirmButtonText: 'OK'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = emailRedirect.replace(':user', response.data.id);;
                        }
                    });
                },
                error: function (xhr, status, error) {
                    let errors = xhr.responseJSON.errors;
                    let errorMessages = '';
                    $.each(errors, function (field, messages) {
                        messages.forEach(function (message) {
                            errorMessages += `<li>${message}</li>`;
                        });
                    });
                    Swal.fire({
                        title: 'Error!',
                        html: `<ul>${errorMessages}</ul>`,
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
            });
        }
    });
</script>
<script>
    function toggleOwnerInputs() {
        const isOwner = document.getElementById('option-2').checked;
        const ownerInputs = document.getElementById('owner-inputs');
        ownerInputs.style.display = isOwner ? 'block' : 'none';
    }
</script>
@endsection
<!-- Styles -->