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

   <!-- about section starts -->
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
      <h1 class="title">customer's reviews</h1>
      <div class="swiper reviews-slider">
         <div class="swiper-wrapper">

            <?php
            // Fetch reviews with correct JOIN condition
            $select_reviews = $conn->prepare("SELECT r.id, r.review_text, r.rating, u.name, u.user_image 
                                              FROM `reviews` r 
                                              JOIN `users` u ON r.id = u.id 
                                              GROUP BY r.id"); // Use GROUP BY to ensure each review is unique
            $select_reviews->execute();
            $reviews = $select_reviews->fetchAll(PDO::FETCH_ASSOC);

            if (count($reviews) > 0) {
               // Loop through all the reviews
               foreach ($reviews as $review) {
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
               echo '<div class="swiper-slide slide">';
               echo '<p>No reviews available.</p>';
               echo '</div>';
            }
            foreach ($reviews as $review) {
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
            echo '<div class="swiper-slide slide">';
            echo '<p>No reviews available.</p>';
            echo '</div>';
         }
            
            ?>

         </div>
         <div class="swiper-pagination"></div>
      </div>
   </section>
   <!-- reviews section ends -->

   <!-- footer section starts -->
   <?php include 'components/footer.php'; ?>
   <!-- footer section ends -->

   <script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>
   <!-- custom js file link -->
   <script src="js/script.js"></script>

   <script>
      var swiper = new Swiper(".reviews-slider", {
         // loop: true,
         grabCursor: true,
         spaceBetween: 20,
         pagination: {
            el: ".swiper-pagination",
            clickable: true,
         },
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
