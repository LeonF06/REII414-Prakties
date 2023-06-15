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
    $sql = "INSERT INTO Students (Stud_ID, FName, LName, Stud_Email, Stud_Pass) VALUES (NULL, '$firstName', '$lastName', '$email', '$hashedPassword')";

    // Execute the statement
    $result = $mysqli->query($sql);

} elseif ($role === 'landlord') {
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $cell = $_POST['cell'];
    $photo = $_POST['photo'];

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    // Prepare the INSERT statement
    $sql = "INSERT INTO Landlords (Land_ID, FName, LName, Cell_Number, Land_Email, Land_Pass, Land_Phot) VALUES (NULL, '$firstName', '$lastName', '$cell', '$email', '$hashedPassword', '$photo')";

    // Execute the statement
    $result = $mysqli->query($sql);
}
$mysqli->close();
?>