$(document).ready(function() {
  setRating("first");
  setPublisherTextOnClickListener();
  setRating("rating");
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
