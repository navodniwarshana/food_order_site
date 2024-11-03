<?php
// Include the database connection file
include 'components/connect.php';

// Start the PHP session to manage user state across pages
session_start();

// Check if user is logged in and set user_id
// If logged in, retrieve user_id from session, otherwise set it to empty string
if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

// Include the add to cart functionality
// This file likely contains functions to add items to the shopping cart
include 'components/add_cart.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>home</title>

   <!-- Include Swiper CSS for the image slider -->
   <link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />

   <!-- Include Font Awesome for icons -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- Include custom CSS file -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>

<!-- Include the user header component -->
<?php include 'components/user_header.php'; ?>

<!-- Hero section with image slider -->
<section class="hero" style="height: 100vh; ">

   <div class="swiper hero-slider">

      <div class="swiper-wrapper">

         <!-- Pizza slide -->
         <div class="swiper-slide slide">
            <div class="content">
               <span>order online</span>
               <h3>delicious pizza</h3>
               <a href="menu.php" class="btn">see menus</a>
            </div>
            <div class="image">
               <img src="images/home-img-1.png" alt="">
            </div>
         </div>

         <!-- Hamburger slide -->
         <div class="swiper-slide slide">
            <div class="content">
               <span>order online</span>
               <h3>chezzy hamburger</h3>
               <a href="menu.php" class="btn">see menus</a>
            </div>
            <div class="image">
               <img src="images/home-img-2.png" alt="">
            </div>
         </div>

         <!-- Roasted chicken slide -->
         <div class="swiper-slide slide">
            <div class="content">
               <span>order online</span>
               <h3>rosted chicken</h3>
               <a href="menu.php" class="btn">see menus</a>
            </div>
            <div class="image">
               <img src="images/home-img-3.png" alt="">
            </div>
         </div>

      </div>

      <!-- Add pagination dots for the slider -->
      <div class="swiper-pagination"></div>

   </div>

</section>

<!-- Food category section -->
<section class="category" ">

   <h1 class="title">food category</h1>

   <div class="box-container">

      <!-- Fast food category -->
      <a href="category.php?category=fast food" class="box">
         <img src="images/cat-1.png" alt="">
         <h3>fast food</h3>
      </a>

      <!-- Main dishes category -->
      <a href="category.php?category=main dish" class="box">
         <img src="images/cat-2.png" alt="">
         <h3>main dishes</h3>
      </a>

      <!-- Drinks category -->
      <a href="category.php?category=drinks" class="box">
         <img src="images/cat-3.png" alt="">
         <h3>drinks</h3>
      </a>

      <!-- Desserts category -->
      <a href="category.php?category=desserts" class="box">
         <img src="images/cat-4.png" alt="">
         <h3>desserts</h3>
      </a>

   </div>

</section>

<!-- Latest dishes section -->
<section class="products" ">

   <h1 class="title">latest dishes</h1>

   <div class="box-container">

      <?php
         // Select 6 latest products from the database
         $select_products = $conn->prepare("SELECT * FROM `products` LIMIT 6");
         $select_products->execute();
         if($select_products->rowCount() > 0){
            while($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)){
      ?>
      <!-- Form to display each product -->
      <form action="" method="post" class="box">
         <input type="hidden" name="pid" value="<?= $fetch_products['id']; ?>">
         <input type="hidden" name="name" value="<?= $fetch_products['name']; ?>">
         <input type="hidden" name="price" value="<?= $fetch_products['price']; ?>">
         <input type="hidden" name="image" value="<?= $fetch_products['image']; ?>">
         <a href="quick_view.php?pid=<?= $fetch_products['id']; ?>" class="fas fa-eye"></a>
         <button type="submit" class="fas fa-shopping-cart" name="add_to_cart"></button>
         <img src="uploaded_img/<?= $fetch_products['image']; ?>" alt="">
         <a href="category.php?category=<?= $fetch_products['category']; ?>" class="cat"><?= $fetch_products['category']; ?></a>
         <div class="name"><?= $fetch_products['name']; ?></div>
         <div class="flex">
            <div class="price"><span>$</span><?= $fetch_products['price']; ?></div>
            <input type="number" name="qty" class="qty" min="1" max="99" value="1" maxlength="2">
         </div>
      </form>
      <?php
            }
         }else{
            echo '<p class="empty">no products added yet!</p>';
         }
      ?>

   </div>

   <div class="more-btn">
      <a href="menu.html" class="btn">veiw all</a>
   </div>

</section>

<!-- Include the footer component -->
<?php include 'components/footer.php'; ?>

<!-- Include Swiper JS for the image slider functionality -->
<script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>

<!-- Include custom JavaScript file -->
<script src="js/script.js"></script>

<script>

// Swiper configuration for the hero slider
var swiper = new Swiper(".hero-slider", {
   loop:true,
   grabCursor: true,
   effect: "flip",
   pagination: {
      el: ".swiper-pagination",
      clickable:true,
   },
});

</script>

</body>
</html>