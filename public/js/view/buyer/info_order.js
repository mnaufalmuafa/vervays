$(document).ready(function(){
	setCreatedAtFormat();
	setOrderStatus();
	setBookItemOnClickListener();
});

function setCreatedAtFormat() {
	var relaseDate = new Date($('#created-at-info').html());
	var date = relaseDate.getDate();
	var month = relaseDate.getMonth()+1;
  month = getMonthInBahasa(month);
  var year = relaseDate.getFullYear();
  $('#created-at-info').html(date+" "+month+" "+year);
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

function setOrderStatus() {
	let status = $("#order-status-info").html();
	if (status === "pending") {
		$("#order-status-info").html("Menunggu pembayaran");
	}
	else if (status === "success") {
		$("#order-status-info").html("Selesai");
	}
	else {
		$("#order-status-info").html("Gagal");
	}
}

function setBookItemOnClickListener() {
	$(".book-item").click(function() {
		var bookId = $(this).attr("data-book-id");
		var title = $("#book-item-"+bookId+" .title").html();
		title = string_to_slug(title);
		window.location.href = "/book/detail/"+bookId+"/"+title;
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