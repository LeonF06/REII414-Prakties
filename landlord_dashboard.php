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
        .form-group {
            margin-bottom: 10px;
        }
        .photoPreview {
            display: inline-block;
            width: 200px;
            height: 200px;
            background-size: cover;
            background-position: center;
            margin-right: 10px;
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
    <h1>Add a Property</h1>
    <form method="POST" action="property_process.php" enctype="multipart/form-data">
        <div class="form-group">
            <label for="address">Address:</label>
            <input type="text" name="address" id="address">
            <button type="button" onclick="window.location.href='maps.php'">Pin</button>
        </div>
        <div class="form-group">
            <label for="description">Description:</label>
            <textarea name="description" id="description"></textarea>
        </div>
        <div class="form-group">
            <label for="price">Price:</label>
            <input type="number" name="price" id="price" step="0.01">
        </div>
        <div class="form-group">
            <label for="availability">Availability:</label>
            <input type="date" name="availability" id="availability">
        </div>
        <div class="form-group">
            <label for="photo">Photo:</label>
            <input type="file" name="photo[]" id="photo" accept="image/*" multiple onchange="previewPhotos(event)">
        </div>
        <div id="photoPreview"></div>
        <div class="form-group">
            <input type="submit" value="Add">
            <button type="button" onclick="goBack()">Back</button>
        </div>
    </form>
</body>
</html>