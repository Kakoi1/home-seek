@extends('layouts.admin')

@section('dashboard')

@section('content')



<section class="home-section">
    @include('partials.admin-nav')

    <!-- main  content -->
    <div class="home-content">
        <div class="container">
            <h2>Dashboard</h2>
            <div class="overview-boxes">
                <div class="box">
                    <i class='bx bx-user'></i>
                    <div class="text">
                        <h3>Total Owners</h3>
                        <p class="number">{{$ownersCount}}</p>
                    </div>
                </div>
                <div class="box box2">
                    <i class='bx bx-home'></i>
                    <div class="text">
                        <h3>Total Listings</h3>
                        <p class="number">{{$propertiesCount}}</p>
                    </div>
                </div>
                <div class="box">
                    <i class='bx bx-group'></i>
                    <div class="text">
                        <h3>Total Users</h3>
                        <p class="number">{{$usersCount}}</p>
                    </div>
                </div>
            </div>

            <div class="charts">
                <h4>No. of Availability of Rooms</h4>
                <canvas id="roomTypeChart" width="400" height="400"></canvas>
            </div>
        </div>
</section>



@endsection