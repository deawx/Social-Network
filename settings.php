<?php

require_once("includes/header.php");
//include_once("includes/settings_handler.php")

?>

<div class="header bg-gradient-primary pb-8 pt-5 pt-md-9">
  <div class="container-fluid mt--3">
    <div class="row">
      <div class="col-xl-4 order-xl-2 mb-5 mb-xl-0">
        <div class="card card-profile shadow">
          <div class="row justify-content-center">
            <div class="col-lg-3 order-lg-2">
              <div class="card-profile-image">
                <a href="upload.php">
                  <img src="<?php echo $user['profile_pic']; ?>" class="rounded-circle">
                </a>
              </div>
            </div>
          </div>

          <div class="card-body pt-0 pt-md-4 mt-4">
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
              <h3>
                <?php
                  $user_obj = new User($con, $userLoggedIn);
                  echo $user_obj->getFirstAndLastName();
                ?>
              </h3>
              
              <div class="h5 font-weight-300">
                <?php echo $user_obj->getUsername(); ?>
              </div>

              <div class="mt-4">
                <span class="font-weight-light">26 years old</span>
              </div>

              <div class="mt-4">
                <span class="font-weight-light">Sare, FRANCE</span>
              </div>

            </div>
          </div>
        </div>
      </div>

      <div class="col-xl-8 order-xl-1">
        <div class="card bg-secondary shadow">
          <div class="card-header bg-white border-0">
            <div class="row align-items-center">
              <div class="col-8">
                <h3 class="heading-small mb-0">My account</h3>
              </div>

              <div class="col-4 text-right">
                <a href="#!" class="btn btn-sm btn-primary">Settings</a>
              </div>
            </div>
          </div>

          <div class="card-body">
            <form action="settings.php" method="POST">
              <h6 class="heading-small text-muted mb-4">User information</h6>
              <div class="pl-lg-4">
                <div class="row">
                  <div class="col-lg-6">
                    <div class="form-group">
                      <label class="form-control-label" for="first_name">First name</label>
                      <input type="text" id="first_name" name="first_name" class="form-control form-control-alternative" 
                             placeholder="<?php echo $user['first_name']; ?>" />
                    </div>
                  </div>

                  <div class="col-lg-6">
                    <div class="form-group">
                      <label class="form-control-label" for="last_name">Last name</label>
                      <input type="text" id="last_name" name="last_name" class="form-control form-control-alternative" 
                             placeholder="<?php echo $user['last_name']; ?>" />
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-lg-12">
                    <div class="form-group">
                      <label class="form-control-label" for="email">Email address</label>
                      <input type="email" id="email" name="email" class="form-control form-control-alternative" 
                             placeholder="<?php echo $user['email']; ?>" />
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-lg-6">
                    <div class="form-group">
                      <label class="form-control-label" for="old_password">Old Password</label>
                      <input type="password" id="old_password" name="old_password" class="form-control form-control-alternative" 
                             placeholder="Old Password" />
                    </div>
                  </div>

                  <div class="col-lg-6">
                    <div class="form-group">
                      <label class="form-control-label" for="new_password">New Password</label>
                      <input type="password" id="new_password" name="new_password" class="form-control form-control-alternative" 
                             placeholder="New Password" />
                    </div>
                  </div>
                </div>
              </div>
            </form>

            <hr class="my-4" />

            <form action="close_account.php" method="POST">
              <h6 class="heading-small text-muted mb-4">Close Account</h6>
              <div class="pl-lg-4">
                <div class="row mr-2">
                  <div class="col-md-12">
                    <button type="submit" id="close_account" name="close_account" class="btn btn-danger btn-lg btn-block">
                      Close Account
                    </button>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
</html>