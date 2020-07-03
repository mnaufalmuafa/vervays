$(document).ready(function() {
	showWishlist();
});

function showWishlist() {
	$.ajax({
		url : "/get/user_wishlist",
		method : "GET"
	}).done(function(data) {
		console.log({data});
		if (data.length == 0) {
			showExceptionContainer();
			$("#btnSearchBook").click(function() {
				window.location.href = "/";
			});
		}
		else {
			var template = document.querySelector("#bookTemplate");
			var container = document.querySelector(".main-section");
			for (let i = 0; i < data.length; i++) {
				var clone = template.content.cloneNode(true);
				var ebookCoverURL = "/ebook/ebook_cover/"+data[i].ebookCoverId+"/"+data[i].ebookCoverName;
				var rating = parseFloat(data[i].rating);
				rating = rating.toPrecision(2);
				data[i].rating = rating;
				clone.querySelector('.card-book').setAttribute("id", "book-"+data[i].id);
				clone.querySelector(".ebook-image").setAttribute("src", ebookCoverURL);
				clone.querySelector(".ebook-image").setAttribute("data-book-id", data[i].id);
				clone.querySelector(".ebook-image").setAttribute("data-book-title", data[i].title);
				clone.querySelector(".book-title").innerHTML = data[i].title;
				clone.querySelector(".book-title").setAttribute("data-book-id", data[i].id);
				clone.querySelector(".book-title").setAttribute("data-book-title", data[i].title);
				clone.querySelector(".author-text").innerHTML = data[i].author;
				clone.querySelector(".synopsis").innerHTML = data[i].synopsis;
				clone.querySelector("span.rating").innerHTML = data[i].rating;
				clone.querySelector("span.ratingCount").innerHTML = data[i].ratingCount;
				clone.querySelector("span.soldCount").innerHTML = data[i].soldCount;
				clone.querySelector("span.price").innerHTML = convertToRupiah(data[i].price);
				clone.querySelector(".ic-trash").setAttribute("data-book-id", data[i].id);
				clone.querySelector(".ic-trash").setAttribute("data-book-title", data[i].title);
				clone.querySelector(".btn-buy").setAttribute("data-book-id", data[i].id);
				container.appendChild(clone);
			}
			setAllRating();
			setBookOnClickListener();
			setTrashIconOnClickListener();
			setUpBtnBuy();
		}
	});
}

function setAllRating() {
  $(".card-book").each(function() {
    var id = $(this).attr("id");
    var rating = $('#'+id+" span.rating").html();
    rating = Math.floor(rating);
    if (rating >= 1) {
      $('#'+id+' .first-star').attr("src", "/image/icon/yellow_star.png");
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

function convertToRupiah(angka)
{
	var rupiah = '';		
	var angkarev = angka.toString().split('').reverse().join('');
	for(var i = 0; i < angkarev.length; i++) if(i%3 == 0) rupiah += angkarev.substr(i,3)+'.';
	return rupiah.split('',rupiah.length-1).reverse().join('');
}

function setBookOnClickListener() {
	$(".book-title").click(function() {
    var id = $(this).attr("data-book-id");
    var title = $(this).attr("data-book-title");
    window.location.href = "/book/detail/"+id+"/"+string_to_slug(title);
  });
  $(".ebook-image").click(function() {
    var id = $(this).attr("data-book-id");
    var title = $(this).attr("data-book-title");
    window.location.href = "/book/detail/"+id+"/"+string_to_slug(title);
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

function setTrashIconOnClickListener() {
	$(".ic-trash").click(function() {
		var id = $(this).attr("data-book-id");
		var title = $(this).attr("data-book-title");
		var removeBook = confirm("Apakah anda yakin ingin menghapus buku \""+title+"\" dari wishlist?");
		if (removeBook) {
			$.ajax({
				url : "/post/remove_book_from_wish_list/"+id,
				method : "POST"
			}).done(function() {
				location.reload();
			});
		}
	});
}

function showExceptionContainer() {
	$(".main-section").hide();
	var kelas = $('.exception-container').attr("class");
	kelas = kelas.replace("none", "block");
	$('.exception-container').attr("class", kelas);
}

function setUpBtnBuy() {
  $(".btn-buy").click(function() {
		var bookId = $(this).attr("data-book-id");
    $.ajax({
      type : "GET",
      url : "/get/whether_the_user_has_added_book_to_cart/"+bookId
    }).done(function(isUserHasAddedBookToCart) {
      isUserHasAddedBookToCart = (isUserHasAddedBookToCart == "true");
      if (!isUserHasAddedBookToCart) { // Jika user belum memasukkan buku ke keranjang
        $.ajax({ // Memasukkan buku ke keranjang
          url : "/post/add_book_to_cart/"+bookId,
          method : "POST"
        }).done(function() {
          window.location.href = "/cart";
        });
      }
      else {
        window.location.href = "/cart";
      }
    });
  });
}