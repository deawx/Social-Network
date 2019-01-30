<?php

if(isset($_POST['log_btn'])) {
   $email = filter_var($_POST['log_email'], FILTER_SANITIZE_EMAIL);
   $_SESSION['log_email'] = $email;

   $password = md5($_POST['log_password']);

   $check_database = mysqli_query($con, "SELECT * FROM users WHERE (email='$email') AND (password='$password')");
   $check_login = mysqli_num_rows($check_database);

   if($check_login == 1) {
      $row = mysqli_fetch_array($check_database);
      $username = $row['username'];
      $_SESSION['username'] = $username;

      header("Location: index.php");
      exit();
   }
}

?>