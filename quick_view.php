<?php

// Include the 'components/connect.php' file
include 'components/connect.php';

// Start the PHP session
session_start();

// Check if user is logged in and set user_id
if (isset($_SESSION['user_id'])) {
   $user_id = $_SESSION['user_id'];
} else {
   $user_id = '';
};

// Include the 'components/add_cart.php' file
include 'components/add_cart.php';

?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>quick view</title>

   <!-- font awesome cdn link -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link -->
   <link rel="stylesheet" href="css/style.css">

</head>

<body>

   <!-- Include the user header component -->
   <?php include 'components/user_header.php'; ?>

   <section class="quick-view">

      <h1 class="title">quick view</h1>

      <?php
      // Get the product ID from URL parameter
      $pid = $_GET['pid'];
      // Prepare SQL statement to select product from database
      $select_products = $conn->prepare("SELECT * FROM `products` WHERE id = ?");
      $select_products->execute([$pid]);
      // If products exist, display them
      if ($select_products->rowCount() > 0) {
         while ($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)) {
      ?>

            <!-- Display product information and add to cart form -->
            <form action="cart.php" method="post" class="box">
               <input type="hidden" name="pid" value="<?= $fetch_products['id']; ?>">
               <input type="hidden" name="name" value="<?= $fetch_products['name']; ?>">
               <input type="hidden" name="price" value="<?= $fetch_products['price']; ?>">
               <input type="hidden" name="image" value="<?= $fetch_products['image']; ?>">
               <img src="uploaded_img/<?= $fetch_products['image']; ?>" alt="">
               <a href="category.php?category=<?= $fetch_products['category']; ?>" class="cat"><?= $fetch_products['category']; ?></a>
               <div class="name"><?= $fetch_products['name']; ?></div>
               <div class="flex">
                  <div class="price"><span>$</span><?= $fetch_products['price']; ?></div>
                  <input type="number" name="qty" class="qty" min="1" max="99" value="1" maxlength="2">
               </div>
               <button type="submit" name="add_to_cart" class="cart-btn">add to cart</button>
            </form>
      <?php
         }
      } else {
         // If no products, display a message
         echo '<p class="empty">no products added yet!</p>';
      }
      ?>

   </section>

   <!-- Include the footer component -->
   <?php include 'components/footer.php'; ?>

   <!-- Include Swiper JavaScript library -->
   <script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>

   <!-- custom JavaScript file link -->
   <script src="js/script.js"></script>

</body>

</html>