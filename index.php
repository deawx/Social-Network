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

  <title>MSN - Register</title>
</head>

<body>
  <nav class="navbar navbar-color-on-scroll navbar-transparent fixed-top navbar-expand-lg" color-on-scroll="100" id="sectionsNav">
    <div class="container">
      <div class="navbar-translate">

		    <button class="navbar-toggler" type="button" data-toggle="collapse" aria-expanded="false" aria-label="Toggle navigation">
          <span class="sr-only">Toggle navigation</span>
          <span class="navbar-toggler-icon"></span>
          <span class="navbar-toggler-icon"></span>
          <span class="navbar-toggler-icon"></span>
        </button>
			</div>

      <div class="collapse navbar-collapse">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a href="index.php" class="nav-link"><i class="material-icons">home</i> Home</a>
					</li>

          <li class="nav-item active">
            <a href="register.php" class="nav-link"><i class="material-icons">perm_identity</i> Register</a>
					</li>
        </ul>
      </div>
    </div>
  </nav>

  <div class="page-header header-filter" style="background-image: url('../assets/img/bg2.jpg'); background-size: cover; background-position: top center;">
    <div class="container">
      <div class="container-fluid" style="margin-top: 150px;">

        <?php
					echo ErrorMessage();
					echo SuccessMessage();
        ?>

        <form action="login.php" method="post">
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
                          <i class="material-icons">face</i>
                        </span>
                      </div>
                      <input type="text" id="username" name="Username" class="form-control" placeholder="Username">
                    </div>
                  </span>

                  <span class="bmd-form-group">
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text">
                          <i class="material-icons">email</i>
                        </span>
                      </div>
                      <input type="email" id="email" name="Email" class="form-control" placeholder="Email">
                    </div>
                  </span>

                  <span class="bmd-form-group">
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text">
                          <i class="material-icons">lock_outline</i>
                        </span>
                      </div>
                      <input type="password" id="password" name="Password" class="form-control" placeholder="Password">
                    </div>
                  </span>
                </div>
                <br />
                <div class="card-footer ml-auto mr-auto">
                  <button type="submit" id="submit" name="submit" class="btn btn-rose">Lets Go Now</button>
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>

  <script type="text/javascript" src="../assets/js/lib/jquery.min.js"></script>
  <script type="text/javascript" src="../assets/js/lib/popper.min.js"></script>
  <script type="text/javascript" src="../assets/js/lib/bootstrap-material-design.min.js"></script>
  <script type="text/javascript" src="../assets/js/material-blog.min.js"></script>

</body>
</html>