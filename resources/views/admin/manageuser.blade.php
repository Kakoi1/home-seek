@extends('layouts.admin')

@section('manage user')

@section('content')

<body>

    <section class="home-section">
        @include('partials.admin-nav')

        <!-- main  content -->
        <div class="home-content">
            <div class="container">
                <h2>Manage Users</h2>
                <!-- Filter Buttons -->
                <div class="filter-buttons">
                    <button class="filter-btn active" data-filter="all">All</button>
                    <button class="filter-btn" data-filter="approved">Approved</button>
                    <button class="filter-btn" data-filter="rejected">Rejected</button>
                    <button class="filter-btn" data-filter="pending">Pending</button>
                </div>


                <div class="user-boxes">
                    @foreach($users as $user)
                        <div class="user-box">
                            <!-- Display user image -->
                            <img src="{{ $user->profile_picture ? asset('storage/profile_pictures/' . $user->profile_picture) : 'https://via.placeholder.com/80x80' }}"
                                alt="User Image">

                            <!-- User Information -->
                            <div class="user-info">
                                <h4>{{ $user->name }}</h4>
                                <p>Status: {{ $user->status ? 'Inactive' : 'Active' }}</p>
                                <p>Role: {{ $user->role }}</p>
                            </div>

                            <!-- Action Buttons -->
                            <div class="buttons">
                                <button class="btn-approve" onclick="approveUser({{ $user->id }})">Approve</button>
                                <button class="btn-manage" onclick="manageUser({{ $user->id }})">Manage</button>
                            </div>
                        </div>
                    @endforeach


                </div>
    </section>



    @endsection