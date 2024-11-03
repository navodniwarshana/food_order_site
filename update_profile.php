<?php

// Include the database connection file
include 'components/connect.php';

// Start the session
session_start();

// Check if the user is logged in
if (isset($_SESSION['user_id'])) {
   $user_id = $_SESSION['user_id'];
} else {
   $user_id = '';
   // Redirect the user to the home page if not logged in
   header('location:home.php');
};

// Check if the form has been submitted
if (isset($_POST['submit'])) {

   // Retrieve and sanitize the name from the form
   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);

   // Retrieve and sanitize the email from the form
   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   // Retrieve and sanitize the phone number from the form
   $number = $_POST['number'];
   $number = filter_var($number, FILTER_SANITIZE_STRING);

   // Update the user's name if it's not empty
   if (!empty($name)) {
      $update_name = $conn->prepare("UPDATE `users` SET name = ? WHERE id = ?");
      $update_name->execute([$name, $user_id]);
   }

   // Check if the email is already taken and update it if not
   if (!empty($email)) {
      $select_email = $conn->prepare("SELECT * FROM `users` WHERE email = ?");
      $select_email->execute([$email]);
      if ($select_email->rowCount() > 0) {
         $message[] = 'email already taken!';
      } else {
         $update_email = $conn->prepare("UPDATE `users` SET email = ? WHERE id = ?");
         $update_email->execute([$email, $user_id]);
      }
   }

   // Check if the phone number is already taken and update it if not
   if (!empty($number)) {
      $select_number = $conn->prepare("SELECT * FROM `users` WHERE number = ?");
      $select_number->execute([$number]);
      if ($select_number->rowCount() > 0) {
         $message[] = 'number already taken!';
      } else {
         $update_number = $conn->prepare("UPDATE `users` SET number = ? WHERE id = ?");
         $update_number->execute([$number, $user_id]);
      }
   }

   // Handle the user image upload
   if (isset($_FILES['user_image'])) {
      $file_name = $_FILES['user_image']['name'];
      $file_size = $_FILES['user_image']['size'];
      $file_tmp = $_FILES['user_image']['tmp_name'];
      $file_type = $_FILES['user_image']['type'];
      $file_name_parts = explode('.', $_FILES['user_image']['name']); // Store in a variable
      $file_ext = strtolower(end($file_name_parts)); // Store explode result in a variable

      $extensions = array("jpeg", "jpg", "png", "webp");

      // Check if the file extension is allowed
      if (in_array($file_ext, $extensions) === false) {
         $message[] = "extension not allowed, please choose a JPEG or PNG file.";
      }

      // Check if the file size exceeds the limit
      if ($file_size > 2097152) {
         $message[] = 'File size must be less than 2 MB';
      }

      // If there are no errors, move the uploaded file to the images directory and update the user's profile picture
      if (empty($message) == true) {
         move_uploaded_file($file_tmp, "images/" . $file_name);
         $update_picture = $conn->prepare("UPDATE `users` SET user_image = ? WHERE id = ?");
         $update_picture->execute(["images/" . $file_name, $user_id]);
      }
   }

   // Retrieve the user's current password from the database
   $empty_pass = 'da39a3ee5e6b4b0d3255bfef95601890afd80709';
   $select_prev_pass = $conn->prepare("SELECT password FROM `users` WHERE id = ?");
   $select_prev_pass->execute([$user_id]);
   $fetch_prev_pass = $select_prev_pass->fetch(PDO::FETCH_ASSOC);
   $prev_pass = $fetch_prev_pass['password'];
   // Retrieve and hash the old password from the form
   $old_pass = sha1($_POST['old_pass']);
   $old_pass = filter_var($old_pass, FILTER_SANITIZE_STRING);
   // Retrieve and hash the new password from the form
   $new_pass = sha1($_POST['new_pass']);
   $new_pass = filter_var($new_pass, FILTER_SANITIZE_STRING);
   // Retrieve and hash the confirm password from the form
   $confirm_pass = sha1($_POST['confirm_pass']);
   $confirm_pass = filter_var($confirm_pass, FILTER_SANITIZE_STRING);

   // Check if the old password is correct and update the password if it's correct and the new password is not empty
   if ($old_pass != $empty_pass) {
      if ($old_pass != $prev_pass) {
         $message[] = 'old password not matched!';
      } elseif ($new_pass != $confirm_pass) {
         $message[] = 'confirm password not matched!';
      } else {
         if ($new_pass != $empty_pass) {
            $update_pass = $conn->prepare("UPDATE `users` SET password = ? WHERE id = ?");
            $update_pass->execute([$confirm_pass, $user_id]);
            $message[] = 'password updated successfully!';
         } else {
            $message[] = 'please enter a new password!';
         }
      }
   }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>update profile</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>

<body>

   <!-- header section starts  -->
   <?php include 'components/user_header.php'; ?>
   <!-- header section ends -->

   <section class="form-container update-form">

      <form action="" method="post" enctype="multipart/form-data">
         <h3>update profile</h3>
         <input type="text" name="name" placeholder="<?= $fetch_profile['name']; ?>" class="box" maxlength="50">
         <input type="email" name="email" placeholder="<?= $fetch_profile['email']; ?>" class="box" maxlength="50" oninput="this.value = this.value.replace(/\s/g, '')">
         <input type="number" name="number" placeholder="<?= $fetch_profile['number']; ?>"" class=" box" min="0" max="9999999999" maxlength="10">
         <input type="password" name="old_pass" placeholder="enter your old password" class="box" maxlength="50" oninput="this.value = this.value.replace(/\s/g, '')">
         <input type="password" name="new_pass" placeholder="enter your new password" class="box" maxlength="50" oninput="this.value = this.value.replace(/\s/g, '')">
         <input type="password" name="confirm_pass" placeholder="confirm your new password" class="box" maxlength="50" oninput="this.value = this.value.replace(/\s/g, '')">
         <input type="file" name="user_image" accept="image/*" style="color: #000; background: #fff; border: 1px solid #ccc; padding: 10px; border-radius: 5px;">
         <input type="submit" value="update now" name="submit" class="btn">
      </form>

   </section>










   <?php include 'components/footer.php'; ?>






   <!-- custom js file link  -->
   <script src="js/script.js"></script>

</body>

</html>