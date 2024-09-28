<?php

include 'components/connect.php';

session_start();

if (isset($_SESSION['user_id'])) {
   $user_id = $_SESSION['user_id'];
   $select_user = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
   $select_user->execute([$user_id]);
   $fetch_profile = $select_user->fetch(PDO::FETCH_ASSOC);
   $user_image = $fetch_profile['user_image'] ? $fetch_profile['user_image'] : 'images/user-icon.png';
} else {
   $user_id = '';
   header('location:home.php');
};

?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>profile</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>

<body>

   <!-- header section starts  -->
   <?php include 'components/user_header.php'; ?>
   <!-- header section ends -->

   <section class="user-details">

      <div class="user">
         <?php

         ?>

         <div class="profile-picture" style="display: flex; align-items: center; justify-content: center; flex-direction: column; padding: 2rem;  margin: 2rem;  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); margin-bottom: 1rem;">
            <img src="<?php echo $user_image; ?>" alt="" style="width: 150p; height: 150p; border-radius: 50%; object-fit: cover;">
         </div>
         <p><i class="fas fa-user"></i><span><span><?= $fetch_profile['name']; ?></span></span></p>
         <p><i class="fas fa-phone"></i><span><?= $fetch_profile['number']; ?></span></p>
         <p><i class="fas fa-envelope"></i><span><?= $fetch_profile['email']; ?></span></p>
         <a href="update_profile.php" class="btn">update info</a>
         <p class="address"><i class="fas fa-map-marker-alt"></i><span><?php if ($fetch_profile['address'] == '') {
                                                                           echo 'please enter your address';
                                                                        } else {
                                                                           echo $fetch_profile['address'];
                                                                        } ?></span></p>
         <a href="update_address.php" class="btn">update address</a>
      </div>

   </section>










   <?php include 'components/footer.php'; ?>







   <!-- custom js file link  -->
   <script src="js/script.js"></script>

</body>

</html>