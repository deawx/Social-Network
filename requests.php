<?php include_once("includes/header.php"); ?>

  <div class="bg-gradient-primary pb-8 pt-5 pt-md-9">
    <div class="container mt-5">
      <div class="col">
        <div class="card bg-secondary shadow">
          <div class="card-header border-0">
            <div class="row align-items-center">
              <div class="col-12">
                <h6 class="heading-small mb-0 ml-3">Friend Requests</h6>
              </div>
            </div>
          </div>

          <div class="card-body border-0">
            <div class="container-fluid mt--3">

              <?php
                $query = mysqli_query($con, "SELECT * FROM friend_requests WHERE (user_to='$userLoggedIn')");
                if(mysqli_num_rows($query) == 0) {
                  echo "
                    <div class='tab-content mt-4 mb--2'>
                      <div id='alerts-disimissible-component' class='fade show active'>
                        <div class='alert alert-success fade show' style='font-size: 16px;'>

                          <span class='alert-inner--icon'>
                            <i class='far fa-calendar-check'></i>
                          </span>

                          <span class='alert-inner--text'>
                            <strong>You are up to date !</strong>
                            <br />
                            You have no friend requests at this time ! 
                            <a href='index.php' class='btn-link text-white' style='outline: none;'>Click here to go back.</a>
                          </span>
                        </div>
                      </div>
                    </div>
                  ";
                } else {
                  while($row = mysqli_fetch_array($query)) {
                    $user_from = $row['user_from'];
                    $user_from_obj = new User($con, $user_from);

                    echo "
                      <div class='tab-content mt-4 mb--2'>
                        <div id='alerts-disimissible-component' class='fade show active'>
                          <div class='alert alert-primary fade show' style='font-size: 16px;'>

                            <span class='alert-inner--icon'>
                              <i class='fas fa-user-clock'></i>
                            </span>
                        
                            <span class='alert-inner--text'>
                              <strong>You've got pending requests !</strong>
                              <br />"
                              . $user_from_obj->getFirstAndLastName() . " sent you a friend request !
                            </span>
                          </div>
                        ";

                        $user_from_friend_array = $user_from_obj->getFriendArray();
                        if(isset($_POST['accept_request' . $user_from])) {
                          $add_friend_query = mysqli_query($con, "UPDATE users SET friend_array=CONCAT(friend_array, '$user_from,') 
                                                                  WHERE (username='$userLoggedIn')");

                          $add_friend_query = mysqli_query($con, "UPDATE users SET friend_array=CONCAT(friend_array, '$userLoggedIn,') 
                                                                  WHERE (username='$user_from')");

                          $delete_query = mysqli_query($con, "DELETE FROM friend_requests 
                                                              WHERE (user_to='$userLoggedIn' AND user_from='$user_from')");

                          header("Location: requests.php");
                        }

                        if(isset($_POST['ignore_request' . $user_from])) {
                          $delete_query = mysqli_query($con, "DELETE FROM friend_requests WHERE (user_to='$userLoggedIn' AND user_from='$user_from')");
                          header("Location: requests.php");
                        }
                      ?>

                      <form action="requests.php" method="POST">
                        <button type="submit" name="accept_request<?php echo $user_from; ?>" class="btn btn-success btn-icon">
                          <span class='btn-inner--icon'>
                            <i class='fas fa-user-check' style='font-size: 20px;'></i>
                          </span>
                          <span class='btn-inner--text'> Accept</span>
                        </button>

                        <button type="submit" name="ignore_request<?php echo $user_from; ?>" class="btn btn-danger btn-icon">
                          <span class='btn-inner--icon'>
                            <i class='fas fa-user-times' style='font-size: 20px;'></i>
                          </span>
                          <span class='btn-inner--text'> Ignore</span>
                        </button>
                      </form>
                    </div>
                  </div>

                  <?php
                    }
                  }
                ?>

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
</html>