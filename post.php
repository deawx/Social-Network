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
          <div class="card-header border-0">
            <div class="row align-items-center">
              <div class="col-12">
                <h6 class="heading-small mb-0">Oops ! An error has occurred.</h6>
              </div>
            </div>
          </div>

          <div class="card-body border-0">
            <div class="container-fluid mt--3">
                <div class="col">
                  <div class="tab-content mt-4 mb--2">
                    <div id="alerts-disimissible-component" class="fade show active">
                      <div class="alert alert-danger fade show" role="alert" style="font-size: 16px;">
                        <span class="alert-inner--icon">
                          <i class="fas fa-exclamation-triangle mr-2"></i>
                        </span>

                        <span class="alert-inner--text">
                          <?php
                            $post = new Post($con, $userLoggedIn);
                            $post->getSinglePost($id);
                          ?>
                        </span>
                      </div>
                    </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
</html>