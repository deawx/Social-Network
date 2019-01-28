<?php

require_once("includes/database.php");

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no" />

  <link rel="stylesheet" type="text/css" href="assets/css/fonts.css" />
  <link rel="stylesheet" type="text/css" href="assets/css/material.css" />

  <title>Material Social Network - Register</title>
</head>

<body>
  <div class="page-header header-filter" style="background-image: url('assets/img/bg2.jpg'); background-size: cover; background-position: center center;">
    <div class="container">
      <div class="container-fluid" style="margin-top:60px;">

        <form action="register.php" method="POST">
          <div class="row">
            <div class="col-lg-4 col-md-6 col-sm-8 ml-auto mr-auto">
              <div class="card card-login card-hidden">
                <div class="card-header card-header-rose text-center">
                  <h4 class="card-title">Register</h4>
                </div>
              
                <div class="card-body ">
                  <span class="bmd-form-group">
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text">
                          <i class="material-icons">person_outline</i>
                        </span>
                      </div>
                      <input type="text" id="reg_fname" name="reg_fname" class="form-control" placeholder="First Name">
                    </div>
                  </span>

                  <span class="bmd-form-group">
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text">
                          <i class="material-icons">person</i>
                        </span>
                      </div>
                      <input type="text" id="reg_lname" name="reg_lname" class="form-control" placeholder="Last Name">
                    </div>
                  </span>

                  <span class="bmd-form-group">
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text">
                          <i class="material-icons">mail_outline</i>
                        </span>
                      </div>
                      <input type="text" id="reg_email" name="reg_email" class="form-control" placeholder="Email">
                    </div>
                  </span>

                  <span class="bmd-form-group">
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text">
                          <i class="material-icons">email</i>
                        </span>
                      </div>
                      <input type="text" id="reg_email2" name="reg_email2" class="form-control" placeholder="Confirm Email">
                    </div>
                  </span>

                  <span class="bmd-form-group">
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text">
                          <i class="material-icons">lock_outline</i>
                        </span>
                      </div>
                      <input type="reg_password" id="reg_password" name="Password" class="form-control" placeholder="Password">
                    </div>
                  </span>

                  <span class="bmd-form-group">
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text">
                          <i class="material-icons">lock</i>
                        </span>
                      </div>
                      <input type="reg_password2" id="reg_password2" name="Password" class="form-control" placeholder="Confirm Password">
                    </div>
                  </span>
                </div>
                <br />
                <div class="card-footer ml-auto mr-auto">
                  <button type="submit" id="reg_btn" name="reg_btn" class="btn btn-rose">Register Now</button>
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>

  <script type="text/javascript" src="assets/js/lib/jquery.min.js"></script>
  <script type="text/javascript" src="assets/js/lib/popper.min.js"></script>
  <script type="text/javascript" src="assets/js/lib/bootstrap-material-design.min.js"></script>
  <script type="text/javascript" src="assets/js/material.js"></script>

</body>
</html>