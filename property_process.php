<?php
include "db_connect.php";
session_start();
//include "signin_process.php";
// Retrieve form data
$address = $_POST['address'];
$price = $_POST['price'];
$availability = $_POST['availability'];
$popularity = $_POST['popularity'];
$dateoflisting = $_POST['dateoflisting'];

// Get the landlord ID from the session
$landid = $_SESSION['land_id'];

// Prepare the INSERT statement
$sql = "INSERT INTO Properties (Prop_ID, Land_ID, Prop_Address, Price, Avail, Popul, DOL) VALUES (NULL, '$landid', '$address', '$price', '$availability', '$popularity', '$dateoflisting')";
// Execute the statement
$result = $mysqli->query($sql);

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
$mysqli->close();
?>