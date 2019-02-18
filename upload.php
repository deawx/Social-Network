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
	$uploaddir = $_SERVER['DOCUMENT_ROOT'] . '/assets/img/profile_pics';
  
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
    $msg= "
      <div class='alert alert-success mt-2 mb-4' role='alert'>
        <span class='text-lead'>
          <strong>Success ! </strong>
          Upload Complete.
        </span>
      </div>
    ";
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
      <div class='alert alert-danger mt-2 mb-4' role='alert'>
        <span class='text-lead'>
          <strong>Error ! </strong>
          There was an error uploading the file. Please upload a .jpg, .gif or .png file.
        </span>
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

<div class="header bg-gradient-primary pb-8 pt-5 pt-md-9">
  <div class="container mt--3">
    <div class="col">
      <div class="card bg-secondary shadow">
        <div class="card-header border-0">
          <div class="row align-items-center">
            <div class="col-12">

	            <?php echo $msg; ?>

	            <form action="upload.php" method="post" enctype="multipart/form-data" class="text-center">
                <h4 class="heading-title text-primary mb--4 mt-2">
	                Upload something
                </h4>
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

          <?php
            // IF AN IMAGE HAS BEEN UPLOADED DISPLAY CROPPING AREA
            if($imgSrc) {
          ?>

          <script>
	          $('#Overlay').show();
		        $('#formExample').hide();
	        </script>

          <hr class="mt-5 mb-5" />

          <div class="row align-items-center mb-4">
            <div class="col-6 ml-6">
	            <img src="<?=$imgSrc?>" id="jcrop_target" class="raised" />
	          </div>  

	          <div class="col-4 ml-3 text-center">	        
              <h3 class="heading-title text-primary mb-5">Crop Profile Image</h3>
	              <span class="text-lead">
	                Crop / resize your uploaded profile image.
                  <br /><br />
	                Once you are happy with your profile image then please click save.
	              </span>
	            </p>

              <div style="display: flex; flex-direction: row; flex-wrap: nowrap;
	                        justify-content: center; align-items: center; align-content: center;">

                <form action="upload.php" method="post" onsubmit="return cancelCrop();" class="mt-5">
                  <button type="submit" class="btn btn-danger mr-2">Cancel</button>
                </form>

                <form action="upload.php" method="post" onsubmit="return checkCoords();" class="mt-5">
                  <input type="hidden" id="x" name="x" />
                  <input type="hidden" id="y" name="y" />
                  <input type="hidden" id="w" name="w" />
                  <input type="hidden" id="h" name="h" />
                  <input type="hidden" value="jpeg" name="type" /> <?php // $type; ?> 
                  <input type="hidden" value="<?=$src?>" name="src" />
                  <button type="submit" class="btn btn-success">Save</button>
                </form>
              </div>
            </div>
	          <?php } ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>