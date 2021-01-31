$(document).ready(function() {
  setUpAlert();
  setBtnUbahDataOnClickListener();
  setUpBtnCashout();
  setBtnTambahBukuOnClickListener();
  setupBookList();
});

function setupBookList() {
  $.ajax({
    url : "/get/get_publishers_book",
    method : "GET"
  }).done(function (data) {
    console.log(data);
    showBookList(data);
    setBtnHapusOnClickListener();
    setBtnEditBukuOnClickListener();
    setBtnViewBukuOnClickListener();
  });
}

function showBookList(data) {
  var temp = document.getElementById("book-table-row");
  for (let index = 0; index < data.length; index++) {
    var clone = temp.content.cloneNode(true);
    clone.querySelector(".no").innerHTML = index + 1;
    clone.querySelector(".title").innerHTML = data[index].title;
    clone.querySelector(".price").innerHTML = data[index].price;
    clone.querySelector(".rating").innerHTML = data[index].rating;
    clone.querySelector(".ratingCount").innerHTML = data[index].ratingCount;
    clone.querySelector(".soldCount").innerHTML = data[index].soldCount;
    clone.querySelector(".btn-edit-buku").setAttribute("book-id", data[index].id);
    clone.querySelector(".btn-view-buku").setAttribute("book-id", data[index].id);
    clone.querySelector(".btn-hapus-buku").setAttribute("book-id", data[index].id);
    clone.querySelector(".btn-view-buku").setAttribute("book-title", data[index].title);
    clone.querySelector(".btn-hapus-buku").setAttribute("book-title", data[index].title);
    document.getElementById("book-table-tbody").appendChild(clone);
  }
}

function setBtnUbahDataOnClickListener() {
  $('#btnUbahData').click(function() {
		$(location).attr("href", "/publisher/edit");
  });
}

function setBtnTambahBukuOnClickListener() {
  $('#btnTambahBuku').click(function() {
    $(location).attr("href", "/publisher/input/book");
  });
}

function setBtnHapusOnClickListener() {
  $('.btn-hapus-buku').click(function() {
    var title = $(this).attr("book-title");
    Swal.fire({
      title: "Apakah anda yakin akan menghapus buku \""+title+' ?',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Ya',
      cancelButtonText : 'Tidak'
    }).then((result) => {
      if (result.value) {
        var id = $(this).attr("book-id");
        $.ajax({
          url : "/publisher/delete/book",
          method : "POST",
          data : {
            "id" : id
          }
        }).done(function() {
          storeFlashMessage("Berhasil menghapus buku "+"\""+title+"\"", "success", 2);
          location.reload();
        });
      }
    });
  });
}

function setBtnEditBukuOnClickListener() {
  $('.btn-edit-buku').click(function() {
    var id = $(this).attr("book-id");
    window.location.href = "/publisher/edit/book?id="+id;
  });
}

function setBtnViewBukuOnClickListener() {
  $('.btn-view-buku').click(function() {
    var id = $(this).attr("book-id");
    window.location.href = "/book/detail/"+id+"/"+string_to_slug($(this).attr("book-title"));
  });
}

function setUpBtnCashout() {
  var balance = $('meta[name=balance]').attr("content");
  balance = parseInt(balance);
  if (balance >= 30000) {
    var kelas = $("#btnCashout").attr("class");
    kelas = kelas.replace("none", "inline");
    $("#btnCashout").attr("class", kelas);
    $("#btnCashout").attr("onclick", "window.location.href = \"/publisher/cashout\"");
  }
}