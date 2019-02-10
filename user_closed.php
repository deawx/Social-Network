<?php
include_once("includes/header.php");
?>

<div class="bg-gradient-primary pb-8 pt-5 pt-md-9">
  <div class="container-fluid mt--3">
    <div class="row">
      <div class="col">
        <div class="tab-content mt-7">
          <div id="alerts-disimissible-component" class="tab-pane tab-example-result fade show active"
               role="tabpanel" aria-labelledby="alerts-disimissible-component-tab">
            <div class="alert alert-danger alert-dismissible fade show" role="alert" style="font-size: 16px;">
              <span class="alert-inner--icon">
                <i class="fas fa-user-lock"></i>
              </span>
              <span class="alert-inner--text" >
                <strong>User Closed !</strong>
                This account is closed. <a href="index.php" class="btn-link" style="color: white;">Click here to go back.</a>
              </span>
              <button class="close" type="button" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">x</span>
              </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>