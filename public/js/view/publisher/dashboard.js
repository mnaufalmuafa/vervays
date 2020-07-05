$(document).ready(function() {
  setBtnUbahDataOnClickListener();
  setBtnTambahBukuOnClickListener();
  setTrashIconOnClickListener();
  setRating();
  setBtnEditBukuOnClickListener();
  setBtnViewBukuOnClickListener();
});

function string_to_slug (str) {
  str = str.replace(/^\s+|\s+$/g, ''); // trim
  str = str.toLowerCase();

  // remove accents, swap ñ for n, etc
  var from = "àáäâèéëêìíïîòóöôùúüûñç·/_,:;";
  var to   = "aaaaeeeeiiiioooouuuunc------";
  for (var i=0, l=from.length ; i<l ; i++) {
    str = str.replace(new RegExp(from.charAt(i), 'g'), to.charAt(i));
  }

  str = str.replace(/[^a-z0-9 -]/g, '') // remove invalid chars
    .replace(/\s+/g, '-') // collapse whitespace and replace by -
    .replace(/-+/g, '-'); // collapse dashes

  return str;
}

function setBtnUbahDataOnClickListener() {
  $('#btnUbahData').click(function() {
		$(location).attr("href", "/publisher/edit");
  });
}

function setBtnTambahBukuOnClickListener() {
  $('#btnTambahBuku').click(function() {
    $(location).attr("href", "/publisher/input/book");
  });
}

function setTrashIconOnClickListener() {
  $('.ic-trash').click(function() {
    console.log("hapus");
    var wantDelete = confirm("Apakah anda yakin ingin menghapus buku \""+$(this).attr("book-title")+'" ?');
    if (wantDelete) {
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
    }
  });
}

function setRating() {
  $('.card-book').each(function() {
    var rating = $(this).attr("rating");
    var id = $(this).attr("id");
    rating = parseFloat(rating);
    rating = rating.toFixed(1);
    $("#"+id + " .book-rating-container p span:first-child").html(rating);
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
  
}

function setBtnEditBukuOnClickListener() {
  $('.btn-edit-buku').click(function() {
    var id = $(this).attr("book-id");
    window.location.href = "/publisher/edit/book?id="+id;
  });
}

function setBtnViewBukuOnClickListener() {
  $('.btn-view-buku').click(function() {
    var id = $(this).attr("book-id");
    window.location.href = "/book/detail/"+id+"/"+string_to_slug($(this).attr("book-title"));
  });
}