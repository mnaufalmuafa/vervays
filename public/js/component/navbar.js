$(document).ready(function() {
  var width = $(window).width();
  if (width < 992) {
    $("#navbarSeparator").hide();
  }
  $('#inputSearchBar').keypress(function(event) {
    if ( event.which == 13 ) {
      if ($('#inputSearchBar').val() === "") {
        console.log('kosong');
      }
      else {
        var keyword = $('#inputSearchBar').val();
        keyword = string_to_slug(keyword);
        console.log(keyword);
        window.location.href = "/search?keyword="+keyword;
      }
    }
  });

  $('#linkLogout').click(function(event) {
    event.preventDefault();
    Swal.fire({
      title: 'Apakah anda yakin ingin logout?',
      showCancelButton: true,
      confirmButtonColor: '#d33',
      cancelButtonColor: '#3085d6',
      confirmButtonText: 'Ya',
      cancelButtonText : 'Tidak'
    }).then((result) => {
      if (result.value) {
        $.ajax({
          url : "/logout",
          method : "POST",
        }).done(function() {
          window.location.href = "/";
        });
      }
    });
  });

  $('#linkMenjadiPublisher').click(function(event) {
    event.preventDefault();
    $.ajax({
      url : "/bepublisher",
      method : "POST"
    }).done(function() {
      window.location.href = "/publisher/dashboard";
    });
  });
});

function NavbarWindowChangeListener() {
  var width = $(window).width();
  if (width < 992) {
    $("#navbarSeparator").hide();
  }
  else {
    $("#navbarSeparator").show();
  }
}

$(window).on('resize', NavbarWindowChangeListener);