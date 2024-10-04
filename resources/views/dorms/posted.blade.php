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
        width: 46rem;

    }

    .info p span {
        font-weight: 500;
        color: blue;
    }

    .inquire {
        width: 15%;
        position: absolute;
        top: 8rem;
        right: 25rem !important;
        margin: 0 auto;
    }

    .dorm-container {
        max-width: 1300px;
        margin: 0 auto;
        padding: 20px;
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
</style>
@php
    // Decode the JSON string into an array
    $imag = json_decode($dorm->image, true);
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
                        <img class="d-block w-80" src="{{ asset('storage/dorm_pictures/' . $image) }}" alt="{{ $dorm->name }}"
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
                <img src="{{ asset('storage/dorm_pictures/' . $image) }}" alt="{{ $dorm->name }}"
                    style="width: 60px; height: 60px; object-fit: cover; border-radius: 10px; cursor: pointer; margin-right: 10px;"
                    onclick="openModal('{{ asset('storage/dorm_pictures/' . $image) }}', '{{ $dorm->name }}')">
            @endforeach
        </div>
    </div>
    <br>
    <div class="info" style="margin-top: 30px; margin: 0 auto;">
        <h1>{{ $dorm->name }}</h1>
        <h4>{{ $dorm->description }}</h4>
        <p><i class="fas fa-map-marker-alt"></i> {{ $dorm->address }}</p>
        <p>Rooms Available: {{ $rooms }}</p>
        <p>Price: ₱ <span>{{ $dorm->price }}</span></p>
        <p>Posted by: {{ $dorm->user->name }}</p>

        <!-- Room Display Button -->
        <button type="button" onclick="showRooms()" class="btn btn-primary mt-3">View Rooms</button>
        <br>

        <!-- Chat Box -->
        @if($dorm->user->id == Auth::id())
            <button id="manage-rooms-btn" class="btn btn-primary">Manage Rooms</button>
        @else
            <a href="{{ route('dorm.inquire', $dorm->id) }}" class="btn btn-primary inquire"><i class="fas fa-envelope"></i>
                Inquire </a>
        @endif
    </div>
    <br>
    <div id="map" style="width: 100%; height: 500px;"></div>
    <script id="dorms-data" type="application/json">
    {!! json_encode($dorm) !!}
</script>
    <!-- Reviews Section -->
    <div class="reviews-section" style="margin-top: 50px;">
        <h3>Reviews</h3>
        <!-- Placeholder for reviews -->
        <p>No reviews yet.</p>
    </div>

    <!-- Manage Rooms Button -->

    <!-- Room Management Section -->
    <div id="room-management" class="room-management" style="display: none;">
        <button id="close-room-management" class="close-btn">✖</button> <!-- Close Button -->
        <h4>Manage Rooms</h4>

        <!-- Room Count Controls -->
        <div class="room-controls" style="display: flex; align-items: center; gap: 10px;">
            <button id="decrement" class="btn btn-danger" style="font-size: 20px; width: 40px; height: 40px;">-</button>
            <span id="room-count" style="margin: 0 15px; font-size: 20px;">{{ $rooms }}</span>
            <button id="increment" class="btn btn-success"
                style="font-size: 20px; width: 40px; height: 40px;">+</button>
        </div>

        <!-- Add a button to save room changes -->
        <button id="add-rooms" class="btn btn-primary mt-3">Save Room Changes</button>
    </div>

    <div id="imageModal" class="image-modal" style="display: none;">
        <span class="closemodal">&times;</span>
        <img class="modal-content" id="fullImage">
        <!-- <div id="image-caption"></div> -->
    </div>

    <!-- Modal/Div for Selecting Rooms to Delete -->
    <div id="room-delete-modal" class="room-delete-modal" style="display:none;">
        <h5>Select Room(s) to Delete:</h5>
        <div id="room-list">
            @foreach($dorm->rooms as $room)
                <div class="room-item">
                    <label>
                        <input type="checkbox" name="rooms_to_delete[]" value="{{ $room->id }}">
                        Room Number: {{ $room->number }} (Price: {{ $room->price }})
                    </label>
                </div>
            @endforeach
        </div>
        <button id="confirm-delete" class="btn btn-danger">Confirm Delete</button>
        <button id="cancel-delete" class="btn btn-secondary">Cancel</button>
    </div>

    <!-- Separate Overlays for Room Management and Delete Modal -->
    <div id="room-management-overlay" class="modal-overlay" style="display: none;"></div>
    <div id="room-delete-overlay" class="modal-overlay" style="display: none;"></div>

</div>
<!-- Overlay -->


<br><br>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const propertyId = {{ $dorm->id }};

        const url = `{{ route('dorm.view', ':dormId') }}`.replace(':dormId', propertyId);

        fetch(url, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
            }
        })
            .then(response => response.json())
            .then(data => {
                console.log(data.message); // Optionally show a message
            })
            .catch(error => console.error('Error:', error));
    });

    function showRooms() {
        // Create the overlay element
        var overlay = document.createElement("div");
        overlay.id = "overlay";

        // Create the room grid container
        var roomGrid = document.createElement("div");
        roomGrid.id = "room-grid";

        @if(isset($dorm->rooms))
                    @foreach($dorm->rooms as $room)

                                var roomDiv = document.createElement("div");
                                roomDiv.classList.add("room");
                                roomDiv.innerHTML = `
                        <p>Room Number: {{ $room->number }}</p>
                        <img class='pic' src="{{ $room->images ? asset('storage/room_images/' . $room->images) : 'https://via.placeholder.com/120x120'}}" alt="Room Image"
                        style="width: 150px; height: 150px; object-fit: cover; border-radius: 10px;">
                        <p>Capacity: {{ $room->capacity }}</p>
                        <p>Price: {{ $room->price }}</p>
                        <p>{{ $room->status ? 'Available' : 'Not Available' }}</p>
                        `;

                                @if ($dorm->user_id == auth::id())
                                            roomDiv.innerHTML += `
                                    <button onclick="window.location.href='{{ route('room.edit', ['id' => $room->id, 'action' => 'edit']) }}'">Edit</button>
                                    <button onclick="window.location.href='{{ route('room.edit', ['id' => $room->id, 'action' => 'view']) }}'">View</button>
                                    <button onclick="window.location.href='{{ route('room.edit', ['id' => $room->id, 'action' => 'delete']) }}'">Delete</button>
                                    `;
                                @elseif($room->status)
                                    roomDiv.innerHTML += `<button onclick="window.location.href='{{ route('room.edit', ['id' => $room->id, 'action' => 'view']) }}'">View</button>`;
                                @endif

                                roomGrid.appendChild(roomDiv);

                    @endforeach
        @endif

        // Close button
        var closeButton = document.createElement("button");
        closeButton.id = "close-button";
        closeButton.innerHTML = "&times;";
        overlay.appendChild(closeButton);
        overlay.appendChild(roomGrid);

        document.body.appendChild(overlay);

        closeButton.addEventListener("click", function () {
            overlay.remove();
        });
    }

    // Function to jump to a specific carousel slide
    function jumpToSlide(index) {
        $('#carouselExampleControls').carousel(index);
    }
    // Room count variable to track the current number of rooms
    let roomCount = parseInt(document.getElementById('room-count').innerText);
    let deleteClickCount = 0;
    let roomIndex = {{ $dorm->rooms->count() }}; // Set initial index based on existing rooms

    // Show Room Management section and its overlay when "Manage Rooms" button is clicked
    document.getElementById('manage-rooms-btn').addEventListener('click', function () {
        document.getElementById('room-management').style.display = 'block';
        document.getElementById('room-management-overlay').style.display = 'block'; // Show overlay for room management
    });

    // Close button for room management modal
    document.getElementById('close-room-management').addEventListener('click', function () {
        hideRoomManagementModal();
    });

    document.getElementById('decrement').addEventListener('click', function () {
        if (roomCount > 0) {
            deleteClickCount++;
            showDeleteModal(deleteClickCount); // Show modal for selecting rooms to delete
        }
    });

    // Function to show the room delete modal with its own overlay
    function showDeleteModal(timesClicked) {
        document.getElementById('room-delete-modal').style.display = 'block';
        document.getElementById('room-delete-overlay').style.display = 'block'; // Show separate overlay for delete modal

        // Clear and repopulate the room list in the delete modal
        const roomListDelete = document.getElementById('room-list-delete');
        roomListDelete.innerHTML = ''; // Clear previous entries
        document.querySelectorAll('.room-item').forEach(function (roomItem) {
            const clonedRoomItem = roomItem.cloneNode(true);
            roomListDelete.appendChild(clonedRoomItem);
        });
    }

    document.getElementById('increment').addEventListener('click', function () {
        // Use SweetAlert to ask how many rooms to add
        Swal.fire({
            title: 'How many rooms do you want to add?',
            input: 'number',
            inputAttributes: {
                min: 1
            },
            inputValue: 1, // Default value
            showCancelButton: true,
            confirmButtonText: 'Add',
            cancelButtonText: 'Cancel',
            inputValidator: (value) => {
                if (!value || value <= 0) {
                    return 'Please enter a valid number of rooms.';
                }
            }
        }).then((result) => {
            if (result.isConfirmed) {
                const roomsToAdd = result.value;
                let timerInterval;
                // Make an AJAX request to add rooms
                fetch('{{ route('dorm.addRooms', $dorm->id) }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ rooms_available: roomsToAdd })
                })
                    .then(response => response.json())
                    .then(data => {
                        // Success alert using SweetAlert
                        Swal.fire({
                            title: "Auto close alert!",
                            html: `${roomsToAdd} room(s) added successfully.`,
                            timer: 2000,
                            timerProgressBar: true,
                            didOpen: () => {
                                Swal.showLoading();
                                const timer = Swal.getPopup().querySelector("b");
                                timerInterval = setInterval(() => {
                                    timer.textContent = `${Swal.getTimerLeft()}`;
                                }, 100);
                            },
                            willClose: () => {
                                clearInterval(timerInterval);
                            }
                        }).then((result) => {
                            /* Read more about handling dismissals below */
                            if (result.dismiss === Swal.DismissReason.timer) {
                                roomCount += parseInt(roomsToAdd);
                                document.getElementById('room-count').innerText = roomCount;
                                location.reload();
                            }
                        });

                    })
                    .catch(error => {
                        console.error('Error:', error);
                        // Error alert using SweetAlert
                        Swal.fire(
                            'Error!',
                            'Failed to add rooms. Please try again later.',
                            'error'
                        );
                    });
            }
        });
    });


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