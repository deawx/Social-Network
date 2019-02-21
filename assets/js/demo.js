function getUser(value, user) {
  $.post("includes/handlers/ajax_friend_search.php", {query:value, userLoggedIn:user}, function(data) {
    $(".results").html(data);
  });
}