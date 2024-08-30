let map, marker, routingControl, userMarker, heading = 0;

// Define the bounds for Minglanilla, Cebu
const minglanillaBounds = [
    [10.233, 123.789], // Southwest corner
    [10.283, 123.835]  // Northeast corner
];

document.addEventListener('DOMContentLoaded', function() {
    function initMap() {
        // Create a map centered at Cebu
        map = L.map('map').setView([10.255, 123.807], 14);

        // Add OpenStreetMap tiles
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        // Set the map bounds to Minglanilla
        // map.setMaxBounds(minglanillaBounds);

        // Dorm locations
        var dormDataElement = document.getElementById('dorms-data');
        if (dormDataElement) {
            var dorms = JSON.parse(dormDataElement.textContent);
            if (Array.isArray(dorms)) {
                dorms.forEach(function(dorm) {
                    var marker = L.marker([dorm.latitude, dorm.longitude]).addTo(map);
                    marker.bindPopup(dorm.name + '<br><a href="#" onclick="getDirections(' + dorm.latitude + ',' + dorm.longitude + '); return false;">Direction</a>');
                });
            } else {
                var dorm = dorms;
                var marker = L.marker([dorm.latitude, dorm.longitude]).addTo(map);
                marker.bindPopup(dorm.name + '<br><a href="#" onclick="getDirections(' + dorm.latitude + ',' + dorm.longitude + '); return false;">Direction</a>');
                map.setView([dorm.latitude, dorm.longitude], 14);
            }
        }

        if (window.DeviceOrientationEvent) {
            window.addEventListener('deviceorientation', handleOrientation, true);
        }

        // Add click event to place a marker within the bounds
        map.on('click', function(e) {
            if (e.latlng.lat >= 10.233 && e.latlng.lat <= 10.283 && e.latlng.lng >= 123.789 && e.latlng.lng <= 123.835) {
                if (marker) {
                    map.removeLayer(marker);
                }
                marker = L.marker(e.latlng).addTo(map);
                document.getElementById("latitude").value = e.latlng.lat;
                document.getElementById("longitude").value = e.latlng.lng;

                // Get the address from the coordinates and set it in the input field
                getAddress(e.latlng.lat, e.latlng.lng);
            } else {
                alert("Please pin a location within Minglanilla, Cebu.");
            }
        });
    }

    function getDirections(lat, lng) {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                var userLatLng = [position.coords.latitude, position.coords.longitude];
                addRouting(userLatLng, [lat, lng]);
                addUserMarker(userLatLng);
            });
        } else {
            alert("Geolocation is not supported by this browser.");
        }
    }

    function addRouting(start, end) {
        if (routingControl) {
            map.removeControl(routingControl);
        }
        routingControl = L.Routing.control({
            waypoints: [
                L.latLng(start[0], start[1]),
                L.latLng(end[0], end[1])
            ],
            routeWhileDragging: true
        }).addTo(map);
    }

    function addUserMarker(latlng) {
        var userIcon = L.divIcon({
            html: '<img src="/images/right-arrow_275202.png" style="transform: rotate(' + heading + 'deg);" class="leaflet-rotate-icon" />',
            iconSize: [0, 0],
            iconAnchor: [16, 16]
        });

        if (userMarker) {
            userMarker.setLatLng(latlng);
            userMarker.setIcon(userIcon);
        } else {
            userMarker = L.marker(latlng, { icon: userIcon }).addTo(map);
        }

        map.setView(latlng, 14);
    }

    function handleOrientation(event) {
        heading = event.alpha;

        if (userMarker) {
            var icon = userMarker.getIcon();
            icon.options.html = '<img src="/images/right-arrow_275202.png" style="transform: rotate(' + heading + 'deg);" class="leaflet-rotate-icon" />';
            userMarker.setIcon(icon);
        }
    }

    function getAddress(latitude, longitude) {
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const xhr = new XMLHttpRequest();
        xhr.open("POST", "/get-coor", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.setRequestHeader("X-CSRF-TOKEN", csrfToken);
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                document.getElementById("address").value = xhr.responseText;
            }
        };
        xhr.send("latitude=" + latitude + "&longitude=" + longitude);
    }

    function showMap() {
        document.getElementById('map').style.display = 'block';
        setTimeout(() => {
            map.invalidateSize();
        }, 100);
    }

    function closeMap() {
        document.getElementById('map').style.display = 'none';
    }

    // Make functions globally accessible
    window.getDirections = getDirections;
    window.showMap = showMap;
    window.closeMap = closeMap;

    initMap();
});

function getUserLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition, showError);
    } else {
        alert("Geolocation is not supported by this browser.");
    }
}

function showPosition(position) {
    var lat = position.coords.latitude;
    var lon = position.coords.longitude;
    if (lat >= 10.233 && lat <= 10.283 && lon >= 123.789 && lon <= 123.835) {
        document.getElementById("latitude").value = lat;
        document.getElementById("longitude").value = lon;

        // Set the marker on the map
        if (marker) {
            map.removeLayer(marker);
        }
        marker = L.marker([lat, lon]).addTo(map);
        map.setView([lat, lon], 14);

        // Get the address from the coordinates and set it in the input field
        getAddress(lat, lon);
    } else {
        alert("Location is outside Minglanilla, Cebu.");
    }
}

function showError(error) {
    switch (error.code) {
        case error.PERMISSION_DENIED:
            alert("User denied the request for Geolocation.");
            break;
        case error.POSITION_UNAVAILABLE:
            alert("Location information is unavailable.");
            break;
        case error.TIMEOUT:
            alert("The request to get user location timed out.");
            break;
        case error.UNKNOWN_ERROR:
            alert("An unknown error occurred.");
            break;
    }
}
