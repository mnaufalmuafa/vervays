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
        window.location.href = "http://127.0.0.1:8000/search?keyword="+keyword;
      }
    }
  });
});

function NavbarWindowChangeListener() {
  var width = $(window).width();
  // $('#tesLayar').html(width);
  if (width < 992) {
    $("#navbarSeparator").hide();
  }
  else {
    $("#navbarSeparator").show();
  }
}

$(window).on('resize', NavbarWindowChangeListener);