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
         $date_added = date("Y-m-d H:i:s");

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

   public function loadPostsFriends($data, $limit) {
      $page = $data['page'];
      $userLoggedIn = $this->user_obj->getUsername();

      if($page == 1) {
         $start = 0;
      } else {
         $start = ($page - 1) * $limit;
      }

      $str = "";
      $data_query = mysqli_query($this->con, "SELECT * FROM posts WHERE (deleted='no') ORDER BY id DESC");

      if(mysqli_num_rows($data_query) > 0) {
         $num_iterations = 0;
         $count = 1;
   
         while($row = mysqli_fetch_array($data_query)) {
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

            if($num_iterations++ < $start) {
               continue;
            }

            // ONCE $limit POSTS HAVE BEEN LOADED, BREAK
            if($count > $limit) {
               break;
            } else {
               $count++;
            }

            $user_infos = mysqli_query($this->con, "SELECT first_name, last_name, profile_pic FROM users WHERE (username='$added_by')");
            $user_row = mysqli_fetch_array($user_infos);

            $first_name = $user_row['first_name'];
            $last_name = $user_row['last_name'];
            $profile_pic = $user_row['profile_pic'];

            //TIMEFRAME
            $date_time_now = date("Y-m-d  H:i:s");
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

            $str .= "
               <div class='status_post'>
                  <div class='card-body border-0'>
                     <div class='p-3'>
                        <div class='row align-items-center'>
                           <div class='col-lg-2 ml-1 mr-1'>
                              <img class='img-fluid rounded-circle shadow-lg' src='$profile_pic' />
                           </div>

                           <div class='col-lg-8'>
                              <h3 class='heading mb-0'>
                                 <a href='$added_by'>$first_name $last_name</a> $user_to
                              </h3>
                              <p class='mb-0 mt-3'>
                                 $body
                              </p>
                           </div>
                        </div>
                     </div>
                  </div>

                  <div class='card-footer bg-secondary border-0'>
                     <div class='row'>
                        <div class='col-lg-3 text-left'>
                           <button type='submit' class='btn btn-primary btn-icon'>
                              <span class='btn-inner--icon'>
                                 <i class='fas fa-calendar-day' style='font-size: 20px;'></i>
                              </span>

                              <span class='btn-inner--text'>$time_message</span>
                           </button>
                        </div>
      
                        <div class='col-lg-9 text-right'>
                           <button type='submit' class='btn btn-outline-danger btn-icon'>
                              <span class='btn-inner--icon'>
                                 <i class='fas fa-heart' style='font-size: 16px;'></i>
                              </span>

                              <span class='btn-inner--text'>18</span>
                           </button>
      
                           <button type='submit' class='btn btn-outline-info btn-icon'>
                              <span class='btn-inner--icon'>
                                 <i class='fas fa-comments' style='font-size: 16px;'></i>
                              </span>

                              <span class='btn-inner--text'>10</span>
                           </button>
                        </div>
                     </div>
                  </div>
               </div>

               <hr class='my-4' />
            "; // END $str
         }

         if($count > $limit) {
            $str .= "
               <input type='hidden' class='nextPage' value='" . ($page + 1) . "' />
               <input type='hidden' class='noMorePosts' value='false' />
            ";
         } else {
            $str .= "
               <input type='hidden' class='noMorePosts' value='true' />
               <div class='alert alert-primary alert-dismissible fade show text-center'>
                  <span class='alert-inner--text' style='text-transform: uppercase; font-weight: 600;'>
                     No more posts to show ...
                  </span>
               </div>         
            ";
         }
      }

      echo $str;
   }
}

?>