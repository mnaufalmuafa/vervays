$(document).ready(function() {
  // displayExceptionSection();
  getCart();
  setFormOnSubmitListener();
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
      showCart(books);
    }
  });
}

function showCart(books) {
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

function setFormOnSubmitListener() {
  $('#orderForm').submit(function(e) {
    e.preventDefault();
    $(':input[type="submit"]').prop('disabled', true);
    $(':input[type="submit"]').html('....');
    var bookCount = 0;
    $(".book-item").each(function() {
      bookCount++;
    });
    if (bookCount > 0) {
      var arrBookId = [];
      $(".book-item").each(function() {
        arrBookId.push($(this).attr("data-book-id"));
      });
      paymentMethod = getPaymentMethodValue();
      var bookData = {arrBookId, paymentMethod};
      console.log(bookData);

      $.ajax({
        url : "http://127.0.0.1:8000/post/create_order",
        method : "POST",
        // timeout : 0,
        headers : {
          "Content-Type": "application/json",
        },
        data : JSON.stringify({"paymentMethod":paymentMethod}),
        dataType : "JSON", 
      }).always(function(orderId) {
        console.log(orderId);
        window.location.href = "/info/order/"+orderId;
      });
    }
  });
}

function getPaymentMethodValue() {
  var radios = document.getElementsByName('paymentMethod');
  for (var i = 0, length = radios.length; i < length; i++) {
    if (radios[i].checked) {
      return radios[i].value;
    }
  }
}