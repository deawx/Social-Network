<?php

include_once("../../config/config.php");
include_once("../classes/User.php");
include_once("../classes/Message.php");

$limit = 5;

$message = new Message($con, $_REQUEST['userLoggedIn']);
echo $message->getConversDropdown($_REQUEST, $limit);

?>