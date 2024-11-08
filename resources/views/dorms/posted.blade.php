@extends('layouts.app')

@section('title', 'Dorm Details')

@section('content')
<style>
    /* Existing styles */
    #overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.7);
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 1000;
    }

    #image-container {
        max-width: 90%;
        max-height: 90%;
        overflow: auto;
    }

    #image-container img {
        width: 100%;
        height: auto;
    }

    /* New styles for room grid */
    #room-grid {
        display: flex;
        /* grid-template-rows: repeat(auto-fit, minmax(150px, 1fr)); */
        flex-wrap: wrap;
        justify-content: space-between;
        gap: 20px;
    }

    #room-grid .room {
        background-color: white;
        padding: 10px;
        border-radius: 5px;
        text-align: center;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        width: 300px;
        height: 400px;
    }

    #close-button {
        position: absolute;
        top: 10px;
        left: 10px;
        background: transparent;
        border: none;
        font-size: 30px;
        color: #fff;
        cursor: pointer;
    }

    .pic {
        width: 150px;
        height: 100px;

    }

    .room button:hover {
        background-color: #0056b3;
    }

    .info h1 {
        text-transform: uppercase;
        padding-left: 20px;
        border-left: 10px solid cadetblue;
        border-radius: 6px;
        /* === */
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;

    }

    .info button {
        padding: 10px 15px;
        border: none;
        border-color: #007bff;
        background: linear-gradient(to right, rgba(11, 136, 147, 0.911), rgba(54, 0, 51, 0.877));
        color: white;
        border-radius: 5px;
        margin: 0 auto;
        display: block;
    }

    .room button {
        padding: 5px 10px;
        border: none;
        border-color: #007bff;
        background: linear-gradient(to right, rgba(11, 136, 147, 0.911), rgba(54, 0, 51, 0.877));
        color: white;
        border-radius: 5px;
        margin: 0 auto;

    }

    .info button:hover {

        background-color: #226eb9;

    }

    .info {
        /* display: grid;
        justify-content: center;
        align-items: center; */
        /* margin: 0 50px; */
        width: 100%;
        padding: 25px;
        overflow: hidden;
        /* width: 46rem; */

    }

    .info p span {
        font-weight: 500;
        color: blue;
    }


    .dorm-container {
        max-width: 1300px;
        margin: 0 auto;
        padding: 10px;
    }

    .carousel-thumbnails img:hover {
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }

    /* Review section */
    .reviews-section h3 {
        margin-bottom: 20px;
    }

    #overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.8);
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 1000;
    }

    #close-button {
        position: absolute;
        top: 20px;
        right: 20px;
        background: none;
        color: white;
        font-size: 30px;
        border: none;
        cursor: pointer;
        width: 100px;
    }

    .modal-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        /* Semi-transparent black background */
        z-index: 999;
    }

    .room-management,
    .room-delete-modal {
        background-color: #fff;
        padding: 20px;
        border-radius: 10px;
        position: fixed;
        top: 20%;
        left: 50%;
        transform: translate(-50%, -20%);
        z-index: 1000;
    }

    .close-btn {
        position: absolute;
        top: 10px;
        right: 10px;
        background-color: transparent;
        border: none;
        font-size: 24px;
        cursor: pointer;
        color: #333;
    }

    .room-management {
        width: 400px;
        display: none;
    }

    .room-delete-modal {
        width: 400px;
        display: none;
    }

    #room-delete-modal {
        display: none;
        /* Initially hidden */
    }

    /* Full-screen Image Modal */
    .image-modal {
        display: none;
        position: fixed;
        justify-content: center;
        align-items: center;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0, 0, 0, 0.9);
    }

    .modal-content {
        margin: auto;
        display: block;
        width: 80%;
        max-width: 1000px;
        border-radius: 15px;
    }

    #image-caption {
        text-align: center;
        color: #ccc;
        padding: 10px 0;
        height: 150px;
    }

    /* Close button */
    .closemodal {
        position: absolute;
        top: 15px;
        right: 25px;
        color: #fff;
        font-size: 35px;
        font-weight: bold;
        cursor: pointer;
    }

    /* Zoom-in animation */
    .modal-content {
        animation: zoom 0.6s;
    }

    @keyframes zoom {
        from {
            transform: scale(0);
        }

        to {
            transform: scale(1);
        }
    }

    .buttoner {
        display: flex;
        justify-content: space-evenly;
        align-items: flex-end;
    }

    /* Reviews section container */
    .reviews-section {
        background-color: #f9f9f9;
        border-radius: 8px;
        padding: 20px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        max-width: 1300px;
        margin: 0 auto;
    }

    /* Header styles */
    .reviews-section h3 {
        font-size: 24px;
        font-weight: bold;
        color: #333;
        margin-bottom: 20px;
    }

    /* No reviews text */
    .no-reviews {
        font-size: 16px;
        color: #888;
        text-align: center;
        padding: 20px 0;
    }

    /* Review item container */
    .review-item {
        border-bottom: 1px solid #ddd;
        padding: 20px 0;
        margin-bottom: 20px;
    }

    /* Review header */
    .review-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 10px;
    }

    /* User name and date */
    .review-header h4 {
        font-size: 18px;
        color: #333;
        margin: 0;
    }

    .review-header .review-date {
        font-size: 14px;
        color: #999;
    }

    /* Rating stars */
    .rating {
        color: gold;
        font-size: 16px;
    }

    /* Review body with comments */
    .review-body p {
        font-size: 16px;
        color: #555;
        line-height: 1.5;
    }

    /* No comments provided */
    .no-comments {
        font-style: italic;
        color: #888;
    }

    .userComment {
        display: flex;
        justify-content: space-evenly;
        width: 21%;
    }

    .userComment img {
        border-radius: 120px;
    }

    /* General container */
    .booking-container {
        display: flex;
        justify-content: space-between;
        padding: 20px;
        font-family: Arial, sans-serif;
    }

    /* Room details section */
    .room-details {
        width: 60%;
    }

    .rating {
        display: flex;
        align-items: center;
        gap: 10px;
        margin: 10px 0;
    }

    .rating-star {
        color: gold;
        font-weight: bold;
    }

    .review-count {
        color: gray;
    }

    .host-info {
        margin-top: 20px;
    }

    .features {
        margin-top: 15px;
        list-style-type: none;
        padding: 0;
    }

    .features li {
        margin-bottom: 10px;
    }

    /* Booking form section */
    .booking-form {
        width: 35%;
        max-width: 400px;
        padding: 20px;
        border: 1px solid #ccc;
        border-radius: 10px;
        background-color: #f9f9f9;
    }

    .price {
        font-size: 24px;
        font-weight: bold;
        margin-bottom: 20px;
    }

    .form-group {
        margin-bottom: 15px;
    }

    label {
        display: block;
        margin-bottom: 5px;
        font-weight: bold;
    }

    input,
    select {
        width: 100%;
        padding: 8px;
        margin-top: 5px;
        border-radius: 5px;
        border: 1px solid #ccc;
    }

    .btn-reserve {
        width: 100%;
        padding: 10px;
        background-color: #ff385c;
        color: white;
        border: none;
        border-radius: 5px;
        font-size: 18px;
        cursor: pointer;
    }

    .price-details {
        margin-top: 20px;
    }

    .price-details p {
        display: flex;
        justify-content: space-between;
    }

    .price-details hr {
        margin: 10px 0;
    }
</style>
@php
    // Decode the JSON string into an array
    $totalRating = 0;
    $rating = 0;
    foreach ($propertyReview->reviews as $review) {

        $totalRating += $review->rating;

    }
    if ($propertyReview->reviews->count()) {
        $rating = $totalRating / $propertyReview->reviews->count();
    }
    $fullAddress = $dorm->address;

    // Split the string by commas
    $addressParts = explode(',', $fullAddress);
    $shortAddress = implode(', ', array_slice($addressParts, 0, 3));
@endphp
<br>
<br>

<div class="dorm-container">

    <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
            @php
                // Decode the JSON string into an array
                $imag = json_decode($dorm->image, true);
            @endphp

            @if (is_array($imag) && !empty($imag))
                @foreach($imag as $key => $image)
                    <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                        <img class="d-block w-80"
                            src="{{ asset('https://storage.googleapis.com/homeseek-profile-image/' . $image) }}"
                            alt="{{ $dorm->name }}"
                            style="height: 500px; object-fit: cover; border-radius: 15px; margin: 0 auto;">
                    </div>
                @endforeach
            @else
                <div class="carousel-item active">
                    <p>No images available.</p>
                </div>
            @endif
        </div>
        <!-- Carousel Controls -->
        <a class="carousel-control-prev" style="background-color: #14131346; border-radius: 8px;"
            href="#carouselExampleControls" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" style="background-color: #14131346; border-radius: 8px;"
            href="#carouselExampleControls" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>

        <!-- Thumbnail indicators -->
        <div class="carousel-thumbnails" style="display: flex; justify-content: center; margin-top: 15px;">
            @foreach($imag as $key => $image)
                <img src="{{ asset('https://storage.googleapis.com/homeseek-profile-image/' . $image) }}"
                    alt="{{ $dorm->name }}"
                    style="width: 60px; height: 60px; object-fit: cover; border-radius: 10px; cursor: pointer; margin-right: 10px;"
                    onclick="openModal('{{ asset(path: 'https://storage.googleapis.com/homeseek-profile-image/' . $image) }}', '{{ $dorm->name }}')">
            @endforeach
        </div>
    </div>
    <br>
    <div class="info" style="margin-top: 30px; margin: 0 auto;">

        <div class="booking-container">
            <div class="room-details">
                <h1>{{ $dorm->name }}</h1>
                <h4>{{ $dorm->description }}</h4>
                <p><i class="fas fa-map-marker-alt"></i> {{ $shortAddress }}</p>
                <p><strong>{{$dorm->capacity}}</strong> Capacity · <strong>{{$dorm->bedroom}}</strong> bedrooms ·
                    <strong>{{$dorm->beds}}</strong> beds
                </p>

                <!-- Review and Rating Section -->
                <div class="rating">
                    @if ($rating >= 4)
                        <span class="badge">Guest favorite</span>
                    @endif

                    <span class="rating-star">★ {{$rating}}</span>
                    <span class="review-count">({{$propertyReview->reviews->count()}} reviews)</span>
                </div>

                <!-- Host Information -->
                <div class="host-info">
                    <p onclick="openUserPopup({{$dorm->user_id}})">Posted by <strong> <a
                                href="javascript: void(0)">{{ $dorm->user->name }}</a></strong></p>

                    <p><strong>Date Posted</strong> ·
                        @if ($dorm->created_at->diffInYears() < 1)
                            {{ $dorm->created_at->diffForHumans() }}
                        @else
                            {{ $dorm->created_at->format('Y F') }}
                        @endif
                    </p>
                    @if (Auth::id() != $dorm->user_id)
                        <div style="float:left;">
                            <button onclick="showReportPopup({{$dorm->user->id}}, {{$dorm->id}}, 'property')"
                                class="bts">Report Property <i class="fa-solid fa-flag"></i></button>
                        </div>
                    @endif
                </div>

            </div>
            @if (Auth::id() != $dorm->user_id)
                <div class="booking-form">
                    <div class="price">
                        <span>{{ $dorm->price }}</span> / day
                    </div>

                    <form id="bookingForm" action="{{route('rentForm.store')}}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="checkin">Check-in</label>
                            <input type="date" id="checkin" name="start_date">
                        </div>
                        <input type="hidden" name="dorm_id" id="" value="{{$dorm->id}}">
                        <input type="hidden" name="total_price" id="tprice">
                        <div class="form-group">
                            <label for="checkout">Check-out</label>
                            <input type="date" id="checkout" name="end_date">
                        </div>
                        <div class="form-group">
                            <label for="guests">Guests</label>
                            <select id="guests" name="guests">
                                @for ($i = 1; $i <= $dorm->capacity; $i++)
                                    <option value="{{ $i }}">{{ $i }} guest{{ $i > 1 ? 's' : '' }}</option>
                                @endfor


                                <!-- Add more options -->
                            </select>
                        </div>

                        @if (!$hasPendingOrActiveRentForm)
                            <button type="submit" id="Book" class="btn-reserve">Book now</button>
                        @else
                            <p class="text-danger">You already have Booked a Property. You cannot book at this moment.</p>
                        @endif

                    </form>

                    <!-- Pricing Details -->
                    <div class="price-details">
                        <p>₱{{ $dorm->price }} x <span id="nights">0</span> nights</p>
                        <hr>
                        <p>Total <span id="total-price">₱0</span></p>
                    </div>
                </div>
            @endif

        </div>
        <!-- Room Display Button -->
    </div>
    <br>
    <div id="map" style="width: 100%; height: 500px;"></div>
    <script id="dorms-data" type="application/json">
    {!! json_encode($dorm) !!}
</script>
    <!-- Reviews Section -->
    <div class="reviews-section" style="margin-top: 50px;">
        <h3>Reviews</h3>

        @if($dorm->reviews->isEmpty())
            <p>No reviews yet.</p>
        @else
            @foreach($propertyReview->reviews as $review)
                <div class="review-item" style="border-bottom: 1px solid #ddd; padding: 10px 0 0px 10px;">
                    <div class="userComment">
                        <img src="{{ $review->user->profile_picture ? asset('https://storage.googleapis.com/homeseek-profile-image/' . $review->user->profile_picture) : 'https://via.placeholder.com/80x80' }}"
                            alt="" width="35px" height="35px">
                        <h4>{{ $review->user->name }} <span
                                style="font-size: 14px; color: #888;">({{ $review->created_at->format('M d, Y') }})</span></h4>
                    </div>

                    <div class="rating" style="color: gold;">
                        @for($i = 1; $i <= 5; $i++)
                            @if($i <= $review->rating)
                                &#9733; <!-- Full star -->
                            @else
                                &#9734; <!-- Empty star -->
                            @endif
                        @endfor
                    </div>

                    @if($review->comments)
                        <p>{{ $review->comments }}</p>
                    @else
                        <p>No comments provided.</p>
                    @endif
                </div>
            @endforeach
        @endif
    </div>


    <!-- Manage Rooms Button -->

    <!-- Room Management Section -->


    <div id="imageModal" class="image-modal" style="display: none;">
        <span class="closemodal">&times;</span>
        <img class="modal-content" id="fullImage">
        <!-- <div id="image-caption"></div> -->
    </div>



    <!-- Separate Overlays for Room Management and Delete Modal -->
    <div id="room-management-overlay" class="modal-overlay" style="display: none;"></div>
    <div id="room-delete-overlay" class="modal-overlay" style="display: none;"></div>

</div>
<!-- Overlay -->


<br><br>
<script>
    @if (Auth::id() != $dorm->user_id)
        document.addEventListener("DOMContentLoaded", function () {
            const checkinInput = document.getElementById("checkin");
            const checkoutInput = document.getElementById("checkout");
            const pricePerNight = {{ $dorm->price }};
            const cleaningFee = 1500;

            // Set today's date as minimum for check-in
            const today = new Date().toISOString().split("T")[0];
            checkinInput.setAttribute("min", today);

            // Update the checkout min date once checkin is selected
            checkinInput.addEventListener("change", function () {
                const checkinDate = checkinInput.value;
                checkoutInput.setAttribute("min", checkinDate);
                calculateTotal();  // Recalculate the total price
            });

            // Calculate the total price when check-out is selected
            checkoutInput.addEventListener("change", function () {
                calculateTotal();
            });

            function calculateTotal() {
                const checkinDate = new Date(checkinInput.value);
                const checkoutDate = new Date(checkoutInput.value);

                // Ensure checkout is after checkin
                if (checkoutDate > checkinDate) {
                    const timeDiff = checkoutDate.getTime() - checkinDate.getTime();
                    const nights = Math.ceil(timeDiff / (1000 * 3600 * 24)); // Days between checkin and checkout

                    // Update the nights and total price display
                    document.getElementById("nights").textContent = nights;
                    const totalPrice = nights * pricePerNight;
                    document.getElementById("total-price").textContent = `₱${totalPrice.toLocaleString()}`;
                    document.getElementById("tprice").value = totalPrice;
                    const finalTotal = totalPrice + cleaningFee;
                    document.getElementById("final-total").textContent = `₱${finalTotal.toLocaleString()}`;
                } else {
                    // Reset the totals if dates are invalid
                    document.getElementById("nights").textContent = 0;
                    document.getElementById("total-price").textContent = "₱0";
                    document.getElementById("final-total").textContent = "₱0";
                }
            }
        });
    @endif


    // Function to jump to a specific carousel slide
    function jumpToSlide(index) {
        $('#carouselExampleControls').carousel(index);
    }
    // Room count variable to track the current number of rooms


    // Close button for room management modal


    // Function to show the room delete modal with its own overlay




    // Confirm Delete Button: Send selected room(s) for deletion
    document.getElementById('confirm-delete').addEventListener('click', function () {
        let selectedRooms = [];
        document.querySelectorAll('input[name="rooms_to_delete[]"]:checked').forEach(function (checkbox) {
            selectedRooms.push(checkbox.value);
        });

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
                if (selectedRooms.length > 0) {
                    // Make an AJAX request to delete rooms
                    fetch('{{ route('dorm.deleteRooms', $dorm->id) }}', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({ rooms_to_delete: selectedRooms })
                    })
                        .then(response => response.json())
                        .then(data => {
                            alert('Rooms deleted successfully!');
                            // Hide modal and update room count/display
                            document.getElementById('room-delete-modal').style.display = 'none';
                            document.getElementById('room-delete-overlay').style.display = 'none';
                            roomCount -= selectedRooms.length;
                            document.getElementById('room-count').innerText = roomCount;
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('Failed to delete rooms.');
                        });
                } else {
                    alert('Please select at least one room to delete.');
                }
            }
        });
    });

    // Hide the delete modal if the user cancels the action
    document.getElementById('cancel-delete').addEventListener('click', function () {
        document.getElementById('room-delete-modal').style.display = 'none';
    });

    // Function to hide the room management modal and overlay
    function hideRoomManagementModal() {
        document.getElementById('room-management').style.display = 'none';
        document.getElementById('room-management-overlay').style.display = 'none';
    }

    // Function to hide room delete modal and its overlay
    function hideDeleteModal() {
        document.getElementById('room-delete-modal').style.display = 'none';
        document.getElementById('room-delete-overlay').style.display = 'none';
    }


</script>
<script>
    function openModal(imageSrc, captionText) {
        var modal = document.getElementById("imageModal");
        var fullImage = document.getElementById("fullImage");
        // var caption = document.getElementById("image-caption");

        // Set the image source and caption
        fullImage.src = imageSrc;
        // caption.innerHTML = captionText;

        // Display the modal
        modal.style.display = "flex";
    }

    // Close the modal when the close button is clicked
    var modaler = document.getElementById("imageModal");
    var closeModalBtn = document.getElementsByClassName("closemodal")[0];

    closeModalBtn.onclick = function () {
        modaler.style.display = "none";
    }

    // Close the modal if the user clicks outside the images
    window.onclick = function (event) {
        if (event.target == modaler) {
            modaler.style.display = "none";
        }
    }
</script>
@endsection