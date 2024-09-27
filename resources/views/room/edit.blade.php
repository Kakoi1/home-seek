@extends('layouts.app')

@section('title', $room->number)

@section('content')

<style>
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


    button {
        background-color: #4CAF50;
        /* Green */
        border: none;
        color: white;
        padding: 8px 16px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 14px;
        margin: 4px 2px;
        cursor: pointer;
        border-radius: 4px;
        transition: background-color 0.3s ease;
    }

    button:hover {
        background-color: #45a049;
    }

    button[name="status"][value="rejected"] {
        background-color: #f44336;
        /* Red */
    }

    button[name="status"][value="rejected"]:hover {
        background-color: #e53935;
    }
</style>

@if ($action == "edit")
    <h1>Edit Room</h1>
    <form method="POST" action="{{ route('room.update', $room->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="room_number">Room Number</label>
            <input type="text" id="room_number" name="number" value="{{ $room->number }}" required>
        </div>

        <div class="form-group">
            <label for="type">Room Capacity</label>
            <input type="text" id="capacity" name="capacity" value="{{ $room->capacity }}" required>
        </div>

        <div class="form-group">
            <label for="price">Price</label>
            <input type="text" id="price" name="price" value="{{ $room->price }}" required>
        </div>

        <div class="form-group">
            <label for="is_available">Available</label>
            <input type="checkbox" id="status" name="status" {{ $room->status ? 'checked' : '' }}>
        </div>

        <div class="form-group">
            <label for="images">Image</label>
            <input type="file" accept="image/png, image/gif, image/jpeg" id="images" name="images">
            @if($room->images)
                <img src="{{ asset('storage/room_images/' . $room->images) }}" alt="Room Image"
                    style="width: 150px; height: 150px;">
            @endif
        </div>

        <button type="submit">Update Room</button>
    </form>
@elseif($action == "view")
    <h1>{{$room->dorm->name}}</h1>
    <h2>{{$room->number}}</h2>
    <p><strong>Room Capacity: </strong>{{$room->capacity }}</p>
    <p><strong>Price: </strong>{{$room->capacity }}</p>
    <p><strong>Room Capacity: </strong>{{$room->status ? 'available' : 'not available' }}</p>
    @if($room->images)
        <img src="{{ asset('storage/room_images/' . $room->images) }}" alt="Room Image"
            style="width: 50%; margin: 0 auto height: 250px;">

    @endif

    @if (!$occupied)
        <h2>Inquiries</h2>
        @if($submited->isNotEmpty())
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
                            <td>
                                <!-- Approve and Reject buttons -->
                                <form action="{{ route('rentForm.updateStatus', $submit->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" name="status" value="approved">Approve</button>
                                    <button type="submit" name="status" value="rejected">Reject</button>
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

@endsection