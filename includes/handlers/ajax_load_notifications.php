<?php

include_once("../../config/config.php");
include_once("../classes/User.php");
include_once("../classes/Notification.php");

$limit = 5;

$notification = new Notification($con, $_REQUEST['userLoggedIn']);
echo $notification->getNotificationDropdown($_REQUEST, $limit);

?>