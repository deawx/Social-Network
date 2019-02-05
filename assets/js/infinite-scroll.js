$(document).ready(function() {
  var userLoggedIn = '<?php echo $userLoggedIn; ?>';
  var inProgress = false;

  loadPosts();

  $(window).scroll(function() {
    var bottomElement = $(".status_post").last();
    var noMorePosts = $('.posts_area').find('.noMorePosts').val();

    if(isElementInView(bottomElement[0]) && noMorePosts == 'false') {
      loadPosts();
    }
  });

  function loadPosts() {
    if(inProgress) {
      return;
    }
 
    inProgress = true;
    $('#loading').show();
 
    var page = $('.posts_area').find('.nextPage').val() || 1;

    $.ajax({
      url: "includes/handlers/ajax_load_posts.php",
      type: "POST",
      data: "page=" + page + "&userLoggedIn=" + userLoggedIn,
      cache: false,

      success: function(response) {
        $('.posts_area').find('.nextPage').remove();
        $('.posts_area').find('.noMorePosts').remove();
        $('.posts_area').find('.noMorePostsText').remove();

        $('#loading').hide();
        $(".posts_area").append(response);

        inProgress = false;
      }
    });
  }

  //CHECK IF THE ELEMENT IS IN VIEW
  function isElementInView(element) {
    if(element == null) {
      return;
    }

    var rect = element.getBoundingClientRect();
    return (
      rect.top >= 0 &&
      rect.left >= 0 &&
      rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
      rect.right <= (window.innerWidth || document.documentElement.clientWidth)
    );
  }
});