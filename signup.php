<?php
include 'connection.php';
$error = '';

if (isset($_POST['signup'])) {
    $name = mysqli_real_escape_string($connect, $_POST['name']);
    $email = mysqli_real_escape_string($connect, $_POST['email']);
    $phone = mysqli_real_escape_string($connect, $_POST['phone']);
    $address = mysqli_real_escape_string($connect, $_POST['address']);
    $password = $_POST['password'];
    $confirm_pass = $_POST['confirm-password']; // Added for password confirmation

    // Password validation
    $passwordhashing = password_hash($password, PASSWORD_DEFAULT);
    $lowercase = preg_match('@[a-z]@', $password);
    $uppercase = preg_match('@[A-Z]@', $password);
    $numbers = preg_match('@[0-9]@', $password);

    // Check if email already exists
    $select = "SELECT `email` FROM `user` WHERE `email` ='$email'";
    $run_select = mysqli_query($connect, $select);
    $rows = mysqli_num_rows($run_select);

    // Check if phone number already exists
    $selectPN = "SELECT `phone` FROM `user` WHERE `phone` ='$phone'";
    $run_selectPN = mysqli_query($connect, $selectPN);
    $rowsPN = mysqli_num_rows($run_selectPN);

    if ($rows > 0) {
        $error = "This email is already taken";
    } elseif (strlen($phone) != 11) {
        $error = "Please enter a valid 11-digit phone number";
    } elseif ($rowsPN > 0) {
        $error = "This phone number is already in use";
    } elseif (!$lowercase || !$uppercase || !$numbers) {
        $error = "Password must contain at least 1 uppercase letter, 1 lowercase letter, and 1 number";
    } elseif ($password !== $confirm_pass) {
        $error = "Password doesn't match confirmed password";
    } else {
        $insert = "INSERT INTO `user` VALUES(NULL, '$name', '$email', '$passwordhashing', '$phone' ,'$address')";
        $run_insert = mysqli_query($connect, $insert);
        if ($run_insert) {
            header("Location:login.php");
            exit();
        } else {
            $error = "There was an error with your registration. Please try again.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sign Up</title>
  <link rel="stylesheet" href="css/signup.css">
</head>
<body>

  <!-- Main Content -->
  <div class="main-content container">
    <div class="signup-form-container">
      <h2>Create Your Account</h2>
      <?php if ($error): ?>
        <p style="color:red;"><?php echo $error; ?></p>
      <?php endif; ?>
      <form method="POST">
        <div class="form-group">
          <label for="name">Full Name</label>
          <input type="text" id="name" name="name" required value="<?php echo isset($_POST['name']) ? $_POST['name'] : ''; ?>" >
          
        </div>
        <div class="form-group">
          <label for="email">Email Address</label>
          <input type="email" id="email" name="email" required value="<?php echo isset($_POST['email']) ? $_POST['email'] : ''; ?>" >
          
        </div>
        <div class="form-group">
          <label for="password">Password</label>
          <input type="password" id="password" name="password" required >
        </div>
        <div class="form-group">
          <label for="confirm-password">Confirm Password</label>
          <input type="password" id="confirm-password" name="confirm-password" required>
        </div>
        <div class="form-group">
          <label for="phone">Phone Number</label>
          <input type="text" id="phone" name="phone" required value="<?php echo isset($_POST['phone']) ? $_POST['phone'] : ''; ?>" >
          
        </div>
        <div class="form-group">
          <label for="address">Address</label>
          <input type="text" id="address" name="address" required value="<?php echo isset($_POST['address']) ? $_POST['address'] : ''; ?>" >
          
        </div>
        <button type="submit" class="signup-button" name="signup">Sign Up</button>
      </form>
      <p>Already have an account? <a href="login.php">Login here</a>.</p>
    </div>
  </div>

</body>
</html>
