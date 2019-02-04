<?php

class Post {
   private $user_obj;
   private $con;

   public function __construct($con, $user) {
      $this->con = $con;
      $this->user_obj = new User($con, $user); 
   }

   public function submitPost($body, $user_to) {
      $body = strip_tags($body);
      $body = mysqli_escape_string($this->con, $body);
      $check_empty = preg_replace('/\s+/', '', $body);

      if($check_empty != "") {

         // CURRENT DATE & TIME
         $date_added = date("d m Y H:i:s");

         // GET USERNAME
         $added_by = $this->user_obj->getUsername();

         // IF USER IS ON OWN PROFILE, $user_to = 'none';
         if($user_to == $added_by) {
            $user_to = "none";
         }

         // INSERT POST
         $query = mysqli_query($this->con, "INSERT INTO posts VALUES ('', '$body', '$added_by', '$user_to', '$date_added', 'no', 'no', '0')");
         $returned_id = mysqli_insert_id($this->con);

         // UPDATE POST COUNT FOR USER
         $num_posts = $this->user_obj->getNumPosts();
         $num_posts++;
         $update_query = mysqli_query($this->con, "UPDATE users SET num_posts='$num_posts' WHERE (username='$added_by')");
      }
   }

   public function loadPostsFriends() {
      $str = "";
      $data = mysqli_query($this->con, "SELECT * FROM posts WHERE (deleted='no') ORDER BY id DESC");
   
      while($row = mysqli_fetch_array($data)) {
         $id = $row['id'];
         $body = $row['body'];
         $added_by = $row['added_by'];
         $date_time = $row['date_added'];

         // PREPARE user_to STRING SO IT CAN BE INCLUDED EVEN IF NOT POSTED TO A USER
         if($row['user_to'] == "none") {
            $user_to = "";
         } else {
            $user_to_obj = new User($this->con, $row['user_to']);
            $user_to_name = $user_to_obj->getFirstAndLastName();
            $user_to = "to <a href='" . $row['user_to'] . "'>" . $user_to_name . "</a>";
         }

         // CHECK IF USER WHO POSTED, HAS THEIR ACCOUNT CLOSED
         $added_by_obj = new User($this->con, $added_by);
         if($added_by_obj->isClosed()) {
            continue;
         }

         $user_infos = mysqli_query($this->con, "SELECT first_name, last_name, profile_pic FROM users WHERE (username='$added_by')");
         $user_row = mysqli_fetch_array($user_infos);

         $first_name = $user_row['first_name'];
         $last_name = $user_row['last_name'];
         $profile_pic = $user_row['profile_pic'];

         //TIMEFRAME
         $date_time_now = date("d m Y  H:i:s");
         $start_date = new DateTime($date_time);
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

         $str .= "<div class='status_post'>
                     <div class='post_profile_pic'>
                        <img src='$profile_pic' width='50'>
                     </div>
                     <div class='posted_by'>
                        <a href='$added_by'>$first_name $last_name</a> $user_to $time_message
                     </div>
                     <div id='post_body'>
                        $body
                        <br>
                     </div>
                  </div>";
      }

      echo $str;
   }
}

?>