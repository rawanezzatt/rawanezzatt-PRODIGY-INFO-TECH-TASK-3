<?php
include("connection.php");
$user_id=$_SESSION['user_id'] ;


$select = "SELECT * FROM `product`";
$runselect = mysqli_query($connect, $select);
$fetch=mysqli_fetch_assoc($runselect);
$product_id=$fetch['product_id'];


if (isset($_POST['search'])) {
  $text = $_POST['text'];
  $selectsearch = "SELECT * FROM `product` WHERE (`product_name` LIKE '%$text%') OR (`product_price` LIKE '%$text%') OR (`product_description` LIKE '%$text%') ";
  $runsearch = mysqli_query($connect, $selectsearch);
}
if (isset($_POST['el'])) {
  $select1 = "SELECT * FROM `product` WHERE `cat_id`=1";
  $runselect1= mysqli_query($connect, $select1);
}

if (isset($_POST['cl'])) {
  $select2 = "SELECT * FROM `product` WHERE`cat_id`=2";
  $runselect2 = mysqli_query($connect, $select2);
  }
if (isset($_POST['ho'])) {
  $select3 = "SELECT * FROM `product` WHERE`cat_id`=3";
  $runselect3 = mysqli_query($connect, $select3);
    }      
if (isset($_POST['bo'])) {
  $select4 = "SELECT * FROM `product` WHERE`cat_id`=4";
  $runselect4 = mysqli_query($connect, $select4);
    }



if (isset($_POST['add'])) {
  $product_id = mysqli_real_escape_string($connect, $_POST['product_id']); // Ensure product_id is retrieved correctly
  $select5 = "SELECT * FROM `cart` WHERE `product_id` = '$product_id' AND `user_id` = '$user_id'";
  $runselect5 = mysqli_query($connect, $select5);

  if (mysqli_num_rows($runselect5) > 0) {
      $fetch = mysqli_fetch_assoc($runselect5);
      $quantity = $fetch['quantity'];
      $newquantity = $quantity + 1;

      $update = "UPDATE `cart` SET `quantity` = '$newquantity' WHERE `product_id` = '$product_id' AND `user_id` = '$user_id'";
      if (mysqli_query($connect, $update)) {
          echo "Product quantity updated!";
      } else {
          echo "Error updating product quantity: " . mysqli_error($connect);
      }
  } else {
      $insert = "INSERT INTO `cart` (cart_id, product_id, user_id, quantity) VALUES (NULL, '$product_id', '$user_id', 1)";
      if (mysqli_query($connect, $insert)) {
          echo "Product added to cart!";
      } else {
          echo "Error adding product to cart: " . mysqli_error($connect);
      }
  }
}



?>



<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>E-commerce Home - Rearranged Layout</title>
  <link rel="stylesheet" href="css/home.css">
</head>
<body>
  <!-- Top Header -->
  <header class="top-header">
    <h1 class="logo">E-SHOP</h1>
    <div class="account-links">
      <a href="profile.php">profile</a>
      <a href="cart.php">Cart</a>
    </div>
  </header>
  
  <!-- Full-width Search Bar -->
  <form method="POST">
    <div class="search-bar">
      <input type="search" name="text" placeholder="Search for products, brands, and more...">
      <button type="submit" name="search">Search</button>
    </div>
  </form>

  <!-- Main Content Area with Sidebar -->
  <div class="main-content">
    <!-- Side Category Menu -->
    <aside class="side-menu">
      <form method="POST">
      <button type="submit" name="all">All</button> 
        <button type="submit" name="el">Electronics</button> 
        <button type="submit" name="cl">Clothing</button>
        <button type="submit" name="ho">Home & Kitchen</button>
        <button type="submit" name="bo">Books</button>
      </form>
    </aside>
    
    <!-- Main Area -->
    <div class="main-area">
      <!-- Carousel / Banner -->
      <section class="carousel">
        <!-- <img src="banner.jpg" alt="Main Banner"> -->
      </section>

      <!-- Product Grid -->
      <div class="product-grid">
       <!-- <h2 class="sh">Popular Products</h2> -->

        <?php
        // Show search results if search is performed
        if (isset($_POST['search'])) {
          foreach ($runsearch as $data) { ?>
            <div class="product-list">
              <div class="product-item">
                <img src="./img/<?php echo $data['product_img']; ?>" width="150px" alt="Product Image">
                <h3><?php echo $data['product_name']; ?></h3>
                <p><?php echo $data['product_description']; ?></p>
                <h5>EGP <?php echo $data['product_price']; ?></h5>
                <form method="POST">
                <input type="hidden" name="product_id" value="<?php echo $data['product_id']; ?>">

                <button  type="submit"  name="add">Add to Cart</button>
                </form>
              </div>
            </div>
          <?php }
        } else if (isset($_POST['el'])) {
          // Show electronics category products
          foreach ($runselect1 as $data) { ?>
            <div class="product-list">
              <div class="product-item">
                <img src="./img/<?php echo $data['product_img']; ?>" width="150px" alt="Product Image">
                <h3><?php echo $data['product_name']; ?></h3>
                <p><?php echo $data['product_description']; ?></p>
                <h5>EGP <?php echo $data['product_price']; ?></h5>
                <form method="POST">
                <input type="hidden" name="product_id" value="<?php echo $data['product_id']; ?>">

                <button  type="submit"  name="add">Add to Cart</button>
                </form>
              </div>
            </div>
          <?php }
        } else if (isset($_POST['all'])) {
          // Show electronics category products
          foreach ($runselect as $data) { ?>
            <div class="product-list">
              <div class="product-item">
                <img src="./img/<?php echo $data['product_img']; ?>" width="150px" alt="Product Image">
                <h3><?php echo $data['product_name']; ?></h3>
                <p><?php echo $data['product_description']; ?></p>
                <h5>EGP <?php echo $data['product_price']; ?></h5>
                <form method="POST">
                <input type="hidden" name="product_id" value="<?php echo $data['product_id']; ?>">

                <button  type="submit"  name="add">Add to Cart</button>
                </form>
              </div>
            </div>
          <?php }
        }  else if (isset($_POST['cl'])) {
          // Show clothing category products
          foreach ($runselect2 as $data) { ?>
            <div class="product-list">
              <div class="product-item">
                <img src="./img/<?php echo $data['product_img']; ?>" width="150px" alt="Product Image">
                <h3><?php echo $data['product_name']; ?></h3>
                <p><?php echo $data['product_description']; ?></p>
                <h5>EGP <?php echo $data['product_price']; ?></h5>
                <form method="POST">
                <input type="hidden" name="product_id" value="<?php echo $data['product_id']; ?>">

                <button  type="submit" name="add">Add to Cart</button>
                </form>
              </div>
            </div>
          <?php }
        } else if (isset($_POST['ho'])) {
          // Show home & kitchen category products
          foreach ($runselect3 as $data) { ?>
            <div class="product-list">
              <div class="product-item">
                <img src="./img/<?php echo $data['product_img']; ?>" width="150px" alt="Product Image">
                <h3><?php echo $data['product_name']; ?></h3>
                <p><?php echo $data['product_description']; ?></p>
                <h5>EGP <?php echo $data['product_price']; ?></h5>
                <form method="POST">
                <input type="hidden" name="product_id" value="<?php echo $data['product_id']; ?>">

                <button  type="submit"  name="add">Add to Cart</button>
                </form>
              </div>
            </div>
          <?php }
        } else if (isset($_POST['bo'])) {
          // Show books category products
          foreach ($runselect4 as $data) { ?>
            <div class="product-list">
              <div class="product-item">
                <img src="./img/<?php echo $data['product_img']; ?>" width="150px" alt="Product Image">
                <h3><?php echo $data['product_name']; ?></h3>
                <p><?php echo $data['product_description']; ?></p>
                <h5>EGP <?php echo $data['product_price']; ?></h5>
                <form method="POST">
                <input type="hidden" name="product_id" value="<?php echo $data['product_id']; ?>">

                <button type="submit"  name="add">Add to Cart</button>
                </form>
              </div>
            </div>
          <?php }
        } else {
          // Show all products if no search or category filter is applied
          foreach ($runselect as $data) { ?>
            <div class="product-list">
              <div class="product-item">
                <img src="./img/<?php echo $data['product_img']; ?>" width="150px" alt="Product Image">
                <h3><?php echo $data['product_name']; ?></h3>
                <p><?php echo $data['product_description']; ?></p>
                <h5>EGP <?php echo $data['product_price']; ?></h5>
                <form method="POST">
                <input type="hidden" name="product_id" value="<?php echo $data['product_id']; ?>">

                <button type="submit"  name="add">Add to Cart</button>
                </form>
              </div>
            </div>
          <?php }
        } ?>
      </div>
    </div>
  </div>
</body>
</html>
