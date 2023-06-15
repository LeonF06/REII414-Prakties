<!DOCTYPE html>
<html>
<head>
    <title>Sign Up</title>
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
                    <label for="photo">Photo:</label>
                    <input type="file" name="photo" id="photo" accept="image/*" onchange="previewPhoto(event)">
                    <br>
                    <img id="photoPreview" src="#" alt="Photo Preview" style="max-width: 200px; max-height: 200px;">
                `;
            } else {
                fieldsContainer.innerHTML = '';
            }
        }
        
        function previewPhoto(event) {
            var photoInput = event.target;
            var photoPreview = document.getElementById('photoPreview');
            
            if (photoInput.files && photoInput.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    photoPreview.src = e.target.result;
                };
                reader.readAsDataURL(photoInput.files[0]);
            } else {
                photoPreview.src = '#';
            }
        }
        
        function goBack() {
            window.history.back();
        }
    </script>
</head>
<body>
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
</body>
</html>