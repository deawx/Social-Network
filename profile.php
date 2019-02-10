<?php
include_once("includes/header.php");
include_once("includes/classes/Post.php");

if(isset($_GET['profile_username'])) {
   $username = $_GET['profile_username'];
   $user_infos = mysqli_query($con, "SELECT * FROM users WHERE (username='$username')");
   $user = mysqli_fetch_array($user_infos);
   $num_friends = (substr_count($user['friend_array'], ",")) - 1;
}

?>

<div class="header bg-gradient-primary pb-8 pt-5 pt-md-9">
  <div class="container-fluid mt--3">
    <div class="row">
      <div class="col-xl-4 order-xl-2 mb-5 mb-xl-0">
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
              <a href="#" class="btn btn-sm btn-info mr-4">Connect</a>
              <a href="#" class="btn btn-sm btn-default float-right">Message</a>
            </div>
          </div>

          <div class="card-body pt-0 pt-md-4">
            <div class="row">
              <div class="col">
                <div class="card-profile-stats d-flex justify-content-center mt-md-5">
                  <div>
                    <span class="heading"><?php echo $num_friends; ?></span>
                    <span class="description">Friends</span>
                  </div>

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
              <h3><?php echo $username; ?></h3>
              
              <div class="h5 font-weight-300">
                <i class="ni location_pin mr-2"></i>Sare, France
              </div>

              <div class="h5 mt-4">
                <i class="ni business_briefcase-24 mr-2"></i>Solution Manager - Creative Tim Officer
              </div>

            </div>
          </div>
        </div>
      </div>

      <div class="col-xl-8 order-xl-1">
        <div class="card bg-secondary shadow">
          <form action="<?php echo $username; ?>">
            <?php
              $profile_user_obj = new User($con, $username);

              if($profile_user_obj->isClosed()) {
                heeader("Location: user_closed.php");
              }

              $logged_in_user_obj = new User($con, $userLoggedIn);

              if($userLoggedIn != $username) {
                if($logged_in_user_obj->isFriend($username)) {
                  echo "<input type='submit' name='remove_friend' class='danger' value='remove friend'>"; 
                } elseif($logged_in_user_obj->didReceiveRequest($username)) {
                  echo "<input type='submit' name='respond_request' class='warning' value='Respond to request'>";
                } elseif($logged_in_user_obj->didSendRequest($username)) {
                  echo "<input type='submit' name='' class='default' value='Request Sent'>";
                } else {
                  echo "<input type='submit' name='add_friend' class='success' value='Add Friend'>";
                }
              }
            ?>

            <div class="card-header bg-white border-0">
              <div class="row align-items-center">
                <div class="col-8">
                  <h3 class="mb-0">Profile of <?php echo $username; ?></h3>
                </div>

                <div class="col-4 text-right">
                  <button type='submit' class='btn btn-primary btn-icon'>
                    <span class='btn-inner--icon'>
                      <i class='fas fa-user-plus' style='font-size: 20px;'></i>
                    </span>

                    <span class='btn-inner--text'> Add Firends</span>
                  </button>
                </div>
              </div>
            </div>
          </form>

          <div class="card-body">
            <form>
              <h6 class="heading-small text-muted mb-4">User information</h6>
              <div class="pl-lg-4">
                <div class="row">
                  <div class="col-lg-6">
                    <div class="form-group">
                      <label class="form-control-label" for="input-username">Username</label>
                      <input type="text" id="input-username" class="form-control form-control-alternative" placeholder="Username" value="lucky.jesse">
                    </div>
                  </div>

                  <div class="col-lg-6">
                    <div class="form-group">
                      <label class="form-control-label" for="input-email">Email address</label>
                      <input type="email" id="input-email" class="form-control form-control-alternative" placeholder="jesse@example.com">
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-lg-6">
                    <div class="form-group">
                      <label class="form-control-label" for="input-first-name">First name</label>
                      <input type="text" id="input-first-name" class="form-control form-control-alternative" placeholder="First name" value="Lucky">
                    </div>
                  </div>

                  <div class="col-lg-6">
                    <div class="form-group">
                      <label class="form-control-label" for="input-last-name">Last name</label>
                      <input type="text" id="input-last-name" class="form-control form-control-alternative" placeholder="Last name" value="Jesse">
                    </div>
                  </div>
                </div>
              </div>

              <hr class="my-4" />

              <h6 class="heading-small text-muted mb-4">Contact information</h6>
              <div class="pl-lg-4">
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label class="form-control-label" for="input-address">Address</label>
                      <input id="input-address" class="form-control form-control-alternative" placeholder="Home Address" value="Bld Mihail Kogalniceanu, nr. 8 Bl 1, Sc 1, Ap 09" type="text">
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-lg-4">
                    <div class="form-group">
                      <label class="form-control-label" for="input-city">City</label>
                      <input type="text" id="input-city" class="form-control form-control-alternative" placeholder="City" value="New York">
                    </div>
                  </div>

                  <div class="col-lg-4">
                    <div class="form-group">
                      <label class="form-control-label" for="input-country">Country</label>
                      <input type="text" id="input-country" class="form-control form-control-alternative" placeholder="Country" value="United States">
                    </div>
                  </div>

                  <div class="col-lg-4">
                    <div class="form-group">
                      <label class="form-control-label" for="input-country">Postal code</label>
                      <input type="number" id="input-postal-code" class="form-control form-control-alternative" placeholder="Postal code">
                    </div>
                  </div>
                </div>
              </div>

              <hr class="my-4" />

              <h6 class="heading-small text-muted mb-4">About me</h6>
              <div class="pl-lg-4">
                <div class="form-group">
                  <label>About Me</label>
                  <textarea rows="4" class="form-control form-control-alternative" placeholder="A few words about you ...">A beautiful Dashboard for Bootstrap 4. It is Free and Open Source.</textarea>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script type="text/javascript" src="assets/js/lib/jquery.min.js"></script>
  <script type="text/javascript" src="assets/js/lib/bootstrap.bundle.min.js"></script>
  <script type="text/javascript" src="assets/js/argon.min.js"></script>

</body>
</html>