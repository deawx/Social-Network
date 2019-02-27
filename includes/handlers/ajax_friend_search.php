<?php

include_once("../../config/config.php");
include_once("../classes/User.php");

$query = $_POST['query'];
$userLoggedIn = $_POST['userLoggedIn'];
$names = explode(" ", $query);

if(strpos($query, "_") !== false) {
  $usersReturned = mysqli_query($con, "SELECT * FROM users 
                                       WHERE (username LIKE '$query%') 
                                       AND user_closed='no' 
                                       LIMIT 8");
} elseif(count($names) == 2) {
  $usersReturned = mysqli_query($con, "SELECT * FROM users 
                                       WHERE (first_name LIKE '%$names[0]%' AND last_name LIKE '%$names[1]') 
                                       AND user_closed='no' 
                                       LIMIT 8");
} else {
  $usersReturned = mysqli_query($con, "SELECT * FROM users 
                                       WHERE (first_name LIKE '%$names[0]%' OR last_name LIKE '%$names[0]') 
                                       AND user_closed='no' 
                                       LIMIT 8");
}

if($query != "") {
  while($row = mysqli_fetch_array($usersReturned)) {
    $user = new User($con, $userLoggedIn);

    if($row['username'] != $userLoggedIn) {
      $mutual_friends = $user->getMutualFriends($row['username']) . " friends in common";
    } else {
      $mutual_friends = "";
    }

    if($user->isFriend($row['username']) && ($row['username'] != $userLoggedIn)) {
      echo "
        <a href='messages.php?u=" . $row['username'] . "' style='outline: none;'>
          <h3 class='heading'>
            <img src='" . $row['profile_pic'] . "' class='avatar' />
            <span style='position: relative; top: -1.5vh' class='text-primary ml-2'>"
              . $row['first_name'] . " " . $row['last_name'] .

            "<small class='text-muted'> - "
              . $row['username'] .
            "</small></span>

            <div class='text-left mt--3' style='margin-left:3.9vw;'>
              <small>" . $mutual_friends . "</small>
            </div>
          </h3>
          <hr class='my-4' />
        </a>
      ";
    }
  }
}

?>