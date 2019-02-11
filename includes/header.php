<?php

require_once("config/config.php");
include_once("includes/classes/User.php");
include_once("includes/classes/Post.php");

if(isset($_SESSION['username'])) {
   $userLoggedIn = $_SESSION['username'];
   $user_infos = mysqli_query($con, "SELECT * FROM users WHERE (username='$userLoggedIn')");
   $user = mysqli_fetch_array($user_infos);
   $num_friends = (substr_count($user['friend_array'], ",")) - 1;
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

  <title>Social Network - Dashboard</title>
</head>

<body>
  <div class="main-content">
    <nav class="navbar navbar-top navbar-expand-md navbar-dark" id="navbar-main">
      <div class="container-fluid">

        <a class="h2 mb-0 text-white text-uppercase d-none d-lg-inline-block" href="index.php">My Social Network</a>

        <form class="navbar-search navbar-search-dark form-inline d-none d-md-flex mr-lg-auto ml-lg-auto">
          <div class="form-group mb-0">
            <div class="input-group input-group-alternative">
              <div class="input-group-prepend">
                <span class="input-group-text">
                  <i class="fas fa-search"></i>
                </span>
              </div>
              <input class="form-control" placeholder="Search" type="text">
            </div>
          </div>
        </form>

        <ul class="navbar-nav align-items-center d-none d-md-flex">
        <li class="nav-item">
            <a class="nav-link nav-link-icon" href="" data-toggle="tooltip"
               data-placement="bottom" title="Messages">
              <i style="font-size: 1.25rem;" class="ni ni-email-83"></i>
            </a>
          </li>

          <li class="nav-item">
            <a class="nav-link nav-link-icon" href="" data-toggle="tooltip" 
               data-placement="bottom" title="Notifications">
              <i style="font-size: 1.25rem;" class="ni ni-notification-70"></i>
            </a>
          </li>

          <li class="nav-item dropdown">
            <a class="nav-link pr-0" href="#" role="button" data-toggle="dropdown" 
               aria-haspopup="true" aria-expanded="false">
              <div class="media align-items-center">
                <span class="avatar avatar-sm rounded-circle">
                  <img alt="Image placeholder" src="<?php echo $user['profile_pic']; ?>">
                </span>
                <div class="media-body ml-2 d-none d-lg-block">
                  <span class="mb-0 text-sm font-weight-bold">
                    <?php
                      $user_obj = new User($con, $userLoggedIn);
                      echo $user_obj->getFirstAndLastName();
                    ?>
                  </span>
                </div>
              </div>
            </a>

            <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-right">
              <div class=" dropdown-header noti-title">
                <h6 class="text-overflow m-0">Welcome <?php echo $user['first_name']; ?> !</h6>
              </div>

              <a href="<?php echo $userLoggedIn; ?>" class="dropdown-item">
                <i class="ni ni-settings-gear-65"></i>
                <span>My profile</span>
              </a>

              <a href="requests.php" class="dropdown-item">
                <i class="fas fa-user-friends"></i>
                <span>Friend Requests</span>
              </a>

              <div class="dropdown-divider"></div>

              <a href="includes/handlers/logout.php" class="dropdown-item">
                <i class="ni ni-button-power"></i>
                <span>Logout</span>
              </a>
            </div>
          </li>
        </ul>
      </div>
    </nav>
  </div>
