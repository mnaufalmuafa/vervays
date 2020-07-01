$(document).ready(function() {
  // displayExceptionSection();
  getCart();
});

function displayExceptionSection() {
	var kelas = $('.exception-container').attr("class");
	kelas = kelas.replace("none", "block");
	$('.exception-container').attr("class", kelas);
}

function displayMainSection() {
  var kelas = $('.main-container').attr("class");
	kelas = kelas.replace("none", "block");
	$('.main-container').attr("class", kelas);
}

function getCart() {
	$.ajax({
    url : "/get/get_user_cart/",
    method : "get"
  }).done(function(books) {
    // console.log(books);
    if (books.length === 0) { //Jika keranjang belanja masih kosong
      displayExceptionSection();
      $('#btnSearchBook').click(function() {
        window.location.href = "/";
      });
    }
    else { // Jika keranjang belanja sudah terisi (minimal 1 buku)
      displayMainSection();
      var template = document.querySelector('#bookTemplate');
      var container = document.querySelector('#bookContainer');
      var totalPrice = 0;
      for (let i = 0; i < books.length; i++) {
        var clone = template.content.cloneNode(true);
        var ebookCoverURL = "/ebook/ebook_cover/"+books[i].ebookCoverId+"/"+books[i].ebookCoverName;
        clone.querySelector('h4').innerHTML = books[i].title;
        clone.querySelector('p.authorInfo span').innerHTML = books[i].author;
        clone.querySelector('p.publisherDetail').innerHTML = books[i].publisherName;
        clone.querySelector('p.price span').innerHTML = books[i].priceForHuman;
        clone.querySelector('div').setAttribute("data-book-id", books[i].bookId);
        clone.querySelector('div').setAttribute("data-price", books[i].price);
        clone.querySelector('img').setAttribute("src", ebookCoverURL);
        clone.querySelector('img').setAttribute("data-book-id", books[i].bookId);
        clone.querySelector('img').setAttribute("data-book-title", books[i].title);
        clone.querySelector('.book-title').setAttribute("data-book-id", books[i].bookId);
        clone.querySelector('.book-title').setAttribute("data-book-title", books[i].title);
        clone.querySelector('.ic-trash').setAttribute("data-book-id", books[i].bookId);
        clone.querySelector('.ic-trash').setAttribute("data-book-title", books[i].title);
        totalPrice = totalPrice + books[i].price;
        container.appendChild(clone);
      }
      setBookOnClickListener();
      setTrashIconOnClickListener();
      $('#total-amount span').html(convertToRupiah(totalPrice));
    }
  });
}

function convertToRupiah(angka){
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
  $(".book-cover").click(function() {
    var id = $(this).attr("data-book-id");
    var title = $(this).attr("data-book-title");
    window.location.href = "/book/detail/"+id+"/"+string_to_slug(title);
  });
}

function setTrashIconOnClickListener() {
  $(".ic-trash").click(function() {
    var id = $(this).attr("data-book-id");
    var title = $(this).attr("data-book-title");
    var willDeleteBookFromCart = confirm("Apakah anda yakin akan menghapus buku \""+title+"\" dari keranjang ?");
    if (willDeleteBookFromCart) {
      $.ajax({
        url : "/post/remove_book_from_cart/"+id,
        method : "POST"
      }).done(function() {
        location.reload();
      });
    }
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