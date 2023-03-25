jQuery(document).ready(function ($) {
  let value;
  $("#smile, #straight, #sad").click(function (event) {
    event.preventDefault();
    console.log("clicked");
    value = $("#post-value").val();
    $.ajax({
      url: ajaxUrl,
      type: "POST",
      data: {
        action: "update_reaction_value",
        column_name: $(this).attr("id"),
        post_id: value,
      },
      success: function (response) {
        $("#reaction-section").html(response);
      },
      error: function (response) {
        console.log(response);
      },
    });
  });
});
