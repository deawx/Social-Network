<?php

require_once("includes/header.php");
//session_destroy();

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
                    <span class="h2 font-weight-bold mb-0"><?php echo ($user['friend_array']); ?></span>
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
        <form>
          <div class="card-header border-0">
            <div class="row align-items-center">
              <div class="col-8">
                <h6 class="heading-small mb-0">Write your message</h6>
              </div>

              <div class="col-4 text-right">
                <button type="submit" class="btn btn-primary btn-icon mb-3 mb-sm-0">
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
                <textarea rows="4" class="form-control form-control-alternative">Post a message ...</textarea>
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

        <div class="card-body border-0">
          <div class="p-3">
            <div class="row align-items-center">
              <div class="col-lg-2 ml-1 mr-1">
                <img class="img-fluid rounded-circle shadow-lg" src="assets/img/profile_pics/defaults/head_alizarin.png" />
              </div>

              <div class="col-lg-8">
                <h3 class="heading mb-0">Echeverria Laurent</h3>
                <p class="mb-0 mt-3">
                  Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque vel scelerisque metus. Fusce porta 
                  interdum est sit amet ultricies. Vivamus rutrum quam a ante aliquet venenatis. Aenean eros turpis, tincidunt 
                  et leo eu, egestas efficitur nunc. Suspendisse a posuere tellus, et volutpat ante.
                </p>
              </div>
            </div>
          </div>
        </div>

        <div class="card-footer bg-secondary border-0">
          <div class="row">
            <div class="col-lg-3 text-left">
              <button type="submit" class="btn btn-primary btn-icon">
                <span class="btn-inner--icon">
                  <i class="fas fa-calendar-day" style="font-size: 20px;"></i>
                </span>
                <span class="btn-inner--text">31 Janv 2019</span>
              </button>
            </div>

            <div class="col-lg-9 text-right">
              <button type="submit" class="btn btn-outline-danger btn-icon">
                <span class="btn-inner--icon">
                  <i class="fas fa-heart" style="font-size: 16px;"></i>
                </span>
                <span class="btn-inner--text">18</span>
              </button>

              <button type="submit" class="btn btn-outline-info btn-icon">
                <span class="btn-inner--icon">
                  <i class="fas fa-comments" style="font-size: 16px;"></i>
                </span>
                <span class="btn-inner--text">10</span>
              </button>
            </div>
          </div>
        </div>
        <hr class="my-4" />

        <div class="card-body border-0">
          <div class="p-3">
            <div class="row align-items-center">
              <div class="col-lg-2 ml-1 mr-1">
                <img class="img-fluid rounded-circle shadow-lg" src="assets/img/profile_pics/defaults/head_pete_river.png" />
              </div>

              <div class="col-lg-8">
                <h3 class="heading mb-0">Marie Poppins</h3>
                <p class="mb-0 mt-3">
                  Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque vel scelerisque metus. Fusce porta 
                  interdum est sit amet ultricies. Vivamus rutrum quam a ante aliquet venenatis. Aenean eros turpis, tincidunt 
                  et leo eu, egestas efficitur nunc. Suspendisse a posuere tellus, et volutpat ante.
                </p>
              </div>
            </div>
          </div>
        </div>

        <div class="card-footer bg-secondary border-0">
          <div class="row">
            <div class="col-lg-3 text-left">
              <button type="submit" class="btn btn-primary btn-icon">
                <span class="btn-inner--icon">
                  <i class="fas fa-calendar-day" style="font-size: 20px;"></i>
                </span>
                <span class="btn-inner--text">30 Janv 2019</span>
              </button>
            </div>

            <div class="col-lg-9 text-right">
              <button type="submit" class="btn btn-outline-danger btn-icon">
                <span class="btn-inner--icon">
                  <i class="fas fa-heart" style="font-size: 16px;"></i>
                </span>
                <span class="btn-inner--text">3</span>
              </button>

              <button type="submit" class="btn btn-outline-info btn-icon">
                <span class="btn-inner--icon">
                  <i class="fas fa-comments" style="font-size: 16px;"></i>
                </span>
                <span class="btn-inner--text">9</span>
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script type="text/javascript" src="assets/js/lib/jquery.min.js"></script>
  <script type="text/javascript" src="assets/js/lib/bootstrap.bundle.min.js"></script>
  <script type="text/javascript" src="assets/js/argon.min.js"></script>

</body>
</html>