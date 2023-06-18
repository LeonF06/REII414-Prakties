<!DOCTYPE html>
<html>
<head>
    <title>Campus Cribs</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.min.css">
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
        }

        .form-group {
            margin-bottom: 10px;
        }

        .email-group {
            display: flex;
            align-items: center;
        }

        .email-group label {
            margin-right: 35px;
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

        .label-link {
            margin-top: 20px;
        }

        .label-link a {
            color: #4CAF50;
            text-decoration: none;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Campus Cribs</h1>
        <h2>Sign in</h2>
        <form method="POST" action="signin_process.php">
            <div class="form-group email-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit" class="button">Sign in</button>
        </form>

        <div class="label-link">
            <label>Don't have a profile?</label>
            <a href="signup.php">Sign up</a>
        </div>
    </div>
</body>
</html>