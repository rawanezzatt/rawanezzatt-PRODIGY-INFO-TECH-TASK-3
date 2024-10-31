<?php
include("connection.php");
$user_id=$_SESSION['user_id'] ;

$select_name = "SELECT * FROM `user`WHERE `user_id` = '$user_id'";
$runpay=mysqli_query($connect,$select_name);
$fetch=mysqli_fetch_assoc($runpay);
$user_name=$fetch['name'];
$address=$fetch['address'];


if(isset($_POST['pay'])){
  $card_number =$_POST['card'];
  $cvv =$_POST['cvv'];
  $city=$_POST['city'];
  $country =$_POST['country'];

  $insert = "INSERT INTO `payment` VALUES (NULL, '1','$user_id' ,'$cvv',  '$city',  '$country')";
  $run_insert = mysqli_query($connect, $insert);

  header("location: home.php");

}







?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Payment Form</title>
  <link rel="stylesheet" href="css/payment.css">
</head>
<body>
  <!-- Navbar -->
  <nav class="navbar">
    <div class="container">
      <a href="#" class="logo">E-SHOP</a>
      <ul class="nav-links">
        <li><a href="home.php">Home</a></li>
        <li><a href="profile.php">Profile</a></li>
        <li><a href="cart.php">Cart</a></li>
      </ul>
    </div>
  </nav>

  <!-- Search Bar -->
  <div class="search-bar-container">
    <div class="container">
      <form class="search-form">
      </form>
    </div>
  </div>

  <!-- Payment Form Section -->
  <div class="main-content container">
    <section class="payment-section">
      <h2>Payment Information</h2>
      <form class="payment-form" method="POST">
        <!-- Cardholder Name -->
        <div class="form-group">
          <label for="cardholder-name">Cardholder Name</label>
          <input type="text" id="cardholder-name" placeholder="Enter Cardholder Name" name="name"value=" <?php echo $user_name ?>">
        </div>

        <!-- Card Number -->
        <div class="form-group">
          <label for="card-number">Card Number</label>
          <input type="text" id="card-number" placeholder="1234 5678 9012 3456" name="card">
        </div>

        <!-- Expiration Date and CVV -->
        <div class="form-row">
          <div class="form-group">
            <label for="cvv">CVV</label>
            <input type="text" id="cvv" placeholder="123" name="cvv">
          </div>
        </div>

        <!-- Billing Address -->
        <div class="form-group">
          <label for="billing-address"> Address</label>
          <input type="text" id="billing-address" placeholder="1234 Main St">
        </div>

        <!-- City, State, Zip -->
        <div class="form-row">
          <div class="form-group">
            <label for="city">City</label>
            <input type="text" id="city" placeholder="City"name="city">
          </div>
          <div class="form-group">
            <label for="state">State</label>
            <input type="text" id="state" placeholder="State" name="country">
          </div>
        </div>

        <!-- Submit Button -->
        <button type="submit" class="payment-button" name='pay'>Submit Payment</button>
      </form>
    </section>
  </div>

  <!-- Footer -->
  <footer class="footer">
    <div class="container">
      <p>&copy; 2024 E-SHOP. All Rights Reserved.</p>
    </div>
  </footer>

</body>
</html>
