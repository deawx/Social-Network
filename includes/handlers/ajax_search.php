<?php

include_once("../../config/config.php");
include_once("../../includes/classes/User.php");

$query = $_POST['query'];
$userLoggedIn = $_POST['userLoggedIn'];
$names = explode(" ", $query);

// IF QUERY CONTAINS AN UNDERSCORE = USERNAME
if(strpos($query, '_') !== false) {
  $usersReturnedQuery = mysqli_query($con, "SELECT * FROM users 
                                            WHERE (username LIKE '$query%' AND user_closed='no')
                                            LIMIT 8");
}

// IF QUERY CONTAINS 2 WORDS = FIRST && LAST NAMES
elseif(count($names) == 2) {
  $usersReturnedQuery = mysqli_query($con, "SELECT * FROM users 
                                            WHERE ((first_name LIKE '$names[0]%' AND last_name LIKE '%$names[1]%') AND user_closed='no')
                                            LIMIT 8");
}

// IF QUERY CONTAINS 1 WORD SEARCH FIRST || LAST NAME
else {
  $usersReturnedQuery = mysqli_query($con, "SELECT * FROM users 
                                            WHERE ((first_name LIKE '$names[0]%' OR last_name LIKE '%$names[0]%') AND user_closed='no')
                                            LIMIT 8");
}

if($query != "") {
  while($row = mysqli_fetch_array($usersReturnedQuery)) {
    $user = new User($con, $userLoggedIn);

    if($row['username'] != $userLoggedIn) {
      $mutual_friends = $user->getMutualFriends($row['username']) . " friends in common";
    } else {
      $mutual_friends = "";
    }

    if($row['username'] != $userLoggedIn) {
    echo "
      <div class='card card-profile shadow'>
        <div class='card-header bg-white border-0' style='border-radius: 30px;'>
          <div class='row align-items-center'>
            <div class='col-12'>
              <h6 class='heading-small mb-0'>
                Friends Found :
              </h6>
            </div>
          </div>
        </div>

        <div class='card-body bg-secondary border-0'>
          <a href='" . $row['username'] . "'>
            <h3 class='heading'>
              <img src='" . $row['profile_pic'] . "' class='avatar' />
              <span style='position: relative; top: -1.5vh' class='text-primary ml-2'>"
                . $row['first_name'] . " " . $row['last_name'] .

                "<small class='text-muted'> - "
                  . $row['username'] .
                "</small>
              </span>

              <div class='text-left mt--3' style='margin-left:3.9vw;'>
                <small class='text-primary'>" . $mutual_friends . "</small>
              </div>
            </h3>
            <hr class='my-4' />
          </a>
        </div>
      </div>
    ";
    } else {
      echo "";
    }
  }
}
?>