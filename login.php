<?php
// Include your database connection file
include("connection.php");

$error = ""; // Variable to hold error messages

if (isset($_POST['login'])) {
    // Get and sanitize input data
    $email = mysqli_real_escape_string($connect, $_POST['email']);
    $password = mysqli_real_escape_string($connect, $_POST['password']);

    // Check for empty fields
    if (empty($email)) {
        $error .= "Email can't be left empty. ";
    }
    if (empty($password)) {
        $error .= "Password can't be left empty.";
    }

    if (empty($error)) { // Only proceed if no errors
        // Query to select user by email
        $selectemail = "SELECT * FROM `user` WHERE `email` = '$email'";
        $runselect = mysqli_query($connect, $selectemail);

        if ($runselect) {
            if (mysqli_num_rows($runselect) > 0) {
                $data = mysqli_fetch_assoc($runselect);
                $hashedPass = $data['password'];
                if (password_verify($password, $hashedPass)) {
                    header("Location: home.php"); // Replace with your homepage
                    $_SESSION['user_id'] = $data['user_id'];
                    $_SESSION['email'] =$email;
                exit(); // Stop further script execution after redirect
                } else {
                    $error = "Incorrect Password.";
                }
            } else {
                $error = "Email isn't registered.";
            }
        } else {
            $error = "Database query error.";
        }
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <link rel="stylesheet" href="css/login.css">
</head>
<body>

  <!-- Navbar -->

  <!-- Main Content -->
  <div class="main-content container">
    <div class="login-form-container">
      <h2>Login to Your Account</h2>
      <form  method="POST">
        <div class="form-group">
          <label for="email">Email Address</label>
          <input type="email" id="email" name="email" required>
        </div>
        <div class="form-group">
          <label for="password">Password</label>
          <input type="password" id="password" name="password" required>
        </div>
        <button type="submit" class="login-button" name="login">Login</button>
      </form>
      <p>Don't have an account? <a href="signup.php">Sign up here</a>.</p>
    </div>
  </div>


</body>
</html>

