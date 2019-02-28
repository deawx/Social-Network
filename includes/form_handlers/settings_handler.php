<?php

if(isset($_POST['save_details'])) {
  $first_name = $_POST['first_name'];
  $last_name = $_POST['last_name'];
  $email = $_POST['email'];
  $old_password = $_POST['old_password'];
  $new_password = $_POST['new_password'];

  $email_check = mysqli_query($con, "SELECT * FROM users WHERE (email='$email')");
  $row = mysqli_fetch_array($email_check);

  $matched_user = $row['username'];
  if($matched_user == "" || $matched_user == $userLoggedIn) {
    $query = mysqli_query($con, "UPDATE users 
                                 SET first_name='$first_name', last_name='$last_name', email='$email' 
                                 WHERE (username='$userLoggedIn')");

    header("Location: settings.php");
  } else {
    $message_email = "
      <div class='row mt--3 mb-4 mr-2'>
        <div class='col-md-12'>
          <div class='text-danger'>
            <strong>Error : </strong>That email is already in use !
          </div>
        </div>
      </div>
    ";
  }
} else {
  $message = "";
}

?>