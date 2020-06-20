$(document).ready(function() {
  $('.text-info-book-not-found').hide();
  var keyword = $('meta[name=keyword]').attr("content");
  while (keyword.includes("-", 0)) {
    keyword = keyword.replace('-', ' ');
  }
  $('#keyword span').html(keyword);
  while (keyword.includes(" ", 0)) {
    keyword = keyword.replace(' ', '%20');
  }
  $.ajax({
    url : "/search/book?keyword="+keyword,
    type : "GET"
  }).done(function(data) {
    var arrBook = Object.values(data);
    var template = document.querySelector('#productRow');
    var colBook = document.querySelector("#col-book");
    if (arrBook.length == 0) {
      $('.text-info-book-not-found').show();
    }
    for (var i = 0 ; i < arrBook.length ; i++) {
      var clone = template.content.cloneNode(true);
      var ebookCoverId = arrBook[i].ebookCoverId;
      var ebookCoverFileName = arrBook[i].ebookCoverName;
      var ebookCoverURL = "/ebook/ebook_cover/"+ebookCoverId+"/"+ebookCoverFileName;
      clone.querySelector('.card-book').setAttribute("id", "book-"+arrBook[i].id);
      clone.querySelector('.card-book').setAttribute("rating", arrBook[i].rating);
      clone.querySelector(".ebook-image").setAttribute("src", ebookCoverURL);
      clone.querySelector("h4.book-title").innerHTML = arrBook[i].title;
      clone.querySelector("span.author-text").innerHTML = arrBook[i].author;
      clone.querySelector("p.synopsis").innerHTML = arrBook[i].synopsis;
      clone.querySelector("span.price").innerHTML = arrBook[i].priceForHuman;
      clone.querySelector("span.rating").innerHTML = arrBook[i].rating;
      clone.querySelector("span.ratingCount").innerHTML = arrBook[i].ratingCount;
      clone.querySelector("span.soldCount").innerHTML = arrBook[i].soldCount;
      colBook.appendChild(clone);
    }
    showAllRating();
  });
  ///////////////////////////////////////////////////////////
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

function showAllRating() {
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
}