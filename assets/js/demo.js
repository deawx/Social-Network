function getUser(value, user) {
  $.post("includes/handlers/ajax_friend_search.php", {query:value, userLoggedIn:user}, function(data) {
    $(".results").html(data);
  });
}

function getDropdownData(user, type) {
  if($(".dropdown-message").css("height") == "0px") {
    var pageName;

    if(type == 'notification') {

    } else if(type == 'message') {
      pageName = "ajax_load_messages.php";
      $("span").remove("#unread_message");
    }

    var ajaxreq = $.ajax({
      url: "includes/handlers/" + pageName,
      type: "POST",
      data: "page=1&userLoggedIn=" + user,
      cache: false,

      success: function(response) {
        $(".dropdown-message").html(response);
        $(".dropdown-message").css({"padding":"0px", "height":"280px"});
        $("#dropdown_data_type").val(type);
      }
    });
  } else {
    $(".dropdown-message").html("");
    $(".dropdown-message").css({"padding":"0px", "height":"0px"}); 
  }
}