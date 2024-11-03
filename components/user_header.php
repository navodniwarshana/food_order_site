<?php
// Check if there are any messages to display
if(isset($message)){
   // Loop through each message and display it
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

<header class="header">

   <section class="flex">

      <!-- Link to the home page -->
      <a href="home.php" style="font-size: 2rem; font-weight: bold; color: #fed330; text-decoration: none;">WARIYAS KITCHEN</a>

      <!-- Navigation bar with links to different pages -->
      <nav class="navbar">
         <a href="home.php" style="text-transform: uppercase;">HOME</a>
         <a href="about.php" style="text-transform: uppercase;">ABOUT</a>
         <a href="menu.php" style="text-transform: uppercase;">MENU</a>
         <a href="orders.php" style="text-transform: uppercase;">ORDERS</a>
         <a href="contact.php" style="text-transform: uppercase;">CONTACT</a>
      </nav>

      <!-- Icons for search, cart, user profile, and menu -->
      <div class="icons">
         <!-- Prepare a SQL query to count the number of items in the cart for the current user -->
         <?php
            $count_cart_items = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
            $count_cart_items->execute([$user_id]);
            $total_cart_items = $count_cart_items->rowCount();
         ?>
         <!-- Link to the search page -->
         <a href="search.php"><i class="fas fa-search"></i></a>
         <!-- Link to the cart page with the total number of items -->
         <a href="cart.php"><i class="fas fa-shopping-cart"></i><span>(<?= $total_cart_items; ?>)</span></a>
         <!-- Icon for the user profile -->
         <div id="user-btn" class="fas fa-user"></div>
         <!-- Icon for the menu -->
         <div id="menu-btn" class="fas fa-bars"></div>
      </div>

      <!-- User profile section -->
      <div class="profile">
         <!-- Prepare a SQL query to select the user profile -->
         <?php
            $select_profile = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
            $select_profile->execute([$user_id]);
            if($select_profile->rowCount() > 0){
               $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
         ?>
         <!-- Display the user's name -->
         <p class="name"><?= $fetch_profile['name']; ?></p>
         <!-- Links to the profile and logout pages -->
         <div class="flex">
            <a href="profile.php" class="btn">profile</a>
            <a href="components/user_logout.php" onclick="return confirm('logout from this website?');" class="delete-btn">logout</a>
         </div>
         <!-- Links to login and register pages if not logged in -->
         <p class="account">
            <a href="login.php">login</a> or
            <a href="register.php">register</a>
         </p> 
         <?php
            }else{
         ?>
            <!-- Message to login first if not logged in -->
            <p class="name">please login first!</p>
            <!-- Link to the login page -->
            <a href="login.php" class="btn">login</a>
         <?php
          }
         ?>
      </div>

   </section>

</header>

