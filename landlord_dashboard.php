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
    <title>Add</title>
    <style>
        body {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin: 0;
            font-family: Arial, sans-serif;
        }

        .menu-bar {
            background-color: #4CAF50;
            width: 100%;
            display: flex;
            justify-content: center;
        }

        .menu {
            list-style-type: none;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: space-around;
            width: 100%;
        }

        .menu li {
            flex: 1;
            text-align: center;
        }

        .menu a {
            display: block;
            padding: 10px 0;
            text-decoration: none;
            color: white;
        }

        .menu a:hover {
        background-color: #ddd;
        }

        .container {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            text-align: left;
            margin-top: 20px;
        }

        h1 {
            margin: 0;
        }

        .form-group {
            margin-bottom: 10px;
        }

        .form-group.right-align {
            display: flex;
            align-items: center;
            justify-content: flex-end;
        }

        .form-group.left-align {
            display: flex;
            align-items: center;
            justify-content: flex-start;
        }

        .form-group.right-align label {
            margin-right: 10px;
        }

        .form-group.right-align input,
        .form-group.left-align input {
            margin-left: 10px;
        }

        .photoPreview {
            display: inline-block;
            width: 200px;
            height: 200px;
            background-size: cover;
            background-position: center;
            margin-right: 20px;
        }

        .button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            border: none;
            cursor: pointer;
            font-size: 16px;
        }

        .form-group.left-align {
            display: flex;
            align-items: center;
            justify-content: flex-start;
        }

        .form-group.left-align label {
            margin-right: 10px;
        }

        .form-group.left-align input {
            margin-left: 10px;
        }

        .form-group.left-align .price-label {
            margin-right: 33px;
        }
    </style>
    <script>
        function previewPhotos(event) {
            var photoInput = event.target;
            var photoPreview = document.getElementById('photoPreview');
            photoPreview.innerHTML = ""; // Clear existing previews

            if (photoInput.files && photoInput.files.length > 0) {
                for (var i = 0; i < photoInput.files.length; i++) {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        var div = document.createElement('div');
                        div.classList.add('photoPreview');
                        div.style.backgroundImage = 'url(' + e.target.result + ')';
                        photoPreview.appendChild(div);
                    };
                    reader.readAsDataURL(photoInput.files[i]);
                }
            } else {
                photoPreview.innerHTML = "No photos selected.";
            }
        }

        function goBack() {
            window.history.back();
        }
    </script>
</head>
<body>
<div class="menu-bar">
    <ul class="menu">
        <li><a href="index.php">Home</a></li>
        <?php if (isset($_SESSION['student_id']) || isset($_SESSION['land_id'])): ?>
            <li><a href="students_dashboard.php">Properties</a></li>
        <?php endif; ?>
        <?php if (isset($_SESSION['land_id'])): ?>
            <li><a href="landlord_dashboard.php">Add a Property</a></li>
        <?php endif; ?>
    </ul>
</div>
<div class="container">
    <h1>Add a Property</h1>
    <form method="POST" action="property_process.php" enctype="multipart/form-data">
            <div class="form-group right-align">
                <label for="address">Address:</label>
                <input type="text" name="address" id="address" placeholder="Enter address">
                <button type="button" class="button" onclick="window.location.href='maps.php'">Pin</button>
            </div>
            <div class="form-group left-align">
                <label class="price-label" for="price">Price:</label>
                <input type="number" name="price" id="price" step="0.01" placeholder="Enter price">
            </div>
            <div class="form-group left-align">
                <label for="availability">Availability:</label>
                <input type="date" name="availability" id="availability">
            </div>
            <div class="form-group">
                <label for="description">Description:</label>
                <textarea name="description" id="description"></textarea>
            </div>
            <div class="form-group">
                <label for="photo">Photo:</label>
                <input type="file" name="photo[]" id="photo" accept="image/*" multiple onchange="previewPhotos(event)">
            </div>
            <div id="photoPreview"></div>
            <div class="form-group">
                <input type="submit" value="Add" class="button">
                <button type="button" class="button" onclick="goBack()">Back</button>
            </div>
        </form>
    </div>
</body>
</html>