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

    }

    .info button {
        padding: 10px 15px;
        border: none;
        background-color: #3697da;
        color: white;
        border-radius: 5px;

        margin: 0 auto;
        display: block;
    }

    .info button:hover {

        background-color: #226eb9;

    }

    .info {
        /* display: grid;
        justify-content: center;
        align-items: center; */
        /* margin: 0 50px; */
        padding: 25px;
        overflow: hidden;

    }

    .dorm-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 20px;
    }

    .info p span {
        font-weight: 500;
        color: blue;
    }
</style>

<div class="dorm-container">
    <div class="info">
        <h1>{{ $dorm->name }}</h1>
        <h4>{{ $dorm->description }}</h4>
        <p>{{ $dorm->address }}</p>
        <p>Latitude: <i>{{ $dorm->latitude }}</i></p>
        <p>Longitude: <i>{{ $dorm->longitude }}</i></p>
        <p>Rooms Available: {{ $dorm->rooms_available }}</p>
        <p>Price: <span>{{ $dorm->price }}</span></p>

        @php
            // Decode the JSON string into an array
            $imag = json_decode($dorm->image, true);
        @endphp

        @if (is_array($imag) && !empty($imag))
            @foreach($imag as $image)
                <img src="{{ asset('storage/dorm_pictures/' . $image) }}" alt="{{ $dorm->name }}" onclick="showImage(this.src)"
                    style="width: 150px; height: 150px; display:flex; justify-content:center; gap:10px;">


            @endforeach
        @else
            <p>No images available.</p>
        @endif

        <p>Posted by: {{ $dorm->user->name }}</p>

        <!-- Room Display Button -->
        <button type="button" onclick="showRooms()">View Rooms</button>
    </div>
    <!-- Chat Box -->
    @if($dorm->user->id == Auth::id())
        <!-- Dorm owner functionalities here -->
    @else
        <a href="{{ route('dorm.inquire', $dorm->id) }}" class="btn btn-primary">Inquire</a>
    @endif

    <div id="map" style="width: 100%; height: 500px;"></div>
</div>
<script id="dorms-data" type="application/json">
    {!! json_encode($dorm) !!}
</script>

<script>
    function showImage(src) {
        // Create the overlay element
        var overlay = document.createElement("div");
        overlay.id = "overlay";

        // Create the image container and add the image
        var imageContainer = document.createElement("div");
        imageContainer.id = "image-container";
        var img = document.createElement("img");
        img.src = src;
        imageContainer.appendChild(img);

        // Add the image container to the overlay
        overlay.appendChild(imageContainer);

        // Append the overlay to the body
        document.body.appendChild(overlay);

        // Add an event listener to close the overlay when clicked
        overlay.addEventListener("click", function () {
            overlay.remove();
        });
    }

    function showRooms() {
        // Create the overlay element
        var overlay = document.createElement("div");
        overlay.id = "overlay";

        // Create the room grid container
        var roomGrid = document.createElement("div");
        roomGrid.id = "room-grid";

        // Assuming you have a JavaScript variable with room data
        @if(isset($dorm->rooms))
            @foreach($dorm->rooms as $room)

                var roomDiv = document.createElement("div");
                roomDiv.classList.add("room");
                roomDiv.innerHTML = `
                                        <p>Room Number: {{ $room->number }}</p>
                                        <img class='pic' src="{{ asset('storage/room_images/' . $room->images) }}" alt="Room Image">
                                        <p>Capacity: {{ $room->capacity }}</p>
                                        <p>Price: {{ $room->price }}</p>
                                        <p>{{ $room->status ? 'Available' : 'Not Available' }}</p>
                                    `;

                @if ($dorm->user_id == auth::id())
                    roomDiv.innerHTML += `<button onclick="window.location.href='{{ route('room.edit', ['id' => $room->id, 'action' => 'edit']) }}'">edit</button>
                                                                          <button onclick="window.location.href='{{ route('room.edit', ['id' => $room->id, 'action' => 'view']) }}'">View</button>
                                                                          <button onclick="window.location.href='{{ route('room.edit', ['id' => $room->id, 'action' => 'delete']) }}'">delete</button>
                                                    `;
                @elseif($room->status)
                    roomDiv.innerHTML += `<a href="{{ route('room.inquire', $room->id) }}" class="btn btn-primary">Inquire Room</a>`;
                @endif

                roomGrid.appendChild(roomDiv);

            @endforeach
        @endif

        // Create the close button with an icon
        var closeButton = document.createElement("button");
        closeButton.id = "close-button";
        closeButton.innerHTML = "&times;"; // HTML entity for a multiplication sign (close icon)

        // Add the room grid and close button to the overlay
        overlay.appendChild(closeButton);
        overlay.appendChild(roomGrid);

        // Append the overlay to the body
        document.body.appendChild(overlay);

        // Add an event listener to close the overlay when clicked
        closeButton.addEventListener("click", function () {
            overlay.remove();
        });
    }
</script>

@endsection