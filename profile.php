<?php
include("connection.php");
$user_id=$_SESSION['user_id'] ;

$select = "SELECT * FROM `user` WHERE `user_id` = '$user_id'";
$runselect=mysqli_query($connect,$select);

$fetch=mysqli_fetch_assoc($runselect);
$name=$fetch['name'];
$email=$fetch['email'];
$address=$fetch['address'];


$select_order = "SELECT * FROM `cart` JOIN `product` ON `cart` .`product_id` = `product`.`product_id`WHERE `user_id` = '$user_id'";

$runorder=mysqli_query($connect,$select_order);


?>




<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>User Profile</title>
  <link rel="stylesheet" href="css/profile.css">
</head>
<body>
  <!-- Navbar -->
  <nav class="navbar">
    <div class="container">
      <a href="#" class="logo">E-SHOP</a>
      <ul class="nav-links">
        <li><a href="home.php">Home</a></li>
        <li><a href="cart.php">Cart</a></li>
      </ul>
    </div>
  </nav>

  <!-- Search Bar -->
  <div class="search-bar-container">
    <div class="container">
      <form class="search-form">
        <!-- <input type="text" placeholder="Search for products, brands, and more..." class="search-input">
        <button type="submit" class="search-button">Search</button> -->
      </form>
    </div>
  </div>

  <!-- Main Content -->
  <div class="main-content container">
    <!-- Sidebar -->
    <!-- <aside class="sidebar">
      <ul>
      <form method="POST">
        <button type="submit" name="el">Electronics</button> 
        <button type="submit" name="cl">Clothing</button>
        <button type="submit" name="ho">Home & Kitchen</button>
        <button type="submit" name="bo">Books</button>
      </form>
      </ul>
    </aside> -->

    <!-- Profile & Order History Section -->
    <section class="profile-section">
      <!-- User Info -->
      <div class="profile-header">
        <h2>User Profile</h2>

        <p><strong>Name:</strong><?php echo $name ; ?></p>
        </p>
        <p><strong>Email:</strong> <?php echo $email ; ?></p>
        <p><strong>Address:</strong> <?php echo $address ; ?></p>
      </div>

      <!-- Order History -->
      <div class="order-history">
        <h3>Order History</h3>
        <div class="order-item">
          <div class="order-details">
            <?php foreach ($runorder as $data) { ?>
              <form method="POST">
                
                <img src="./img/<?php echo $data['product_img']; ?>" alt="Product 1" class="order-img">
            <p><strong>Order #1023</strong> - Delivered</p>
            <p><?php echo $data['product_name']; ?>- <?php echo $data['product_price']; ?> EGP</p>
            <?php } ?>
          </div>
        </div>
        <div class="logout-button">
      <form method="POST">
      <button type="submit"  name="logout" class="btn">logout</button>
      </form>
      </div>
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
