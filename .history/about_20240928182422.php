<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>about</title>

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

<!-- steps section starts  -->

<section class="steps">

   <h1 class="title">simple steps</h1>

   <div class="box-container">

      <div class="box">
         <img src="images/step-1.png" alt="">
         <h3>choose order</h3>
         <p>Explore our menu and choose your favorite dishes.</p>
      </div>

      <div class="box">
         <img src="images/step-2.png" alt="">
         <h3>fast delivery</h3>
         <p>Our team will ensure your order is prepared and delivered to you in a timely manner.</p>
      </div>

      <div class="box">
         <img src="images/step-3.png" alt="">
         <h3>enjoy food</h3>
         <p>Once your order arrives, sit back, relax, and enjoy your delicious meal.</p>
      </div>

   </div>

</section>

<!-- steps section ends -->

<!-- reviews section starts  -->

<section class="reviews">

   <h1 class="title">customer's reviews</h1>

   <div class="swiper reviews-slider">

      <div class="swiper-wrapper">

         <?php
         $select_reviews = $conn->prepare("SELECT r.id, r.review_text, r.rating, u.name, u.user_image FROM `reviews` r JOIN `users` u ON r.id = u.id");
         $select_reviews->execute();
         $reviews = $select_reviews->fetchAll(PDO::FETCH_ASSOC);

         if(count($reviews) > 0){
            
            $review = $reviews[0]; // Select the first review
            echo '<div class="swiper-slide slide">';
            echo '<img src="'.$review['user_image'].'" alt="">';
            echo '<p>"'.$review['review_text'].'"';
            echo '<div class="stars">';
            for($i = 0; $i < 5; $i++){
               if($i < $review['rating']){
                  echo '<i class="fas fa-star"></i>';
               } else {
                  echo '<i class="far fa-star"></i>';
               }
            }
            echo '</div>';
            echo '<h3>'.$review['name'].'</h3>';
            echo '</div>';
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



















<!-- footer section starts  -->
<?php include 'components/footer.php'; ?>
<!-- footer section ends -->=






<script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>

<!-- custom js file link  -->
<script src="js/script.js"></script>

<script>

var swiper = new Swiper(".reviews-slider", {
   loop:true,
   grabCursor: true,
   spaceBetween: 20,
   pagination: {
      el: ".swiper-pagination",
      clickable:true,
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