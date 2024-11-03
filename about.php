<?php

// Include the database connection file
include 'components/connect.php';

// Start the PHP session
session_start();

// Check if user is logged in and set user_id
// If logged in, retrieve user_id from session, otherwise set it to empty string
if (isset($_SESSION['user_id'])) {
   $user_id = $_SESSION['user_id'];
} else {
   $user_id = '';
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
   <!-- Set character encoding for the document -->
   <meta charset="UTF-8">
   <!-- Set document compatibility mode for Internet Explorer -->
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <!-- Set the viewport for responsive design -->
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <!-- Set the page title -->
   <title>About</title>

   <!-- Include Swiper CSS for slider functionality -->
   <link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />
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
      <h3>about us</h3>
      <p><a href="home.php">home</a> <span> / about</span></p>
   </div>

   <!-- About section starts -->
   <section class="about">
      <div class="row">
         <!-- Display an image -->
         <div class="image">
            <img src="images/about-img.svg" alt="">
         </div>
         <!-- Display content about the company -->
         <div class="content">
            <h3>why choose us?</h3>
            <p>We are a team of passionate food lovers, dedicated to providing the best dining experience for our customers. Our chefs use only the freshest ingredients to create mouthwatering dishes that will leave you wanting more.</p>
            <a href="menu.php" class="btn">our menu</a>
         </div>
      </div>
   </section>
   <!-- About section ends -->

   <!-- Reviews section starts -->
   <section class="reviews">
      <h1 class="title">customer's reviews</h1>
      <!-- Initialize Swiper slider for reviews -->
      <div class="swiper reviews-slider">
         <div class="swiper-wrapper">

            <?php
            // Prepare and execute SQL query to fetch reviews with user information
            $select_reviews = $conn->prepare("SELECT r.id, r.review_text, r.rating, u.name, u.user_image 
                                              FROM `reviews` r 
                                              JOIN `users` u ON r.id = u.id 
                                              GROUP BY r.id"); // Use GROUP BY to ensure each review is unique
            $select_reviews->execute();
            $reviews = $select_reviews->fetchAll(PDO::FETCH_ASSOC);

            // Check if there are any reviews
            if (count($reviews) > 0) {
               // Loop through all the reviews
               foreach ($reviews as $review) {
                  // Display each review in a slide
                  echo '<div class="swiper-slide slide">';
                  echo '<img src="' . $review['user_image'] . '" alt="User Image">';
                  echo '<p>"' . $review['review_text'] . '"</p>';
                  echo '<div class="stars">';

                  // Display the star rating
                  for ($i = 0; $i < 5; $i++) {
                     if ($i < $review['rating']) {
                        echo '<i class="fas fa-star"></i>';
                     } else {
                        echo '<i class="far fa-star"></i>';
                     }
                  }

                  echo '</div>';
                  echo '<h3>' . $review['name'] . '</h3>';
                  echo '</div>';
               }
            } else {
               // Display a message if no reviews are available
               echo '<div class="swiper-slide slide">';
               echo '<p>No reviews available.</p>';
               echo '</div>';
            }
            
            
            ?>

         </div>
         <!-- Add pagination for the slider -->
         <div class="swiper-pagination"></div>
      </div>
   </section>
   <!-- Reviews section ends -->

   <!-- Include the footer section -->
   <?php include 'components/footer.php'; ?>

   <!-- Include Swiper JS for slider functionality -->
   <script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>
   <!-- Include custom JavaScript file -->
   <script src="js/script.js"></script>

   <script>
      // Initialize Swiper for reviews slider
      var swiper = new Swiper(".reviews-slider", {
         // loop: true,
         grabCursor: true,
         spaceBetween: 20,
         pagination: {
            el: ".swiper-pagination",
            clickable: true,
         },
         // Set breakpoints for responsive design
         breakpoints: {
            0: {
               slidesPerView: 1,
            },
            700: {
               slidesPerView: 2,
            },
            1024: {
               slidesPerView: 3,
            },
         },
      });
   </script>

</body>

</html>
