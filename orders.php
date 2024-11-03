<?php

// Include the database connection file
include 'components/connect.php';

// Start the PHP session
session_start();

// Check if user is logged in and set user_id
// If not logged in, redirect to home page
if (isset($_SESSION['user_id'])) {
   $user_id = $_SESSION['user_id'];
} else {
   $user_id = '';
   header('location:home.php');
};

?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>orders</title>

   <!-- Include Font Awesome CSS for icons -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- Include custom CSS file -->
   <link rel="stylesheet" href="css/style.css">

</head>

<body>

   <!-- Include the header section for user -->
   <?php include 'components/user_header.php'; ?>

   <!-- Display the page heading and breadcrumb -->
   <div class="heading">
      <h3>orders</h3>
      <p><a href="html.php">home</a> <span> / orders</span></p>
   </div>

   <!-- Orders section starts -->
   <section class="orders">

      <h1 class="title">your orders</h1>

      <div class="box-container">

         <?php
         // Check if user is logged in
         if ($user_id == '') {
            echo '<p class="empty">please login to see your orders</p>';
         } else {
            // Fetch orders for the logged-in user
            $select_orders = $conn->prepare("SELECT * FROM `orders` WHERE user_id = ?");
            $select_orders->execute([$user_id]);
            if ($select_orders->rowCount() > 0) {
               while ($fetch_orders = $select_orders->fetch(PDO::FETCH_ASSOC)) {
         ?>
                  <!-- Display order details -->
                  <div class="box">
                     <p>placed on : <span><?= $fetch_orders['placed_on']; ?></span></p>
                     <p>name : <span><?= $fetch_orders['name']; ?></span></p>
                     <p>email : <span><?= $fetch_orders['email']; ?></span></p>
                     <p>number : <span><?= $fetch_orders['number']; ?></span></p>
                     <p>address : <span><?= $fetch_orders['address']; ?></span></p>
                     <p>payment method : <span><?= $fetch_orders['method']; ?></span></p>
                     <p>your orders : <span><?= $fetch_orders['total_products']; ?></span></p>
                     <p>total price : <span>Rs.<?= $fetch_orders['total_price']; ?>/-</span></p>
                     <p> payment status : <span style="color:<?php if ($fetch_orders['payment_status'] == 'pending') {
                                                                  echo 'red';
                                                               } else {
                                                                  echo 'green';
                                                               }; ?>"><?= $fetch_orders['payment_status']; ?></span> </p>
                     <a href="thankyou.php" class="btn">Leave a Review</a>
                  </div>
         <?php
               }
            } else {
               echo '<p class="empty">no orders placed yet!</p>';
            }
         }
         ?>

      </div>

   </section>
   <!-- Orders section ends -->

   <!-- Include the footer section -->
   <?php include 'components/footer.php'; ?>

   <!-- Include custom JavaScript file -->
   <script src="js/script.js"></script>

</body>

</html>