<?php

include_once("../../config/config.php");
include_once("../classes/User.php");

$query = $_POST['query'];
$userLoggedIn = $_POST['userLoggedIn'];
$names = explode(" ", $query);

?>