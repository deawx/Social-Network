<?php

include_once("includes/header.php");

$message_obj = new Message($con, $userLoggedIn);

if(isset($_GET['u'])) {
  $user_to = $_GET['u'];
} else {
  $user_to = $message_obj->getMostRecentUser();
  if($user_to == false) {
    $user_to = 'new';
  }
}

if($user_to != "new") {
  $user_to_obj = new User($con, $user_to);
}

if(isset($_POST['post_msg'])) {
  if(isset($_POST['msg_body'])) {
    $body = mysqli_real_escape_string($con, $_POST['msg_body']);
    $date = date("Y-m-d H:i:s");
    $message_obj->sendMessage($user_to, $body, $date);
  }
}
?>

  <div class="header bg-gradient-primary pb-8 pt-5 pt-md-9">
    <div class="container">
      <div class="header-body">
        <div class="row">
    
          <div class="col-xl-4 col-lg-6">
            <div class="card card-stats mb-4 mb-xl-0">
              <div class="card-body">
                <div class="row">
                  <div class="col">
                    <h5 class="card-title text-uppercase text-muted mb-0">Friends</h5>
                    <span class="h2 font-weight-bold mb-0">
                      <?php echo $num_friends; ?>
                    </span>
                  </div>
                  
                  <div class="col-auto">
                    <div class="icon icon-shape bg-yellow text-white rounded-circle shadow">
                      <i class="fas fa-user-friends"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="col-xl-4 col-lg-6">
            <div class="card card-stats mb-4 mb-xl-0">
              <div class="card-body">
                <div class="row">
                  <div class="col">
                    <h5 class="card-title text-uppercase text-muted mb-0">Likes</h5>
                    <span class="h2 font-weight-bold mb-0"><?php echo $user['num_likes']; ?></span>
                  </div>

                  <div class="col-auto">
                    <div class="icon icon-shape bg-danger text-white rounded-circle shadow">
                      <i class="fas fa-heart"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="col-xl-4 col-lg-6">
            <div class="card card-stats mb-4 mb-xl-0">
              <div class="card-body">
                <div class="row">
                  <div class="col">
                    <h5 class="card-title text-uppercase text-muted mb-0">Posts</h5>
                    <span class="h2 font-weight-bold mb-0"><?php echo $user['num_posts']; ?></span>
                  </div>

                  <div class="col-auto">
                    <div class="icon icon-shape bg-info text-white rounded-circle shadow">
                      <i class="fas fa-comments"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <?php
    if($user_to != "new") {
      echo " 
        <div class='container mt-5 mb-5'>
          <div class='row justify-content-md-center'>
            <div class='col-10'>
              <div class='card bg-secondary shadow'>
                <div class='card-header border-0'>
                  <div class='row align-items-center'>
                    <div class='col-12'>
                      <h6 class='heading-small mb-0'>
                        You and <a href='$user_to'>" . $user_to_obj->getFirstAndLastName() . "</a>
                      </h6>
                    </div>
                  </div>
                </div>

                <div class='card-body border-0'>
                  <div class='p-3'>
                    <div class='row align-items-center'>
                      <div class='loaded_messages' id='scroll_messages'>" .
                        $message_obj->getMessages($user_to) . "
                      </div>
                    </div>
                  </div>
                </div>
              ";
            } else {
              echo "
                <div class='container mt-5'>
                  <div class='col'>
                    <div class='card bg-secondary shadow'>
                      <div class='card-header border-0'>
                        <div class='row align-items-center'>
                          <div class='col-12'>
                            <h6 class='heading-small mb-0'>
                              New Message
                            </h6>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              ";
            }
          ?>

          <div class="message_post">
            <form action="" method="POST" >
              <?php
                if($user_to == "new") {
                  echo "Select the friend you would like to message.<br /><br />";
                  echo "TO : <input type='text' />";
                  echo "<div class='results'></div>";
                } else {
                  echo 
                    "<div class='row justify-content-md-center'>
                      <div class='pl-lg-5 ml--2 col-10'>
                        <div class='form-group mr-4'>
                          <textarea rows='3' class='form-control form-control-alternative' name='msg_body' placeholder='Write your message ...'></textarea>
                        </div>
                      </div>

                      <div class='col-2 mt-4'>
                        <button type='submit' name='post_msg' class='btn btn-lg btn-primary btn-icon mb-4'>
                          <span class='btn-inner--icon'>
                            <i class='fas fa-paper-plane'></i>
                          </span>
                          <span class='btn-inner--text'>Send</span>
                        </button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          ";
        }
      ?>
    </form>
  </div>

  <script>
    let div = document.getElementById("scroll_messages");
    div.scrollTop = div.scrollHeight;
  </script>
</body>
</html>  