<?php

require_once("includes/database.php");
require_once("includes/form_handlers/register_handler.php");

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no" />

  <link rel="stylesheet" type="text/css" href="assets/css/nucleo.css" />
  <link rel="stylesheet" type="text/css" href="assets/css/argon.min.css" />

  <title>Material Social Network - Register</title>
</head>

<body class="bg-default">
  <div class="main-content">
    <div class="header bg-gradient-primary py-7 py-lg-8">
      <div class="separator separator-bottom separator-skew zindex-100">
        <svg x="0" y="0" viewBox="0 0 2560 100">
          <polygon class="fill-default" points="2560 0 2560 100 0 100"></polygon>
        </svg>
      </div>
    </div>

    <div class="container mt--8 pb-5">
      <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8">
          <div class="card bg-secondary shadow border-0">
            <div class="card-body px-lg-5 py-lg-5">
              <form role="form" action="register.php" method="POST">

                <div class="form-group">
                  <div class="input-group input-group-alternative mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="ni ni-hat-3"></i></span>
                    </div>
                    <input class="form-control" placeholder="First Name" type="text" name="reg_fname"
                           value="<?php if(isset($_SESSION['reg_fname'])) echo $_SESSION['reg_fname']; ?>" />
                  </div>

                  <p class="text-danger text-center">
                    <?php 
                      if(in_array("Your first name must be between 3 & 25 characters.", $error_array)) 
                        echo "Your first name must be between 3 & 25 characters.";
                    ?>
                  </p>
                </div>

                <div class="form-group">
                  <div class="input-group input-group-alternative mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="ni ni-hat-3"></i></span>
                    </div>
                    <input class="form-control" placeholder="Last Name" type="text" name="reg_lname"
                           value="<?php if(isset($_SESSION['reg_lname'])) echo $_SESSION['reg_lname']; ?>" />
                  </div>

                  <p class="text-danger text-center">
                    <?php
                      if(in_array("Your last name must be between 3 & 25 characters.", $error_array)) 
                        echo "Your last name must be between 3 & 25 characters.";
                    ?>
                  </p>
                </div>

                <div class="form-group">
                  <div class="input-group input-group-alternative mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="ni ni-email-83"></i></span>
                    </div>
                    <input class="form-control" placeholder="Email" type="email" name="reg_email"
                           value="<?php if(isset($_SESSION['reg_email'])) echo $_SESSION['reg_email']; ?>" />
                  </div>

                  <p class="text-danger text-center">
                    <?php
                      if (in_array("Invalid email format.", $error_array)) echo "Invalid email format.";
                    ?>
                  </p>
                </div>

                <div class="form-group">
                  <div class="input-group input-group-alternative mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="ni ni-email-83"></i></span>
                    </div>
                    <input class="form-control" placeholder="Confirm Email" type="email" name="reg_email2" 
                           value="<?php if(isset($_SESSION['reg_email2'])) echo $_SESSION['reg_email2']; ?>" />
                  </div>

                  <p class="text-danger text-center">
                    <?php 
                      if(in_array("Email already in use.", $error_array)) echo "Email already in use.";
                      elseif (in_array("Email don't match.", $error_array)) echo "Email don't match.";
                    ?>
                  </p>
                </div>

                <div class="form-group">
                  <div class="input-group input-group-alternative">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="ni ni-key-25"></i></span>
                    </div>
                    <input class="form-control" placeholder="Password" type="password" name="reg_password" />
                  </div>

                  <p class="text-danger text-center">
                    <?php
                      if (in_array("Your password must be between 5 & 30 characters.", $error_array)) echo "Your password must be between 5 & 30 characters.";
                      elseif (in_array("Your password can only contain english characters or numbers.", $error_array)) echo "Your password can only contain english characters or numbers.";
                    ?>
                  </p>
                </div>

                <div class="form-group">
                  <div class="input-group input-group-alternative">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
                    </div>
                    <input class="form-control" placeholder="Confirm Password" type="password" name="reg_password2"/>
                  </div>

                  <p class="text-danger text-center">
                    <?php 
                      if(in_array("Your password don't match.", $error_array)) echo "Your password don't match.";
                    ?>
                  </p>
                </div>

                <div class="text-center">
                  <button type="submit" name="reg_btn" class="btn btn-primary mt-4">Create my account</button>
                </div>

                <?php
                  if(in_array("<br /><div class='alert alert-success text-center'><strong>Success! Goahead and login !</strong></div>", $error_array))
                  echo "<br /><div class='alert alert-success text-center'><strong>Success! Goahead and login !</strong></div>";
                ?>
              </form>
            </div>
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