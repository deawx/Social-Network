<?php

require_once("includes/header.php");
//session_destroy();

?>

  <div class="container-fluid mt-7">
    <div class="row">
      <div class="col-xl-3 order-xl-2 mb-4 mb-xl-0">
        <div class="card card-profile shadow">
          <div class="row justify-content-center">
            <div class="col-lg-3 order-lg-2">
              <div class="card-profile-image">
                <a href="#">
                  <img src="<?php echo $user['profile_pic']; ?>" class="rounded-circle">
                </a>
              </div>
            </div>
          </div>

          <div class="card-body pt-0 pt-md-4">
            <div class="row">
              <div class="col">
                <div class="card-profile-stats d-flex justify-content-center mt-md-5">
                  <div>
                    <span class="heading">
                      <i class="fas fa-user-friends"></i>
                    </span>
                    <span class="heading"><?php echo ($user['friend_array']); ?></span>
                  </div>

                  <div>
                    <span class="heading">
                      <i class="fas fa-thumbs-up"></i>
                    </span>
                    <span class="heading"><?php echo $user['num_likes']; ?></span>
                  </div>

                  <div>
                    <span class="heading">
                      <i class="fas fa-comments"></i>
                    </span>
                    <span class="heading"><?php echo $user['num_posts']; ?></span>
                  </div>
                </div>
              </div>
            </div>

            <div class="text-center">
              <h3>
                <a href="#">
                  <?php echo $user['first_name'] . ' ' . $user['last_name']; ?>
                </a>
              </h3>

              <div class="h5 font-weight-300">
                <i class="ni location_pin mr-2"></i>Bucharest, Romania
              </div>

              <div class="h5 mt-4">
                <i class="ni business_briefcase-24 mr-2"></i>Solution Manager - Creative Tim Officer
              </div>

              <div>
                <i class="ni education_hat mr-2"></i>University of Computer Science
              </div>

              <hr class="my-4" />

              <p>Ryan — the name taken by Melbourne-raised, Brooklyn-based Nick Murphy — writes, performs and records all of his own music.</p>
              <a href="#">Show more</a>
            </div>
          </div>
        </div>
      </div>


  <script type="text/javascript" src="assets/js/lib/jquery.min.js"></script>
  <script type="text/javascript" src="assets/js/lib/bootstrap.bundle.min.js"></script>
  <script type="text/javascript" src="assets/js/argon.min.js"></script>

</body>
</html>