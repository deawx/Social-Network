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
    <div class="container-fluid mt--3">
      <div class="row">
        <div class="col-xl-4 order-xl-2 mb-5 mb-xl-0">
          <div class="card card-profile shadow">
            <div class='card-header bg-white border-0'>
              <div class='row align-items-center'>
                <div class='col-12'>
                  <h6 class='heading-small mb-0'>
                    Conversations :
                  </h6>
                </div>
              </div>
            </div>

            <div class='card-body bg-secondary border-0'>
              <div class='p-3'>
                <?php
                  echo $message_obj->getConvers();
                ?>
              
              <div style="text-align: center;">
                <a href="messages.php?u=new" class="btn btn-lg btn-primary mt-1 mb--2" >
                  <span class="btn-inner--text" style="color: #fff;">
                    New Message
                  </span>
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>

        <?php
          if($user_to != "new") {
            echo " 
              <div class='col-xl-8 order-xl-1'>
                <div class='card bg-secondary shadow'>
                  <div class='card-header bg-white border-0'>
                    <div class='row align-items-center'>
                      <div class='col-8'>
                        <h6 class='heading-small mb-0'>
                          You and <a href='$user_to' style='outline: none;'>" . $user_to_obj->getFirstAndLastName() . "</a>
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
                <div class='col-xl-8 order-xl-1'>
                  <div class='card bg-secondary shadow'>
                    <div class='card-header bg-white border-0'>
                      <div class='row align-items-center'>
                        <div class='col-8'>
                          <h6 class='heading-small mb-0'>
                            Select the friend you would like to message.
                          </h6>
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
                      echo "
                        <div class='card-body border-0'>
                          <div class='form-group'>
                            <label for=''>TO :</label>
                            
                            <div class='input-group input-group-alternative mb-4'>
                              <div class='input-group-prepend'>
                                <span class='input-group-text'>
                                  <i class='ni ni-single-02'></i>
                                </span>
                              </div>
                              
                              <input class='form-control form-control-alternative' placeholder='Enter the name' 
                                     type='text' name='q' onkeyup='getUser(this.value, <?php echo $userLoggedIn; ?>)'
                                     id='search_text_input' autocomplete='off' />
                            </div>
                          </div>
                          <div class='results'></div>
                        </div>
                      ";
                    } else {
                      echo 
                        "<div class='row justify-content-md-center'>
                          <div class='pl-lg-5 ml--2 col-10'>
                            <div class='form-group mr-4 mt--3'>
                              <textarea rows='3' class='form-control form-control-alternative' name='msg_body' placeholder='Write your message ...'></textarea>
                            </div>
                          </div>

                          <div class='col-2 mt-2'>
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