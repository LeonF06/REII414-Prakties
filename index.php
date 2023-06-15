<!DOCTYPE html>
<html>
<head>
    <title>Page Switching Example</title>
</head>
<body>
    <?php
    // Check if a page has been selected
    if (isset($_GET['page'])) {
        $page = $_GET['page'];
        
        // Display the selected page
        switch ($page) {
            case 'signup':
                include 'signup.php';
                break;
            case 'database':
                include 'database.php';
                break;
            default:
                include 'index.php';
                break;
        }
    } else {
        // Display the main page content by default
        ?>
        <h1>Main Page (Login)</h1>
        <h2>Sign in</h2>
        <form method="POST" action="signin_process.php">
            <div>
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div>
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit">Sign in</button>
        </form>

        <!-- Buttons to switch pages -->
        <button onclick="location.href='index.php?page=signup'">Go to Sign Up Page</button>
        <button onclick="location.href='index.php?page=database'">Go to Database Page</button>
        <?php
    }
    ?>
</body>
</html>
