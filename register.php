<?php

require_once("includes/database.php");
require_once("includes/sessions.php");

$fname = "";
$lname = "";
$email = "";
$email2 = "";
$password = "";
$password2 = "";
$date = "";
$error_array = array();

if(isset($_POST['reg_btn'])) {

//--------------------------------------------------------------------------------- FIRST NAME
  $fname = strip_tags($_POST['reg_fname']);
  $fname = str_replace(' ', '', $fname);
  $fname = ucfirst(strtolower($fname));
  $_SESSION['reg_fname'] = $fname;

  if(strlen($fname) < 3 || strlen($fname) > 25) {
    array_push($error_array, "Your first name must be between 3 & 25 characters.");
  };

//--------------------------------------------------------------------------------- LAST NAME
  $lname = strip_tags($_POST['reg_lname']);
  $lname = str_replace(' ', '', $lname);
  $lname = ucfirst(strtolower($lname));
  $_SESSION['reg_lname'] = $lname;

  if(strlen($lname) < 3 || strlen($lname) > 25) {
    array_push($error_array, "Your last name must be between 3 & 25 characters.");
  };

//--------------------------------------------------------------------------------- EMAIL
  $email = strip_tags($_POST['reg_email']);
  $email = str_replace(' ', '', $email);
  $email = ucfirst(strtolower($email));
  $_SESSION['reg_email'] = $email;

//--------------------------------------------------------------------------------- CONFIRM EMAIL
  $email2 = strip_tags($_POST['reg_email2']);
  $email2 = str_replace(' ', '', $email2);
  $email2 = ucfirst(strtolower($email2));
  $_SESSION['reg_email2'] = $email2;

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

//--------------------------------------------------------------------------------- PASSWORD & DATE
  $password = strip_tags($_POST['reg_password']);
  $password2 = strip_tags($_POST['reg_password2']);

  if($password != $password2) {
    array_push($error_array, "Your password don't match.");
  } else {
    if(preg_match('/[^a-zA-Z0-9]/', $password)) {
      array_push($error_array, "Your password can only contain english characters or numbers.");
    };
  };

  if(strlen($password) < 5 || strlen($password) > 30) {
    array_push($error_array, "Your password must be between 5 & 30 characters.");
  };

  $date = date("d-m-Y");
//--------------------------------------------------------------------------------- USERNAME & PROFILE_PIC
  if(empty($error_array)) {
    $password = md5($password);
    $username = strtolower($fname . "_" . $lname);
    $username_check = mysqli_query($Connection, "SELECT username FROM users WHERE (username='$username')");
    $i = 0;

    while(mysqli_num_rows($username_check) != 0) {
      $i++;
      $username = $username . "_" . $i;
      $username_check = mysqli_query($Connection, "SELECT username FROM users WHERE (username='$username')");
    };

    $rand = rand(1, 16);

    if($rand == 1) $profile_pic = "assets/img/profile_pics/defaults/head_alizarin.png";
    elseif ($rand == 2) $profile_pic = "assets/img/profile_pics/defaults/head_amethyst.png";
    elseif ($rand == 3) $profile_pic = "assets/img/profile_pics/defaults/head_belize_hole.png";
    elseif ($rand == 4) $profile_pic = "assets/img/profile_pics/defaults/head_carrot.png";
    elseif ($rand == 5) $profile_pic = "assets/img/profile_pics/defaults/head_deep_blue.png";
    elseif ($rand == 6) $profile_pic = "assets/img/profile_pics/defaults/head_emerald.png";
    elseif ($rand == 7) $profile_pic = "assets/img/profile_pics/defaults/head_green_sea.png";
    elseif ($rand == 8) $profile_pic = "assets/img/profile_pics/defaults/head_nephritis.png";
    elseif ($rand == 9) $profile_pic = "assets/img/profile_pics/defaults/head_pete_river.png";
    elseif ($rand == 10) $profile_pic = "assets/img/profile_pics/defaults/head_pomegranate.png";
    elseif ($rand == 11) $profile_pic = "assets/img/profile_pics/defaults/head_pumpkin.png";
    elseif ($rand == 12) $profile_pic = "assets/img/profile_pics/defaults/head_red.png";
    elseif ($rand == 13) $profile_pic = "assets/img/profile_pics/defaults/head_sun_flower.png";
    elseif ($rand == 14) $profile_pic = "assets/img/profile_pics/defaults/head_turqoise.png";
    elseif ($rand == 15) $profile_pic = "assets/img/profile_pics/defaults/head_wet_asphalt.png";
    elseif ($rand == 16) $profile_pic = "assets/img/profile_pics/defaults/head_wisteria.png";

    $query = mysqli_query($Connection, "INSERT INTO users VALUES ('', '$fname', '$lname', '$username', '$email', '$password', '$date', '$profile_pic', '0', '0', 'no', ',')");
    array_push($error_array, "<br /><div class='alert alert-success text-center'><strong>Success! Goahead and login !</strong></div>");

    $_SESSION['reg_fname'] = "";
    $_SESSION['reg_lname'] = "";
    $_SESSION['reg_email'] = "";
    $_SESSION['reg_email2'] = "";
  };
};

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