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
                <button type="submit" class="btn btn-icon btn-3 btn-outline-info">
                  <span class="btn-inner--icon"><i class="fas fa-paper-plane"></i></span>
                  <span class="btn-inner--text">Post</span>
                </button>
              </div>
            </div>
          </div>

          <div class="card-body">
            <div class="pl-lg-4">
              <div class="form-group">
                <textarea rows="4" class="form-control form-control-alternative" placeholder="A few words about you ...">A beautiful Dashboard for Bootstrap 4. It is Free and Open Source.</textarea>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>  

            <div class="pl-lg-4">
              <div class="row">
                <div class="col-lg-6">
                  <div class="form-group">
                    <label class="form-control-label" for="input-username">Username</label>
                    <input type="text" id="input-username" class="form-control form-control-alternative" placeholder="Username" value="lucky.jesse">
                  </div>
                </div>

                <div class="col-lg-6">
                  <div class="form-group">
                    <label class="form-control-label" for="input-email">Email address</label>
                    <input type="email" id="input-email" class="form-control form-control-alternative" placeholder="jesse@example.com">
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-lg-6">
                  <div class="form-group">
                    <label class="form-control-label" for="input-first-name">First name</label>
                    <input type="text" id="input-first-name" class="form-control form-control-alternative" placeholder="First name" value="Lucky">
                  </div>
                </div>

                <div class="col-lg-6">
                  <div class="form-group">
                    <label class="form-control-label" for="input-last-name">Last name</label>
                    <input type="text" id="input-last-name" class="form-control form-control-alternative" placeholder="Last name" value="Jesse">
                  </div>
                </div>
              </div>
            </div>

            <hr class="my-4" />

            <h6 class="heading-small text-muted mb-4">Contact information</h6>
            <div class="pl-lg-4">
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label class="form-control-label" for="input-address">Address</label>
                    <input id="input-address" class="form-control form-control-alternative" placeholder="Home Address" value="Bld Mihail Kogalniceanu, nr. 8 Bl 1, Sc 1, Ap 09" type="text">
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-lg-4">
                  <div class="form-group">
                    <label class="form-control-label" for="input-city">City</label>
                    <input type="text" id="input-city" class="form-control form-control-alternative" placeholder="City" value="New York">
                  </div>
                </div>

                <div class="col-lg-4">
                  <div class="form-group">
                    <label class="form-control-label" for="input-country">Country</label>
                    <input type="text" id="input-country" class="form-control form-control-alternative" placeholder="Country" value="United States">
                  </div>
                </div>

                <div class="col-lg-4">
                  <div class="form-group">
                    <label class="form-control-label" for="input-country">Postal code</label>
                    <input type="number" id="input-postal-code" class="form-control form-control-alternative" placeholder="Postal code">
                  </div>
                </div>
              </div>
            </div>

            <hr class="my-4" />

            <h6 class="heading-small text-muted mb-4">About me</h6>

            <div class="pl-lg-4">
              <div class="form-group">
                <label>About Me</label>
                <textarea rows="4" class="form-control form-control-alternative" placeholder="A few words about you ...">A beautiful Dashboard for Bootstrap 4. It is Free and Open Source.</textarea>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <script type="text/javascript" src="assets/js/lib/jquery.min.js"></script>
  <script type="text/javascript" src="assets/js/lib/bootstrap.bundle.min.js"></script>
  <script type="text/javascript" src="assets/js/argon.min.js"></script>

</body>
</html>