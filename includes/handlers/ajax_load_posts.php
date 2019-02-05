<?php

require_once("../../config/config.php");
require_once("../classes/User.php");
require_once("../classes/Post.php");

$limit = 10;

$posts = new Post($con, $_REQUEST['userLoggedIn']);
$posts->loadPostsFriends($_REQUEST, $limit);

?>