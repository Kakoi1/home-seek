<!-- resources/views/auth/email_verification.blade.php -->

@extends('layouts.app')

@section('title', 'Email Verification')

@section('content')
<style>
    .verification-wrapper {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        background-color: #f0f4f8;
    }

    .verification-card {
        background-color: #fff;
        padding: 40px;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        width: 400px;
        text-align: center;
    }

    .verification-card h2 {
        margin-bottom: 20px;
        color: #333;
    }

    .verification-card p {
        color: #666;
        font-size: 16px;
        margin-bottom: 30px;
    }

    .input-group {
        margin-bottom: 20px;
        text-align: left;
    }

    .input-group label {
        font-weight: bold;
        display: block;
        margin-bottom: 8px;
        color: #333;
    }

    .input-field {
        width: 100%;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-size: 16px;
        outline: none;
        transition: border-color 0.3s;
    }

    .input-field:focus {
        border-color: #007bff;
    }

    .btn-primary {
        background: linear-gradient(to left, rgba(11, 136, 147, 0.712), rgba(54, 0, 51, 0.74));
        color: white;
        border: none;
        padding: 10px 20px;
        font-size: 16px;
        border-radius: 4px;
        cursor: pointer;
        width: 100%;
    }

    .btn-primary:hover {
        background-color: #0056b3;
    }

    .resend-link {
        margin-top: 15px;
        font-size: 14px;
    }

    .resend-link a {
        color: #007bff;
        text-decoration: none;
    }

    .resend-link a:hover {
        text-decoration: underline;
    }
</style>
<div class="verification-wrapper">
    <div class="verification-card">
        <h2>Email Verification</h2>
        <p>We have sent a verification code to your email. Please enter the code below to verify your email address.</p>

        <form method="POST" action="{{ route('verify.email') }}">
            @csrf
            <input type="hidden" name="user_id" value="{{ $user->id }}">

            <div class="input-group">
                <label for="verification_code">Verification Code</label>
                <input type="text" name="verification_code" id="verification_code" class="input-field"
                    placeholder="Enter code" required>
            </div>

            <button type="submit" class="btn btn-primary">Verify Email</button>
        </form>

        <div class="resend-link">
            <p>Didn’t receive a code? <a href="javascript:void(0);" id="resend-code">Resend Code</a></p>

        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        $('#resend-code').click(function (e) {
            e.preventDefault(); // Prevent default link behavior

            Swal.fire({
                title: 'Are you sure?',
                text: "You want to resend the verification code?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, resend it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('resend.code', ['user' => $user->id]) }}",
                        type: 'GET',
                        success: function (response) {
                            Swal.fire(
                                'Sent!',
                                'The verification code has been resent successfully.',
                                'success'
                            );
                        },
                        error: function (xhr, status, error) {
                            Swal.fire(
                                'Error!',
                                'There was an error resending the code. Please try again.',
                                'error'
                            );
                        }
                    });
                }
            });
        });
    });
</script>
@endsection