$(document).ready(function() {
	$('#btnUbahData').click(function() {
		$(location).attr("href", "/publisher/edit");
  });
  $('#btnTambahBuku').click(function() {
    $(location).attr("href", "/publisher/input/book");
  });
  $('.ic-trash').click(function() {
    console.log("hapus");
    confirm("Apakah anda yakin ingin menghapus buku \""+$(this).attr("book-title")+'" ?');
  });
});