<?php

include 'components/connect.php';

session_start();

// Log current session data for debugging
error_log("Current session data: " . print_r($_SESSION, true));

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
   $customer_name = $_SESSION['customer_name'] ?? ''; // Added null coalescing operator
   // $user_image = $_SESSION['user_image'] ?? ''; // Added null coalescing operator
   $review_text = $_POST['review'] ?? ''; 
   $rating = $_POST['rating'] ?? ''; 
   $created_at = date('Y-m-d H:i:s'); 
}else{
   $user_id = '';
   $customer_name = '';
   $user_image = ''; // Default value if user image is not set
   $review_text = '';
   $rating = '';
   $created_at = '';
   // Debugging line
   error_log("Session ID not set. Redirecting to home.php");
   header('location:home.php');
   exit(); // Ensure no further code is executed
};

if(isset($_POST['submit'])){
   // Ensure $id is defined, e.g., set it to $user_id or another appropriate value
   $id = $user_id; // Assuming you want to use user_id as the id for the review

   $review_text = filter_var($review_text, FILTER_SANITIZE_STRING);

   $insert_review = $conn->prepare("INSERT INTO `reviews`(id, customer_name, user_image, review_text, rating, created_at) VALUES(?,?,?,?,?,?)");
   $insert_review->execute([$id, $customer_name, $user_image, $review_text, $rating, $created_at]);

   $message[] = 'Thank you for your review!';
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
         <label for="rating" class="form-label">Rating:</label>
         <select id="rating" name="rating" class="form-control">
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
         </select>
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
