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
        <h2>Favourites</h2>

    </div>

    <div id="dorms-list">
        @include('partials.dorms', ['dorms' => $dorms])
    </div>

    <br>
    <br>
</div>
<script src="{{asset('js/dorm.js')}}"></script>
@endsection