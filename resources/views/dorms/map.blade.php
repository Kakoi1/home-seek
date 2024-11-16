@extends('layouts.app')

@section('title', 'Map Search')

@section('content')

<script src="{{asset('js/map.js')}}"></script>

<style>
    .intmap {
        padding: 20px 0;
    }
</style>
<div class="container">
    <h1 class="intmap">Interactive Map</h1>
    <div id="map" style="width: 100%; height: 500px;"></div>
    <script id="dorms-data" type="application/json">
        {!! json_encode($dorms) !!}
    </script>

</div>
<script src="{{ asset('js/map.js') }}"></script>
@endsection