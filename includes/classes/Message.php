<?php

class Message {
  private $user_obj;
  private $con;

  public function __construct($con, $user) {
    $this->con = $con;
    $this->user_obj = new User($con, $user);
  }

  public function getMostRecentUser() {
    $userLoggedIn = $this->user_obj->getUsername();
    $query = mysqli_query($this->con, "SELECT user_to, user_from FROM messages 
                                       WHERE (user_to='$userLoggedIn' OR user_from='$userLoggedIn') 
                                       ORDER BY id DESC LIMIT 1");
    if(mysqli_num_rows($query) == 0) {
      return false;
    }

    $row = mysqli_fetch_array($query);
    $user_to = $row['user_to'];
    $user_from = $row['user_from'];

    if($user_to != $userLoggedIn) {
      return $user_to;
    } else {
      return $user_from;
    }
  }

  public function sendMessage($user_to, $body, $date) {
    if($body != "") {
      $userLoggedIn = $this->user_obj->getUsername();
      $query = mysqli_query($this->con, "INSERT INTO messages VALUES('', '$user_to', '$userLoggedIn', '$body', '$date', 'no', 'no', 'no')");    
    }
  }

  public function getMessages($otherUser) {
    $userLoggedIn = $this->user_obj->getUsername();
    $data = "";

    $query = mysqli_query($this->con, "UPDATE messages SET opened='yes' WHERE (user_to='$userLoggedIn' AND user_from='$otherUser')");
    $get_messages_query = mysqli_query($this->con, "SELECT * FROM messages WHERE ((user_to='$userLoggedIn' AND user_from='$otherUser') OR (user_from='$userLoggedIn' AND user_to='$otherUser'))");

    while($row = mysqli_fetch_array($get_messages_query)) {
      $user_to = $row['user_to'];
      $user_from = $row['user_from'];
      $body = $row['body'];
      $div_top = ($user_to == $userLoggedIn) ? "<div class='bubble' id='primary'>" : "<div class='bubble' id='green'>";
      $data = $data . $div_top . $body . "</div>";
    }

    return $data;
  }

  public function getLatestMessage($userLoggedIn, $user2) {
    $details_array = array();
    $query = mysqli_query($this->con, "SELECT body, user_to, date FROM messages 
                                       WHERE ((user_to='$userLoggedIn' AND user_from='$user2') 
                                       OR (user_to='$user2' AND user_from='$userLoggedIn')) 
                                       ORDER BY id DESC LIMIT 1");
    $row = mysqli_fetch_array($query);

    $date_time_now = date("Y-m-d  H:i:s");
    $start_date = new DateTime($row['date']);
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

    array_push($details_array, $row['body']);
    array_push($details_array, $time_message);

    return $details_array;
  }

  public function getConvers() {
    $userLoggedIn = $this->user_obj->getUsername();
    $return_string = "";
    $convers = array();

    $query = mysqli_query($this->con, "SELECT user_to, user_from FROM messages 
                                       WHERE (user_to='$userLoggedIn' OR user_from='$userLoggedIn')
                                       ORDER BY id DESC");

    while($row = mysqli_fetch_array($query)) {
      $user_to_push = ($row['user_to'] != $userLoggedIn) ? $row['user_to'] : $row['user_from'];

      if(!in_array($user_to_push, $convers)) {
        array_push($convers, $user_to_push);
      }
    }

    foreach($convers as $username) {
      $user_found_obj = new User($this->con, $username);
      $latest_msg_details = $this->getLatestMessage($userLoggedIn, $username);
      $dots = (strlen($latest_msg_details[0]) >= 50) ? " ..." : "";
      $split = str_split($latest_msg_details[0], 50);
      $split = $split[0] . $dots;

      $return_string .= "
        <a href='messages.php?u=$username' style='outline: none;'>
          <h3 class='heading'>
            <img src='" . $user_found_obj->getProfilePic() . "' class='avatar' />
            <span class='ml-3 text-primary'>" . $user_found_obj->getFirstAndLastName() . "</span>
            <small class='text-muted'> - " . $latest_msg_details[1] . "</small>
            <div class='text-left ml-2 mt-4'>
              <small>" . $split . "</small>
            </div>
          </h3>
          <hr class='my-4' />
        </a>
      ";
    }

    return $return_string;
  }

  public function getConversDropdown($data, $limit) {
    $page = $data['page'];
    $userLoggedIn = $this->user_obj->getUsername();
    $return_string = "";
    $convers = array();

    if($page == 1) {
      $start = 0;
    } else {
      $start = ($page - 1) * $limit;
    }

		$set_viewed_query = mysqli_query($this->con, "UPDATE messages SET viewed='yes' WHERE (user_to='$userLoggedIn')");

		$query = mysqli_query($this->con, "SELECT user_to, user_from FROM messages 
                                       WHERE (user_to='$userLoggedIn' OR user_from='$userLoggedIn') 
                                       ORDER BY id DESC");

    while($row = mysqli_fetch_array($query)) {
      $user_to_push = ($row['user_to'] != $userLoggedIn) ? $row['user_to'] : $row['user_from'];

      if(!in_array($user_to_push, $convers)) {
        array_push($convers, $user_to_push);
      }
    }

    $num_iterations = 0;
    $count = 1;

    foreach($convers as $username) {
      if($num_iterations++ < $start) {
        continue;
      }

      if($count > $limit) {
        break;
      } else {
        $count++;
      }

			$is_unread_query = mysqli_query($this->con, "SELECT opened FROM messages 
                                                   WHERE (user_to='$userLoggedIn' AND user_from='$username') 
                                                   ORDER BY id DESC");

      $row = mysqli_fetch_array($is_unread_query);
      $style = ($row['opened'] == 'no') ? "background-color: #000;" : "";


      $user_found_obj = new User($this->con, $username);
      $latest_msg_details = $this->getLatestMessage($userLoggedIn, $username);
      $dots = (strlen($latest_msg_details[0]) >= 50) ? " ..." : "";
      $split = str_split($latest_msg_details[0], 50);
      $split = $split[0] . $dots;

      $return_string .= "
        <a href='messages.php?u=$username' style='outline: none;'>
        <div class='user_found_messages' style='" . $style . "'>
          <h3 class='heading'>
            <img src='" . $user_found_obj->getProfilePic() . "' class='avatar' />
            <span class='ml-3 text-primary'>" . $user_found_obj->getFirstAndLastName() . "</span>
            <small class='text-muted'> - " . $latest_msg_details[1] . "</small>
            <div class='text-left ml-2 mt-4'>
              <small>" . $split . "</small>
            </div>
          </h3>
          </div>
          <hr class='my-4' />
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
        <div class='alert alert-primary' role='alert'>
          <small>
            No more messages to load !
          </small>
        </div>
      ";
    }

    return $return_string;
  }
}
?>