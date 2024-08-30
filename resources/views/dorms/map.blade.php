<!DOCTYPE html>
<html>

<head>
    <title>Dorms Map</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/leaflet.css" />
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/leaflet-routing-machine/3.2.12/leaflet-routing-machine.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/leaflet.js"></script>
    <script
        src="https://cdnjs.cloudflare.com/ajax/libs/leaflet-routing-machine/3.2.12/leaflet-routing-machine.js"></script>
    <style>
        .leaflet-rotate-icon {
            transform-origin: center;
        }
    </style>
</head>

<script src="{{asset('js/map.js')}}"></script>

<body>
    <h1>Dorms Map</h1>
    <div id="map" style="width: 100%; height: 500px;"></div>
    <script id="dorms-data" type="application/json">
        {!! json_encode($dorms) !!}
    </script>
</body>

</html>