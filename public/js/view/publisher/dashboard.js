$(document).ready(function() {
	$('#btnUbahData').click(function() {
		$(location).attr("href", "/publisher/edit");
  });
  $('#btnTambahBuku').click(function() {
    $(location).attr("href", "/publisher/input/book");
  });
});