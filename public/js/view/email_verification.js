console.log('ready2');
$(document).ready(function() {
	console.log('ready');
  $('#btnLogout').click(function(event) {
		event.preventDefault();
		console.log('dsg');
    var isLogout = confirm("Apakah yakin ingin logout?");
    if (isLogout) {
      $.ajax({
        url : "/logout",
        method : "POST",
      }).done(function() {
        window.location.href = "/";
      });
    }
  });
});