<?php

class Post {
   private $user_obj;
   private $con;

   public function __construct($con, $user) {
      $this->con = $con;
      $this->user_obj = new User($con, $user); 
   }

   public function submitPost($body, $user_to) {
      $body = strip_tags($body);
      $body = mysqli_escape_string($this->con, $body);
      $check_empty = preg_replace('/\s+/', '', $body);

      if($check_empty != "") {
         $date_added = date("d-m-Y H:i:s");
         $added_by = $this->user_obj->getUsername;

      }
   }
}

?>