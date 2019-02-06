<?php

include_once("../../config/config.php");
include_once("../classes/User.php");
include_once("../classes/Post.php");

$limit = 10;

$posts = new Post($con, $_REQUEST['userLoggedIn']);
$posts->loadPostsFriends($_REQUEST, $limit);

?>