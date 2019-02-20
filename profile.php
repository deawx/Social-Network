<?php

include_once("includes/header.php");

if(isset($_GET['profile_username'])) {
   $username = $_GET['profile_username'];
   $user_infos = mysqli_query($con, "SELECT * FROM users WHERE (username='$username')");
   $user = mysqli_fetch_array($user_infos);
   $num_friends = (substr_count($user['friend_array'], ",")) - 1;
}
if(isset($_POST['remove_friend'])) {
  $user = new User($con, $userLoggedIn);
  $user->removeFriend($username);
  header("Location: $username");
}
if(isset($_POST['add_friend'])) {
  $user = new User($con, $userLoggedIn);
  $user->sendRequest($username);
  header("Location: $username");
}
if(isset($_POST['respond_request'])) {
  header("Location: requests.php");
}
if(isset($_POST['post_btn'])) {
  $post = new Post($con, $_POST['user_from']);
  $post->submitPost($_POST['post_body'], $_POST['user_to']);
}
?>

<div class="header bg-gradient-primary pb-8 pt-5 pt-md-9">
  <div class="container-fluid mt--3">
    <div class="row">
      <div class="col-xl-5 order-xl-2 mb-5 mb-xl-0 ml--3">
        <div class="card card-profile shadow">
          <div class="row justify-content-center">
            <div class="col-lg-3 order-lg-2">
              <div class="card-profile-image">
                <a href="#">
                  <img src="<?php echo $user['profile_pic']; ?>" class="rounded-circle">
                </a>
              </div>
            </div>
          </div>

          <div class="card-header text-center border-0 pt-8 pt-md-4 pb-0 pb-md-4">
            <div class="d-flex justify-content-between">
              <form action="<?php echo $username; ?>" method="POST">
                <?php
                  $profile_user_obj = new User($con, $username);
                  if($profile_user_obj->isClosed()) {
                    header("Location: user_closed.php");
                  }

                  $logged_in_user_obj = new User($con, $userLoggedIn);
                  if($userLoggedIn != $username) {
                    if($logged_in_user_obj->isFriend($username)) {
                      echo "
                        <button type='submit' name='remove_friend' class='btn btn-sm btn-danger btn-icon'>
                          <span class='btn-inner--icon'>
                            <i class='fas fa-user-minus' style='font-size: 15px;'></i>
                          </span>
                          <span class='btn-inner--text'>REMOVE FRIEND</span>
                        </button>
                      "; 
                    } elseif($logged_in_user_obj->didReceiveRequest($username)) {
                      echo "
                        <button type='submit' name='respond_request' class='btn btn-sm btn-warning btn-icon'>
                          <span class='btn-inner--icon'>
                            <i class='fas fa-user-clock' style='font-size: 15px;'></i>
                          </span>
                          <span class='btn-inner--text'>RESPOND TO REQUEST</span>
                        </button>
                      ";
                    } elseif($logged_in_user_obj->didSendRequest($username)) {
                      echo "
                        <button type='submit' name='' class='btn btn-sm btn-neutral btn-icon'>
                          <span class='btn-inner--icon'>
                            <i class='fas fa-handshake' style='font-size: 15px;'></i>
                          </span>
                          <span class='btn-inner--text'>REQUEST SENT</span>
                        </button>
                      ";
                    } else {
                      echo "
                        <button type='submit' name='add_friend' class='btn btn-sm btn-primary btn-icon'>
                          <span class='btn-inner--icon'>
                            <i class='fas fa-user-plus' style='font-size: 15px;'></i>
                          </span>
                          <span class='btn-inner--text'>ADD FRIEND</span>
                        </button>
                      ";
                    }
                  }
                ?>
              </form>

              <?php
               if($userLoggedIn != $username) {
                echo"
                  <a href='messages.php?u=$username' class='btn btn-sm btn-primary btn-icon'>
                    <span class='btn-inner--icon'>
                      <i class='fas fa-paper-plane' style='font-size: 15px;'></i>
                    </span>
                    <span class='btn-inner--text'>SEND MESSAGE</span>
                  </a>
                ";
               } else {
                echo"
                  <a href='messages.php?u=new' class='btn btn-sm btn-primary btn-icon'>
                    <span class='btn-inner--icon'>
                      <i class='fas fa-pen' style='font-size: 15px;'></i>
                    </span>
                    <span class='btn-inner--text'>WRITE MESSAGE</span>
                  </a>
                ";
               }
            ?>
            </div>
          </div>

          <div class="card-body pt-0 pt-md-4">
            <div class="row">
              <div class="col">
                <div class="card-profile-stats d-flex justify-content-center md-5">

                  <div>
                    <span class="heading"><?php echo $num_friends; ?></span>
                    <span class="description">Friends</span>
                  </div>

                  <?php
                    if($userLoggedIn != $username) {
                      echo "
                        <div>
                          <span class='heading'> " .
                            $logged_in_user_obj->getMutualFriends($username) .
                          "</span>
                          <span class='description'>Mutual Friends</span>
                        </div>
                      ";
                    }
                  ?>

                  <div>
                    <span class="heading"><?php echo $user['num_likes']; ?></span>
                    <span class="description">Likes</span>
                  </div>

                  <div>
                    <span class="heading"><?php echo $user['num_posts']; ?></span>
                    <span class="description">Posts</span>
                  </div>
                </div>
              </div>
            </div>

            <div class="text-center">
              <h3>
                <?php
                  $user_obj = new User($con, $username);
                  echo $user_obj->getFirstAndLastName();
                ?>
              </h3>

              <div class="h5 font-weight-300">
                <?php echo $username; ?>
              </div>

              <div class="h5 mt-4">
                <i class="ni business_briefcase-24 mr-2"></i>Solution Manager - Creative Tim Officer
              </div>

            </div>
          </div>
        </div>
      </div>

      <div class="col-xl-7 order-xl-1 ml-2">
        <div class="card bg-secondary shadow">
          <form method="POST" action="<?php echo $username; ?>">
            <div class="card-header bg-white border-0">
              <div class="row align-items-center">
                <div class="col-8">
                  <h3 class="heading-small mb-0">
                    Post a message to your friend
                  </h3>
                </div>
              </div>
            </div>

            <div class="card-body">
              <div class="form-group">
                <textarea rows="6" name="post_body" class="form-control form-control-alternative mt-1">What do you want to tell him?</textarea>
              </div>

              <input type="hidden" name="user_from" value="<?php echo $userLoggedIn; ?>" />
              <input type="hidden" name="user_to" value="<?php echo $username; ?>" />

              <div class="text-right">
                <button type="submit" name="post_btn" id="post_btn" class="btn btn-primary btn-icon  mt-1">
                  <span class="btn-inner--icon">
                    <i class="fas fa-paper-plane"></i>
                  </span>
                  <span class="btn-inner--text">Send Post</span>
                </button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <div class="container-fluid mt-5">
    <div class="col">
      <div class="card bg-secondary shadow">
        <div class="card-header border-0">
          <div class="row align-items-center">
            <div class="col-12">
              <h6 class="heading-small mb-0">Latest Posts</h6>
            </div>
          </div>
        </div>

        <div class="posts_area"></div>
        <img id="loading" src="assets/img/icons/loading.gif" alt="loader" style="max-width: 100px; margin: 0 auto;" />
        
      </div>
    </div>
  </div>

  <script>
    $(document).ready(function() {
      let userLoggedIn = '<?php echo $userLoggedIn; ?>';
      let profileUsername = '<?php echo $username; ?>';
      let inProgress = false;
      loadPosts();

      $(window).scroll(function() {
        let bottomElement = $(".status_post").last();
        let noMorePosts = $('.posts_area').find('.noMorePosts').val();

        if(isElementInView(bottomElement[0]) && noMorePosts == 'false') {
          loadPosts();
        }
      });

      function loadPosts() {
        if(inProgress) {
          return;
        }
 
        inProgress = true;
        $('#loading').show();
        var page = $('.posts_area').find('.nextPage').val() || 1;

        $.ajax({
          url: "includes/handlers/ajax_load_profile_posts.php",
          type: "POST",
          data: "page=" + page + "&userLoggedIn=" + userLoggedIn + "&profileUsername=" + profileUsername,
          cache: false,

          success: function(response) {
            $('.posts_area').find('.nextPage').remove();
            $('.posts_area').find('.noMorePosts').remove();
            $('.posts_area').find('.noMorePostsText').remove();

            $('#loading').hide();
            $(".posts_area").append(response);

            inProgress = false;
          }
        });
      }

      //CHECK IF THE ELEMENT IS IN VIEW
      function isElementInView(element) {
        if(element == null) {
          return;
        }

        let rect = element.getBoundingClientRect();
        return (
          rect.top >= 0 &&
          rect.left >= 0 &&
          rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
          rect.right <= (window.innerWidth || document.documentElement.clientWidth)
        );
      }
    });
  </script>
</body>
</html>