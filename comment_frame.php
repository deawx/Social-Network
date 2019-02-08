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
         id="comment_form" name="postComment<?php echo $post_id; ?>" class="mb-7 mt-1">

      <div class="form-group mr-3 ml-4">
         <textarea rows="4" name="post_body" class="form-control form-control-alternative">Post a comment ...</textarea>
      </div>

      <button type="submit" name="postComment<?php echo $post_id; ?>" class="btn btn-primary btn-icon mr-3"  style="float: right;">
         <span class="btn-inner--icon">
            <i class="fas fa-paper-plane"></i>
         </span>

         <span class="btn-inner--text">Post a comment</span>
      </button>
   </form>

   <?php

   // LOAD COMMENTS
   $get_comments = mysqli_query($con, "SELECT * FROM comments WHERE (post_id='$post_id') ORDER BY id DESC");
   $count = mysqli_num_rows($get_comments);

   if($count != 0) {
      while($comment = mysqli_fetch_array($get_comments)) {
         $comment_body = $comment['post_body'];
         $posted_to = $comment['posted_to'];
         $posted_by = $comment['posted_by'];
         $date_added = $comment['date_added'];
         $removed = $comment['removed'];

         //TIMEFRAME
         $date_time_now = date("Y-m-d  H:i:s");
         $start_date = new DateTime($date_added);
         $end_date = new DateTime($date_time_now);
         $interval = $start_date->diff($end_date);

         if($interval->y >= 1) {
            if($interval == 1) {
               $time_message = $interval->y . " year ago"; // 1 year
            } else {
               $time_message = $interval->y . " years ago"; // 1+ years
            }
         } elseif($interval->m >= 1) {
            if($interval->d == 0) {
               $days = " ago";
            } elseif($interval->d == 1) {
               $days = $interval->d . " day ago";
            } else {
               $days = $interval->d . " days ago";
            }

            if($interval->m == 1) {
               $time_message = $interval->m . " month" . $days;
            } else {
               $time_message = $interval->m . " months" . $days;
            }
         } elseif($interval->d >= 1) {
            if($interval->d == 1) {
               $time_message = "Yesterday";
            } else {
               $time_message = $interval->d . " days ago";
            }
         } elseif($interval->h >= 1) {
            if($interval->h == 1) {
               $time_message = $interval->h . " hour ago";
            } else {
               $time_message = $interval->h . " hours ago";
            }
         } elseif($interval->i >= 1) {
            if($interval->i == 1) {
               $time_message = $interval->i . " minute ago";
            } else {
               $time_message = $interval->i . " minutes ago";
            }
         } else {
            if($interval->s < 30) {
               $time_message = "Just now";
            } else {
               $time_message = $interval->s . " seconds ago";
            }
         }

          $user_obj = new User($con, $posted_by);

          ?>

         <div class="comment_section">
            <div class="card-body border-0">
               <div class="p-1">
                  <div class="row align-items-center">
                     <div class="col-lg-2 ml-1 mr-1">
                        <img class="img-fluid rounded-circle shadow-lg" style="height:100px;" src="<?php echo $user_obj->getProfilePic(); ?>" />
                     </div>

                     <div class="col-lg-8">
                        <h3 class="heading mb-0">
                           <a href="<?php echo $posted_by; ?>" target="_parent">
                              <?php echo $user_obj->getFirstAndLastName(); ?>
                           </a>
                           <small class="text-muted">- <?php echo $time_message; ?></small>
                        </h3>

                        <p class='mb-0 mt-3'>
                           <?php echo $comment_body; ?>
                        </p>
                     </div>

                     <br/>

                  </div>
               </div>
            </div>
         </div>

         <?php
      }
   } else {
      echo "
         <div class='alert alert-primary alert-dismissible fade show text-center ml-4 mr-3'>
            <span class='alert-inner--text' style='text-transform: uppercase; font-weight: 600;'>
               Be the first to write a comment
            </span>
         </div>
      ";
   }

   ?>

</body>