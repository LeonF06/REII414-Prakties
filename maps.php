<?php
session_start();

// Set the session timeout in seconds (30 minutes)
$sessionTimeout = 1800;

// Check if the session variable for the last activity timestamp exists
if (isset($_SESSION['lastActivity'])) {
    // Calculate the time difference between the current time and the last activity
    $inactiveTime = time() - $_SESSION['lastActivity'];

    // Check if the user has been inactive for longer than the session timeout
    if ($inactiveTime >= $sessionTimeout) {
        // Expire the session and redirect the user to the login page
        session_unset();
        session_destroy();
        header("Location: index.php");
        exit();
    }
}
// Update the last activity timestamp in the session
$_SESSION['lastActivity'] = time();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Map Search</title>
    <style>
        body {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            margin: 20px;
        }

        h1 {
            margin-bottom: 10px;
        }

        #calculateDistanceButton,
        #saveLocationButton,
        #distanceLabel {
            display: none;
            margin-left: 10px;
        }

        #map {
            height: 600px;
            width: 100%;
            margin-top: 20px;
        }

        #distanceContainer {
            display: flex;
            flex-direction: row;
            align-items: flex-start;
            margin-top: 20px;
            margin-left: 20px;
        }

        h2 {
            margin-top: 0;
            margin-bottom: 10px;
        }

        #distanceTextArea {
            width: 150px;
            margin-top: 5px;
        }

        #gateInfo {
            margin-left: 20px;
        }

    </style>
    <!-- Include Leaflet CSS and JavaScript -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <script src="https://unpkg.com/es6-promise@4.2.8/dist/es6-promise.min.js"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
</head>
<body>
    <h1>Map Search</h1>
    <p>Try turning on your location. Click anywhere on the map to place a location pinpoint for your property. Click on the calculate distance button to determine the distances to the 6 university gates. Click on the save location button to conclude.</p>
    <form id="searchForm" action="landlord_dashboard.php" method="GET">
        <div id="buttonContainer">
            <button id="calculateDistanceButton" onclick="calculateDistances()">Calculate distances</button>
            <button id="saveLocationButton" onclick="saveLocation(pinnedLocation)">Save location</button>
        </div>
    </form>
    <div id="map"></div>
    <div id="distanceContainer">
        <div id="textAreaContainer">
            <h2>Distance to gates:</h2>
            <textarea id="distanceTextArea" rows="6" cols="40"></textarea>
        </div>
        <div id="gateInfo">
            <p>Gate A: Onderwys kampus hek</p>
            <p>Gate B: Ratau lebone hek</p>
            <p>Gate C: Weet en sweet hek</p>
            <p>Gate D: Hoofhek</p>
            <p>Gate E: Astro hek</p>
            <p>Gate F: Ingenieurskampus hek</p>
        </div>
    </div>
    <style>
        /* Add CSS styles for the heading and text area */
        h2 {
            margin-top: 0;
            margin-bottom: 10px;
        }

        #distanceTextArea {
            margin-top: 5px;
        }

        #textAreaContainer {
            margin-right: 20px;
        }

        #gateInfo p {
            margin: 0;
        }
    </style>

    <script>
        // Initialize the map
        var map = L.map('map').setView([-26.694387, 27.093413], 15);

        // Add a tile layer (using OpenStreetMap)
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors',
            maxZoom: 18,
        }).addTo(map);

        var pinnedMarker = null;
        var pinnedLocation = null;
        var routeLayers = [];
        var gateMarkers = [];

        // Function to handle form submission
        document.getElementById('searchForm').addEventListener('submit', function(e) {
            e.preventDefault(); // Prevent form submission

            var address = document.getElementById('address').value;

            // Use Leaflet Control.Geocoder to geocode the address
            var geocoder = L.Control.Geocoder.nominatim();
            geocoder.geocode(address, function(results) {
                if (results && results.length > 0) {
                    var location = results[0].center;

                    // Center the map on the searched location
                    map.setView(location, 13);

                    // Pin the location on the map
                    pinLocation(location, address);
                } else {
                    alert('Geocode was not successful for the following reason: No results found.');
                }
            });
        });

        // Get user's current location
        if ('geolocation' in navigator) {
            navigator.geolocation.getCurrentPosition(function(position) {
                var userLocation = [position.coords.latitude, position.coords.longitude];

                // Add a marker for the user's current location
                L.marker(userLocation).addTo(map)
                    .bindPopup('You are here')
                    .openPopup();

                // Optionally, center the map on the user's location
                map.setView(userLocation, 15);
            }, function(error) {
                console.log('Error occurred. Error code: ' + error.code);
            });
        } else {
            console.log('Geolocation is not supported by this browser.');
        }

        // Event listener for map click
        map.on('click', function(e) {
            // Pin the location on the map
            pinLocation(e.latlng, 'Property Location');
        });

        function pinLocation(location, address) {
            // Remove previous pinned marker if it exists
            if (pinnedMarker) {
                map.removeLayer(pinnedMarker);
            }

            // Add a new marker at the location
            pinnedMarker = L.marker(location).addTo(map);

            // Bind a popup to the marker
            pinnedMarker.bindPopup(address).openPopup();



            // Store the pinned location
            pinnedLocation = location;

            //$finalLocation = pinnedLocation;

            // Show the "Calculate distances" and "Save location" buttons
            document.getElementById('calculateDistanceButton').style.display = 'block';
            document.getElementById('saveLocationButton').style.display = 'block';

            // Get current zoom level
            var zoom = map.getZoom();

            // Update the map view to the pinned location
            map.setView(location, zoom);
        }

        function calculateDistances() {
            if (pinnedLocation) {
                var gateCoordinates = [
                    { name: 'Gate A', lat: -26.695400, lng: 27.088731 },
                    { name: 'Gate B', lat: -26.693543, lng: 27.091154 },
                    { name: 'Gate C', lat: -26.690207, lng: 27.086658 },
                    { name: 'Gate D', lat: -26.690416, lng: 27.093102 },
                    { name: 'Gate E', lat: -26.684412, lng: 27.095134 },
                    { name: 'Gate F', lat: -26.677807, lng: 27.096124 }
                ];

                // Clear existing route layers and gate markers
                routeLayers.forEach(function(layer) {
                    map.removeLayer(layer);
                });
                gateMarkers.forEach(function(marker) {
                    map.removeLayer(marker);
                });

                // Clear the distance text area
                document.getElementById('distanceTextArea').value = '';

                // Calculate distances and draw routes for each gate
                gateCoordinates.forEach(function(gate, index) {
                    var startLatLng = L.latLng(pinnedLocation.lat, pinnedLocation.lng);
                    var endLatLng = L.latLng(gate.lat, gate.lng);
                    var coordinates = [startLatLng, endLatLng];

                    // Make a request to OpenRouteService API for route information
                    axios.get('https://api.openrouteservice.org/v2/directions/driving-car', {
                        params: {
                            api_key: '5b3ce3597851110001cf6248a8e3652f1d3e4d2081c5f654b5c9b97c',
                            start: startLatLng.lng + ',' + startLatLng.lat,
                            end: endLatLng.lng + ',' + endLatLng.lat
                        }
                    }).then(function(response) {
                        var route = response.data.features[0];
                        var distance = route.properties.summary.distance / 1000; // Convert to kilometers

                        // Display the distance in the text area
                        document.getElementById('distanceTextArea').value += gate.name + ': ' + distance.toFixed(2) + ' km\n';

                        // Save the distance on the server
                        saveDistance(distance, index + 1);

                        // Draw the route on the map
                        var routeCoordinates = route.geometry.coordinates.map(function(coord) {
                            return [coord[1], coord[0]]; // Reverse the order of coordinates
                        });

                        var routeLayer = L.polyline(routeCoordinates).addTo(map);
                        routeLayers.push(routeLayer);
                    }).catch(function(error) {
                        console.log('Error occurred while fetching route information:', error);
                    });

                    // Add gate marker to the map
                    var gateMarker = L.marker([gate.lat, gate.lng]).addTo(map);
                    gateMarker.bindPopup(gate.name);
                    gateMarkers.push(gateMarker);
                });
            } else {
                alert('Please pin a location on the map first.');
            }
        }

        function saveDistance(distance, index) {
            // Create a new XMLHttpRequest object
            var xhr = new XMLHttpRequest();

            // Set up the request
            xhr.open('POST', 'save_distance.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

            // Set up the callback function
            xhr.onreadystatechange = function() {
                if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
                    // Request finished successfully
                    console.log('Distance saved: ' + distance + ' km');
                } else if (xhr.readyState === XMLHttpRequest.DONE && xhr.status !== 200) {
                    // Request finished with an error
                    console.log('Error saving distance: ' + xhr.status);
                }
            };

            // Prepare the data to send
            var data = 'distance=' + encodeURIComponent(distance.toFixed(2)) + '&index=' + encodeURIComponent(index);

            // Send the request
            xhr.send(data);
        }

        function saveLocation(pinnedLocation) {
            if (pinnedLocation) {
                // Print the value of pinnedLocation
                console.log(pinnedLocation);

                // Create a form dynamically
                var form = document.createElement('form');
                form.action = 'save_property_data.php';
                form.method = 'POST';

                // Create a hidden input field with the value of pinnedLocation
                var hiddenInput = document.createElement('input');
                hiddenInput.type = 'hidden';
                hiddenInput.name = 'pinnedLocation';
                hiddenInput.value = JSON.stringify(pinnedLocation);

                // Append the hidden input field to the form
                form.appendChild(hiddenInput);

                // Append the form to the document body
                document.body.appendChild(form);

                // Submit the form
                form.submit();
            } else {
                alert('Please pin a location on the map first.');
            }
        }
    </script>
</body>
</html>