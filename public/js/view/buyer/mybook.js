$(document).ready(function() {
	showBooks();
});

function showBooks() {
	$.ajax({
		url : "get/get_user_books",
		method : "GET"
	}).done(function(data) {
		console.log(data);
		if (data.length == 0) { // Jika user blm punya buku
			showExceptionContainer();
		}
		else { // Jika user sudah punya buku
			showMainContainer();
			pureShowBooks(data);
			hideAllButtonInsideCardBook();
			setCardBookOnMouseEnterAndMouseLeaveListener();
		}
	});
}

function pureShowBooks(books) {
	var template = document.querySelector('#bookTemplate');
	var container = document.querySelector(".row");
	for (let i = 0; i < books.length; i++) {
		var clone = template.content.cloneNode(true);
		clone = setUpClone(clone, books[i]);
		container.appendChild(clone);
	}
}

function setUpClone(clone, book) {
	clone.querySelector("p.title").innerHTML = book.title;
	clone.querySelector("p.author").innerHTML = book.author;
	clone.querySelector("div").setAttribute("id", "book"+book.id);
	clone.querySelector("img").setAttribute("src", "/ebook/ebook_cover/"+book.ebookCoverId+"/"+book.ebookCoverFileName);
	clone.querySelector(".btnRead").setAttribute("onclick", "window.location.href = \"/read/book/"+book.id+"\"");
	clone.querySelector(".imageLink").setAttribute("href", "/book/detail/"+book.id+"/"+string_to_slug(book.title));
	clone.querySelector(".titleLink").setAttribute("href", "/book/detail/"+book.id+"/"+string_to_slug(book.title));
	if (book.didTheUserGiveAReview === true) {
		clone.querySelector(".btnGiveRating").setAttribute("data-emptied", 1);
	}
	else {
		clone.querySelector(".btnGiveRating").setAttribute("data-emptied", 0);
		clone.querySelector(".btnGiveRating").setAttribute("onclick", "window.location.href = \"/give_rating/"+book.id+"\"");
	}
	return clone;
}

function showExceptionContainer() {
	var kelas = $(".exception-container").attr("class");
	kelas = kelas.replace("d-none", "");
	$(".exception-container").attr("class", kelas);
}

function showMainContainer() {
	var kelas = $(".main-container").attr("class");
	kelas = kelas.replace("d-none", "");
	$(".main-container").attr("class", kelas);
}

function hideAllButtonInsideCardBook() {
	$(".card-book button").hide();
}

function setCardBookOnMouseEnterAndMouseLeaveListener() {
	$(".card-book")
		.mouseenter(function() {
			var id = $(this).attr('id');
			$("#"+id+" .btnRead").show();
			if ($("#"+id+" .btnGiveRating").attr("data-emptied") == 0) {
				$("#"+id+" .btnGiveRating").show();
			}
		})
		.mouseleave(function() {
			var id = $(this).attr('id');
			$("#"+id+" .btnRead").hide();
			if ($("#"+id+" .btnGiveRating").attr("data-emptied") == 0) {
				$("#"+id+" .btnGiveRating").hide();
			}
		});
}