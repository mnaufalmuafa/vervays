$(document).ready(function() {
  setBalanceInfoFormat();
  setFormOnSubmitListener();
});

function setBalanceInfoFormat() {
  var balance = $("span.info-balance").html();
  $("span.info-balance").html(convertToRupiah(balance));
}

function setFormOnSubmitListener() {
  $("#form").on("submit", function(event) {
    event.preventDefault();
    $.ajax({
      url : "/publisher/post/cashout",
      method : "POST",
      data : {
        amount : $("#inputAmount").val(),
        bankId : $('#inputBank').val(),
        accountOwner : $("#inputAccountOwner").val()
      },
      success : function(text) {
        console.log(text);
      },
      failed : function(text) {
        console.log(text);
      }
    }).done(function(res) {
      console.log(res);
      window.location.href = "/publisher/dashboard"
    });
  });
}

function convertToRupiah(angka)
{
	var rupiah = '';		
	var angkarev = angka.toString().split('').reverse().join('');
	for(var i = 0; i < angkarev.length; i++) if(i%3 == 0) rupiah += angkarev.substr(i,3)+'.';
	return rupiah.split('',rupiah.length-1).reverse().join('');
}