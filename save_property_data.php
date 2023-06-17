<?php
session_start();

$location = json_decode($_POST['pinnedLocation'], true);

// Check if decoding the JSON was successful
if ($location && isset($location['lat']) && isset($location['lng'])) {
    $latitude = $location['lat'];
    $longitude = $location['lng'];

    $point = "POINT($longitude $latitude)";
    $_SESSION['point'] = $point;
}

header('Location: landlord_dashboard.php');
?>