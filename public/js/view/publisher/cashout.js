$(document).ready(function() {
  setFormOnSubmitListener();
});

function setFormOnSubmitListener() {
  $("#form").on("submit", function(event) {
    event.preventDefault();
    $.ajax({
      url : "/publisher/post/cashout",
      method : "POST",
      data : {
        amount : $("#inputAmount").val()
      },
      success : function(text) {
        console.log(text);
      },
      failed : function(text) {
        console.log(text);
      }
    }).done(function(res) {
      console.log(res);
      window.location.href = "/publisher/dashboard"
    });
  });
}