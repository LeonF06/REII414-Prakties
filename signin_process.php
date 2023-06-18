<?php
include "db_connect.php";
session_start();

// Retrieve the submitted form data
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Construct the SELECT query for students
    $studentSql = "SELECT Stud_ID, FName, LName, Stud_Email, Stud_Pass FROM Students WHERE Stud_Email = ?";
    $studentStmt = $mysqli->prepare($studentSql);
    $studentStmt->bind_param("s", $email);
    
    // Execute the query for students
    $studentStmt->execute();
    $studentResult = $studentStmt->get_result();

    // Check if the query was successful and a row was returned for students
    if ($studentResult && $studentResult->num_rows > 0) {
        // Fetch the row as an associative array
        $row = $studentResult->fetch_assoc();

        // Verify the password for students
        if (password_verify($password, $row['Stud_Pass'])) {
            // Password is correct, authentication successful for students
            // You can store the student's ID or other relevant data in session variables for further use
            $_SESSION['student_id'] = $row['Stud_ID'];
            $_SESSION['student_name'] = $row['FName'] . ' ' . $row['LName'];

            // Redirect the student to a logged-in area or display a success message for students
            header('Location: students_dashboard.php');
            exit;
        }
    } else {
        // Construct the SELECT query for landlords
        $landlordSql = "SELECT Land_ID, FName, LName, Land_Email, Land_Pass, Cell_Number FROM Landlords WHERE Land_Email = ?";
        $landlordStmt = $mysqli->prepare($landlordSql);
        $landlordStmt->bind_param("s", $email);

        // Execute the query for landlords
        $landlordStmt->execute();
        $landlordResult = $landlordStmt->get_result();

        // Check if the query was successful and a row was returned for landlords
        if ($landlordResult && $landlordResult->num_rows > 0) {
            // Fetch the row as an associative array
            $row = $landlordResult->fetch_assoc();

            // Verify the password for landlords
            if (password_verify($password, $row['Land_Pass'])) {
                // Password is correct, authentication successful for landlords
                // You can store the landlord's ID or other relevant data in session variables for further use
                $_SESSION['land_id'] = $row['Land_ID'];
                $_SESSION['landlord_name'] = $row['FName'] . ' ' . $row['LName'];
                // Redirect the landlord to a specific page for landlords
                header('Location: landlord_dashboard.php');
                exit;
            }
        }
    }
    // Authentication failed, redirect back to the login page with an error message
    header('Location: index.php?error=1');
    exit;
}
$mysqli->close();
?>