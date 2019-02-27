<?php

include_once("includes/header.php");

if(isset($_GET['id'])) {
  $id = $_GET['id'];
} else {
  $id = 0;
}

?>
  <div class="bg-gradient-primary pb-8 pt-5 pt-md-9">
    <div class="container mt-5">
      <div class="col">
        <div class="card bg-secondary shadow">
          <div class="card-body border-0">
            <div class="container-fluid mt--3">

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