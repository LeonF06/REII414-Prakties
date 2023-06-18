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

    // Check if the user already exists
    $existingUserQuery = $mysqli->prepare("SELECT Stud_Email FROM Students WHERE Stud_Email = ?");
    $existingUserQuery->bind_param("s", $email);
    $existingUserQuery->execute();
    $existingUserQuery->store_result();

    if ($existingUserQuery->num_rows > 0) {
        // User already exists, handle the error
        echo "User with the provided email already exists.";
    } else {
        // User doesn't exist, proceed with account creation

        // Prepare the INSERT statement
        $sql = $mysqli->prepare("INSERT INTO Students (Stud_ID, FName, LName, Stud_Email, Stud_Pass) VALUES (NULL, ?, ?, ?, ?)");
        $sql->bind_param("ssss", $firstName, $lastName, $email, $hashedPassword);

        // Execute the statement
        $sql->execute();
        $sql->close();

        echo "Account created successfully.";
    }

    $existingUserQuery->close();

} elseif ($role === 'landlord') {
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $cell = $_POST['cell'];

    // Check if the cellphone number is 10 digits long
    if (strlen($cell) !== 10) {
        // Cellphone number is not 10 digits long, handle the error
        echo "Cellphone number should be 10 digits long.";
        exit;
    }

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    // Check if the user already exists
    $existingUserQuery = $mysqli->prepare("SELECT Land_Email FROM Landlords WHERE Land_Email = ?");
    $existingUserQuery->bind_param("s", $email);
    $existingUserQuery->execute();
    $existingUserQuery->store_result();

    if ($existingUserQuery->num_rows > 0) {
        // User already exists, handle the error
        echo "User with the provided email already exists.";
        exit;
    } else {
        // User doesn't exist, proceed with account creation

        // Prepare the INSERT statement
        $sql = $mysqli->prepare("INSERT INTO Landlords (Land_ID, FName, LName, Cell_Number, Land_Email, Land_Pass) VALUES (NULL, ?, ?, ?, ?, ?)");
        $sql->bind_param("sssss", $firstName, $lastName, $cell, $email, $hashedPassword);

        // Execute the statement
        $sql->execute();
        $sql->close();

        echo "Account created successfully.";
    }

    $existingUserQuery->close();
}

$mysqli->close();
header('Location: index.php');
?>