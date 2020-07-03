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
			// TODO : show exception section
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
				clone.querySelector(".book-title").innerHTML = data[i].title;
				clone.querySelector(".author-text").innerHTML = data[i].author;
				clone.querySelector(".synopsis").innerHTML = data[i].synopsis;
				clone.querySelector("span.rating").innerHTML = data[i].rating;
				clone.querySelector("span.ratingCount").innerHTML = data[i].ratingCount;
				clone.querySelector("span.soldCount").innerHTML = data[i].soldCount;
				clone.querySelector("span.price").innerHTML = convertToRupiah(data[i].price);
				container.appendChild(clone);
			}
			setAllRating();
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