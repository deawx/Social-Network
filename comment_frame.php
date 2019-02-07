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

   <script>
      function toggle() {
         var element = document.getElementById('comment_section');

         if(element.style.display == 'block') {
            element.style.display = 'none';
         } else {
            element.style.display= 'block';
         }
      }
   </script>

   <?php

   // GET ID OF POST
   if(isset($_GET['post_id'])) {
      $post_id = $_GET['post_id'];
   }

   $user_query = mysqli_query($con, "SELECT added_by, user_to FROM posts WHERE (id='$post_id')");
   $row = mysqli_fetch_array($user_query);

   $posted_to = $row['added_by'];

   if(isset($_POST['postComment' . $post_id])) {
      $post_body = $_POST['post_body'];
      $post_body = mysqli_escape_string($con, $post_body);
      $date_time_now = date("Y-m-d H:i:s");
      $insert_post = mysqli_query($con, "INSERT INTO comments 
                                         VALUES ('', '$post_body', '$userLoggedIn', '$posted_to', '$date_time_now', 'no', '$post_id')");
      echo "<p>Comment Posted !</p>";
   }
   ?>

   <form action="comment_frame.php?post_id=<?php echo $post_id; ?>" method="POST" 
         id="comment_form" name="postComment<?php echo $post_id; ?>">
   
      <textarea name="post_body"></textarea>
      <input type="submit" name="postComment<?php echo $post_id; ?>" value="Post" />

      <!-- LOAD COMMENTS -->

   </form>
</body>