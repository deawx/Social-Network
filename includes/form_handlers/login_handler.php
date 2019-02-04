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

      $user_closed_query = mysqli_query($con, "SELECT * FROM users WHERE (email='$email') AND (user_closed='yes')");
      if(mysqli_num_rows($user_closed_query) == 1) {
         $reopen_account = mysqli_query($con, "UPDATE users SET user_closed='no' WHERE (email='$email')");
      };

      header("Location: index.php");
      exit();
   } else {
      array_push($error_array, "<div class='alert alert-danger text-center' style='margin-bottom: 35px;'><strong>Error! Email or password was incorrect.</strong></div>");
   }
}

?>