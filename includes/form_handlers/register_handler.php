<?php

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
      $email_check = mysqli_query($con, "SELECT email FROM users WHERE (email='$email')");
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
    $username_check = mysqli_query($con, "SELECT username FROM users WHERE (username='$username')");
    $i = 0;

    while(mysqli_num_rows($username_check) != 0) {
      $i++;
      $username = $username . "_" . $i;
      $username_check = mysqli_query($con, "SELECT username FROM users WHERE (username='$username')");
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

    $query = mysqli_query($con, "INSERT INTO users VALUES ('', '$fname', '$lname', '$username', '$email', '$password', '$date', '$profile_pic', '0', '0', 'no', ',')");
    array_push($error_array, "<div class='alert alert-success text-center' style='margin-bottom: 35px;'><strong>Success! Goahead and login !</strong></div>");

    $_SESSION['reg_fname'] = "";
    $_SESSION['reg_lname'] = "";
    $_SESSION['reg_email'] = "";
    $_SESSION['reg_email2'] = "";
  };
};

?>