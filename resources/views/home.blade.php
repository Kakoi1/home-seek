@extends('layouts.app')

@section('title', 'Home')

@section('content')
<style>
    #dorm-list {

        display: flex;
        align-items: center;
        justify-content: center;
    }

    .home-container {
        max-width: 2000px;
        margin: 0 auto;
    }

    .top-area-container {
        /* display: grid;
        place-items: center; */
        margin: 0 4rem;

    }

    #search-form {
        padding: 20px;
        background-color: #f6f7f6;
        border-radius: 5px;
        /* box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px -1px rgba(0, 0, 0, 0.1); */
        box-shadow: 0 1px 1px rgba(0, 0, 0, 0.12), 0 2px 2px rgba(0, 0, 0, 0.12);
        margin-bottom: 4rem !important;
    }

    .home-container h2 {
        text-align: center;
    }

    .map-search {
        width: 15%;
        margin: 0 auto;
        display: block;
        background: linear-gradient(to right, rgba(11, 136, 147, 0.712), rgba(54, 0, 51, 0.74));
        color: white;
    }

    .map-search:hover {
        background-color: #4561a4;
        color: white;
        font-weight: 500;
    }
</style>
<div class="home-container">
    <br>
    <div class="top-area-container">
        <h2>Accommodation Available</h2>
        <h5>Filter by:</h5>

        <!-- Search Form -->
        <form id="search-form" class="mb-4 search-form">
            <div class="form-row">
                <div class="col-md-4 mb-3">
                    <input type="text" name="search" class="form-control"
                        placeholder="Enter Accommodation name or address" value="{{ request('search') }}">
                </div>
                <div class="col-md-3 mb-3">
                    <input type="number" name="min_price" class="form-control" placeholder="Enter min price"
                        value="{{ request('min_price') }}">
                </div>
                <div class="col-md-3 mb-3">
                    <input type="number" name="max_price" class="form-control" placeholder="Enter max price"
                        value="{{ request('max_price') }}">
                </div>
                <!-- <div class="col-md-3 mb-3">
                    <input type="number" name="rooms_avail" class="form-control" placeholder="Enter no. of rooms"
                        value="{{ request('rooms_avail') }}">
                </div> -->
            </div>
            <button onclick="location.href ='{{ route('showdorms') }}'" class="btn map-search" type="button">Map
                Search</button>
        </form>
    </div>

    <div id="dorms-list">
        @include('partials.dorms', ['dorms' => $dorms])
    </div>
    <br>
    <br>
    <br>
    <div id="pagination-links" class="d-flex justify-content-center">
        {{ $dorms->links() }}
    </div>
    <br>
    <br>
</div>
<script src="{{asset('js/dorm.js')}}"></script>
@endsection