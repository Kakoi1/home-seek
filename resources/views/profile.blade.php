@extends('layouts.app')

@section('title', 'Profile')

@section('content')
<div class="container">
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
        <a href="{{'adddorm'}}">add dorm</a>
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
        <h2>Inquiries</h2>
        <ul>
            @foreach($inquiries as $inquiry)
                <li>{{ $inquiry->message }} from {{ $inquiry->user->name }}</li>
            @endforeach
        </ul>

        <h2>Statistics</h2>
        <p>Total Properties: {{ $statistics['total_properties'] }}</p>
        <p>Total Inquiries: {{ $statistics['total_inquiries'] }}</p>

    @elseif($user->role == 'tenant')
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
    </script>
</div>
@endsection