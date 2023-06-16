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

// Prepare the INSERT statement
$sql = "INSERT INTO properties (Prop_ID, Land_ID, Prop_Address, Prop_Description, Prop_Price, Prop_Avail, Prop_Popularity) VALUES (NULL, '$landid', '$address', '$description', '$price', '$availability', '$popularity')";
// Execute the statement
$result = $mysqli->query($sql);

if ($result) {
    // Get the last inserted property ID
    $propid = $mysqli->insert_id;

    // Prepare the INSERT statement for photos
    $sql = $mysqli->prepare("INSERT INTO Photos (Prop_ID, Phot_Data) VALUES (?, ?)");

    // Loop through each uploaded photo
    if(isset($_FILES['photo'])){
        $photoCount = count($_FILES['photo']['name']);
        for($i=0; $i<$photoCount; $i++){
            $photo = $_FILES['photo']['tmp_name'][$i];
            $photoData = file_get_contents($photo);
            
            // Bind parameters and execute the statement
            $sql->bind_param("ss", $propid, $photoData);
            $sql->execute();
        }
    }
} else {
    // Display the SQL error message
    echo "Error: " . $mysqli->error;
}

$mysqli->close();
?>
