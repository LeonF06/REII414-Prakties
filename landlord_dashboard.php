<!DOCTYPE html>
<html>
<head>
    <title>Add</title>
    <style>
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
        <label for="Address">Address:</label>
        <input type="text" name="address" id="address">
        <br>
        <label for="price">Price:</label>
        <input type="text" name="price" id="price">
        <br>
        <label for="availability">availability:</label>
        <input type="text" name="availability" id="availability">
        <br>
        <label for="popularity">popularity:</label>
        <input type="text" name="popularity" id="popularity">
        <br>
        <label for="dateoflisting">dateoflisting:</label>
        <input type="text" name="dateoflisting" id="dateoflisting">
        <br>
        <label for="photo">Photo:</label>
        <input type="file" name="photo[]" id="photo" accept="image/*" multiple onchange="previewPhotos(event)">
        <br>
        <div id="photoPreview"></div>
        <br>
        <input type="submit" value="Add">
        <button type="button" onclick="goBack()">Back</button>
    </form>
</body>
</html>