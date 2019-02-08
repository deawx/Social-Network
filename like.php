<?php

require_once("config/config.php");
include_once("includes/classes/User.php");
include_once("includes/classes/Post.php");

if(isset($_SESSION['username'])) {
   $userLoggedIn = $_SESSION['username'];
   $user_infos = mysqli_query($con, "SELECT * FROM users WHERE (username='$userLoggedIn')");
   $user = mysqli_fetch_array($user_infos);
} else {
   header("Location: login.php");
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no" />

  <script type="text/javascript" src="assets/js/lib/jquery.min.js"></script>
  <script type="text/javascript" src="assets/js/lib/bootstrap.bundle.min.js"></script>
  <script type="text/javascript" src="assets/js/argon.min.js"></script>

  <link rel="stylesheet" type="text/css" href="assets/css/all.min.css" />
  <link rel="stylesheet" type="text/css" href="assets/css/nucleo.css" />
  <link rel="stylesheet" type="text/css" href="assets/css/argon.min.css" />
</head>

<body>

   <?php

   // GET ID OF POST
   if(isset($_GET['post_id'])) {
      $post_id = $_GET['post_id'];
   }

   $get_likes = mysqli_query($con, "SELECT likes, added_by FROM posts WHERE (id='$post_id')");
   $row = mysqli_fetch_array($get_likes);
   $total_likes = $row['likes'];
   $user_liked = $row['added_by'];
   $total_users_likes = $row['num_likes'];

   $user_infos = mysqli_query($con, "SELECT * FROM users WHERE (username='$user_liked')");
   $row = mysqli_fetch_array($user_infos);

   // LIKE BTN
   if(isset($_POST['like_btn'])) {
      $total_likes++;
      $likes_query = mysqli_query($con, "UPDATE posts SET likes='$total_likes' WHERE (post_id='$post_id')");

      $total_users_likes++;
      $users_likes_query = mysqli_query($con, "UPDATE users SET num_likes='$total_users_likes' WHERE (username='$user_liked')");

      $insert_user = mysqli_query($con, "INSERT INTO likes VALUES('', '$userLoggedIn', '$post_id')");

      // INSERT NOTIFICATION
   }

   // UNLIKE BTN

   // CHECK FOR PREVIOUS LIKE
   $check_query = mysqli_query($con, "SELECT * FROM likes WHERE (username='$userLoggedIn' AND post_id='$post_id')");
   $num_rows = mysqli_num_rows($check_query);

   if($num_rows > 0) {
      echo "
         <form action='like.php?post_id=" . $post_id . "' method='POST'>
            <input type='submit'class='comment_like' name='unlike_btn' value='Unlike' />
            <div class='like_value'>
               " . $total_likes . " Likes
            </div>
         </form>
      ";
   } else {
      echo "
         <form action='like.php?post_id=" . $post_id . "' method='POST'>
            <input type='submit'class='comment_like' name='like_btn' value='Like' />
            <div class='like_value'>
               " . $total_likes . " Likes
            </div>
         </form>
      ";
   }

   ?>

</body>