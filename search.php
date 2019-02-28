<?php

include_once("includes/header.php");

if(isset($_GET['q'])) {
  $query = $_GET['q'];
} else {
  $query = "";
}

if(isset($_GET['type'])) {
  $type = $_GET['type'];
} else {
  $type = "name";
}


?>

  <div class="bg-gradient-primary pb-8 pt-5 pt-md-9">
    <div class="container mt-5">
      <div class="col">
        <div class="card bg-secondary shadow">
          <?php
            if($query == "") {
              echo "
                <div class='card-header border-0'>
                  <div class='row align-items-center'>
                    <div class='col-12'>
                      <h6 class='heading-small mb-0'>
                        Oops an error has occurred !
                      </h6>
                    </div>
                  </div>
                </div>

                <div class='card-body'>
                  <div class='tab-content'>
                    <div class='alert alert-danger alert-dismissible fade show' role='alert' style='font-size: 16px;'>
                      <span class='alert-inner--icon'>
                        <i class='fas fa-exclamation-triangle'></i>
                      </span>
                      <span class='alert-inner--text'>
                        <strong>Error !</strong>
                        <br />
                        You must enter something in the search box ! 
                        <a href='index.php' class='btn-link text-white' style='outline: none;'>Click here to go back.</a>
                      </span>
                    </div>
                  </div>
                </div>
              ";
            } else {
              if($type == "username") {
                $usersReturnedQuery = mysqli_query($con, "SELECT * FROM users 
                                                          WHERE (username LIKE '$query%' AND user_closed='no')
                                                          LIMIT 8");
              } else {
                $names = explode(" ", $query);

                if(count($names) == 3) {
                  $usersReturnedQuery = mysqli_query($con, "SELECT * FROM users 
                                                            WHERE ((first_name LIKE '$names[0]%' AND 
                                                                    last_name LIKE '%$names[2]%') AND 
                                                                    user_closed='no')"); 
                } elseif(count($names) == 3) {
                  $usersReturnedQuery = mysqli_query($con, "SELECT * FROM users 
                                                            WHERE ((first_name LIKE '$names[0]%' AND 
                                                                    last_name LIKE '%$names[1]%') AND 
                                                                    user_closed='no')");
                } else {
                  $usersReturnedQuery = mysqli_query($con, "SELECT * FROM users 
                                                            WHERE ((first_name LIKE '$names[0]%' OR 
                                                                    last_name LIKE '%$names[0]%') AND 
                                                                    user_closed='no')");
                }
              }
            }

            // CHECK IF RESULTS WERE FOUND
            if(mysqli_num_rows($usersReturnedQuery) == 0) {
              echo "
                <div class='card-header border-0'>
                  <div class='row align-items-center'>
                    <div class='col-12'>
                      <h6 class='heading-small mb-0'>
                        No users found !
                      </h6>
                    </div>
                  </div>
                </div>

                <div class='card-body mt-3'>
                  <div class='tab-content'>
                    <div class='alert alert-danger alert-dismissible fade show' role='alert' style='font-size: 16px;'>
                      <span class='alert-inner--icon'>
                        <i class='fas fa-exclamation-triangle'></i>
                      </span>

                      <span class='alert-inner--text'>
                        <strong>Sorry !</strong>
                        <br />
                        We can't find anyone with a " . $type . " like : <strong class='ml-2'>" . $query . "</strong>
                        <br /><br />
                        <a href='index.php' class='btn-link text-white' style='outline: none;'>Click here to go back.</a>
                      </span>
                    </div>
                  </div>
                </div>
              ";
            } else {
              echo "
                <div class='card-header border-0'>
                  <div class='row align-items-center'>
                    <div class='col-12'>
                      <h6 class='heading-small mb-0'>"
                        . mysqli_num_rows($usersReturnedQuery) . " users found
                      </h6>
                    </div>
                  </div>
                </div>

                <div class='card-body mt-3'>
                  <p>Try searching for :</p>
                  <a href='search.php?q=" . $query . "&type=name'>Name</a>, 
                  <a href='search.php?q=" . $query . "&type=username'>Username</a>
                  <hr />
                ";

                while($row = mysqli_fetch_array($usersReturnedQuery)) {
                  $user_obj = new User($con, $user['username']);

                  $button = "";
                  $mutal_friends = "";

                  if($user['username'] != $row['username']) {
                    // GENERATE BTN DEPENDING ON FRIENDSHIP STATUS
                    if($user_obj->isFriend($row['username'])) {
                      $button = "
                        <button type='submit' name='" . $row['username'] . "' class='btn btn-danger btn-icon'>
                          <span class='btn-inner--icon'>
                            <i class='fas fa-user-minus' style='font-size: 15px;'></i>
                          </span>
                          <span class='btn-inner--text'>REMOVE FRIEND</span>
                        </button>
                      ";
                    } elseif($user_obj->didReceiveRequest($row['username'])) {
                      $button = "
                        <button type='submit' name='" . $row['username'] . "' class='btn btn-warning btn-icon'>
                          <span class='btn-inner--icon'>
                            <i class='fas fa-user-clock' style='font-size: 15px;'></i>
                          </span>
                          <span class='btn-inner--text'>RESPOND TO REQUEST</span>
                        </button>
                      ";
                    } elseif($user_obj->didSendRequest($row['username'])) {
                      $button = "
                        <button class='btn btn-neutral btn-icon'>
                          <span class='btn-inner--icon'>
                            <i class='fas fa-handshake' style='font-size: 15px;'></i>
                          </span>
                          <span class='btn-inner--text'>REQUEST SENT</span>
                        </button>
                      ";
                    } else {
                      $button = "
                        <button type='submit' name='" . $row['username'] . "' class='btn btn-primary btn-icon'>
                          <span class='btn-inner--icon'>
                            <i class='fas fa-user-plus' style='font-size: 15px;'></i>
                          </span>
                          <span class='btn-inner--text'>ADD FRIEND</span>
                        </button>
                      ";
                    }

                    $mutal_friends = $user_obj->getMutualFriends($row['username']) . " frirends in common";

                    // BTN FORMS
                    if(isset($_POST[$row['username']])) {
                      if($user_obj->isFriend($row['username'])) {
                        $user_obj->removeFriend($row['username']);
                        header("Location: http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]");
                      } elseif($user_obj->didReceiveRequest($row['username'])) {
                        header("Location: requests.php");
                      } elseif($user_obj->didSendRequest($row['username'])) {
                        // EMPTY
                      } else {
                        $user_obj->sendRequest($row['username']);
                        header("Location: http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]");
                      } 
                    }

                    echo "
                      <div class='p-3'>
                        <div class='row align-items-center'>
                          <div class='col-lg-2 ml-1 mr-1'>
                            <img class='img-fluid rounded-circle shadow-lg' src='" . $row['profile_pic'] . "' />
                          </div>

                          <div class='col-lg-9'>
                            <h3 class='heading mb-0'>
                              <a href='" . $row['username'] ."' style='outline: none;'>
                                " . $row['first_name'] . " " . $row['last_name'] . "
                              </a>
                              <br />
                              <small class='text-muted'>" . $row['username'] . "</small>
                            </h3>

                            <p class='mb-0 mt-3 ml--1'>
                              $mutal_friends
                            </p>
                          </div>

                          <div class='mb--5' style='position: relative; left: 81.5%; top: -13.5vh;'>
                            <form action='' method='POST'>
                              " . $button . "
                            </form>
                          </div>
                        </div>
                      </div>
                      <hr>
                    ";
                  }
                }
              }
            ?>

        </div>
      </div>
    </div>
  </div>
</body>
</html>