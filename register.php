<?php

require_once("includes/database.php");
require_once("includes/sessions.php");

$fname = "";
$lname = "";
$email = "";
$email2 = "";
$password = "";
$password = "";
$date = "";
$error_array = array();

if(isset($_POST['reg_btn'])) {
  $fname = strip_tags($_POST['reg_fname']);
  $fname = str_replace(' ', '', $fname);
  $fname = ucfirst(strtolower($fname));
  $_SESSION['reg_fname'] = $fname;

  $lname = strip_tags($_POST['reg_lname']);
  $lname = str_replace(' ', '', $lname);
  $lname = ucfirst(strtolower($lname));
  $_SESSION['reg_lname'] = $lname;

  $email = strip_tags($_POST['reg_email']);
  $email = str_replace(' ', '', $email);
  $email = ucfirst(strtolower($email));
  $_SESSION['reg_email'] = $email;

  $email2 = strip_tags($_POST['reg_email2']);
  $email2 = str_replace(' ', '', $email2);
  $email2 = ucfirst(strtolower($email2));
  $_SESSION['reg_email2'] = $email2;

  $password = strip_tags($_POST['reg_password']);
  $password2 = strip_tags($_POST['reg_password2']);

  $date = date("d-m-Y");

  if($email == $email2) {
    if(filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $em = filter_var($email, FILTER_VALIDATE_EMAIL);
      $email_check = mysqli_query($Connection, "SELECT email FROM users WHERE (email='$email')");
      $num_rows = mysqli_num_rows($email_check);

      if($num_rows > 0) {
        array_push($error_array, "Email already in use.");
      };
    } else {
      array_push($error_array, "Invalid email format.");
    };
  } else {
    array_push($error_array, "Email don't match.");
  };

  if(strlen($fname) < 3 || strlen($fname) > 25) {
    array_push($error_array, "Your first name must be between 3 & 25 characters.");
  };

  if(strlen($lname) < 3 || strlen($lname) > 25) {
    array_push($error_array, "Your last name must be between 3 & 25 characters.");
  };

  if($password !== $password2) {
    array_push($error_array, "Your password don't match.");
  } else {
      if(preg_match('/[^a-zA-Z0-9]/', $password)) {
        array_push($error_array, "Your password can only contain english characters or numbers.");
      };
    };

  if(strlen($password < 5 || $password > 30)) {
    array_push($error_array, "Your password must be between 5 & 30 characters.");
  }
};

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no" />

  <link rel="stylesheet" type="text/css" href="assets/css/fonts.css" />
  <link rel="stylesheet" type="text/css" href="assets/css/material-kit.min.css" />

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
                      <input type="text" id="reg_fname" name="reg_fname" class="form-control" placeholder="First Name"
                             value="<?php if(isset($_SESSION['reg_fname'])) echo $_SESSION['reg_fname']; ?>"
                      />

                      <br />

                      <p class="text-danger text-center">
                        <?php 
                          if(in_array("Your first name must be between 3 & 25 characters.", $error_array)) 
                            echo "Your first name must be between 3 & 25 characters.";
                        ?>
                      </p>
                    </div>
                  </span>

                  <span class="bmd-form-group">
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text">
                          <i class="material-icons">person</i>
                        </span>
                      </div>
                      <input type="text" id="reg_lname" name="reg_lname" class="form-control" placeholder="Last Name"
                             value="<?php if(isset($_SESSION['reg_lname'])) echo $_SESSION['reg_lname']; ?>"
                      />

                      <br />

                      <p class="text-danger text-center">
                        <?php
                          if(in_array("Your last name must be between 3 & 25 characters.", $error_array)) 
                            echo "Your last name must be between 3 & 25 characters.";
                        ?>
                      </p>
                    </div>
                  </span>

                  <span class="bmd-form-group">
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text">
                          <i class="material-icons">mail_outline</i>
                        </span>
                      </div>
                      <input type="email" id="reg_email" name="reg_email" class="form-control" placeholder="Email"
                             value="<?php if(isset($_SESSION['reg_email'])) echo $_SESSION['reg_email']; ?>"
                      />

                      <br />

                      <p class="text-danger text-center">
                        <?php
                          if (in_array("Invalid email format.", $error_array)) echo "Invalid email format.";
                        ?>
                      </p>
                    </div>
                  </span>

                  <span class="bmd-form-group">
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text">
                          <i class="material-icons">email</i>
                        </span>
                      </div>
                      <input type="email" id="reg_email2" name="reg_email2" class="form-control" placeholder="Confirm Email"
                             value="<?php if(isset($_SESSION['reg_email2'])) echo $_SESSION['reg_email2']; ?>"
                      />

                      <br />

                      <p class="text-danger text-center">
                        <?php 
                          if(in_array("Email already in use.", $error_array)) echo "Email already in use.";
                          elseif (in_array("Email don't match.", $error_array)) echo "Email don't match.";
                        ?>
                      </p>
                    </div>
                  </span>

                  <span class="bmd-form-group">
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text">
                          <i class="material-icons">lock_outline</i>
                        </span>
                      </div>
                      <input type="password" id="reg_password" name="reg_password" class="form-control" placeholder="Password" />

                      <br />
                      
                      <p class="text-danger text-center">
                        <?php
                          if (in_array("Your password must be between 5 & 30 characters.", $error_array)) echo "Your password must be between 5 & 30 characters.";
                          elseif (in_array("Your password can only contain english characters or numbers.", $error_array)) echo "Your password can only contain english characters or numbers.";
                        ?>
                      </p>
                    </div>
                  </span>

                  <span class="bmd-form-group">
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text">
                          <i class="material-icons">lock</i>
                        </span>
                      </div>
                      <input type="password" id="reg_password2" name="reg_password2" class="form-control" placeholder="Confirm Password" />

                      <br />

                      <p class="text-danger text-center">
                        <?php 
                          if(in_array("Your password don't match.", $error_array)) echo "Your password don't match.";
                        ?>
                      </p>
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
  <script type="text/javascript" src="assets/js/material-kit.min.js"></script>

</body>
</html>