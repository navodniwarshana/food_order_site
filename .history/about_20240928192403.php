<?php

include 'components/connect.php';

session_start();

if (isset($_SESSION['user_id'])) {
   $user_id = $_SESSION['user_id'];
} else {
   $user_id = '';
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>About</title>

   <link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />
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
      <h3>about us</h3>
      <p><a href="home.php">home</a> <span> / about</span></p>
   </div>

   <!-- about section starts  -->
   <section class="about">
      <div class="row">
         <div class="image">
            <img src="images/about-img.svg" alt="">
         </div>
         <div class="content">
            <h3>why choose us?</h3>
            <p>We are a team of passionate food lovers, dedicated to providing the best dining experience for our customers. Our chefs use only the freshest ingredients to create mouthwatering dishes that will leave you wanting more.</p>
            <a href="menu.php" class="btn">our menu</a>
         </div>
      </div>
   </section>
   <!-- about section ends -->

   <!-- reviews section starts -->
   <section class="reviews">
      <h1 class="title">Customer's Reviews</h1>
      <table border="1" cellpadding="10" cellspacing="0">
         <thead>
            <tr>
               <th>User Image</th>
               <th>User Name</th>
               <th>Review</th>
               <th>Rating</th>
            </tr>
         </thead>
         <tbody>

            <?php
            // Fetch reviews with the correct JOIN condition
            $select_reviews = $conn->prepare("SELECT r.id, r.review_text, r.rating, u.name, u.user_image 
                                              FROM `reviews` r 
                                              JOIN `users` u ON r.user_id = u.id 
                                              GROUP BY r.id"); // Ensuring unique reviews
            $select_reviews->execute();
            $reviews = $select_reviews->fetchAll(PDO::FETCH_ASSOC);

            if (count($reviews) > 0) {
               // Loop through all reviews and display them in a table
               foreach ($reviews as $review) {
                  echo '<tr>';
                  echo '<td><img src="' . $review['user_image'] . '" alt="User Image" width="50" height="50"></td>';
                  echo '<td>' . $review['name'] . '</td>';
                  echo '<td>"' . $review['review_text'] . '"</td>';
                  echo '<td>';
                  
                  // Display the star rating
                  for ($i = 0; $i < 5; $i++) {
                     if ($i < $review['rating']) {
                        echo '<i class="fas fa-star"></i>';
                     } else {
                        echo '<i class="far fa-star"></i>';
                     }
                  }
                  
                  echo '</td>';
                  echo '</tr>';
               }
            } else {
               echo '<tr><td colspan="4">No reviews available.</td></tr>';
            }
            ?>

         </tbody>
      </table>
   </section>
   <!-- reviews section ends -->

   <!-- footer section starts -->
   <?php include 'components/footer.php'; ?>
   <!-- footer section ends -->

   <script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>
   <!-- custom js file link -->
   <script src="js/script.js"></script>

</body>

</html>
