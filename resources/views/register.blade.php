@extends('layouts.app')

@section('title', 'Register')

@section('content')
<h1>Sign up</h1>
<div class="containers">

    <div class="logreg-box">
        <div class="forms-box login">
            <form id="register-form1" enctype="multipart/form-data">
                @csrf
                <h2>Sign Up</h2>
                <h2>For Tenants</h2>
                <div class="left">


                    <div class="input-box">
                        <input type="hidden" name="role" id="role" value="tenant">
                        <input type="text" id="name" name="name" required>
                        <label for="name">Full Name:</label>
                    </div>
                    <div class="input-box">

                        <input type="email" id="email" name="email" required>
                        <label for="email">Email Address:</label>
                    </div>
                    <div class="input-box">

                        <input type="text" id="username" name="username" required>
                        <label for="username">Username:</label>
                    </div>
                    <div class="input-box">

                        <input type="password" id="password" name="password" required>
                        <label for="password">Password:</label>
                    </div>
                    <div class="input-box">

                        <input type="password" id="password_confirmation" name="password_confirmation" required>
                        <label for="password_confirmation">Confirm Password:</label>
                    </div>
                </div>

                <div class="right">
                    <div class="input-box">

                        <input type="text" id="phone" name="phone">
                        <label for="phone">Phone Number:</label>
                    </div>
                    <div class="input-box">

                        <input type="text" id="address" name="address">
                        <label for="address">Address:</label>
                    </div>
                    <div class="input-box">

                        <input type="date" id="dob" name="dob">
                        <label for="dob">Date of Birth:</label>
                    </div>
                    <div class="input-box">

                        <select id="gender" name="gender">
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                            <option value="other">Other</option>
                            <label for="gender">Gender:</label>
                        </select>
                    </div>
                    <div class="input-box">
                        <input type="file" id="profile_picture" name="profile_picture">
                        <label for="profile_picture">Profile Picture:</label>
                    </div>

                </div>

                <div>
                    <button class="btn" id="tenant">Register</button>
                </div>
                <div class="login-register">
                    <p>Sign up as Property owner<a href="#" class="register-link">Sign In</a></p>
                    <p>Already have an account?<a href="{{route('login')}}" class="">Sign In</a></p>
                </div>

            </form>
        </div>
        <!-- =========================================================================================== -->
        <div class="forms-box register" id="registerd">
            <form id="register-form" enctype="multipart/form-data">
                @csrf
                <h2>Sign Up</h2>
                <h2>For propety owners</h2>
                <div class="left">


                    <div class="input-box">
                        <input type="hidden" name="role" id="role" value="owner">
                        <input type="text" id="name" name="name" required>
                        <label for="name">Full Name:</label>
                    </div>
                    <div class="input-box">

                        <input type="email" id="email" name="email" required>
                        <label for="email">Email Address:</label>
                    </div>
                    <div class="input-box">

                        <input type="text" id="username" name="username" required>
                        <label for="username">Username:</label>
                    </div>
                    <div class="input-box">

                        <input type="password" id="password" name="password" required>
                        <label for="password">Password:</label>
                    </div>
                    <div class="input-box">

                        <input type="password" id="password_confirmation" name="password_confirmation" required>
                        <label for="password_confirmation">Confirm Password:</label>
                    </div>
                </div>

                <div class="right">
                    <div class="input-box">

                        <input type="text" id="phone" name="phone">
                        <label for="phone">Phone Number:</label>
                    </div>
                    <div class="input-box">

                        <input type="text" id="address" name="address">
                        <label for="address">Address:</label>
                    </div>
                    <div class="input-box">

                        <input type="date" id="dob" name="dob">
                        <label for="dob">Date of Birth:</label>
                    </div>
                    <div class="input-box">

                        <select id="gender" name="gender">
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                            <option value="other">Other</option>
                            <label for="gender">Gender:</label>
                        </select>
                    </div>
                    <div class="input-box">
                        <input type="file" id="profile_picture" name="profile_picture">
                        <label for="profile_picture">Profile Picture:</label>
                    </div>

                </div>

                <div>
                    <button class="btn" id="owner">Register</button>
                </div>
                <div class="login-register">
                    <p>Sign up as Tenant? <a href="#" class="login-link">Sign In</a></p>
                    <p>Already have an account?<a href="{{route('login')}}" class="">Sign In</a></p>
                </div>

            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $('#owner').on('click', function (e) {
            e.preventDefault(); // Prevent form submission
            submitForm($('#register-form')); // Pass the correct form ID
        });

        $('#tenant').on('click', function (e) {
            e.preventDefault(); // Prevent form submission
            submitForm($('#register-form1')); // Pass the correct form ID
        });

        function submitForm(form) {
            $.ajax({
                url: '{{ route("register") }}', // Ensure the route name is correct
                method: 'POST',
                data: new FormData(form[0]), // Serialize the form data
                processData: false, // Important for FormData handling
                contentType: false, // Important for FormData handling
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    Swal.fire({
                        title: 'Success!',
                        text: response.message || 'Registration successful',
                        icon: 'success',
                        confirmButtonText: 'OK'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = '{{ route("login") }}'; // Redirect to login
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


@endsection