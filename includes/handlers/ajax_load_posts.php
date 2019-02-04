<?php

require_once("../../config/config.php");
require_once("../classes/Post.php");
require_once("../classes/User.php");

$limit = 10;

$posts = new Post($con, $_REQUEST['$userLoggedIn']);
$posts->loadPostsFriends();

?>