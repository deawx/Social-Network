<?php
include_once("includes/header.php");

if(isset($_GET['profile_username'])) {
   $username = $_GET['profile_username'];
   $user_infos = mysqli_query($con, "SELECT * FROM users WHERE (username='$username')");
   $user = mysqli_fetch_array($user_infos);
   $num_friends = (substr_count($user['friend_array'], ",")) - 1;
}

?>

<div>
   <img src="<?php echo $user['profile_pic']; ?>">
   <?php echo $username;?>
   <br />
   <?php echo "Posts :" . $user['num_posts']; ?>
   <br />
   <?php echo "Friends :" . $num_friends; ?>
   <br />
   <?php echo "Likes :" . $user['num_likes']; ?>
</div>