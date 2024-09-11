@extends('layouts.app')

@section('title', 'Home')

@section('content')
<style>
    #dorm-list {}

    .home-container {
        max-width: 2000px;
        margin: 0 auto;
    }
</style>
<div class="home-container">
    <br>
    <h2>Dorm Listings</h2>

    <!-- Search Form -->
    <form id="search-form" class="mb-4 search-form">
        <div class="form-row">
            <div class="col-md-4 mb-3">
                <input type="text" name="search" class="form-control" placeholder="Search by name or address"
                    value="{{ request('search') }}">
            </div>
            <div class="col-md-3 mb-3">
                <input type="number" name="min_price" class="form-control" placeholder="Min price"
                    value="{{ request('min_price') }}">
            </div>
            <div class="col-md-3 mb-3">
                <input type="number" name="max_price" class="form-control" placeholder="Max price"
                    value="{{ request('max_price') }}">
            </div>
            <div class="col-md-3 mb-3">
                <input type="number" name="rooms_avail" class="form-control" placeholder="Rooms"
                    value="{{ request('rooms_avail') }}">
            </div>
        </div>
    </form>

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
</div>

@endsection