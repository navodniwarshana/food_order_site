<?php

// Include the database connection file
include 'components/connect.php';

// Start the PHP session
session_start();

// Check if user is logged in and set user_id
if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

// Handle form submission
if(isset($_POST['submit'])){

   // Sanitize and store email input
   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   // Hash and sanitize password input
   $pass = sha1($_POST['pass']);
   $pass = filter_var($pass, FILTER_SANITIZE_STRING);

   // Prepare and execute SQL to select user with matching email and password
   $select_user = $conn->prepare("SELECT * FROM `users` WHERE email = ? AND password = ?");
   $select_user->execute([$email, $pass]);
   $row = $select_user->fetch(PDO::FETCH_ASSOC);

   // If user found, set session and redirect to home page
   if($select_user->rowCount() > 0){
      $_SESSION['user_id'] = $row['id'];
      header('location:home.php');
   }else{
      // If user not found, set error message
      $message[] = 'incorrect username or password!';
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>login</title>

   <!-- Include Font Awesome CSS for icons -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- Include custom CSS file -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<!-- Include the header section for user -->
<?php include 'components/user_header.php'; ?>

<!-- Login form section -->
<section class="form-container">

   <form action="" method="post">
      <h3>login now</h3>
      <input type="email" name="email" required placeholder="enter your email" class="box" maxlength="50" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="password" name="pass" required placeholder="enter your password" class="box" maxlength="50" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="submit" value="login now" name="submit" class="btn">
      <p>don't have an account? <a href="register.php">register now</a></p>
   </form>

</section>

<!-- Include the footer section -->
<?php include 'components/footer.php'; ?>

<!-- Include custom JavaScript file -->
<script src="js/script.js"></script>

</body>
</html>