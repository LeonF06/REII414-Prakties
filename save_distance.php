<?php
session_start();

if (isset($_POST['distance']) && isset($_POST['index'])) {
    $distance = $_POST['distance'];
    $index = $_POST['index'];

    $_SESSION['distance' . $index] = $distance;

    // Send a success response
    echo 'Distance saved successfully.';
} else {
    // Send an error response
    echo 'Invalid request.';
}
?>