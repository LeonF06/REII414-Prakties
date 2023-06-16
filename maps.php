<!DOCTYPE html>
<html>
<head>
    <title>Map Search</title>
    <style>
        body {
            display: flex;
            justify-content: flex-start;
            align-items: flex-start;
            flex-direction: column;
            margin-top: 20px;
            margin-left: 20px;
        }

        h1 {
            margin-bottom: 10px;
        }

        #calculateDistanceButton,
        #saveLocationButton {
            display: none;
            margin-left: 10px;
        }

        #map {
            height: 790px;
            width: 85%;
            margin-top: 15px;
            margin-left: 220px;
        }

        #searchForm {
            display: flex;
            align-items: flex-start;
            margin-top: 10px;
        }

        #searchForm input[type="text"] {
            margin-right: 10px;
        }
    </style>
    <!-- Include Leaflet CSS and JavaScript -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
</head>
<body>
    <h1>Map Search</h1>
    <form id="searchForm">
        <input type="text" id="address" placeholder="Enter an address">
        <button type="submit">Search</button>
        <button id="calculateDistanceButton" onclick="calculateDistance()">Calculate distance</button>
        <button id="saveLocationButton" onclick="saveLocation()">Save location</button>
    </form>
    <div id="map"></div>

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

            // Show the "Calculate distance" and "Save location" buttons
            document.getElementById('calculateDistanceButton').style.display = 'block';
            document.getElementById('saveLocationButton').style.display = 'block';

            // Get current zoom level
            var zoom = map.getZoom();

            // Update the map view to the pinned location
            map.setView(location, zoom);
        }

        function calculateDistance() {
            if (pinnedLocation) {
                // Send the pinned location coordinates to the calculate_distance.php script
                var url = 'calculate_distance.php?lat=' + pinnedLocation.lat + '&lng=' + pinnedLocation.lng;
                window.location.href = url;
            } else {
                alert('Please pin a location on the map first.');
            }
        }

        function saveLocation() {
            if (pinnedLocation) {
                // Send the pinned location coordinates to the save_location.php script
                var url = 'save_location.php?lat=' + pinnedLocation.lat + '&lng=' + pinnedLocation.lng;
                window.location.href = url;
            } else {
                alert('Please pin a location on the map first.');
            }
        }
    </script>
</body>
</html>