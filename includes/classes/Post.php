<?php

class Post {
  private $user_obj;
  private $con;

  public function __construct($con, $user) {
      $this->con = $con;
      $this->user_obj = new User($con, $user); 
  }

  public function submitPost($body, $user_to) {
      $body = strip_tags($body);
      $body = mysqli_escape_string($this->con, $body);
      $check_empty = preg_replace('/\s+/', '', $body);

      if($check_empty != "") {

         // CURRENT DATE & TIME
         $date_added = date("Y-m-d H:i:s");

         // GET USERNAME
         $added_by = $this->user_obj->getUsername();

         // IF USER IS ON OWN PROFILE, $user_to = 'none';
         if($user_to == $added_by) {
            $user_to = "none";
         }

         // INSERT POST
         $query = mysqli_query($this->con, "INSERT INTO posts 
                                            VALUES ('', '$body', '$added_by', '$user_to', '$date_added', 'no', 'no', '0')");

         $returned_id = mysqli_insert_id($this->con);

         // INSERT NOTIFICATION
         if($user_to != 'none') {
           $notification = new Notification($this->con, $added_by);
           $notification->insertNotification($returned_id, $user_to, 'profile_post');
         }

         // UPDATE POST COUNT FOR USER
         $num_posts = $this->user_obj->getNumPosts();
         $num_posts++;
         $update_query = mysqli_query($this->con, "UPDATE users SET num_posts='$num_posts' WHERE (username='$added_by')");
      }
  }

  public function loadPostsFriends($data, $limit) {
    $page = $data['page'];
    $userLoggedIn = $this->user_obj->getUsername();

    if($page == 1) {
       $start = 0;
    } else {
      $start = ($page - 1) * $limit;
    }

    $str = "";
    $data_query = mysqli_query($this->con, "SELECT * FROM posts WHERE (deleted='no') ORDER BY id DESC");

    if(mysqli_num_rows($data_query) > 0) {
      $num_iterations = 0;
      $count = 1;
   
      while($row = mysqli_fetch_array($data_query)) {
        $id = $row['id'];
        $body = $row['body'];
        $added_by = $row['added_by'];
        $date_time = $row['date_added'];

        // PREPARE user_to STRING SO IT CAN BE INCLUDED EVEN IF NOT POSTED TO A USER
        if($row['user_to'] == "none") {
          $user_to = "";
        } else {
          $user_to_obj = new User($this->con, $row['user_to']);
          $user_to_name = $user_to_obj->getFirstAndLastName();
          $user_to = "<span class='text-primary' style='font-size: 22px;'>&#8594;</span> 
                      <a href='" . $row['user_to'] . "'>" . $user_to_name . "</a>";
        }

        // CHECK IF USER WHO POSTED, HAS THEIR ACCOUNT CLOSED
        $added_by_obj = new User($this->con, $added_by);
        if($added_by_obj->isClosed()) {
          continue;
        }

        $user_logged_obj = new User($this->con, $userLoggedIn);
        if($user_logged_obj->isFriend($added_by)) {
          if($num_iterations++ < $start) {
            continue;
          }

          // ONCE $limit POSTS HAVE BEEN LOADED, BREAK
          if($count > $limit) {
            break;
          } else {
            $count++;
          }

          if($userLoggedIn == $added_by) {
            $delete_btn = "
              <button class='btn btn-danger' id='post$id'>
                <i class='fas fa-trash'></i>
              </button>
            ";
          } else {
            $delete_btn = "";
          }

          $user_infos = mysqli_query($this->con, "SELECT first_name, last_name, profile_pic FROM users WHERE (username='$added_by')");
          $user_row = mysqli_fetch_array($user_infos);

          $first_name = $user_row['first_name'];
          $last_name = $user_row['last_name'];
          $profile_pic = $user_row['profile_pic'];

          ?>

          <script>
            function toggle<?php echo $id; ?>() {
              var element = document.getElementById('toggleComment<?php echo $id; ?>');

              if(element.style.display == 'block') {
                element.style.display = 'none';
              } else {
                element.style.display= 'block';
              }
            }
          </script>

          <?php
            $comments_check = mysqli_query($this->con, "SELECT * FROM comments WHERE (post_id='$id')");
            $comments_check_num = mysqli_num_rows($comments_check);

            //TIMEFRAME
            $date_time_now = date("Y-m-d  H:i:s");
            $start_date = new DateTime($date_time);
            $end_date = new DateTime($date_time_now);
            $interval = $start_date->diff($end_date);

            if($interval->y >= 1) {
              if($interval == 1) {
                $time_message = $interval->y . " year ago"; // 1 year
              } else {
                $time_message = $interval->y . " years ago"; // 1+ years
              }
            } elseif($interval->m >= 1) {
              if($interval->d == 0) {
                $days = " ago";
              } elseif($interval->d == 1) {
                $days = $interval->d . " day ago";
              } else {
                $days = $interval->d . " days ago";
              }

              if($interval->m == 1) {
                $time_message = $interval->m . " month" . $days;
              } else {
                $time_message = $interval->m . " months" . $days;
              }
            } elseif($interval->d >= 1) {
              if($interval->d == 1) {
                $time_message = "Yesterday";
              } else {
                $time_message = $interval->d . " days ago";
              }
            } elseif($interval->h >= 1) {
              if($interval->h == 1) {
                $time_message = $interval->h . " hour ago";
              } else {
                $time_message = $interval->h . " hours ago";
              }
            } elseif($interval->i >= 1) {
              if($interval->i == 1) {
                $time_message = $interval->i . " minute ago";
              } else {
                $time_message = $interval->i . " minutes ago";
              }
            } else {
              if($interval->s < 30) {
                $time_message = "Just now";
              } else {
                $time_message = $interval->s . " seconds ago";
              }
            }

            $str .= "
              <div class='status_post'>
                <div class='card-body border-0'>
                  <div class='p-3'>
                    <div class='row align-items-center'>
                      <div class='col-lg-2 ml-1 mr-1'>
                        <img class='img-fluid rounded-circle shadow-lg' src='$profile_pic' />
                      </div>

                      <div class='col-lg-9'>
                        <h3 class='heading mb-0'>
                          <a href='$added_by' style='outline: none;'>$first_name $last_name</a> $user_to
                        </h3>
                        <p class='mb-0 mt-3'>
                          $body
                        </p>
                      </div>
                    </div>
                  </div>
                </div>

                <div class='card-footer bg-secondary border-0 mb--6'>
                  <div class='row'>
                    <div class='col-lg-6 text-left'>
                      <button class='btn btn-primary btn-icon' disabled>
                        <span class='btn-inner--icon'>
                          <i class='fas fa-calendar-day' style='font-size: 20px;'></i>
                        </span>
                        <span class='btn-inner--text'>$time_message</span>
                      </button>
                      $delete_btn

                      <br />
                    </div>

                    <div class='col-lg-5 text-right mr--4'>
                      <button onClick='javascript:toggle$id()' class='btn btn-outline-info btn-icon'>
                        <span class='btn-inner--icon'>
                          <i class='fas fa-comments' style='font-size: 18px;'></i>
                        </span>
                        <span class='btn-inner--text'>$comments_check_num</span>
                      </button>
                    </div>

                    <div class='col-lg-1 text-right'>
                      <iframe style='width: 84px; height=43px; margin-left: 10px;' src='like.php?post_id=$id'></iframe>
                    </div>
                  </div>
                </div>

                <div class='row mt-4'>
                  <div class='col-lg-12 text-center'>
                    <div class='post_comment' id='toggleComment$id' style='display:none;'>
                      <iframe src='comment_frame.php?post_id=$id' id='comment_iframe' frameborder='0' style='width: 100%; height: 285px;'></iframe>
                    </div>
                  </div>
                </div>
              </div>

              <hr class='my-4' />
            "; // END $str
          }
          ?>

          <script>
            $(document).ready(function(){
              $('#post<?php echo $id; ?>').on('click', function() {
                bootbox.confirm("Are you sure you want to delete this post ?", function(result) {
                  $.post("includes/form_handlers/delete_post.php?post_id=<?php echo $id; ?>", {result:result});
                  if(result) {
                    setTimeout(function(){ location.reload(); }, 300);
                  }
                });
              });
            });
          </script>

          <?php

        }

        if($count > $limit) {
          $str .= "
           <input type='hidden' class='nextPage' value='" . ($page + 1) . "' />
           <input type='hidden' class='noMorePosts' value='false' />
          ";
        } else {
          $str .= "
            <input type='hidden' class='noMorePosts' value='true' />
            <div class='alert alert-primary alert-dismissible fade show text-center'>
              <span class='alert-inner--text' style='text-transform: uppercase; font-weight: 600;'>
                 No more posts to show ...
              </span>
           </div>         
          ";
        }
      }
    echo $str;
  }

  public function loadProfilePosts($data, $limit) {
    $page = $data['page'];
    $profileUser = $data['profileUsername'];
    $userLoggedIn = $this->user_obj->getUsername();

    if($page == 1) {
       $start = 0;
    } else {
       $start = ($page - 1) * $limit;
    }

    $str = "";
    $data_query = mysqli_query($this->con, "SELECT * FROM posts 
                                            WHERE (deleted='no' AND ((added_by='$profileUser' AND user_to='none') OR (user_to='$profileUser')))
                                            ORDER BY id DESC");

    if(mysqli_num_rows($data_query) > 0) {
      $num_iterations = 0;
      $count = 1;
 
      while($row = mysqli_fetch_array($data_query)) {
        $id = $row['id'];
        $body = $row['body'];
        $added_by = $row['added_by'];
        $date_time = $row['date_added'];

        if($num_iterations++ < $start) {
          continue;
        }

        // ONCE $limit POSTS HAVE BEEN LOADED, BREAK
        if($count > $limit) {
          break;
        } else {
          $count++;
        }

        if($userLoggedIn == $added_by) {
          $delete_btn = "
            <button class='btn btn-danger' id='post$id'>
              <i class='fas fa-trash'></i>
            </button>";
          } else {
            $delete_btn = "";
          }

          $user_infos = mysqli_query($this->con, "SELECT first_name, last_name, profile_pic FROM users WHERE (username='$added_by')");
          $user_row = mysqli_fetch_array($user_infos);

          $first_name = $user_row['first_name'];
          $last_name = $user_row['last_name'];
          $profile_pic = $user_row['profile_pic'];

          ?>

          <script>
            function toggle<?php echo $id; ?>() {
              var element = document.getElementById('toggleComment<?php echo $id; ?>');

              if(element.style.display == 'block') {
                element.style.display = 'none';
              } else {
                element.style.display= 'block';
              }
            }
          </script>

          <?php
            $comments_check = mysqli_query($this->con, "SELECT * FROM comments WHERE (post_id='$id')");
            $comments_check_num = mysqli_num_rows($comments_check);

            //TIMEFRAME
            $date_time_now = date("Y-m-d  H:i:s");
            $start_date = new DateTime($date_time);
            $end_date = new DateTime($date_time_now);
            $interval = $start_date->diff($end_date);

            if($interval->y >= 1) {
              if($interval == 1) {
                $time_message = $interval->y . " year ago"; // 1 year
              } else {
                $time_message = $interval->y . " years ago"; // 1+ years
              }
            } elseif($interval->m >= 1) {
              if($interval->d == 0) {
                $days = " ago";
              } elseif($interval->d == 1) {
                $days = $interval->d . " day ago";
              } else {
                $days = $interval->d . " days ago";
              }

              if($interval->m == 1) {
                $time_message = $interval->m . " month" . $days;
              } else {
                $time_message = $interval->m . " months" . $days;
              }
            } elseif($interval->d >= 1) {
              if($interval->d == 1) {
                $time_message = "Yesterday";
              } else {
                $time_message = $interval->d . " days ago";
              }
            } elseif($interval->h >= 1) {
              if($interval->h == 1) {
                $time_message = $interval->h . " hour ago";
              } else {
                $time_message = $interval->h . " hours ago";
              }
            } elseif($interval->i >= 1) {
              if($interval->i == 1) {
                $time_message = $interval->i . " minute ago";
              } else {
                $time_message = $interval->i . " minutes ago";
              }
            } else {
              if($interval->s < 30) {
                $time_message = "Just now";
              } else {
                $time_message = $interval->s . " seconds ago";
              }
            }

            $str .= "
              <div class='status_post'>
                <div class='card-body border-0'>
                  <div class='p-3'>
                    <div class='row align-items-center'>
                      <div class='col-lg-2 ml-1 mr-1'>
                        <img class='img-fluid rounded-circle shadow-lg' src='$profile_pic' />
                      </div>

                      <div class='col-lg-9'>
                        <h3 class='heading mb-0'>
                          <a href='$added_by' style='outline: none;'>$first_name $last_name</a>
                        </h3>
                        <p class='mb-0 mt-3'>
                          $body
                        </p>
                      </div>
                    </div>
                  </div>
                </div>

                <div class='card-footer bg-secondary border-0 mb--6'>
                  <div class='row'>
                    <div class='col-lg-6 text-left'>
                      <button class='btn btn-primary btn-icon' disabled>
                        <span class='btn-inner--icon'>
                          <i class='fas fa-calendar-day' style='font-size: 20px;'></i>
                        </span>
                        <span class='btn-inner--text'>$time_message</span>
                      </button>
                      $delete_btn

                      <br />
                    </div>

                    <div class='col-lg-5 text-right mr--4'>
                      <button onClick='javascript:toggle$id()' class='btn btn-outline-info btn-icon'>
                        <span class='btn-inner--icon'>
                          <i class='fas fa-comments' style='font-size: 18px;'></i>
                        </span>
                        <span class='btn-inner--text'>$comments_check_num</span>
                      </button>
                    </div>

                    <div class='col-lg-1 text-right'>
                      <iframe style='width: 84px; height=43px; margin-left: 10px;' src='like.php?post_id=$id'></iframe>
                    </div>
                  </div>
                </div>

                <div class='row mt-4'>
                  <div class='col-lg-12 text-center'>
                    <div class='post_comment' id='toggleComment$id' style='display:none;'>
                      <iframe src='comment_frame.php?post_id=$id' id='comment_iframe' frameborder='0' style='width: 100%; height: 285px;'></iframe>
                    </div>
                  </div>
                </div>
              </div>

              <hr class='my-4' />
            "; // END $str
          ?>

          <script>
            $(document).ready(function() {
              $('#post<?php echo $id; ?>').on('click', function() {
                bootbox.confirm("Are you sure you want to delete this post ?", function(result) {
                  $.post("includes/form_handlers/delete_post.php?post_id=<?php echo $id; ?>", {result:result});
                  if(result) {
                    setTimeout(function(){ location.reload(); }, 300);
                  }
                });
              });
            });
          </script>

        <?php

        } if($count > $limit) {
          $str .= "
            <input type='hidden' class='nextPage' value='" . ($page + 1) . "' />
            <input type='hidden' class='noMorePosts' value='false' />
          ";
        } else {
          $str .= "
            <input type='hidden' class='noMorePosts' value='true' />
            <div class='alert alert-primary alert-dismissible fade show text-center mb-4'>
              <span class='alert-inner--text' style='text-transform: uppercase; font-weight: 600;'>
                No more posts to show ...
              </span>
            </div>         
          ";
        }
      }
    echo $str;
  }

  public function getSinglePost($post_id) {

    $userLoggedIn = $this->user_obj->getUsername();
    $opened_query = mysqli_query($this->con,  "UPDATE notifications SET opened='yes' 
                                               WHERE (user_to='$userLoggedIn' AND link LIKE '%=$post_id')");

    $str = "";
    $data_query = mysqli_query($this->con, "SELECT * FROM posts WHERE (deleted='no' AND id='$post_id')");

    if(mysqli_num_rows($data_query) > 0) {
      $row = mysqli_fetch_array($data_query);
      $id = $row['id'];
      $body = $row['body'];
      $added_by = $row['added_by'];
      $date_time = $row['date_added'];

      // PREPARE user_to STRING SO IT CAN BE INCLUDED EVEN IF NOT POSTED TO A USER
      if($row['user_to'] == "none") {
        $user_to = "";
      } else {
        $user_to_obj = new User($this->con, $row['user_to']);
        $user_to_name = $user_to_obj->getFirstAndLastName();
        $user_to = "<span class='text-primary' style='font-size: 22px;'>&#8594;</span> 
                    <a href='" . $row['user_to'] . "'>" . $user_to_name . "</a>";
      }

      // CHECK IF USER WHO POSTED, HAS THEIR ACCOUNT CLOSED
      $added_by_obj = new User($this->con, $added_by);
      if($added_by_obj->isClosed()) {
        return;
      }

      $user_logged_obj = new User($this->con, $userLoggedIn);
      if($user_logged_obj->isFriend($added_by)) {
        if($userLoggedIn == $added_by) {
          $delete_btn = "
            <button class='btn btn-danger' id='post$id'>
              <i class='fas fa-trash'></i>
            </button>
          ";
        } else {
          $delete_btn = "";
        }

        $user_infos = mysqli_query($this->con, "SELECT first_name, last_name, profile_pic FROM users WHERE (username='$added_by')");
        $user_row = mysqli_fetch_array($user_infos);

        $first_name = $user_row['first_name'];
        $last_name = $user_row['last_name'];
        $profile_pic = $user_row['profile_pic'];

        ?>

        <script>
          function toggle<?php echo $id; ?>() {
            var element = document.getElementById('toggleComment<?php echo $id; ?>');

            if(element.style.display == 'block') {
              element.style.display = 'none';
            } else {
              element.style.display= 'block';
            }
          }
        </script>

        <?php
          $comments_check = mysqli_query($this->con, "SELECT * FROM comments WHERE (post_id='$id')");
          $comments_check_num = mysqli_num_rows($comments_check);

          //TIMEFRAME
          $date_time_now = date("Y-m-d  H:i:s");
          $start_date = new DateTime($date_time);
          $end_date = new DateTime($date_time_now);
          $interval = $start_date->diff($end_date);

          if($interval->y >= 1) {
            if($interval == 1) {
              $time_message = $interval->y . " year ago"; // 1 year
            } else {
              $time_message = $interval->y . " years ago"; // 1+ years
            }
          } elseif($interval->m >= 1) {
            if($interval->d == 0) {
              $days = " ago";
            } elseif($interval->d == 1) {
              $days = $interval->d . " day ago";
            } else {
              $days = $interval->d . " days ago";
            }

            if($interval->m == 1) {
              $time_message = $interval->m . " month" . $days;
            } else {
              $time_message = $interval->m . " months" . $days;
            }
          } elseif($interval->d >= 1) {
            if($interval->d == 1) {
              $time_message = "Yesterday";
            } else {
              $time_message = $interval->d . " days ago";
            }
          } elseif($interval->h >= 1) {
            if($interval->h == 1) {
              $time_message = $interval->h . " hour ago";
            } else {
              $time_message = $interval->h . " hours ago";
            }
          } elseif($interval->i >= 1) {
            if($interval->i == 1) {
              $time_message = $interval->i . " minute ago";
            } else {
              $time_message = $interval->i . " minutes ago";
            }
          } else {
            if($interval->s < 30) {
              $time_message = "Just now";
            } else {
              $time_message = $interval->s . " seconds ago";
            }
          }

          $str .= "
            <div class='card-body border-0'>
              <div class='p-3'>
                <div class='row align-items-center'>
                  <div class='col-lg-2 mr-1'>
                    <img class='img-fluid rounded-circle shadow-lg' src='$profile_pic' />
                  </div>

                  <div class='col-lg-9'>
                    <h3 class='heading mb-0'>
                      <a href='$added_by' style='outline: none;'>$first_name $last_name</a> $user_to
                    </h3>

                    <p class='mb-0 mt-3'>
                      $body
                    </p>
                  </div>
                </div>
              </div>
            </div>

            <div class='card-footer bg-secondary border-0 mb--6'>
              <div class='row'>
                <div class='col-lg-6 text-left'>
                  <button class='btn btn-primary btn-icon ml-1' disabled>
                    <span class='btn-inner--icon'>
                      <i class='fas fa-calendar-day' style='font-size: 20px;'></i>
                    </span>
                    <span class='btn-inner--text'>$time_message</span>
                  </button>
                  $delete_btn
                  <br />
                </div>

                <div class='col-lg-5 text-right mr--4'>
                  <button onClick='javascript:toggle$id()' class='btn btn-outline-info btn-icon'>
                    <span class='btn-inner--icon'>
                      <i class='fas fa-comments' style='font-size: 18px;'></i>
                    </span>
                    <span class='btn-inner--text'>$comments_check_num</span>
                  </button>
                </div>

                <div class='col-lg-1 text-right'>
                  <iframe style='width: 84px; height=43px; margin-left: 10px;' src='like.php?post_id=$id'></iframe>
                </div>
              </div>
            </div>

            <div class='row mt-4'>
              <div class='col-lg-12 text-center'>
                <div class='post_comment' id='toggleComment$id' style='display:none;'>
                  <iframe src='comment_frame.php?post_id=$id' id='comment_iframe' frameborder='0' style='width: 100%; height: 285px;'></iframe>
                </div>
              </div>
            </div>

            <hr class='my-4' />
          ";
        ?>

        <script>
          $(document).ready(function(){
            $('#post<?php echo $id; ?>').on('click', function() {
              bootbox.confirm("Are you sure you want to delete this post ?", function(result) {
                $.post("includes/form_handlers/delete_post.php?post_id=<?php echo $id; ?>", {result:result});
                if(result) {
                  setTimeout(function(){ location.reload(); }, 300);
                }
              });
            });
          });
        </script>

        <?php
        }

        else {
          echo "
            <div class='tab-content mt-4 mb--2'>
              <div id='alerts-disimissible-component' class='fade show active'>
                <div class='alert alert-danger fade show' style='font-size: 16px;'>

                  <span class='alert-inner--icon'>
                    <i class='fas fa-exclamation-triangle mr-2'></i>
                  </span>

                  <span class='alert-inner--text'>
                    <strong>Oops ! An error has occurred.</strong>
                    <br />
                    You cannot see this post because you are not friend with this user.
                    <a href='index.php' class='btn-link' style='color: white; outline: none;'>Click here to go back.</a>
                  </span>
                </div>
              </div>
            </div>
          ";
          return;
        }
      } else {
        echo "
          <div class='tab-content mt-4 mb--2'>
            <div id='alerts-disimissible-component' class='fade show active'>
              <div class='alert alert-danger fade show' style='font-size: 16px;'>

                <span class='alert-inner--icon'>
                  <i class='fas fa-exclamation-triangle mr-2'></i>
                </span>

                <span class='alert-inner--text'>
                  <strong>Oops ! An error has occurred.</strong>
                  <br />
                  No Post found ! If you clicked a link, it may be broken. 
                  <a href='index.php' class='btn-link' style='color: white; outline: none;'>Click here to go back.</a>
                </span>
              </div>
            </div>
          </div>
        ";
        return;
      }
    echo $str;
  }
}

?>