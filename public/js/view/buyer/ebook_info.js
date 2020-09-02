$(document).ready(function() {
  setUpAlert();
  checkBookAvailability();
});

function checkBookAvailability() {
  var id = $('meta[name=book-id]').attr("content");
  $.ajax({
    url : '/get/is_book_not_deleted',
    method : "GET",
    data : { id }
  }).done(function(isNotDeleted) {
    if (isNotDeleted) {
      $("#main-container").attr("class", "container-fluid");
      setAsideButtonDisplay();
      setRating("first");
      setPublisherTextOnClickListener();
      setReleaseDateFormat();
      setRating("rating");
      setRatingProgress();
      displayReview();
    }
    else {
      $("#exception-container").attr("class", "container-fluid");
    }
  });
}

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
    window.location.href = "/info/publisher/"+id+"/"+publisherSlug;
  });
}

function setReleaseDateFormat() {
  var relaseDate = new Date($('#relaseDate span').html());
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

function setRatingProgress() {
  var id = $('meta[name=book-id]').attr("content");
  $.ajax({
    type : "GET",
    url : "/get/get_people_gave_stars_count_all_rating/"+id,
  }).done(function(data) {
    var ratingAllCount = data;
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
    var width = 0;
    if (ratingAllCount != 0) {
      width = (data/ratingAllCount)*100;
    }
    $("#"+standing+"-rating-row .loaded").css("width", width+"%");
    $("#"+standing+"-rating-row p:last-child").html(data);
  });
}

function displayReview() {
  var id = $('meta[name=book-id]').attr("content");
  $.ajax({
    type : "GET",
    url : "/get/get_reviews_by_book_id/"+id
  }).done(function(data) {
    var reviewsCount = data.length;
    var template = document.querySelector('#ratingContainer');
    var container = document.querySelector('#reviews-container');
    var loaded = 0;
    for (let i = 0; i < reviewsCount && i < 3; i++) {
      var clone = template.content.cloneNode(true);
      var name = getReviewerFormattedName(data[i].firstName, data[i].lastName, data[i].isAnonymous, data[i].isDeleted);
      var date = getFormattedDateForReviewSection(data[i].created_at);
      switch (data[i].rating) {
        case 5:
          clone.querySelector('.fifth-star').setAttribute("src", "http://127.0.0.1:8000/image/icon/yellow_star.png");
          clone.querySelector('.fourth-star').setAttribute("src", "http://127.0.0.1:8000/image/icon/yellow_star.png");
          clone.querySelector('.third-star').setAttribute("src", "http://127.0.0.1:8000/image/icon/yellow_star.png");
          clone.querySelector('.second-star').setAttribute("src", "http://127.0.0.1:8000/image/icon/yellow_star.png");
          clone.querySelector('.first-star').setAttribute("src", "http://127.0.0.1:8000/image/icon/yellow_star.png");
          break;
        case 4 :
          clone.querySelector('.fourth-star').setAttribute("src", "http://127.0.0.1:8000/image/icon/yellow_star.png");
          clone.querySelector('.third-star').setAttribute("src", "http://127.0.0.1:8000/image/icon/yellow_star.png");
          clone.querySelector('.second-star').setAttribute("src", "http://127.0.0.1:8000/image/icon/yellow_star.png");
          clone.querySelector('.first-star').setAttribute("src", "http://127.0.0.1:8000/image/icon/yellow_star.png");
          break;
        case 3 :
          clone.querySelector('.third-star').setAttribute("src", "http://127.0.0.1:8000/image/icon/yellow_star.png");
          clone.querySelector('.second-star').setAttribute("src", "http://127.0.0.1:8000/image/icon/yellow_star.png");
          clone.querySelector('.first-star').setAttribute("src", "http://127.0.0.1:8000/image/icon/yellow_star.png");
          break;
        case 2 :
          clone.querySelector('.second-star').setAttribute("src", "http://127.0.0.1:8000/image/icon/yellow_star.png");
          clone.querySelector('.first-star').setAttribute("src", "http://127.0.0.1:8000/image/icon/yellow_star.png");
          break;
        case 1 :
          clone.querySelector('.first-star').setAttribute("src", "http://127.0.0.1:8000/image/icon/yellow_star.png");
          break;
      }
      clone.querySelector('.card-custom').setAttribute("id", "rating-"+data[i].id);
      clone.querySelector('p.reviewer').innerHTML = name;
      clone.querySelector('p.review').innerHTML = data[i].review;
      clone.querySelector('p.review-date').innerHTML = date;
      container.appendChild(clone);
      loaded++;
    }
    if (loaded < reviewsCount) {
      $('#btnLoadMore').show();
      continueDisplayReview(loaded, reviewsCount, data);
    }
    else {
      $('#btnLoadMore').hide();
    }
  });
}

function continueDisplayReview(loaded, reviewsCount, data) {
  $('#btnLoadMore').click(function() {
    var template = document.querySelector('#ratingContainer');
    var container = document.querySelector('#reviews-container');
    var loadedNow = loaded;
    for (let i = loaded; i < reviewsCount && i < (loadedNow+3);) {
      if (i == reviewsCount) {
        break;
      }
      var clone = template.content.cloneNode(true);
      var name = getReviewerFormattedName(data[i].firstName, data[i].lastName, data[i].isAnonymous, data[i].isDeleted);
      var date = getFormattedDateForReviewSection(data[i].created_at);
      switch (data[i].rating) {
        case 5:
          clone.querySelector('.fifth-star').setAttribute("src", "http://127.0.0.1:8000/image/icon/yellow_star.png");
          clone.querySelector('.fourth-star').setAttribute("src", "http://127.0.0.1:8000/image/icon/yellow_star.png");
          clone.querySelector('.third-star').setAttribute("src", "http://127.0.0.1:8000/image/icon/yellow_star.png");
          clone.querySelector('.second-star').setAttribute("src", "http://127.0.0.1:8000/image/icon/yellow_star.png");
          clone.querySelector('.first-star').setAttribute("src", "http://127.0.0.1:8000/image/icon/yellow_star.png");
          break;
        case 4 :
          clone.querySelector('.fourth-star').setAttribute("src", "http://127.0.0.1:8000/image/icon/yellow_star.png");
          clone.querySelector('.third-star').setAttribute("src", "http://127.0.0.1:8000/image/icon/yellow_star.png");
          clone.querySelector('.second-star').setAttribute("src", "http://127.0.0.1:8000/image/icon/yellow_star.png");
          clone.querySelector('.first-star').setAttribute("src", "http://127.0.0.1:8000/image/icon/yellow_star.png");
          break;
        case 3 :
          clone.querySelector('.third-star').setAttribute("src", "http://127.0.0.1:8000/image/icon/yellow_star.png");
          clone.querySelector('.second-star').setAttribute("src", "http://127.0.0.1:8000/image/icon/yellow_star.png");
          clone.querySelector('.first-star').setAttribute("src", "http://127.0.0.1:8000/image/icon/yellow_star.png");
          break;
        case 2 :
          clone.querySelector('.second-star').setAttribute("src", "http://127.0.0.1:8000/image/icon/yellow_star.png");
          clone.querySelector('.first-star').setAttribute("src", "http://127.0.0.1:8000/image/icon/yellow_star.png");
          break;
        case 1 :
          clone.querySelector('.first-star').setAttribute("src", "http://127.0.0.1:8000/image/icon/yellow_star.png");
          break;
      }
      clone.querySelector('.card-custom').setAttribute("id", "rating-"+data[i].id);
      clone.querySelector('p.reviewer').innerHTML = name;
      clone.querySelector('p.review').innerHTML = data[i].review;
      clone.querySelector('p.review-date').innerHTML = date;
      container.appendChild(clone);
      loaded++;
      i++;
    }
    if (loaded < reviewsCount) {
      $('#btnLoadMore').show();
    }
    else {
      $('#btnLoadMore').hide();
    }
  });
}

function getReviewerFormattedName(firstName, lastName, isAnonymous, isUserDeleted) {
  var name = firstName + " " + lastName;
  if (isAnonymous == 1) {
    name = name.substring(0,1) + "***" + name.substring(name.length-1,name.length);
  }
  if (isUserDeleted == 1) {
    name = "Deleted Account";
  }
  return name;
}

function getFormattedDateForReviewSection(date) {
  var newDate = new Date(date);
  return newDate.getDate()+" "+getMonthInBahasa(newDate.getMonth()+1)+" "+newDate.getFullYear();
}

function hideAllAsideButton() {
  $('#btnDelete').hide();
  $('#btnEdit').hide();
  $('#btnRead').hide();
  $('#btnGiveRating').hide();
  $('#btnReadSample').hide();
  $('#btnAddToCart').hide();
  $('#btnAddToWishlist').hide();
  $('#btnBuy').hide();
}

function setAsideButtonDisplay() {
  hideAllAsideButton();
  var bookId = $('meta[name=book-id]').attr("content");
  $.ajax({
    type : "GET",
    url : "/get/get_user_role_for_ebook_info_page/"+bookId
  }).done(function(role) {
    if (role == 1) {
      $('#btnDelete').show();
      $('#btnEdit').show();
      $('#btnEdit').click(function() {
        window.location.href = "/publisher/edit/book?id="+bookId;
      });
      $('#btnDelete').click(function() {
        Swal.fire({
          title: "Apakah anda yakin ingin menghapus buku \""+$(this).attr("data-title")+'" ?',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Ya',
          cancelButtonText : 'Tidak'
        }).then((result) => {
          if (result.value) {
            var id = bookId;
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
      });
    }
    else if (role == 3) {
      $.ajax({
        url : "/get/whether_the_transaction_is_pending_or_success/"+bookId,
        method : "GET"
      }).done(function(response){
        if (response == "pending") {
          $('#btnReadSample').show();
        }
        else { // Jika transaksi telah sukses
          $('#btnRead').show();
          $.ajax({ // Cek apakah user sudah memberi rating
            url : "/get/have_user_given_book_rating/"+bookId,
            method : "GET"
          }).done(function(haveUserGivenBookRating) {
            if (!haveUserGivenBookRating) {
              $('#btnGiveRating').show();
              $('#btnGiveRating').attr("onclick", "window.location.href = \"/give_rating/"+bookId+"\"");
            }
          });
        }
      });
    }
    else if (role == 2) {
      $('#btnReadSample').show();
      $('#btnAddToCart').show();
      $('#btnAddToWishlist').show();
      $('#btnBuy').show();
      setUpBtnAddToCart();
      setUpBtnAddToWishList();
      setUpBtnBuy();
    }
  });
}

function setUpBtnBuy() {
  var bookId = $('meta[name=book-id]').attr("content");
  $("#btnBuy").click(function() {
    $(':input[type="submit"]').prop('disabled', true);
    $(':input[type="submit"]').html('....');
    $.ajax({
      type : "GET",
      url : "/get/whether_the_user_has_added_book_to_cart/"+bookId
    }).done(function(isUserHasAddedBookToCart) {
      isUserHasAddedBookToCart = (isUserHasAddedBookToCart == "true");
      if (!isUserHasAddedBookToCart) { // Jika user belum memasukkan buku ke keranjang
        $.ajax({ // Memasukkan buku ke keranjang
          url : "/post/add_book_to_cart/"+bookId,
          method : "POST"
        }).done(function(response) {
          window.location.href = "/cart";
        });
      }
      else {
        window.location.href = "/cart";
      }
    });
  });
}

function setUpBtnAddToCart() {
  var bookId = $('meta[name=book-id]').attr("content");
  $.ajax({
    type : "GET",
    url : "/get/whether_the_user_has_added_book_to_cart/"+bookId
  }).done(function(isUserHasAddedBookToCart) {
    isUserHasAddedBookToCart = (isUserHasAddedBookToCart == "true");
    if (isUserHasAddedBookToCart) { // Jika user sudah memasukkan buku ke keranjang
      $('#btnAddToCart').html("Hapus dari Keranjang");
      $('#btnAddToCart').attr("onclick", "deleteBookFromCart()");
      $('#btnAddToCart').attr("id", "btnDeleteFromCart");
    }
    else { // Jika user belum memasukkan buku ke keranjang
      $('#btnAddToCart').attr("onclick", "addBookToCart()");
    }
  });
}

function addBookToCart() {
  $('#btnAddToCart').attr("onclick", "");
  $('#btnAddToCart').html("....");
  var bookId = $('meta[name=book-id]').attr("content");
  $.ajax({
    url : "/post/add_book_to_cart/"+bookId,
    method : "POST"
  }).done(function() {
    $('#btnAddToCart').html("Hapus dari Keranjang");
    $('#btnAddToCart').attr("onclick", "deleteBookFromCart()");
    $('#btnAddToCart').attr("id", "btnDeleteFromCart");
    storeFlashMessage("Berhasil menambah ebook ke keranjang belanja", "success", 2);
    setUpAlert();
  });
}

function deleteBookFromCart() {
  $('#btnDeleteFromCart').html("....");
  $('#btnDeleteFromCart').attr("onclick", "");
  var bookId = $('meta[name=book-id]').attr("content");
  $.ajax({
    url : "/post/remove_book_from_cart/"+bookId,
    method : "POST"
  }).done(function() {
    $('#btnDeleteFromCart').html("Tambah ke Keranjang");
    $('#btnDeleteFromCart').attr("onclick", "addBookToCart()");
    $('#btnDeleteFromCart').attr("id", "btnAddToCart");
    storeFlashMessage("Berhasil menghapus ebook dari keranjang belanja", "success", 2);
    setUpAlert();
  });
}

function setUpBtnAddToWishList() {
  var bookId = $('meta[name=book-id]').attr("content");
  $.ajax({
    type : "GET",
    url : "/get/whether_the_user_has_added_book_to_wish_list/"+bookId
  }).done(function(isUserHasAddedBookToWishList) {
    isUserHasAddedBookToWishList = (isUserHasAddedBookToWishList == "true");
    if (isUserHasAddedBookToWishList) { // Jika user sudah memasukkan buku ke keranjang
      $('#btnAddToWishlist').html("Hapus dari Wishlist");
      $('#btnAddToWishlist').attr("onclick", "removeBookFromWishList()");
      $('#btnAddToWishlist').attr("id", "btnDeleteFromWishList");
    }
    else { // Jika user belum memasukkan buku ke keranjang
      $('#btnAddToWishlist').attr("onclick", "addBookToWishList()");
      $('#btnAddToWishlist').attr("id", "btnAddToWishList");
    }
  });
}

function addBookToWishList() {
  $('#btnAddToWishList').attr("onclick", "");
  $('#btnAddToWishList').html("....");
  var bookId = $('meta[name=book-id]').attr("content");
  $.ajax({
    url : "/post/add_book_to_wish_list/"+bookId,
    method : "POST"
  }).done(function() {
    $('#btnAddToWishList').html("Hapus dari Wishlist");
    $('#btnAddToWishList').attr("onclick", "removeBookFromWishList()");
    $('#btnAddToWishList').attr("id", "btnDeleteFromWishList");
    storeFlashMessage("Berhasil menambah ebook ke wishlist", "success", 2);
    setUpAlert();
  });
}

function removeBookFromWishList() {
  $('#btnDeleteFromWishList').html("....");
  $('#btnDeleteFromWishList').attr("onclick", "");
  var bookId = $('meta[name=book-id]').attr("content");
  $.ajax({
    url : "/post/remove_book_from_wish_list/"+bookId,
    method : "POST"
  }).done(function() {
    $('#btnDeleteFromWishList').html("Tambah ke Wishlist");
    $('#btnDeleteFromWishList').attr("onclick", "addBookToWishList()");
    $('#btnDeleteFromWishList').attr("id", "btnAddToWishList");
    storeFlashMessage("Berhasil menghapus ebook dari wishlist", "success", 2);
    setUpAlert();
  });
}

function redirectToReadSamplePage() {
  var bookId = $('meta[name=book-id]').attr("content");
  window.location.href = "/read/sample/"+bookId;
}

function redirectToReadPage() {
  var bookId = $('meta[name=book-id]').attr("content");
  window.location.href = "/read/book/"+bookId;
}