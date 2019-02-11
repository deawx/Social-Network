<?php

require_once("config/config.php");
require_once("includes/form_handlers/register_handler.php");
require_once("includes/form_handlers/login_handler.php");

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

  <title>Social Network - Login</title>
</head>

<body class="bg-default">
  <div class="main-content">
    <nav class="navbar navbar-top navbar-horizontal navbar-expand-md navbar-dark">
      <div class="container px-4">

        <button class="navbar-toggler" type="button" data-toggle="collapse" 
                data-target="#navbar-collapse-main" aria-controls="navbarSupportedContent"
                aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbar-collapse-main">
          <div class="navbar-collapse-header d-md-none">
            <div class="row">
              <div class="col-6 collapse-close">
                <button type="button" class="navbar-toggler" data-toggle="collapse" 
                        data-target="#navbar-collapse-main" aria-controls="sidenav-main" 
                        aria-expanded="false" aria-label="Toggle sidenav">
                  <span></span>
                  <span></span>
                </button>
              </div>
            </div>
          </div>

          <ul class="navbar-nav ml-auto">
            <li class="nav-item">
              <a class="nav-link nav-link-icon" href="index.php">
                <i class="ni ni-planet"></i>
                <span class="nav-link-inner--text">Home</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link nav-link-icon" href="login.php">
                <i class="fas fa-sign-in-alt"></i>
                <span class="nav-link-inner--text">Sign In</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link nav-link-icon" href="register.php">
                <i class="fas fa-user-plus"></i>
                <span class="nav-link-inner--text">Sign Up</span>
              </a>
            </li>
          </ul>
        </div>
      </div>
    </nav>

    <div class="header bg-gradient-primary py-7 py-lg-8">
      <div class="container">
        <div class="header-body text-center mb-7">
          <div class="row justify-content-center">
            <div class="col-lg-5 col-md-6">
              <h1 class="text-white">Welcome to my Social Network!</h1>
            </div>
          </div>
        </div>
      </div>

      <div class="separator separator-bottom separator-skew zindex-100">
        <svg x="0" y="0" viewBox="0 0 2560 100" preserveAspectRatio="none" version="1.1" xmlns="http://www.w3.org/2000/svg">
          <polygon class="fill-default" points="2560 0 2560 100 0 100"></polygon>
        </svg>
      </div>
    </div>

    <div class="container mt--8 pb-5">
      <div class="row justify-content-center">
        <div class="col-lg-5 col-md-7">
          <div class="card bg-secondary shadow border-0">
            <div class="card-header bg-transparent pb-5">

              <div class="text-muted text-center mt-2 mb-3">
                  Oh! You don't have an account, don't wait any longer !
              </div>

              <div class="btn-wrapper text-center">
                <a href="register.php" class="btn btn-primary btn-icon">
                  <span class="btn-inner--icon"><i class="fas fa-user-plus"></i></span>
                  <span class="btn-inner--text">Create my account</span>
                </a>
              </div>
            </div>

            <div class="card-body px-lg-5 py-lg-5">
              <div class="text-center text-muted mb-4">
                Or sign in now !
              </div>

              <form role="form" action="login.php" method="POST">
                <?php
                  if(in_array("<div class='alert alert-danger text-center' style='margin-bottom: 35px;'><strong>Error! Email or password was incorrect.</strong></div>", $error_array))
                  echo "<div class='alert alert-danger text-center' style='margin-bottom: 35px;'><strong>Error! Email or password was incorrect.</strong></div>";
                ?>

                <div class="form-group">
                  <div class="input-group input-group-alternative">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="ni ni-email-83"></i></span>
                    </div>
                    <input class="form-control" placeholder="Email" type="email" name="log_email"
                           value="<?php if(isset($_SESSION['log_email'])) echo $_SESSION['log_email']; ?>" />
                  </div>
                </div>

                <div class="form-group">
                  <div class="input-group input-group-alternative">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
                    </div>
                    <input class="form-control" placeholder="Password" type="password" name="log_password"
                           value="<?php if(isset($_SESSION['log_password'])) echo $_SESSION['log_password']; ?>" />
                  </div>
                </div>

                <div class="custom-control custom-control-alternative custom-checkbox">
                  <input class="custom-control-input" id="customCheckLogin" type="checkbox">
                  <label class="custom-control-label" for="customCheckLogin">
                    <span class="text-muted">Remember me</span>
                  </label>
                </div>

                <div class="text-center">
                  <button type="submit" name="log_btn" class="btn btn-primary my-4">Sign in</button>
                </div>

              </form>
            </div>
          </div>
          <div class="row mt-3">
            <div class="col-6">
              <a href="#" class="text-light"><small>Forgot password?</small></a>
            </div>
            <div class="col-6 text-right">
              <a href="register.php" class="text-light"><small>Create new account</small></a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
</html>