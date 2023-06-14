<!DOCTYPE html>
<html>
  <head>
    <title>Campus Cribs</title>
    <style>
      /* styles for the page */
        body {
            font-family: sans-serif;
            text-align: center;
        }
        form {
            display: inline-block;
            text-align: left;
        }
        /* stack the labels and inputs on top of each other */
        label, input {
            display: block;
        }
        /* give all of the labels some width */
        label {
            width: 125px;
        }
        /* give the submit button some extra space at the bottom */
        input[type="submit"] {
            margin-bottom: 10px;
        }
        /* style the page */
        h1 {
            color: #0099cc;
        }
        form {
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 10px;
            width: 300px;
            margin: 0 auto;
        }
        input[type="text"], input[type="password"] {
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 5px;
            width: 200px;
        }
        input[type="submit"] {
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 5px 10px;
            width: 100px;
            background-color: #0099cc;
            color: #fff;
        }
        input[type="submit"]:hover {
            background-color: #0088cc;
        }
        p {
            color: #0099cc;
        }
        a {
            color: #0099cc;
        }
        a:hover {
            color: #0088cc;
        }
        body {
          background-color: #000;
          overflow: hidden;
        }

        .circle {
          position: bottom;
          width: 50px;
          height: 50px;
          background-color: #fff;
          border-radius: 50%;
          animation: circleMove 10s infinite;
          opacity: 0.7;
        }

        .square {
          position: absolute;
          width: 50px;
          height: 50px;
          background-color: #fff;
          animation: squareMove 10s infinite;
          opacity: 0.7;
        }

        @keyframes circleMove {
          0% { 
            transform: translateX(-50%) translateY(-50%) scale(1);
          }
          50% {
            transform: translateX(50vw) translateY(50vh) scale(0.5);
          }
          100% {
            transform: translateX(-50%) translateY(-50%) scale(1);
          }
        }

        @keyframes squareMove {
          0% { 
            transform: translateX(-50%) translateY(-50%) scale(1);
          }
          50% {
            transform: translateX(50vw) translateY(30vh) scale(0.5);
          }
          100% {
            transform: translateX(-50%) translateY(-50%) scale(1);
          }
        }

    </style>
  </head>
  <body>
    <div class="circle"></div>
    <div class="square"></div>
    <?php if (!isset($_GET['signup'])) { ?>
      <!-- Main page content -->
      <h1>Campus Cribs</h1>
      <p>Welcome to Campus Cribs, your one-stop shop for student housing in Potchefstroom.</p>
      <p>Please log in to access your account:</p>
      <form method="post" action="login.php">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username">
        <label for="password">Password:</label>
        <input type="password" id="password" name="password">
        <input type="submit" value="Log In">
        <p>Don't have an account? <a href="?signup">Sign up here</a>.</p>
      </form>
    <?php } else { ?>
      <!-- Sign up page content -->
      <h1>Campus Cribs - Sign Up</h1>
      <form method="post" action="register.php">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username">
        <label for="password">Password:</label>
        <input type="password" id="password" name="password">
        <label for="confirm_password">Confirm Password:</label>
        <input type="password" id="confirm_password" name="confirm_password">
        <input type="submit" value="Sign Up">
      </form>
      <p>Already have an account? <a href="http://localhost/prakties/">Log in here</a>.</p>
    <?php } ?>
  </body>
</html>