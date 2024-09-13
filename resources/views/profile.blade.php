@extends('layouts.app')

@section('title', 'Profile')

@section('content')

<style>
    .modal-overlay {
        display: none;
        /* Initially hidden */
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.7);
        /* Dark background */
        justify-content: center;
        align-items: center;
        z-index: 9999;
    }

    /* Modal content box */
    .modal-content {
        background-color: #fff;
        padding: 20px;
        border-radius: 8px;
        width: 600px;
        position: relative;
        height: 500px;
        overflow: auto;
    }

    .form-control {
        height: 100%;
    }

    /* Close button (top right corner) */
    .close-btn {
        position: absolute;
        top: 10px;
        right: 10px;
        cursor: pointer;
        font-size: 20px;
        font-weight: bold;
        color: #333;
    }
</style>
<div class="container" style="padding: 20px;">
    <h1>Profile</h1>
    <div class="profile-info">
        <img src="{{ asset('storage/profile_pictures/' . $user->profile_picture) }}" alt="Profile Picture" width="300px"
            height="300px">
        <p>Name: {{ $user->name }}</p>
        <p>Email: {{ $user->email }}</p>
        <p>Contact: {{ $user->contact }}</p>
    </div>

    @if($user->role == 'owner')
        <h2>My Properties</h2>
        <a href="{{'adddorm'}}">list a Property</a>
        <div class="row">

            @foreach($properties as $property)

                <div class="col-md-4">
                    @php
                        $images = json_decode($property->image, true);
                    @endphp

                    @if (is_array($images) && count($images) > 0)
                        <img src="{{ asset('storage/dorm_pictures/' . $images[0]) }}" class="card-img-top"
                            alt="{{ $property->name }}">
                    @else
                        <img src="{{ asset('default-placeholder.png') }}" class="card-img-top" alt="No Image Available">
                    @endif

                    <div class="dropdown" style="position: absolute; top: 10px; right: 20px;">
                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Options
                        </button>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" href="{{ route('dorms.posted', $property->id) }}">Show</a>
                            <a class="dropdown-item" href="{{ route('dorms.adddorm', $property->id) }}">Edit</a>
                            <form id="archive-form-{{ $property->id }}" action="{{ route('dorms.archive', $property->id) }}"
                                method="POST" style="display:inline;">
                                @csrf
                                <button type="button" class="dropdown-item text-danger"
                                    onclick="confirmArchive({{ $property->id }})">Delete</button>
                            </form>
                        </div>
                    </div>
                    <br>
                    <br>
                    <h5>{{$property->name}}</h5>
                </div>

            @endforeach

        </div>
        <!-- <h2>Inquiries</h2> -->

        <h2>Statistics</h2>
        <p>Total Properties: {{ $statistics['total_properties'] }}</p>
        <p>Total Inquiries: {{ $statistics['total_inquiries'] }}</p>

    @elseif($user->role == 'tenant')
        <div class="bg-warning p-4">
            <p>Your account is Not verified yet</p>
            <p>Verifiy to become a property owner</p>
            <button id="openVerificationModal" class="btn ">Verify</button>
        </div>

        <div id="verificationModal" class="modal-overlay">
            <div class="modal-content">
                <span class="close-btn">&times;</span>
                <h2>Submit Verification Documents</h2>
                <form id="verificationForm" action="{{ route('verify') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="id_document">Upload Valid ID</label>
                        <input type="file" id="imageInput" name="id_document" class="form-control" accept="image/*"
                            multiple>
                        <div id="imagePreviewContainer"></div>
                    </div>

                    <!-- If you want another file input for another image -->
                    <div class="form-group">
                        <label for="business_permit">Upload Business Permit</label>
                        <input type="file" id="permitInput" name="business_permit" class="form-control" accept="image/*">
                        <div id="permitPreviewContainer"></div>
                    </div>

                    <button type="submit" class="btn btn-success">Submit</button>
                </form>
            </div>
        </div>

        <h2>Current rented Property</h2>
        @if ($currentDorm)

            <h3><a href="{{ route('dorms.posted', $currentDorm->dorm->id)}}">{{$currentDorm->dorm->name}}</a></h3>
            <h3>{{$currentDorm->room->number}}</h3>
        @else
            <h3>No rented Properties</h3>
        @endif


    @else
        <p>Invalid user role.</p>
    @endif
    <br><br>

    <script>
        function confirmArchive(dormId) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('archive-form-' + dormId).submit();
                }
            })
        }


        // Get elements
        const openModalBtn = document.getElementById('openVerificationModal');
        const modal = document.getElementById('verificationModal');
        const closeModalBtn = document.querySelector('.close-btn');

        // Function to open the modal
        openModalBtn.addEventListener('click', function () {
            modal.style.display = 'flex'; // Show the modal
        });

        // Function to close the modal
        closeModalBtn.addEventListener('click', function () {
            modal.style.display = 'none'; // Hide the modal
        });

        // Close the modal if the user clicks outside the modal content
        window.addEventListener('click', function (event) {
            if (event.target === modal) {
                modal.style.display = 'none';
            }
        });
        // Function to handle image preview
        function previewImage(input, previewContainer) {
            const file = input.files[0]; // Only allow one image
            const previewDiv = document.getElementById(previewContainer);

            // Check if a file is selected and if it is an image
            if (file && file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    // Clear the preview container and create a new image preview
                    previewDiv.innerHTML = ''; // Clear previous image if any

                    const imageWrapper = document.createElement('div');
                    imageWrapper.classList.add('image-wrapper');
                    imageWrapper.style.marginTop = '10px';

                    // Create the image element
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.style.width = '150px';
                    img.style.height = '150px';
                    img.style.objectFit = 'cover';

                    // Create the remove button
                    const removeButton = document.createElement('button');
                    removeButton.textContent = 'Remove';
                    removeButton.classList.add('btn', 'btn-danger');
                    removeButton.style.marginLeft = '10px';

                    // Remove the image preview and clear the file input when clicking "Remove"
                    removeButton.addEventListener('click', function () {
                        previewDiv.innerHTML = ''; // Remove the image preview
                        input.value = ''; // Clear the file input value
                    });

                    // Append the image and remove button to the wrapper, then to the container
                    imageWrapper.appendChild(img);
                    imageWrapper.appendChild(removeButton);
                    previewDiv.appendChild(imageWrapper); // Add the image wrapper to the container
                };

                reader.readAsDataURL(file); // Read the image file and trigger onload
            } else {
                // Clear the preview container if no valid image is selected
                previewDiv.innerHTML = '';
                input.value = ''; // Clear the input if invalid file
                alert('Please select a valid image file.');
            }
        }

        // Add event listeners for each file input
        document.getElementById('imageInput').addEventListener('change', function () {
            previewImage(this, 'imagePreviewContainer');
        });

        document.getElementById('permitInput').addEventListener('change', function () {
            previewImage(this, 'permitPreviewContainer');
        });

    </script>
</div>
@endsection