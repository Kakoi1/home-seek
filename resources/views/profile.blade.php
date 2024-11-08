@extends('layouts.app')

@section('content')
<style>
    .profile-picture {
        position: relative;
        width: 200px;
        height: 200px;
        margin: 0 auto;
    }

    .profile-picture img {
        border-radius: 120px;
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .btn-primary,
    .btn-secondary {
        margin-top: 15px;
    }

    form .form-group {
        margin-bottom: 1rem;
    }
</style>
<div class="container mt-5">
    <div class="card p-4">
        <h3>Edit Your Profile</h3>

        <div class="row">
            <!-- Profile Picture Section -->
            <div class="col-md-4 text-center">
                <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="profile-picture mb-3">
                        <img id="profilePicturePreview"
                            src="{{ auth()->user()->profile_picture ? asset('https://storage.googleapis.com/homeseek-profile-image/' . auth()->user()->profile_picture) : asset('default-avatar.png') }}"
                            alt="Profile Picture" class="img-thumbnail rounded-circle">
                    </div>
                    <label class="btn btn-primary mt-2">
                        CHANGE PHOTO
                        <input type="file" name="profile_picture" id="profile_picture" accept="image/*"
                            style="display: none;" onchange="previewProfilePicture(event)">
                    </label>
            </div>

            <!-- Profile Form Section -->
            <div class="col-md-8">
                <div class="form-group row mb-3">
                    <label for="name" class="col-md-4 col-form-label">Name:</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" id="name" name="name"
                            value="{{ old('name', auth()->user()->name) }}" required>
                    </div>
                </div>

                <div class="form-group row mb-3">
                    <label for="username" class="col-md-4 col-form-label">Username:</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" id="username" name="username"
                            value="{{ old('username', auth()->user()->username) }}" required autocomplete="username">
                    </div>
                </div>
                <div class="form-group row mb-3">
                    <label for="work_phone" class="col-md-4 col-form-label">Role</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" id="work_phone" name="work_phone"
                            value="{{ old('work_phone', auth()->user()->role) }}" disabled>
                    </div>
                </div>


                <div class="form-group row mb-3">
                    <label for="mobile_phone" class="col-md-4 col-form-label">Mobile Phone:</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" id="mobile_phone" name="mobile_phone"
                            value="{{ old('mobile_phone', auth()->user()->phone) }}" autocomplete="tel">
                    </div>
                </div>

                <div class="form-group row mb-3">
                    <label for="email" class="col-md-4 col-form-label">Email:</label>
                    <div class="col-md-8">
                        <input type="email" class="form-control" id="email" value="{{ auth()->user()->email }}"
                            disabled>
                    </div>
                </div>

                <div class="form-group row mb-3">
                    <label for="address" class="col-md-4 col-form-label">Address:</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" id="address" name="address"
                            value="{{ old('address', auth()->user()->address) }}" autocomplete="street-address">

                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-md-8 offset-md-4">
                        <button type="submit" class="btn btn-primary">Save</button>
                        <a href="{{ route('profile.edit') }}" class="btn btn-secondary">Cancel</a>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function previewProfilePicture(event) {
        const reader = new FileReader();
        reader.onload = function () {
            const output = document.getElementById('profilePicturePreview');
            output.src = reader.result;
        };
        reader.readAsDataURL(event.target.files[0]);
    }
</script>
@endsection