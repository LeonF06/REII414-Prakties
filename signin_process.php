<?php
include "db_connect.php";
// Retrieve the submitted form data
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Construct the SELECT query
    $sql = "SELECT Stud_ID, FName, LName, Stud_Email, Stud_Pass FROM Students WHERE Stud_Email = '$email'";

    // Execute the query
    $result = $mysqli->query($sql);

    // Check if the query was successful and a row was returned
    if ($result && $result->num_rows > 0) {
        // Fetch the row as an associative array
        $row = $result->fetch_assoc();

        // Verify the password
        if (password_verify($password, $row['Stud_Pass'])) {
            // Password is correct, authentication successful
            // You can store the student's ID or other relevant data in session variables for further use
            $_SESSION['student_id'] = $row['Stud_ID'];
            $_SESSION['student_name'] = $row['FName'] . ' ' . $row['LName'];

            // Redirect the student to a logged-in area or display a success message
            header('Location: database.php');
            exit;
        }
    }
    // Authentication failed, redirect back to the login page with an error message
    header('Location: index.php?error=1');
    exit;
}
$mysqli->close();
?>