<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['id'])){
   $user_id = $_SESSION['id'];
}else{
   $id = '';
   header('location:home.php');
};

if(isset($_POST['submit'])){

   $review = $_POST['review'];
   $review = filter_var($review, FILTER_SANITIZE_STRING);

   $insert_review = $conn->prepare("INSERT INTO `reviews`(user_id, review) VALUES(?,?)");
   $insert_review->execute([$user_id, $review]);

   $message[] = 'Thank you for your review!';
}

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
   <h3>Thank You</h3>
   <p><a href="home.php">home</a> <span> / Thank You</span></p>
</div>

<section class="thank-you">

   <h1 class="title">Thank you for your order!</h1>

   <form action="" method="post" class="review-form">
      <div class="form-group">
         <label for="review" class="form-label">Add a review:</label>
         <textarea id="review" name="review" rows="4" cols="50" class="form-control"></textarea>
      </div>
      <div class="form-group">
         <input type="submit" name="submit" value="Submit" class="btn">
      </div>
   </form>

   <?php
      if(isset($message)){
         foreach($message as $message){
            echo '
            <div class="message">
               <span>'.$message.'</span>
               <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
            </div>
            ';
         }
      }
   ?>

</section>

<!-- footer section starts  -->
<?php include 'components/footer.php'; ?>
<!-- footer section ends -->

<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>
