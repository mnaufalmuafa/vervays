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
  firstAjaxRequest(keyword);
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

function showBookList(arrBook) {
  arrBook = sortArrBook(arrBook);
  removeAllBook(arrBook);
  var template = document.querySelector('#productRow');
  var colBook = document.querySelector("#col-book");
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
  setBookOnClickListener(arrBook);
}

function showBookListWithFilter(arrBook) {
  arrBook = sortArrBook(arrBook);
  removeAllBook(arrBook);
  var filteredArrBook = [];
  if ($('#categoryWrapper').val() !== "" && $('#languageWrapper').val() !== "") {
    filteredArrBook = filterArrBookByCategory(arrBook);
    filteredArrBook = filterArrBookByLanguage(filteredArrBook);
  }
  else if ($('#languageWrapper').val() !== "") {
    filteredArrBook = filterArrBookByLanguage(arrBook);
  }
  else if ($('#categoryWrapper').val() !== "") {
    filteredArrBook = filterArrBookByCategory(arrBook);
  }
  if ($('#languageWrapper').val() === "" && $('#categoryWrapper').val() === "") {
    filteredArrBook = arrBook;
  }
  var template = document.querySelector('#productRow');
  var colBook = document.querySelector("#col-book");
  for (var i = 0 ; i < filteredArrBook.length ; i++) {
    var clone = template.content.cloneNode(true);
    var ebookCoverId = filteredArrBook[i].ebookCoverId;
    var ebookCoverFileName = filteredArrBook[i].ebookCoverName;
    var ebookCoverURL = "/ebook/ebook_cover/"+ebookCoverId+"/"+ebookCoverFileName;
    clone.querySelector('.card-book').setAttribute("id", "book-"+filteredArrBook[i].id);
    clone.querySelector('.card-book').setAttribute("rating", filteredArrBook[i].rating);
    clone.querySelector(".ebook-image").setAttribute("src", ebookCoverURL);
    clone.querySelector("h4.book-title").innerHTML = filteredArrBook[i].title;
    clone.querySelector("span.author-text").innerHTML = filteredArrBook[i].author;
    clone.querySelector("p.synopsis").innerHTML = filteredArrBook[i].synopsis;
    clone.querySelector("span.price").innerHTML = filteredArrBook[i].priceForHuman;
    clone.querySelector("span.rating").innerHTML = filteredArrBook[i].rating;
    clone.querySelector("span.ratingCount").innerHTML = filteredArrBook[i].ratingCount;
    clone.querySelector("span.soldCount").innerHTML = filteredArrBook[i].soldCount;
    colBook.appendChild(clone);
  }
  setBookOnClickListener(arrBook);
}

function firstAjaxRequest(keyword) {
  $.ajax({
    url : "/search/book?keyword="+keyword,
    type : "GET"
  }).done(function(data) {
    prepareAfterAjax(data, true);
  });
}

function prepareAfterAjax(data, wouldDisplayCategoryAndLanguageFilter) {
  var arrBook = Object.values(data);
  if (arrBook.length == 0) { // Jika tidak ada buku yang sesuai dengan kata kunci pencarian
    $('.text-info-book-not-found').show();
  }
  else if (wouldDisplayCategoryAndLanguageFilter) { 
    // Jika ada buku yang sesuai dengan kata kunci pencarian dan jika filter akan ditampilkan
    displayCategoryAndLanguageFilter(arrBook);
  }
  // showBookList(arrBook);
  // showAllRating();
  setListOnClickListener(arrBook);
  setOrderOptionListener(arrBook);
  return true;
}

function removeAllBook(arrBook) {
  arrBook.forEach(function(item) {
    $('#book-'+item.id).remove();
  });
}

function displayCategoryAndLanguageFilter(arrBook) {
  var arrPureCategory = [];
  var arrCategory = [];
  var arrPureLanguage = [];
  var arrLanguage = [];
  arrBook.forEach(function(item) {
    if (!(arrPureCategory.includes(item.Category))) {
      var namaKategori = item.Category;
      var idKategori = item.categoryId;
      arrCategory.push( { namaKategori, idKategori });
      arrPureCategory.push(item.Category);
    }
    if (!(arrPureLanguage.includes(item.Language))) {
      var namaBahasa = item.Language;
      var idBahasa = item.languageId;
      arrLanguage.push({ namaBahasa, idBahasa });
      arrPureLanguage.push(item.Language);
    }
  });
  console.log({ arrBook, arrCategory, arrLanguage });
  var categoryRowTemplate = document.querySelector('#category-row');
  var languageRowTemplate = document.querySelector('#language-row');
  arrCategory.forEach(function(item) {
    var clone = categoryRowTemplate.content.cloneNode(true);
    clone.querySelector('li').setAttribute("id", "category-"+item.idKategori);
    clone.querySelector('p.category-name').innerHTML = item.namaKategori;
    document.querySelector("ul#categoryList").appendChild(clone);
  });
  arrLanguage.forEach(function(item) {
    var clone = languageRowTemplate.content.cloneNode(true);
    clone.querySelector('li').setAttribute("id", "language-"+item.idBahasa);
    clone.querySelector('p').innerHTML = item.namaBahasa;
    document.querySelector("ul#languageList").appendChild(clone);
  });
}

function setListOnClickListener(arrBook) {
  $('.li-category').click(function() {
    var id = $(this).attr("id");
    if ($('.li-category#'+id+' div').attr("class").includes("d-none")) { // Jika kategori telah dipilih sebelumnya
      $('.li-category div').attr("class", "float-right d-none"); //menghilangkan
      $('.li-category#'+id+' div').attr("class", "float-right"); //memunculkan
      var category = $('.li-category#'+id+' p').html();
      $('#categoryWrapper').val(category);
    }
    else {
      $('#categoryWrapper').val("");
      $('.li-category div').attr("class", "float-right d-none"); //menghilangkan
    }
    showBookListWithFilter(arrBook);
  });
  $('.li-language').click(function() {
    var id = $(this).attr("id");
    if ($('.li-language#'+id+' div').attr("class").includes("d-none")) { // Jika bahasa telah dipilih sebelumnya
      $('.li-language div').attr("class", "float-right d-none"); //menghilangkan
      $('.li-language#'+id+' div').attr("class", "float-right"); //memunculkan
      var language = $('.li-language#'+id+' p').html();
      $('#languageWrapper').val(language);
    }
    else {
      $('#languageWrapper').val("");
      $('.li-language div').attr("class", "float-right d-none"); //menghilangkan
    }
    showBookListWithFilter(arrBook);
  });
}

function filterArrBookByCategory(arrBook) {
  category = $('#categoryWrapper').val();
  var filteredArrBook = [];
  arrBook.forEach(function(item) {
    if (item.Category === category) {
      filteredArrBook.push(item);
    } 
  });
  return filteredArrBook;
}

function filterArrBookByLanguage(arrBook) {
  language = $('#languageWrapper').val();
  var filteredArrBook = [];
  arrBook.forEach(function(item) {
    if (item.Language === language) {
      filteredArrBook.push(item);
    } 
  });
  return filteredArrBook;
}

function setOrderOptionListener(arrBook) {
  $('#orderOption').change(function() {
    if ($('#categoryWrapper').val() !== "" || $('#languageWrapper').val() !== "") { // Jika ada filter
      showBookListWithFilter(arrBook);
    }
    else {
      showBookList(arrBook);
    }
  }).change();
}

function sortArrBook(arrBook) {
  var orderOption = $( "#orderOption option:selected" ).val();
  if (orderOption == 1) {
    arrBook.sort(function(a, b){return a.soldCount - b.soldCount});
  }
  else if (orderOption == 2) {
    arrBook.sort(function(a, b){return b.price - a.price});
  }
  else if (orderOption == 3) {
    arrBook.sort(function(a, b){return a.price - b.price});
  }
  return arrBook;
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

function setBookOnClickListener(arrBook) {
  arrBook.forEach(function(item) {
    $('#book-'+item.id).click(function() {
      window.location.href = "/book/detail/"+item.id+"/"+string_to_slug(item.title);
    });
  });
}