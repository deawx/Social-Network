<?php

require_once("config/config.php");
include_once("includes/classes/User.php");
include_once("includes/classes/Post.php");
include_once("includes/classes/Message.php");
include_once("includes/classes/Notification.php");

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
  <script type="text/javascript" src="assets/js/bootbox.min.js"></script>
  <script type="text/javascript" src="assets/js/demo.js"></script>
  <script type="text/javascript" src="assets/js/jcrop_bits.js"></script>
  <script type="text/javascript" src="assets/js/jquery.Jcrop.js"></script>

  <link rel="stylesheet" type="text/css" href="assets/css/all.min.css" />
  <link rel="stylesheet" type="text/css" href="assets/css/argon.min.css" />
  <link rel="stylesheet" type="text/css" href="assets/css/jquery.Jcrop.css" />
  <link rel="stylesheet" type="text/css" href="assets/css/nucleo.css" />
  <link rel="stylesheet" type="text/css" href="assets/css/style.css" />

  <title>Social Network - Dashboard</title>
</head>

<body>
  <div class="main-content">
    <nav class="navbar navbar-top navbar-expand-md navbar-dark" id="navbar-main">

      <?php
				//UNREAD MESSAGES
				$messages = new Message($con, $userLoggedIn);
        $num_messages = $messages->getUnreadNumber();

        $notifications = new Notification($con, $userLoggedIn);
				$num_notifications = $notifications->getUnreadNumber();
			?>

      <div class="container-fluid">
        <a class="h2 mb-0 text-white text-uppercase d-none d-lg-inline-block" 
           href="index.php" style="outline: none;"
          >My Social Network
        </a>

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
          <li class="nav-item dropdown">        
			      <a class="nav-link nav-link-icon" data-toggle="dropdown" href="javascript:void(0);" 
               onclick="getDropdownData('<?php echo $userLoggedIn; ?>', 'message')" style='outline: none;'>
              <i style='font-size: 1.25rem;' class='ni ni-email-83'></i>
              <?php
				        if($num_messages > 0) {
                  echo "
                    <span class='badge badge-white' id='unread_message'>" . $num_messages . "</span>
                  ";
                }
				      ?>
			      </a>

            <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-right">
              <div class="dropdown-header mb-2">
                <div class="dropdown_data_window"></div>
                <input type="hidden" id="dropdown_data_type" value="" />
              </div>
            </div>
          </li>

          <li class="nav-item dropdown">        
			      <a class="nav-link nav-link-icon" data-toggle="dropdown" href="javascript:void(0);" 
               onclick="getDropdownData('<?php echo $userLoggedIn; ?>', 'notification')" style='outline: none;'>
              <i style='font-size: 1.25rem;' class='ni ni-notification-70'></i>
              <?php
				        if($num_notifications > 0) {
                  echo "
                    <span class='badge badge-white' id='unread_notification'>" . $num_notifications . "</span>
                  ";
                }
				      ?>
			      </a>

            <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-right">
              <div class="dropdown-header mb-2">
                <div class="dropdown_data_window"></div>
                <input type="hidden" id="dropdown_data_type" value="" />
              </div>
            </div>
          </li>

          <li class="nav-item dropdown">
            <a class="nav-link pr-0" href="#" data-toggle="dropdown" tyle="outline: none;">
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
              <div class="dropdown-body">

                <a href="<?php echo $userLoggedIn; ?>" class="dropdown-item" style="outline: none;">
                  <i class="ni ni-badge"></i>
                  <span>My Profile</span>
                </a>

                <a href="requests.php" class="dropdown-item" style="outline: none;">
                  <i class="fas fa-user-friends"></i>
                  <span>Friend Requests</span>
                </a>

                <a href="setting.php" class="dropdown-item" style="outline: none;">
                  <i class="ni ni-settings-gear-65"></i>
                  <span>My Account</span>
                </a>

                <div class="dropdown-divider"></div>

                <a href="includes/handlers/logout.php" class="dropdown-item" style="outline: none;">
                  <i class="ni ni-button-power"></i>
                  <span>Logout</span>
                </a>
              </div>
            </div>
          </li>
        </ul>
      </div>
    </nav>
  </div>

  <script>
    $(function() {
      let userLoggedIn = '<?php echo $userLoggedIn; ?>';
      let dropdownInProgress = false;

      $(".dropdown_data_window").scroll(function() {
        let bottomElement = $(".dropdown_data_window a").last();
    	  let noMoreData = $(".dropdown_data_window").find(".noMoreDropdownData").val();

        if(isElementInView(bottomElement[0]) && noMoreData == 'false') {
          loadPosts();
        }
      });

      function loadPosts() {
        if(dropdownInProgress) {
    		  return;
    	  }

    	  dropdownInProgress = true;
    	  let page = $('.dropdown_data_window').find('.nextPageDropdownData').val() || 1;
    	  let pageName;
    	  let type = $('#dropdown_data_type').val();

    	  if(type == 'notification') {
    		  pageName = "ajax_load_notifications.php";
        } else if(type == 'message') {
    		  pageName = "ajax_load_messages.php";
        }

    	  $.ajax({
    		  url: "includes/handlers/" + pageName,
    		  type: "POST",
    		  data: "page=" + page + "&userLoggedIn=" + userLoggedIn,
    		  cache:false,

    		  success: function(response) {
    			  $('.dropdown_data_window').find('.nextPageDropdownData').remove();
    			  $('.dropdown_data_window').find('.noMoreDropdownData').remove();
  				  $('.dropdown_data_window').append(response);
  				  dropdownInProgress = false;
    		  }
    	  });
      }

      function isElementInView (el) {
        let rect = el.getBoundingClientRect();

        return (
          rect.top >= 0 && rect.left >= 0 &&
          rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
          rect.right <= (window.innerWidth || document.documentElement.clientWidth)
        );
      }
    });

  </script>