<?php

class Notification {
  private $user_obj;
  private $con;

  public function __construct($con, $user) {
    $this->con = $con;
    $this->user_obj = new User($con, $user);
  }

  public function insertNotification($post_id, $user_to, $type) {
    $userLoggedIn = $this->user_obj->getUsername();
    $userLoggedInName = $this->user_obj->getFirstAndLastName();
    $date_time = date("Y-m-d H:m:s");

    switch($type) {
      case 'comment':
        $message = $userLoggedInName . "<br/>commented on your post";
        break;

      case 'like':
        $message = $userLoggedInName . "<br/>like your post";
        break;

      case 'profile_post':
        $message = $userLoggedInName . "<br/>posted on your profile";
        break;

      case 'comment_non_owner':
        $message = $userLoggedInName . "<br/>commented on a post you commented on";
        break;

      case 'profile_comment':
        $message = $userLoggedInName . "<br/>commented on your profile post";
        break;
    }

    $link = "post.php?id=" . $post_id;
    $insert_query = mysqli_query($this->con, "INSERT INTO notifications 
                                              VALUES('', '$user_to', '$userLoggedIn', '$message', '$link', '$date_time', 'no', 'no')");
  }

  public function getNotifications($data, $limit) {
    $page = $data['page'];
    $userLoggedIn = $this->user_obj->getUsername();
    $return_string = "";

    if($page == 1) {
      $start = 0;
    } else {
      $start = ($page - 1) * $limit;
    }

		$set_viewed_query = mysqli_query($this->con, "UPDATE notifications SET viewed='yes' WHERE (user_to='$userLoggedIn')");
		$query = mysqli_query($this->con, "SELECT * FROM notifications WHERE (user_to='$userLoggedIn') ORDER BY id DESC");

    if(mysqli_num_rows($query) == 0) {
      echo "You have no notifications.";
      return;
    }

    $num_iterations = 0;
    $count = 1;

    while($row = mysqli_fetch_array($query)) {
      if($num_iterations++ < $start) {
        continue;
      }

      if($count > $limit) {
        break;
      } else {
        $count++;
      }

      $user_from = $row['user_from'];
      $user_data_query = mysqli_query($this->con, "SELECT * FROM users WHERE (username='$user_from')");
      $user_data = mysqli_fetch_array($user_data_query);

      $date_time_now = date("Y-m-d  H:i:s");
      $start_date = new DateTime($row['datetime']);
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
  


      $return_string .= "
        <a href='" . $row['link'] . "' style='outline: none;'>
          <h3 class='heading-small'>
            <img  src='" . $user_data['profile_pic'] . "' class='avatar ml-1 mr-1'/>
            <span style='position: relative; top: -2vh'class='text-primary mr-2'>"
              . $row['message'] .
            "</span>

            <br />

            <div class='mt--3' style='position: relative; left: 4vw;'>
              <small class='text-muted'>" . $time_message . "</small>
            </div>
          </h3>
          <hr class='mt-4 mb-2' />
        </a>
      ";
    }

    // IF POST WERE LOADED
    if($count > $limit) {
      $return_string .= "
        <input type='hidden' class='nextPageDropdownData' value='" . ($page + 1) . "'/>
        <input type='hidden' class='noMoreDropdownData' value='false' />
      ";
    } else {
      $return_string .= "
        <input type='hidden' class='noMoreDropdownData' value='true' />
        <div class='alert alert-primary mt--2 mb--2' style='border-radius: 0; text-align:center;'>
          <span class='heading-small' style='font-weight:600;'>
            No more notifications !
          </span>
        </div>
      ";
    }

    return $return_string;
  }

  public function getUnreadNumber() {
    $userLoggedIn = $this->user_obj->getUsername();
    $query = mysqli_query($this->con, "SELECT * FROM notifications WHERE (viewed='no' AND user_to='$userLoggedIn')");
    return mysqli_num_rows($query);
  }
}

?>