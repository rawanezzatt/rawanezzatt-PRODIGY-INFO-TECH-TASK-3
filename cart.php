<?php
include("connection.php");
$user_id=$_SESSION['user_id'] ;



$select_name = "SELECT * FROM `cart` JOIN `product` ON `cart` .`product_id` = `product`.`product_id`WHERE `user_id` = '$user_id'";
$run_select_cart=mysqli_query($connect,$select_name);

$subtotal=0;
// $subtotal += $_POST['product_price']; 
while ($data = mysqli_fetch_assoc($run_select_cart)) {
  $subtotal += $data['product_price'];
}


if(isset($_POST['delete'])){
  $id_item=$_POST['id'];
  $cart=$_POST['cart_id'];

  $delete_item="DELETE FROM `cart` WHERE `product_id` = '$id_item' AND`user_id`='$user_id' AND`cart_id`='$cart'";
  $rundelete=mysqli_query($connect,$delete_item);
  
  header("location: cart.php");

}

if(isset($_POST['payment'])){
header("location: payment.php");

}

?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cart</title>
  <link rel="stylesheet" href="css/cart.css">
</head>
<body>

  <!-- Navbar -->
  <nav class="navbar">
  <div class="container">
    <a href="#" class="logo">E-SHOP</a>
    
    <!-- Hamburger Icon -->
    <div class="hamburger" onclick="toggleMenu()">
      <span></span>
      <span></span>
      <span></span>
    </div>
    
    <ul class="nav-links">
      <li><a href="home.php">Home</a></li>
      <li><a href="profile.php">Profile</a></li>
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


    <!-- Cart Section -->
    
    <section class="cart-section">
      <h2>Your Cart</h2>
      <table class="cart-table">
        <thead>
          <tr>
            <th>Product</th>
            <th>Price</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <?php foreach ($run_select_cart as $data) { ?>
              <form method="POST">
            <td><?php echo $data['product_name']; ?> </td>
            <td><?php echo $data['product_price']; ?></td>
             <input type="hidden"name="id" value="<?php echo $data['product_id']; ?>">
             <input type="hidden"name="cart_id" value="<?php echo $data['cart_id']; ?>">

            <td><button class="remove-button" type="submit" name ="delete">Remove</button></td>
          </tr>
        </tbody>
        <?php } ?>
      </table>

      <div class="cart-summary">
        <h3>Cart Summary</h3>
        <p><?php echo $subtotal; ?></p>
        <button  type="submit" name =" payment"class="checkout-button">Proceed to Checkout</button>
      </div>
    </section>
    </form>
  </div>

  <!-- Footer -->
  <footer class="footer">
    <div class="container">
      <p>&copy; 2024 E-SHOP. All Rights Reserved.</p>
    </div>
  </footer>


  <script>
  function toggleMenu() {
    const navLinks = document.querySelector('.nav-links');
    navLinks.classList.toggle('active');
  }
</script>


</body>
</html>
