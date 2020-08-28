// File ini berisi fungsi fungsi yang umum digunakan

function storeFlashMessage(message, type, allotmentId) {
  $.ajax({
    url : "/post/store_flash_message",
    method : "POST",
    data : {
      message,
      type,
      allotmentId
    }
  });
}

function setUpAlert() {
  $.ajax({
    url : "/get/flash_messages",
    method : "GET",
  }).done(function(data) {
    for (let i = 0; i < data.length; i++) {
      if (data[i].allotmentId == 1) {
        Swal.fire({
          position: 'center',
          icon: 'success',
          title: 'Email berhasil diverifikasi',
          text : 'Anda otomatis login',
          showConfirmButton: true,
          timer: 5000
        })
      }
      else if (data[i].allotmentId == 2) {
        showAlert(data[i].message, data[i].type);
      }
    }
  });
}

function showAlert(message, type) {
  $.notify({
    // options
    message: message
  },{
    // settings
    type: type,
    newest_on_top : false,
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

function convertToRupiah(angka)
{
	var rupiah = '';		
	var angkarev = angka.toString().split('').reverse().join('');
	for(var i = 0; i < angkarev.length; i++) if(i%3 == 0) rupiah += angkarev.substr(i,3)+'.';
	return rupiah.split('',rupiah.length-1).reverse().join('');
}