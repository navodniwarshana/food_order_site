<?php

if(isset($_POST['add_to_cart'])){

   if($user_id == ''){
      header('location:login.php');
   }else{

      // Get product ID from POST and sanitize
      $pid = $_POST['pid'];
      $pid = filter_var($pid, FILTER_SANITIZE_STRING);
      
      // Get product name from POST and sanitize
      $name = $_POST['name'];
      $name = filter_var($name, FILTER_SANITIZE_STRING);
      
      // Get product price from POST and sanitize
      $price = $_POST['price'];
      $price = filter_var($price, FILTER_SANITIZE_STRING);
      
      // Get product image from POST and sanitize
      $image = $_POST['image'];
      $image = filter_var($image, FILTER_SANITIZE_STRING);
      
      // Get product quantity from POST and sanitize
      $qty = $_POST['qty'];
      $qty = filter_var($qty, FILTER_SANITIZE_STRING);

      $check_cart_numbers = $conn->prepare("SELECT * FROM `cart` WHERE name = ? AND user_id = ?");
      $check_cart_numbers->execute([$name, $user_id]);

      if($check_cart_numbers->rowCount() > 0){
         $message[] = 'already added to cart!';
      }else{
         $insert_cart = $conn->prepare("INSERT INTO `cart`(user_id, pid, name, price, quantity, image) VALUES(?,?,?,?,?,?)");
         $insert_cart->execute([$user_id, $pid, $name, $price, $qty, $image]);
         $message[] = 'added to cart!';
         
      }

   }

}

?>