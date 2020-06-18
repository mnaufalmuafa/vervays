// const { replace } = require("lodash");

$(document).ready(function() {
  var keyword = $('meta[name=keyword]').attr("content");
  while (keyword.includes("-", 0)) {
    keyword = keyword.replace('-', ' ');
  }
  console.log(keyword);
  $('#keyword span').html(keyword);
  $('#categoryList').collapse('show');
  $('#languageList').collapse('show');
  $('#categoryList').on('hide.bs.collapse', function() {
    var kelas = $('#ic-sort-desc-category').attr('class');
    kelas = kelas.replace('fa-sort-desc','fa-sort-asc');
    $('#ic-sort-desc-category').attr("class", kelas);
  });
  $('#categoryList').on('show.bs.collapse', function() {
    var kelas = $('#ic-sort-desc-category').attr('class');
    kelas = kelas.replace('fa-sort-asc','fa-sort-desc');
    $('#ic-sort-desc-category').attr("class", kelas);
  });
  $('#languageList').on('hide.bs.collapse', function() {
    var kelas = $('#ic-sort-desc-language').attr('class');
    kelas = kelas.replace('fa-sort-desc','fa-sort-asc');
    $('#ic-sort-desc-language').attr("class", kelas);
  });
  $('#languageList').on('show.bs.collapse', function() {
    var kelas = $('#ic-sort-desc-language').attr('class');
    kelas = kelas.replace('fa-sort-asc','fa-sort-desc');
    $('#ic-sort-desc-language').attr("class", kelas);
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
});


/*
jQuery.fn.rotate = function(degrees) {
    $(this).css({'-webkit-transform' : 'rotate('+ degrees +'deg)',
                 '-moz-transform' : 'rotate('+ degrees +'deg)',
                 '-ms-transform' : 'rotate('+ degrees +'deg)',
                 'transform' : 'rotate('+ degrees +'deg)'});
    return $(this);
};

$('.rotate').click(function() {
    rotation += 5;
    $(this).rotate(rotation);
});
*/