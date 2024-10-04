@extends('layouts.app')

@section('title', $room->number)

@section('content')

<style>
    /* ...previous styles... */
    body {
        font-family: 'Arial', sans-serif;
        background-color: #f4f4f4;
        margin: 0;
        /* padding: 20px; */
    }

    h1,
    h2 {
        text-align: center;
        color: #333;
    }

    .room-container {
        width: 80%;
        margin: 0 auto;
        background-color: #fff;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .room-image {
        text-align: center;
        margin-bottom: 20px;
    }

    .room-image img {
        width: 100%;
        max-width: 600px;
        height: auto;
        border-radius: 10px;
        object-fit: cover;
    }

    .form-group {
        margin-bottom: 15px;
    }

    label {
        font-size: 16px;
        color: #555;
        display: block;
        margin-bottom: 5px;
    }

    input[type="text"],
    input[type="number"],
    input[type="file"],
    input[type="checkbox"] {
        width: 100%;
        padding: 10px;
        margin-bottom: 10px;
        border-radius: 5px;
        border: 1px solid #ddd;
        font-size: 16px;
    }

    .btn-container {
        text-align: center;
        margin-top: 20px;
    }

    button {
        background-color: #007bff;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    button:hover {
        background-color: #0056b3;
    }

    /* Inquiries Table */
    table {
        width: 100%;
        border-collapse: collapse;
        margin: 20px 0;
        font-size: 16px;
        text-align: left;
    }

    th,
    td {
        padding: 12px 15px;
        border-bottom: 1px solid #ddd;
    }

    th {
        background-color: #f4f4f4;
        font-weight: bold;
    }

    tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    tr:hover {
        background-color: #f1f1f1;
    }

    .status-buttons {
        text-align: center;
    }

    .approve-btn,
    .reject-btn {
        background-color: #4CAF50;
        padding: 10px 20px;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        margin-right: 10px;
        transition: background-color 0.3s ease;
    }

    .approve-btn:hover {
        background-color: #45a049;
    }

    .reject-btn {
        background-color: #f44336;
    }

    .reject-btn:hover {
        background-color: #e53935;
    }

    /* Image Picker */
    .image-picker {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        justify-content: center;
    }

    .image-picker img {
        width: 80px;
        height: 80px;
        border-radius: 5px;
        cursor: pointer;
        transition: transform 0.3s ease;
    }

    .image-picker img:hover {
        transform: scale(1.1);
    }

    /* Book Room Button Styles */
    .book-room-btn {
        background: linear-gradient(to left, rgba(11, 136, 147, 0.712), rgba(54, 0, 51, 0.74));
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s ease;
        margin-top: 20px;
    }

    .book-room-btn:hover {
        background-color: #218838;
    }

    /* Modal Styles */
    .modal {
        display: none;
        /* Hidden by default */
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        /* Semi-transparent background */
        z-index: 1000;
        justify-content: center;
        align-items: center;
    }

    .modal-content {
        background-color: #fff;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        text-align: center;
    }

    .modal h2 {
        margin-bottom: 20px;
    }

    .modal button {
        background-color: #007bff;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        margin: 10px;
    }

    .modal button:hover {
        background-color: #0056b3;
    }

    .close-btn {
        background-color: #f44336;
    }

    .close-btn:hover {
        background-color: #e53935;
    }
</style>
<br>
<div class="room-container">
    @if ($action == "edit")
        <h1>Edit Room</h1>
        <div class="room-image">
            @if($room->images)
                <img id="selected-image" src="{{ asset('storage/room_images/' . $room->images) }}" alt="Room Image">
            @else
                <img id="selected-image" src="https://via.placeholder.com/300x300" alt="Room Image">
            @endif
        </div>

        <form method="POST" action="{{ route('room.update', $room->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="room_number">Room Number</label>
                <input type="text" id="room_number" name="number" value="{{ $room->number }}" required>
            </div>

            <div class="form-group">
                <label for="capacity">Room Capacity</label>
                <input type="number" id="capacity" name="capacity" value="{{ $room->capacity }}" required>
            </div>

            <div class="form-group">
                <label for="price">Price</label>
                <input type="text" id="price" name="price" value="{{ $room->price }}" required>
            </div>

            <div class="form-group">
                <label for="status">Available</label>
                <input type="checkbox" id="status" name="status" {{ $room->status ? 'checked' : '' }}>
            </div>

            <div class="form-group">
                <label for="images">Upload Image</label>
                <input type="file" accept="image/png, image/gif, image/jpeg" id="images" name="images"
                    onchange="previewImage(event)">
                <div class="image-picker">
                    @if($room->images)
                        <img src="{{ asset('storage/room_images/' . $room->images) }}" alt="Room Image"
                            onclick="showImage(this)">
                    @endif
                </div>
            </div>

            <div class="btn-container">
                <button type="submit">Update Room</button>
            </div>
        </form>
    @elseif ($action == "view")
        <h1>{{ $room->dorm->name }}</h1>
        <h2>{{ $room->number }}</h2>

        <div class="room-image">
            @if($room->images)
                <img src="{{ asset('storage/room_images/' . $room->images) }}" alt="Room Image">
            @endif
        </div>

        <p><strong>Room Capacity: </strong>{{ $room->capacity }}</p>
        <p><strong>Price: </strong>{{ $room->price }}</p>
        <p><strong>Status: </strong>{{ $room->status ? 'Available' : 'Not Available' }}</p>

        <!-- Display Book Room button for tenants only -->
        @if ($room->dorm->user_id != auth()->id())
            <button class="book-room-btn" id="bookRoomBtn">Book Room</button>
        @endif

        <!-- Modal for Booking Options -->
        <!-- <div id="bookingModal" class="modal">
                                            <div class="modal-content">
                                                <h2>Choose Booking Term</h2>
                                                <button id="longTermBtn">Long Term</button>
                                                <button id="shortTermBtn">Short Term</button>
                                                <button class="close-btn" id="closeModalBtn">Close</button>
                                            </div>
                                        </div> -->
        @if ($room->dorm->user_id == auth()->id())
            @if (!$occupied)
                <h2>Inquiries</h2>
                @if($submited->isNotEmpty())
                    <!-- Inquiry Table (same as before) -->
                    <table>
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Starting Date</th>
                                <th>Number of Months</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($submited as $submit)
                                <tr>
                                    <td>{{ $submit->user->name }}</td>
                                    <td>{{ $submit->start_date }}</td>
                                    <td>{{ $submit->duration }}</td>
                                    <td class="status-buttons">
                                        <form action="{{ route('rentForm.updateStatus', $submit->id) }}" method="POST"
                                            style="display: inline;">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="approve-btn" name="status" value="approved">Approve</button>
                                            <button type="submit" class="reject-btn" name="status" value="rejected">Reject</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <h3>No Inquiries</h3>
                @endif
            @else
                <h2>Tenant:</h2>
                <h4>{{ $occupied->user->name }}</h4>
            @endif
        @endif
    @endif
</div>
<script>

    document.getElementById('images').addEventListener('change', function (e) {
        const reader = new FileReader();
        reader.onload = function (event) {
            document.getElementById('selected-image').src = event.target.result;
        };
        reader.readAsDataURL(e.target.files[0]);
    });
</script>
<script>
    // Show modal when Book Room button is clicked


    const bookRoomBtn = document.getElementById('bookRoomBtn');
    const bookingModal = document.getElementById('bookingModal');
    const closeModalBtn = document.getElementById('closeModalBtn');
    const longTermBtn = document.getElementById('longTermBtn');
    const shortTermBtn = document.getElementById('shortTermBtn');

    // bookRoomBtn.addEventListener('click', function () {
    //     bookingModal.style.display = 'flex';
    // });

    // closeModalBtn.addEventListener('click', function () {
    //     bookingModal.style.display = 'none';
    // });

    bookRoomBtn.addEventListener('click', function () {
        window.location.href = '{{ route('rentForm.create', ['roomid' => $room->id]) }}';
    });


    // Close the modal if user clicks outside the modal
    window.onclick = function (event) {
        if (event.target == bookingModal) {
            bookingModal.style.display = 'none';
        }
    }
</script>
<br>
@endsection