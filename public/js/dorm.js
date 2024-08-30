// document.addEventListener('DOMContentLoaded', function() {
//     let map, routingControl, userMarker, heading = 0;

//     function initMap() {
//         // Create a map centered at Cebu
//         map = L.map('map').setView([10.255, 123.807], 14);

//         // Add OpenStreetMap tiles
//         L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
//             attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
//         }).addTo(map);

//         // Dorm locations
//         var dormDataElement = document.getElementById('dorms-data');
//         if (dormDataElement) {
//             var dorms = JSON.parse(dormDataElement.textContent);
//             if (Array.isArray(dorms)) {
//                 dorms.forEach(function(dorm) {
//                     var marker = L.marker([dorm.latitude, dorm.longitude]).addTo(map);
//                     marker.bindPopup(dorm.name + '<br><a href="#" onclick="getDirections(' + dorm.latitude + ',' + dorm.longitude + '); return false;">Direction</a>');
//                 });
//             } else {
//                 var dorm = dorms;
//                 var marker = L.marker([dorm.latitude, dorm.longitude]).addTo(map);
//                 marker.bindPopup(dorm.name + '<br><a href="#" onclick="getDirections(' + dorm.latitude + ',' + dorm.longitude + '); return false;">Direction</a>');
//                 map.setView([dorm.latitude, dorm.longitude], 14);
//             }
//         }

//         if (window.DeviceOrientationEvent) {
//             window.addEventListener('deviceorientation', handleOrientation, true);
//         }
//     }

//     function getDirections(lat, lng) {
//         if (navigator.geolocation) {
//             navigator.geolocation.getCurrentPosition(function(position) {
//                 var userLatLng = [position.coords.latitude, position.coords.longitude];
//                 addRouting(userLatLng, [lat, lng]);
//                 addUserMarker(userLatLng);
//             });
//         } else {
//             alert("Geolocation is not supported by this browser.");
//         }
//     }

//     function addRouting(start, end) {
//         if (routingControl) {
//             map.removeControl(routingControl);
//         }
//         routingControl = L.Routing.control({
//             waypoints: [
//                 L.latLng(start[0], start[1]),
//                 L.latLng(end[0], end[1])
//             ],
//             routeWhileDragging: true
//         }).addTo(map);
//     }

//     function addUserMarker(latlng) {
//         var userIcon = L.divIcon({
//             html: '<img src="/images/right-arrow_275202.png" style="transform: rotate(' + heading + 'deg);" class="leaflet-rotate-icon" />',
//             iconSize: [0, 0],
//             iconAnchor: [16, 16]
//         });

//         if (userMarker) {
//             userMarker.setLatLng(latlng);
//             userMarker.setIcon(userIcon);
//         } else {
//             userMarker = L.marker(latlng, { icon: userIcon }).addTo(map);
//         }

//         map.setView(latlng, 14);
//     }

//     function handleOrientation(event) {
//         heading = event.alpha;

//         if (userMarker) {
//             var icon = userMarker.getIcon();
//             icon.options.html = '<img src="/images/right-arrow_275202.png" style="transform: rotate(' + heading + 'deg);" class="leaflet-rotate-icon" />';
//             userMarker.setIcon(icon);
//         }
//     }

//     // Make functions globally accessible
//     window.getDirections = getDirections;

//     initMap();
// });
