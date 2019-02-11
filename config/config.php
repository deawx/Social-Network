<?php

ob_start();
session_start();

$timezone = date_default_timezone_set("Europe/Paris");
$con = mysqli_connect('localhost', 'root', '', 'social');

if(!$con) {
  die('Database connection failed');
};

$db = mysqli_select_db($con, 'social');

if(!$db) {
  die('Database selection failed: ' . mysqli_connect_error($con));
};

?>