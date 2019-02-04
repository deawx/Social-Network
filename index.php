<?php

require_once("includes/header.php");
require_once("includes/classes/Post.php");

if(isset($_POST['post_btn'])) {
  $post = new POST($con, $userLoggedIn);
  $post->submitPost($_POST['post_text'], 'none');

}

?>

  <div class="header bg-gradient-primary pb-8 pt-5 pt-md-9">
    <div class="container">
      <div class="header-body">
        <div class="row">
    
          <div class="col-xl-4 col-lg-6">
            <div class="card card-stats mb-4 mb-xl-0">
              <div class="card-body">
                <div class="row">
                  <div class="col">
                    <h5 class="card-title text-uppercase text-muted mb-0">Friends</h5>
                    <span class="h2 font-weight-bold mb-0">0<?php echo $user['friend_array']; ?></span>
                  </div>
                  
                  <div class="col-auto">
                    <div class="icon icon-shape bg-yellow text-white rounded-circle shadow">
                      <i class="fas fa-user-friends"></i>
                    </div>
                  </div>
                </div>
                
                <p class="mt-3 mb-0 text-muted text-sm">
                  <span class="text-nowrap">
                    Your last friend added is ...
                  </span>
                </p>
              </div>
            </div>
          </div>

          <div class="col-xl-4 col-lg-6">
            <div class="card card-stats mb-4 mb-xl-0">
              <div class="card-body">
                <div class="row">
                  <div class="col">
                    <h5 class="card-title text-uppercase text-muted mb-0">Likes</h5>
                    <span class="h2 font-weight-bold mb-0"><?php echo $user['num_likes']; ?></span>
                  </div>

                  <div class="col-auto">
                    <div class="icon icon-shape bg-danger text-white rounded-circle shadow">
                      <i class="fas fa-heart"></i>
                    </div>
                  </div>
                </div>

                <p class="mt-3 mb-0 text-muted text-sm">
                  <span class="text-nowrap">
                    Your latest like is ...
                  </span>
                </p>
              </div>
            </div>
          </div>

          <div class="col-xl-4 col-lg-6">
            <div class="card card-stats mb-4 mb-xl-0">
              <div class="card-body">
                <div class="row">
                  <div class="col">
                    <h5 class="card-title text-uppercase text-muted mb-0">Posts</h5>
                    <span class="h2 font-weight-bold mb-0"><?php echo $user['num_posts']; ?></span>
                  </div>

                  <div class="col-auto">
                    <div class="icon icon-shape bg-info text-white rounded-circle shadow">
                      <i class="fas fa-comments"></i>
                    </div>
                  </div>
                </div>

                <p class="mt-3 mb-0 text-muted text-sm">
                  <span class="text-nowrap">
                    Your latest post is ...
                  </span>
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="container mt--6">
    <div class="col">
      <div class="card bg-secondary shadow">
        <form method="POST" action="index.php">
          <div class="card-header border-0">
            <div class="row align-items-center">
              <div class="col-8">
                <h6 class="heading-small mb-0">Write your message</h6>
              </div>

              <div class="col-4 text-right">
                <button type="submit" name="post_btn" id="post_btn" class="btn btn-primary btn-icon mb-3 mb-sm-0">
                  <span class="btn-inner--icon">
                    <i class="fas fa-paper-plane"></i>
                  </span>
                  <span class="btn-inner--text">Send ...</span>
                </button>
              </div>
            </div>
          </div>

          <div class="card-body">
            <div class="pl-lg-4">
              <div class="form-group">
                <textarea rows="4" name="post_text" class="form-control form-control-alternative">Post a message ...</textarea>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>

  <div class="container mt-5">
    <div class="col">
      <div class="card bg-secondary shadow">
        <div class="card-header border-0">
          <div class="row align-items-center">
            <div class="col-12">
              <h6 class="heading-small mb-0">Latest Posts</h6>
            </div>
          </div>
        </div>

        <?php 
          $post = new Post($con, $userLoggedIn);
          $post->loadPostsFriends();
        ?>

      </div>
    </div>
  </div>

  <script type="text/javascript" src="assets/js/lib/jquery.min.js"></script>
  <script type="text/javascript" src="assets/js/lib/bootstrap.bundle.min.js"></script>
  <script type="text/javascript" src="assets/js/argon.min.js"></script>

</body>
</html>