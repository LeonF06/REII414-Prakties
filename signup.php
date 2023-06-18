<?php
session_start();

// Set the session timeout in seconds (30 minutes)
$sessionTimeout = 1800;

// Check if the session variable for the last activity timestamp exists
if (isset($_SESSION['lastActivity'])) {
    // Calculate the time difference between the current time and the last activity
    $inactiveTime = time() - $_SESSION['lastActivity'];

    // Check if the user has been inactive for longer than the session timeout
    if ($inactiveTime >= $sessionTimeout) {
        // Expire the session and redirect the user to the login page
        session_unset();
        session_destroy();
        header("Location: index.php");
        exit();
    }
}
// Update the last activity timestamp in the session
$_SESSION['lastActivity'] = time();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Sign Up</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            font-family: Arial, sans-serif;
        }

        .container {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            text-align: left;
        }

        h1 {
            margin: 0;
            font-size: 24px;
            text-align: center;
        }

        label {
            font-size: 16px;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 5px;
            margin-bottom: 10px;
            font-size: 16px;
        }

        input[type="submit"],
        button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            border: none;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
        }

        input[type="submit"]:hover,
        button:hover {
            background-color: #45a049;
        }
    </style>
    <script>
        function showFields() {
            var role = document.querySelector('input[name="role"]:checked').value;
            var fieldsContainer = document.getElementById("fieldsContainer");
            if (role === 'student') {
                fieldsContainer.innerHTML = `
                    <label for="firstName">First Name:</label>
                    <input type="text" name="firstName" id="firstName">
                    <br>
                    <label for="lastName">Last Name:</label>
                    <input type="text" name="lastName" id="lastName">
                    <br>
                    <label for="email">Email:</label>
                    <input type="email" name="email" id="email">
                    <br>
                    <label for="password">Password:</label>
                    <input type="password" name="password" id="password">
                `;
            } else if (role === 'landlord') {
                fieldsContainer.innerHTML = `
                    <label for="firstName">First Name:</label>
                    <input type="text" name="firstName" id="firstName">
                    <br>
                    <label for="lastName">Last Name:</label>
                    <input type="text" name="lastName" id="lastName">
                    <br>
                    <label for="email">Email:</label>
                    <input type="email" name="email" id="email">
                    <br>
                    <label for="cell">Cell:</label>
                    <input type="text" name="cell" id="cell">
                    <br>
                    <label for="password">Password:</label>
                    <input type="password" name="password" id="password">
                    <br>
                `;
            } else {
                fieldsContainer.innerHTML = '';
            }
        }

        function goBack() {
            window.history.back();
        }
    </script>
</head>
<body>
    <div class="container">
        <h1>Sign Up</h1>

        <form method="POST" action="signup_process.php" enctype="multipart/form-data">
            <label>Choose your role:</label>
            <br>
            <input type="radio" name="role" value="student" id="student" onclick="showFields()">
            <label for="student">Student</label>
            <br>
            <input type="radio" name="role" value="landlord" id="landlord" onclick="showFields()">
            <label for="landlord">Landlord</label>
            <br>
            <br>
            <div id="fieldsContainer"></div>
            <br>
            <input type="submit" value="Sign Up">
            <button type="button" onclick="goBack()">Back</button>
        </form>
    </div>
</body>
</html>