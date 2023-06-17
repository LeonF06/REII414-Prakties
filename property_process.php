<?php
include "db_connect.php";
session_start();

// Retrieve form data
$address = $_POST['address'];
$description = $_POST['description'];
$price = $_POST['price'];
$availability = $_POST['availability'];
// Correct the name of the date input field
$dateoflisting = date('Y-m-d', strtotime($_POST['availability']));
// Insert an integer value of 0 for popularity
$popularity = 0;

// Get the landlord ID from the session
$landid = $_SESSION['land_id'];
$point = $_SESSION['point'];

echo "The point variable values are: " . $_SESSION['point'];

// Prepare the INSERT statement
$sql = "INSERT INTO properties (Prop_ID, Land_ID, Prop_Address, Prop_Location, Prop_Description, Prop_Price, Prop_Avail, Prop_Popularity) VALUES (NULL, '$landid', '$address', ST_GeomFromText('$point'), '$description', '$price', '$availability', '$popularity')";

// Execute the statement
$result = $mysqli->query($sql);

if ($result) {
    // Get the last inserted property ID
    $propid = $mysqli->insert_id;

    // Prepare the INSERT statement for photos
    $sql = $mysqli->prepare("INSERT INTO Photos (Prop_ID, Phot_Data) VALUES (?, ?)");

    // Loop through each uploaded photo
    if (isset($_FILES['photo'])) {
        $photoCount = count($_FILES['photo']['name']);
        for ($i = 0; $i < $photoCount; $i++) {
            $photo = $_FILES['photo']['tmp_name'][$i];
            $photoFileName = $_FILES['photo']['name'][$i];
            $targetPath = 'uploads/' . $photoFileName;
            
            // Move the uploaded file to the target directory
            move_uploaded_file($photo, $targetPath);
            
            // Bind parameters and execute the statement
            $sql->bind_param("is", $propid, $targetPath);
            $sql->execute();
        }   
    }

    // Insert distances into the distances table
    $distances = array();
    for ($i = 1; $i <= 6; $i++) {
        if (isset($_SESSION['distance' . $i])) {
            $distances[$i] = $_SESSION['distance' . $i];
        }
    }

    // Prepare the INSERT statement for distances
    $sql = $mysqli->prepare("INSERT INTO distances (Prop_ID, Dist_A, Dist_B, Dist_C, Dist_D, Dist_E, Dist_F) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $sql->bind_param("idddddd", $propid, $distances[1], $distances[2], $distances[3], $distances[4], $distances[5], $distances[6]);
    $sql->execute();

} else {
    // Display the SQL error message
    echo "Error: " . $mysqli->error;
}

$mysqli->close();
header('Location: students_dashboard.php');
?>
