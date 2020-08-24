// File ini berisi fungsi fungsi yang umum digunakan
console.log("general func");

function storeFlahMessage(message, type, allotmentId) {
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
    console.log(data);
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
    newest_on_top : true,
  });
}