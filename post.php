<?php

include_once("includes/header.php");

if(isset($_GET['id'])) {
  $id = $_GET['id'];
} else {
  $id = 0;
}

?>

  <div class="container mt-5">
    <div class="col">
      <div class="card bg-secondary shadow">
        <div class="card-header border-0">
          <div class="row align-items-center">
            <div class="col-12">
              <h6 class="heading-small mb-0">Post</h6>
            </div>
          </div>
        </div>

        <div class='card-body border-0'>
          <div class='p-3'>
            <div class='row align-items-center'>
              <?php
                $post = new Post($con, $userLoggedIn);
                $post->getSinglePost($id);
              ?>
            </div>
          </div>
        </div>
        
      </div>
    </div>
  </div>
</body>
</html>