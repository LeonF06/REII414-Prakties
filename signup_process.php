<?php
include "db_connect.php";

$role = $_POST['role'];

if ($role === 'student') {
    // Retrieve form data
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    // Prepare the INSERT statement
    $sql = $mysqli->prepare("INSERT INTO Students (Stud_ID, FName, LName, Stud_Email, Stud_Pass) VALUES (NULL, ?, ?, ?, ?)");
    $sql->bind_param("ssss", $firstName, $lastName, $email, $hashedPassword);

    // Execute the statement
    $sql->execute();

} elseif ($role === 'landlord') {
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $cell = $_POST['cell'];
    
    // Handle photo upload
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
        $photo = $_FILES['photo']['tmp_name'];
        $photoData = file_get_contents($photo);
    } else {
        $photoData = null; // Set default photo data if no photo uploaded
    }

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    // Prepare the INSERT statement
    $sql = $mysqli->prepare("INSERT INTO Landlords (Land_ID, FName, LName, Cell_Number, Land_Email, Land_Pass, Land_Phot) VALUES (NULL, ?, ?, ?, ?, ?, ?)");
    $sql->bind_param("ssssss", $firstName, $lastName, $cell, $email, $hashedPassword, $photoData);

    // Execute the statement
    $sql->execute();
}
$sql->close();
$mysqli->close();
?>