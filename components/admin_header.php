<?php
// Check if there are any messages to display
if(isset($message)){
   // Loop through each message
   foreach($message as $message){
      // Output a div with the message and a close button
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

      <!-- Logo linking to dashboard -->
      <a href="dashboard.php" class="logo">Admin<span>Panel</span></a>

      <!-- Navigation menu -->
      <nav class="navbar">
         <a href="dashboard.php">home</a>
         <a href="products.php">products</a>
         <a href="placed_orders.php">orders</a>
         <a href="admin_accounts.php">admins</a>
         <a href="users_accounts.php">users</a>
         <a href="messages.php">messages</a>
      </nav>

      <!-- Icons for menu and user profile -->
      <div class="icons">
         <div id="menu-btn" class="fas fa-bars"></div>
         <div id="user-btn" class="fas fa-user"></div>
      </div>

      <!-- User profile section -->
      <div class="profile">
         <?php
            // Fetch admin profile from database
            $select_profile = $conn->prepare("SELECT * FROM `admin` WHERE id = ?");
            $select_profile->execute([$admin_id]);
            $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
         ?>
         <!-- Display admin name -->
         <p><?= $fetch_profile['name']; ?></p>
         <!-- Link to update profile -->
         <a href="update_profile.php" class="btn">update profile</a>
         <!-- Login and register buttons -->
         <div class="flex-btn">
            <a href="admin_login.php" class="option-btn">login</a>
            <a href="register_admin.php" class="option-btn">register</a>
         </div>
         <!-- Logout button with confirmation -->
         <a href="../components/admin_logout.php" onclick="return confirm('logout from this website?');" class="delete-btn">logout</a>
      </div>

   </section>

</header>