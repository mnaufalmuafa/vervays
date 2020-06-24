$(document).ready(function() {
  setRating("first");
  setPublisherTextOnClickListener();
  setDateFormat();
  setRating("rating");
  setRatingProgress();
});

function setRating(section) {
  var rating = $('.first-section p.rating').html();
  rating = Math.floor(rating);
  if (rating >= 1) {
    $('.'+section+'-section .first-star').attr("src", "/image/icon/yellow_star.png");
  }
  if (rating >= 2) {
    $('.'+section+'-section .second-star').attr("src","/image/icon/yellow_star.png");
  }
  if (rating >= 3) {
    $('.'+section+'-section .third-star').attr("src","/image/icon/yellow_star.png");
  }
  if (rating >= 4) {
    $('.'+section+'-section .fourth-star').attr("src","/image/icon/yellow_star.png");
  }
  if (rating == 5) {
    $('.'+section+'-section .fifth-star').attr("src","/image/icon/yellow_star.png");
  }
}

function setPublisherTextOnClickListener() {
  $('#publisherText').click(function() {
    var id = $(this).attr("data-id");
    var publisherName = $('#publisherText span').html();
    var publisherSlug = string_to_slug(publisherName);
    window.location.href = "/publisher/info/"+id+"/"+publisherSlug;
  });
}

function setDateFormat() {
  var relaseDate = new Date($('#relaseDate span').html());
  console.log(relaseDate.getDate());
  console.log(relaseDate.getMonth()+1);
  console.log(relaseDate.getFullYear());
  var date = relaseDate.getDate();
  var month = relaseDate.getMonth()+1;
  month = getMonthInBahasa(month);
  var year = relaseDate.getFullYear();
  $('#relaseDate span').html(date+" "+month+" "+year);
}

function getMonthInBahasa(intMonth) {
  switch(intMonth) {
    case 1 : return "Januari";
    case 2 : return "Februari";
    case 3 : return "Maret";
    case 4 : return "April";
    case 5 : return "Mei";
    case 6 : return "Juni";
    case 7 : return "Juli";
    case 8 : return "Agustus";
    case 9 : return "September";
    case 10 : return "Oktober";
    case 11 : return "November";
    case 12 : return "Desember";
  }
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

function setRatingProgress() {
  var id = $('meta[name=book-id]').attr("content");
  $.ajax({
    type : "GET",
    url : "/get/get_people_gave_stars_count_all_rating/"+id,
  }).done(function(data) {
    var ratingAllCount = data;
    // console.log({ ratingAllCount, id });
    setRatingProgressPerRating(id, 5, "fifth", ratingAllCount);
    setRatingProgressPerRating(id, 4, "fourth", ratingAllCount);
    setRatingProgressPerRating(id, 3, "third", ratingAllCount);
    setRatingProgressPerRating(id, 2, "second", ratingAllCount);
    setRatingProgressPerRating(id, 1, "first", ratingAllCount);
  });
}

function setRatingProgressPerRating(id, rating, standing, ratingAllCount) {
  $.ajax({
    type : "GET",
    url : "/get/get_people_gave_stars_count_by_rating/"+id+"/"+rating
  }).done(function(data) {
    // console.log(rating+" : "+data);
    var width = 0;
    if (ratingAllCount != 0) {
      width = (data/ratingAllCount)*100;
    }
    $("#"+standing+"-rating-row .loaded").css("width", width+"%");
    $("#"+standing+"-rating-row p:last-child").html(data);
  });
}