$(document).ready(function() {
	showBooks();
	hideAllButtonInsideCardBook();
	setCardBookOnMouseEnterAndMouseLeaveListener();
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
		}
	});
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
			$("#"+id+" button").show();
		})
		.mouseleave(function() {
			var id = $(this).attr('id');
			$("#"+id+" button").hide();
		});
}