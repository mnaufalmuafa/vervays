$(document).ready(function(){
  setUpBookCard();
  setUpAlert();
});

function setUpBookCard() {
  $('.book-card').each(function() {
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

  $('.book-card').click(function() { //set bookCard onClickListener
    var id = $(this).attr("id");
    var title= $('#'+id+" p.bookTitle").html();
    id = id.replace("book-card-", "");
    id = id.replace("-newest", "");
    id = id.replace("-bestseller", "");
    id = id.replace("-editor-choice", "");
    window.location.href = "/book/detail/"+id+"/"+string_to_slug(title);
  });
}

function setUpAlert() {
  $.ajax({
    url : "/get/flash_messages",
    method : "GET",
  }).done(function(data) {
    console.log(data);
    for (let i = 0; i < data.length; i++) {
      if (data[i].allotmentId == 1) {
        Swal.fire({
          position: 'center',
          icon: 'success',
          title: 'Email berhasil diverifikasi',
          text : 'Anda otomatis login',
          showConfirmButton: true,
          timer: 5000
        })
      }
      else if (data[i].allotmentId == 2) {
        showAlert(data[i].message, data[i].type);
      }
    }
  });
}
function showAlert(message, type) {
  $.notify({
    // options
    message: message
  },{
    // settings
    type: type,
    newest_on_top : true,
  });
}

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