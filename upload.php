<?php

include_once("includes/header.php");

$profile_id = $user['username'];
$imgSrc = "";
$result_path = "";
$msg = "";

// REMOVE THE TEMP IMAGE IF IT EXISTS
if(!isset($_POST['x']) && !isset($_FILES['image']['name'])) {
	$temppath = 'assets/img/profile_pics/' . $profile_id . '_temp.jpeg';
  
  if(file_exists ($temppath)) {
    @unlink($temppath);
  }
} 

// UPLOAD ORIGINAL IMAGE TO SERVER
if(isset($_FILES['image']['name'])) {
	
	// GET NAME | SIZE | TEMP LOCATION		    
	$ImageName = $_FILES['image']['name'];
	$ImageSize = $_FILES['image']['size'];
  $ImageTempName = $_FILES['image']['tmp_name'];

	// GET FILE EXT
	$ImageType = @explode('/', $_FILES['image']['type']);
  $type = $ImageType[1];

	// SET UPLOAD DIRECTORY
	$uploaddir = $_SERVER['DOCUMENT_ROOT'] . 'assets/img/profile_pics';
  
  // SET FILE NAME
	$file_temp_name = $profile_id . '_original.' . md5(time()) . 'n' . $type;
	$fullpath = $uploaddir . "/" . $file_temp_name;
	$file_name = $profile_id . '_temp.jpeg';
	$fullpath_2 = $uploaddir . "/" . $file_name;
  
  // MOVE THE FILE TO CORRECT LOCATION
	$move = move_uploaded_file($ImageTempName, $fullpath);
	chmod($fullpath, 0777);

  // CHECK FOR VALID UPLOAD
	if (!$move) {
		die ('File didnt upload');
	} else {
		$imgSrc= "assets/img/profile_pics/" . $file_name;
		$msg= "Upload Complete!";
		$src = $file_name;
	}

	// GET THE UPLOADED IMAGE SIZE
	clearstatcache();
	$original_size = getimagesize($fullpath);
	$original_width = $original_size[0];
	$original_height = $original_size[1];

  // SPECIFY THE NEW SIZE
	$main_width = 500;
	$main_height = $original_height / ($original_width / $main_width);

  // CREATE NEW IMAGE USING CORRECT PHP FUNC			
	if($_FILES["image"]["type"] == "image/gif") {
		$src2 = imagecreatefromgif($fullpath);
  } elseif($_FILES["image"]["type"] == "image/jpeg" || $_FILES["image"]["type"] == "image/pjpeg") {
		$src2 = imagecreatefromjpeg($fullpath);
	} elseif($_FILES["image"]["type"] == "image/png") {
		$src2 = imagecreatefrompng($fullpath);
	} else {
    $msg .= "
      <div class='alert alert-danger alert-dismissible fade show' role='alert'>
        <span class='alert-inner--icon'>
          <i class='fas fa-exclamation-triangle'></i>
        </span>

        <span class='alert-inner--text'>
          <strong>Error ! </strong>
          There was an error uploading the file. Please upload a .jpg, .gif or .png file.
        </span>

        <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
          <span aria-hidden='true'>&times;</span>
        </button>
      </div>
    ";
	}

  // CREATE THE NEW RESIZED IMAGE
	$main = imagecreatetruecolor($main_width, $main_height);
	imagecopyresampled($main, $src2, 0, 0, 0, 0, $main_width, $main_height, $original_width, $original_height);

  // UPLOAD NEW VERSION
	$main_temp = $fullpath_2;
	imagejpeg($main, $main_temp, 100);
	chmod($main_temp,0777);

  // FREE UP MEMORY
	imagedestroy($src2);
	imagedestroy($main);

  // DELETE THE ORIGINAL UPLOAD
	@ unlink($fullpath);
}

// CROPPING & CONVERTING THE IMAGE TO JPG
if(isset($_POST['x'])) {
	$type = $_POST['type'];
	$src = 'assets/img/profile_pics/'.$_POST['src'];
	$finalname = $profile_id.md5(time());

	if($type == 'jpg' || $type == 'jpeg' || $type == 'JPG' || $type == 'JPEG') {

    // THE TARGET DIMENSIONS 150x150
    $targ_w = $targ_h = 150;

		// OUTPUT QUALITY
		$jpeg_quality = 100;
  
    // CREATE A CROPPED COPY OF THE IMAGE
		$img_r = imagecreatefromjpeg($src);
		$dst_r = imagecreatetruecolor($targ_w, $targ_h);

    imagecopyresampled($dst_r, $img_r, 0, 0, $_POST['x'], $_POST['y'], $targ_w, $targ_h, $_POST['w'], $_POST['h']);

    // SAVE THE NEW CROPPED VERSION
		imagejpeg($dst_r, "assets/img/profile_pics/" . $finalname . "n.jpeg", 100);
	} elseif($type == 'png' || $type == 'PNG') {
		$targ_w = $targ_h = 150;
    $jpeg_quality = 100;

		$img_r = imagecreatefrompng($src);
    $dst_r = imagecreatetruecolor($targ_w, $targ_h);

		imagecopyresampled($dst_r, $img_r, 0, 0, $_POST['x'], $_POST['y'], $targ_w, $targ_h, $_POST['w'], $_POST['h']);
		imagejpeg($dst_r, "assets/img/profile_pics/" . $finalname . "n.jpeg", 100);
	} elseif($type == 'gif' || $type == 'GIF') {
		$targ_w = $targ_h = 150;
    $jpeg_quality = 100;

		$img_r = imagecreatefromgif($src);
    $dst_r = imagecreatetruecolor($targ_w, $targ_h);

		imagecopyresampled($dst_r, $img_r, 0, 0, $_POST['x'], $_POST['y'], $targ_w, $targ_h, $_POST['w'], $_POST['h']);
		imagejpeg($dst_r, "assets/img/profile_pics/" . $finalname . "n.jpeg", 100); 	
  }

  // FREE UP MEMORY
	imagedestroy($img_r);
	imagedestroy($dst_r);
	@ unlink($src);

	//RETURN CROPPED IMAGE TO PAGE
	$result_path ="assets/img/profile_pics/".$finalname."n.jpeg";

	//INSERT IMAGE TO DATABASE
	$insert_pic_query = mysqli_query($con, "UPDATE users SET profile_pic='$result_path' WHERE (username='$userLoggedIn')");
	header("Location: " . $userLoggedIn);
}

?>

<div id="Overlay" style=" width:100%; height:100%; border:0px #990000 solid; position:absolute; top:0px; left:0px; z-index:2000; display:none;"></div>
  <div class="header bg-gradient-primary pb-8 pt-5 pt-md-9">
    <div class="container-fluid mt--3">
      <div class="col">
        <div class="card bg-secondary shadow">
          <div class="card-header border-0">
            <div class="row align-items-center">
              <div class="col-12">

	              <?php echo $msg; ?>

	              <form action="upload.php" method="post" enctype="multipart/form-data">
                  <h3 class="heading mb--4 mt-2">
	                  Upload something
                  </h3>
                  <br />
                  <input class="btn btn-neutral mt-4 mb-4" type="file" id="image" name="image" />
                  <br />
                  <button class="btn btn-icon btn-3 btn-primary mt-1 mb-1" type="submit">
	                  <span class="btn-inner--icon">
                      <i class="ni ni-cloud-upload-96"></i>
                    </span>
                    <span class="btn-inner--text">Submit</span>
                  </button>
	              </form>
	            </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <?php
    // IF AN IMAGE HAD BEEN UPLOADED DISPLAY CROPPING AREA
    if($imgSrc) {
  ?>

  <script>
	  $('#Overlay').show();
		$('#formExample').hide();
	</script>

  <div id="CroppingContainer" style="width:800px; max-height:600px; background-color:#FFF; margin-left: -200px; position:relative; overflow:hidden; border:2px #666 solid; z-index:2001; padding-bottom:0px;">  
	  <div id="CroppingArea" style="width:500px; max-height:400px; position:relative; overflow:hidden; margin:40px 0px 40px 40px; border:2px #666 solid; float:left;">	
	    <img src="<?=$imgSrc?>" border="0" id="jcrop_target" style="border:0px #990000 solid; position:relative; margin:0px 0px 0px 0px; padding:0px; " />
	  </div>  

	  <div id="InfoArea" style="width:180px; height:150px; position:relative; overflow:hidden; margin:40px 0px 0px 40px; border:0px #666 solid; float:left;">	
	    <p style="margin:0px; padding:0px; color:#444; font-size:18px;">          
	      <b>Crop Profile Image</b>
        <br /><br />
	      <span style="font-size:14px;">
	        Crop / resize your uploaded profile image.
          <br />
	        Once you are happy with your profile image then please click save.
	      </span>
	    </p>
	  </div>

	  <br />

	  <div id="CropImageForm" style="border: 3px solid red; width:100px; height:30px; float:left; margin:10px 0px 0px 40px;">  
	    <form action="upload.php" method="post" onsubmit="return checkCoords();">
	      <input type="hidden" id="x" name="x" />
	      <input type="hidden" id="y" name="y" />
	      <input type="hidden" id="w" name="w" />
	      <input type="hidden" id="h" name="h" />
	      <input type="hidden" value="jpeg" name="type" /> <?php // $type; ?> 
	      <input type="hidden" value="<?=$src?>" name="src" />
	      <input type="submit" value="Save" style="width:100px; height:30px;" />
	    </form>
	  </div>

	  <div id="CropImageForm2" style="width:100px; height:30px; float:left; margin:10px 0px 0px 40px;">  
	    <form action="upload.php" method="post" onsubmit="return cancelCrop();">
	      <input type="submit" value="Cancel Crop" style="width:100px; height:30px;" />
	    </form>
	  </div>
	</div>
	<?php } ?>
</div>

<?php
  if($result_path) {
?>

  <img src="<?=$result_path?>" style="position:relative; margin:10px auto; width:150px; height:150px;" />
	 
<?php
  }
?>