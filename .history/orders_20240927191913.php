<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
   header('location:thank_you.php');
}else{
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
   <title>Thank You</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<!-- header section starts  -->
<?php include 'components/user_header.php'; ?>
<!-- header section ends -->

<div class="heading">
   <h3>orders</h3>
   <p><a href="html.php">home</a> <span> / orders</span></p>
</div>

<section class="orders">

   <h1 class="title">thank you for your order!</h1>

   <div class="box-container">
      <div class="box">
         <p>Your order has been successfully placed. We will process it as soon as possible.</p>
         <a href="review.php" class="btn">Leave a Review</a>
      </div>
   </div>

</section>