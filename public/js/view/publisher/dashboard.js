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
    var id = $(this).attr("book-id");
    $.ajax({
      url : "/publisher/delete/book",
      method : "POST",
      data : {
        "id" : id
      }
    }).done(function() {
      window.location.href = "/publisher/dashboard";
    });
  });
  $('.card-book').each(function() {
    var rating = $(this).attr("rating");
    var id = $(this).attr("id");
    rating = Math.floor(rating);
    if (rating >= 1) {
      $('#'+id+' .first-star').attr("src","/image/icon/yellow_star.png");
    }
    if (rating >= 2) {
      $('#'+id+' .second-star').attr("src","/image/icon/yellow_star.png");
    }
    if (rating >= 3) {
      $('#'+id+' .third-star').attr("src","/image/icon/yellow_star.png");
    }
    if (rating >= 4) {
      $('#'+id+' .fourth-star').attr("src","/image/icon/yellow_star.png");
    }
    if (rating == 5) {
      $('#'+id+' .fifth-star').attr("src","/image/icon/yellow_star.png");
    }
  });
  $('.btn-edit-buku').click(function() {
    var id = $(this).attr("book-id");
    window.location.href = "/publisher/edit/book?id="+id;
  });
});