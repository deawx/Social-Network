<?php

class User {
   private $user;
   private $con;

   public function __construct($con, $user) {
      $this->con = $con;

      $user_infos = mysqli_query($con, "SELECT * FROM users WHERE (username='$user')");
      $this->user = mysqli_fetch_array($user_infos); 
   }

   public function getFirstAndLastName() {
      $username = $this->user['username'];
      $query = mysqli_query($this->con, "SELECT first_name, last_name FROM users WHERE (username='$username')");
      $row = mysqli_fetch_array($query);
      return $row['first_name'] . " " . $row['last_name'];
   }
}

?>