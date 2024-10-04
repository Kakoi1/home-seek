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

    .modal-content button {
        width: 50%;

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

    /* Statistics Section */
    .statistics-section {
        background-color: #fff;
        padding: 40px;
        border-radius: 15px;
        box-shadow: 0px 8px 20px rgba(0, 0, 0, 0.05);
        border: 1px solid #e7e7e7;
        text-align: center;
        margin-top: 6rem;


    }

    .stats-grid {
        display: flex;
        justify-content: space-between;
        margin-top: 20px;
    }

    .stat-box {
        background-color: #f1f1f1;
        padding: 20px;
        border-radius: 8px;
        flex: 1;
        margin: 0 10px;

        transition: transform 0.3s ease-in-out;
    }

    .stat-box:hover {
        transform: translateY(-5px);
        border: 2px solid royalblue;
    }

    .stat-box p {
        font-size: 1.1rem;
        color: #555;
    }

    .stat-box h3 {
        font-size: 2.5rem;
        color: #0b8893;
    }

    .profile-info {
        display: grid;
        place-items: center;

        padding: 20px 0;
        border-radius: 15px;
        box-shadow: 0px 8px 20px rgba(0, 0, 0, 0.05);
        border: 1px solid #e7e7e7;
        margin-bottom: 4rem;
        overflow: hidden;
    }

    .profile-contact-info {
        display: flex;
        gap: 7rem;
    }
.profile-info img{
    box-shadow: 0px 9px 20px rgba(13, 38, 76, 0.19);
    

}
    /* List a Property Button */
    .custom-button {
        display: inline-block;
        padding: 10px 20px;
        background-color: #0b8893;
        color: white;
        text-decoration: none;/ font-size: 1rem;
        border-radius: 8px;
        transition: background-color 0.3s ease, transform 0.3s ease;
        margin: 15px 0;

    }

    .custom-button:hover {
        background-color: #04656d;
        transform: translateY(-3px);
        color: white;
    }

    .custom-button:active {
        background-color: #033047;
        /* Active state background */
        transform: translateY(0);
        /* Button returns to original position */
    }

    /* ----------------------------- */
    .custom-warning-bg {
        background-color: #d1ecf1;
        /* Light blue */
        color: #0c5460;
        display: grid;
        place-items: center;
        align-items: center;
        margin-bottom: 2rem;
    }

    button#openVerificationModal {
        width: 20%;
        text-transform: uppercase;

    }

    /* --------------- */
    .rented-property-section {
        margin-top: 4rem;
        padding: 40px;
        background-color: #f8f9fa;
        /* Light background */
        border-radius: 10px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    .rented-property-section h2 {
        text-align: center;
        text-transform: uppercase;
    }

    .property-card {
        background-color: #ffffff;
        /* White background for card */
        border-radius: 10px;
        padding: 20px;
        margin-top: 15px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        transition: transform 0.2s;
    }

    .property-card:hover {
        transform: translateY(-5px);
    }

    .property-card h3 {
        margin: 0;
        color: #343a40;
        /* Dark gray for text */
    }

    .property-card a {
        text-decoration: none;
        color: #0b8893;
        /* Custom link color */
        font-weight: bold;
        transition: color 0.3s;
    }

    .property-card a:hover {
        color: #04656d;
        /* Darker shade on hover */
        text-decoration: underline;
    }

    /* ========= verify details ======= */

    .verification-details {
        margin-top: 3.5rem;
        padding: 20px;
        background-color: #ffffff;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        text-align: left;
    }

    .verification-details h4 {
        border-bottom: 2px solid #0b8893;
        padding-bottom: 10px;
        margin-bottom: 15px;
    }

    .verification-details .lead {
        font-size: 1.2rem;
        margin-bottom: 20px;
        color: #495057;
    }

    .verification-details .list-group {
        margin-bottom: 1rem;
    }

    .verification-details .list-group-item {
        border: none;
        padding: 10px 15px;
        background-color: #f8f9fa;
        transition: background-color 0.3s;
        /* =add= */
        border-radius: 15px;
        margin: 5px 0;
    }

    .verification-details .list-group-item:hover {
        background-color: #e9ecef;
    }

    .proper {
        width: 250px !important;
        height: 300px !important;
    }

    .proper-cont {
        background-color: #fff;
        padding: 40px;
        border-radius: 15px;
        box-shadow: 0px 8px 20px rgba(0, 0, 0, 0.05);
        border: 1px solid #e7e7e7;
        text-align: center;
        margin-top: 6rem;
        width: 100%;
        align-items: center;
    }

    .image-carousel {
        background-position: center !important;
        background-size: cover !important;
    }
    h1.username{
        text-transform: uppercase;
        padding: 1rem;
    }
    .containers h2{
        text-align: center;
    }
</style>
<link rel="stylesheet" href="{{asset('css/perdorm.css')}}">
<div class="containers" style="padding: 20px; overflow: auto;">
    <div class="profile-info">
        <h1 class="username">{{$user->name}}'s PROFILE</h1>

        <img src="{{ asset('storage/profile_pictures/' . $user->profile_picture) }}" alt="Profile Picture" width="250px"
            height="250px" style="border-radius: 160px;">
        <br>
        <div class="profile-contact-info">
            <p><b>Name:</b> {{ $user->name }}</p>
            <p><b>Email:</b> {{ $user->email }}</p>
            <p><b>Contact:</b>{{ $user->contact }}</p>
        </div>
    </div>

    @if($user->role == 'owner')
        <h2>My Properties</h2>


        <br>
        <div class="proper-cont">
            <div>
                <a href="{{'adddorm'}}" class="custom-button">+ List a Property</a>
                <br>
                <a href="">See More +</a>
            </div>

            @foreach ($properties as $dorm)
                <div class="proper">
                    <div class="cards">
                        @if (!empty($dorm->image))
                                @php
                                    // Decode the JSON string into an array
                                    $images = json_decode($dorm->image, true);
                                @endphp

                                @if (is_array($images) && !empty($images))
                                    <!-- Carousel container -->
                                    <div class="image-carousel" id="carousel-{{ $dorm->id }}" data-images="{{ json_encode($images) }}"
                                        data-current-image="0"
                                        style="background-image: url('{{ asset('storage/dorm_pictures/' . $images[0]) }}');">
                                        <div class="overlay-content">

                                        </div>

                                        <div class="dropdown " style="position: absolute; top: 10px; right: 20px;">
                                            <button class="btn btn-secondary dropdown-toggle btn-sm" type="button" id="dropdownMenuButton"
                                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Options
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                                                <a class="dropdown-item" href="{{ route('dorms.posted', $dorm->id) }}">Show</a>
                                                <a class="dropdown-item" href="{{ route('dorms.adddorm', $dorm->id) }}">Edit</a>
                                                <form id="archive-form-{{ $dorm->id }}" action="{{ route('dorms.archive', $dorm->id) }}"
                                                    method="POST" style="display:inline;">
                                                    @csrf
                                                    <button type="button" class="dropdown-item text-danger"
                                                        onclick="confirmArchive({{ $dorm->id }})">Delete</button>
                                                </form>
                                            </div>
                                        </div>

                                        <!-- Arrow buttons for image navigation -->
                                        <button class="prev" onclick="prevImage({{ $dorm->id }})">❮</button>
                                        <button class="next" onclick="nextImage({{ $dorm->id }})">❯</button>

                                        <!-- Dots for image indicators -->
                                        <div class="dots-container" id="dots-{{ $dorm->id }}">
                                            @foreach ($images as $index => $image)
                                                <span class="dot {{ $index === 0 ? 'active' : '' }}"
                                                    onclick="setImage({{ $dorm->id }}, {{ $index }})"></span>
                                            @endforeach
                                        </div>

                                    </div>

                                @else
                                    <p>No images available.</p>
                                @endif
                        @else
                            <div class="image-carousel" style="background-image: url('{{ asset('default-placeholder.png') }}');">
                                <div class="overlay-content">
                                    <h3>No Image Available</h3>
                                </div>
                            </div>
                        @endif
                        <div class="card-body" onclick="location.href='{{ route('dorms.posted', $dorm->id) }}'">
                            <h5 class="card-title">{{ $dorm->name }}</h5>

                        </div>
                    </div>
                </div>
            @endforeach

        </div>
        <!-- <h2>Inquiries</h2> -->
        <div class="statistics-section">
            <h2>Statistics 📈</h2>
            <div class="stats-grid">
                <div class="stat-box">
                    <p>Total Properties:</p>
                    <h3>{{ $statistics['total_properties'] }}</h3>

                </div>
                <div class="stat-box">
                    <p>Total Inquiries:</p>
                    <h3>{{ $statistics['total_inquiries'] }}</h3>

                </div>
            </div>
        </div>

    @elseif($user->role == 'tenant')
        <div class="custom-warning-bg p-4 rounded shadow">
            <h5 class="font-weight-bold text-dark">Account Verification Needed</h5>
            <p class="text-dark"> <i class="fas fa-info-circle"></i> Your account is not verified yet.</p>
            <p class="text-dark">Verify to become a property owner.</p>
            <button id="openVerificationModal" class="btn btn-success "> <i class="fas fa-check-circle"></i> Verify
                Now</button>
        </div>

        <div class="verification-details">
            <h4 class="text-primary font-weight-bold">🔑 Become a Property Owner!</h4>
            <p class="lead">Ready to take the next step? Verify your account today!</p>
            <h5 class="text-info">How to Verify:</h5>
            <ul class="list-group">
                <li class="list-group-item">Complete your profile information.</li>
                <li class="list-group-item">Submit required documents (e.g., ID).</li>
                <li class="list-group-item">Wait for our team to confirm your account.</li>
            </ul>
            <h5 class="text-info">Benefits of Verification:</h5>
            <ul class="list-group">
                <li class="list-group-item">Access to property ownership opportunities.</li>
                <li class="list-group-item">Enhanced features and support.</li>
            </ul>
        </div>

        <div id="verificationModal" class="modal-overlay">
            <div class="modal-content">
                <span class="close-btn">&times;</span>
                <h2>Submit Verification Documents</h2>
                <form id="verificationForm" action="{{ route('verify') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="fb_username">Facebook Username</label>
                        <input type="text" id="fb_username" name="fb_username" class="form-control"
                            placeholder="Enter your Facebook username" required>
                    </div>
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

                    <div class="d-flex justify-content-center">
                        <button type="submit" class="btn btn-success">Submit</button>
                    </div>
                </form>
            </div>
        </div>


        <div class="rented-property-section">
            <h2>Current Rented Property</h2>
            @if ($currentDorm)
                <div class="property-card">
                    <h3>
                        <a href="{{ route('dorms.posted', $currentDorm->dorm->id) }}">
                            {{ $currentDorm->dorm->name }}
                        </a>
                    </h3>
                    <h3>Room Number: {{ $currentDorm->room->number }}</h3>
                </div>
            @else
                <div class="property-card">
                <div style="text-align: center; margin: 20px;">
                <img src="{{ asset('images/rent-empty.png') }}" alt="No results found" style="max-width: 300px; height: auto; margin-bottom: 10px;" />
                    <h5>No rented properties.</h5>
                </div> </div>
            @endif
        </div>


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
    <script src="{{asset('js/dorm.js')}}"></script>
</div>
@endsection