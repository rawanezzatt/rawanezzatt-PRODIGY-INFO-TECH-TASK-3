<?php
include("connection.php");
$user_id = $_SESSION['user_id'];

// Fetch cart items
$select_name = "SELECT * FROM `cart` JOIN `product` ON `cart`.`product_id` = `product`.`product_id` WHERE `user_id` = '$user_id'";
$run_select_cart = mysqli_query($connect, $select_name);

// Handle delete action
if (isset($_POST['delete'])) {
    $id_item = $_POST['id'];
    $cart_id = $_POST['cart_id'];

    $delete_item = "DELETE FROM `cart` WHERE `product_id` = '$id_item' AND `user_id` = '$user_id' AND `cart_id` = '$cart_id'";
    $rundelete = mysqli_query($connect, $delete_item);
    header("Location: cart.php");
    exit;
}

// Handle payment action
if (isset($_POST['payment'])) {
    header("Location: payment.php");
    exit;
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
    <ul class="nav-links">
      <li><a href="home.php">Home</a></li>
      <li><a href="profile.php">Profile</a></li>
    </ul>
  </div>
</nav>

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
      <?php foreach ($run_select_cart as $data): ?>
      <tr>
        <td><?php echo $data['product_name']; ?></td>
        <td>$<?php echo number_format($data['product_price'], 2); ?></td>
        <td>
          <form method="POST">
            <input type="hidden" name="id" value="<?php echo $data['product_id']; ?>">
            <input type="hidden" name="cart_id" value="<?php echo $data['cart_id']; ?>">
            <button class="remove-button" type="submit" name="delete">Remove</button>
          </form>
        </td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>

  <!-- Cart Summary -->
  <div class="cart-summary">
    <h3>Cart Summary</h3>
    <p>Subtotal: $109.97</p>
    <form method="POST">
      <button type="submit" name="payment" class="checkout-button">Proceed to Checkout</button>
    </form>
  </div>
</section>

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
