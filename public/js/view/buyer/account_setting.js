$(document).ready(function(){
  resetMenu();
	setUpGenderRadioButton();
	setChangeProfileFormOnSubmitListener();
	setUpChangePasswordForm();
	setUpDeleteAccount();
	setupSidebar();
	setUpAlert();
});

function resetMenu() {
	$(".menu-sidebar div").attr("class", $("#MenuUbahProfil div").attr("class").replace("red", "white")); // menghilangkan sign
	$(".menu-sidebar p").css("color", "black"); // mengubah teks menjadi hitam
	$(".menu-sidebar hr").attr("class", ""); // mengubah warna hr menjadi hitam
	$(".section-content").hide(); // menghilangkan semua isi side utama
}

function choiceMenu(menuId, sectionId) {
	$("#" + menuId + " div").attr("class", $("#" + menuId +" div").attr("class").replace("white", "red")); //setup sign
	$("#" + menuId + " p").css("color", "red"); // mengubah teks menjadi merah
	$("#" + menuId + " hr").attr("class", "red-hr"); // mengubah warna hr menjadi merah
	$("#"+sectionId).show();
}

function setupMonthJoined() {
	var intMonthJoin = parseInt($("#memberJoinFrom span").text());
	switch(intMonthJoin) {
		case 1 :
			$("#memberJoinFrom span").text("Jan");
			break;
		case 2 :
			$("#memberJoinFrom span").text("Feb");
			break;
		case 3 :
			$("#memberJoinFrom span").text("Mar");
			break;
		case 4 :
			$("#memberJoinFrom span").text("Apr");
			break;
		case 5 :
			$("#memberJoinFrom span").text("Mei");
			break;
		case 6 :
			$("#memberJoinFrom span").text("Jun");
			break;
		case 7 :
			$("#memberJoinFrom span").text("Jul");
			break;
		case 8 :
			$("#memberJoinFrom span").text("Agu");
			break;
		case 9 :
			$("#memberJoinFrom span").text("Sep");
			break;
		case 10 :
			$("#memberJoinFrom span").text("Okt");
			break;
		case 11 :
			$("#memberJoinFrom span").text("Nov");
			break;
		case 12 :
			$("#memberJoinFrom span").text("Des");
			break;
	}
}

function setupSidebar() {
  choiceMenu("MenuUbahProfil", "section-ubah-profil");
	setupMonthJoined();
	$("#MenuUbahProfil").click(function() {
		resetMenu();
		choiceMenu("MenuUbahProfil", "section-ubah-profil");
	});
	$("#MenuUbahPassword").click(function() {
		resetMenu();
		choiceMenu("MenuUbahPassword", "section-ubah-password");
	});
	$("#MenuHapusAkun").click(function() {
		resetMenu();
		choiceMenu("MenuHapusAkun", "section-hapus-akun");
	});
}

function setUpGenderRadioButton() {
	var gender = $('meta[name=userGender]').attr("content");
	if (gender == "male") {
		$("#inputRadioLK").prop('checked', true);
	}
	else if (gender == "female") {
		$("#inputRadioPR").prop('checked', true);
	}
}

function setChangeProfileFormOnSubmitListener() {
	$("#changeProfileForm").on("submit", function(event) {
		event.preventDefault();
		var firstName = $("input[name=firstName]").val();
		var lastName = $("input[name=lastName]").val();
		var birthDay = $("#inputBirthDay").val();
		var phoneNum = $("#inputPhoneNumber").val();
		var gender = "";
		if ($("#inputRadioLK:checked").val()) {
			gender = "male";
		}
		else if ($("#inputRadioPR:checked").val()) {
			gender = "female";
		}
		$.ajax({
			url : "/post/update_profile",
			method : "POST",
			data : {
				firstName : firstName,
				lastName : lastName,
				birthDay : birthDay,
				phoneNum : phoneNum,
				gender : gender
			}
		}).done(function() {
			storeFlashMessage("Berhasil mengubah profil", "success", 2);
			location.reload();
		});
	});
}

function setUpChangePasswordForm() {
	setUpInputNewPassword();
	setUpInputRetypeNewPassword();
	$("#changePasswordForm").on("submit", function(event) {
		event.preventDefault();
		$("#btnSubmitChangePassword").prop('disabled', true);
		$.ajax({
			url : "/post/is_password_true",
			method : "POST",
			data : {
				password : $("#inputOldPassword").val()
			}
		}).done(function(isPasswordTrue) {
			if (!isPasswordTrue) { // Jika password lamanya tidak benar
				$("#errorOldPassword").html("Password tidak sesuai");
				$("#errorOldPassword").attr("class", "");
				$("#btnSubmitChangePassword").prop('disabled', false);
			}
			else if ($("#inputNewPassword").val() == $("#inputRetypeNewPassword").val() && $("#inputRetypeNewPassword").val().length > 7) { // jika benar
				$.ajax({
					url : "/post/update_password",
					method : "POST",
					data : {
						password : $("#inputNewPassword").val()
					}
				}).done(function() {
					storeFlashMessage("Berhasil mengubah password", "success", 2);
					location.reload();
				});
			}
			else {
				$("#btnSubmitChangePassword").prop('disabled', false);
			}
		});
	});
}

function setUpInputNewPassword() {
	$("#inputNewPassword").keyup(function() {
		if ($("#inputNewPassword").val().length < 8) {
			$("#errorNewPassword").html("Password minimal terdiri dari 8 karaker");
			$("#errorNewPassword").attr("class", "");
		}
		else {
			$("#errorNewPassword").attr("class", "d-none");
		}
	});
}

function setUpInputRetypeNewPassword() {
	$("#inputRetypeNewPassword").keyup(function() {
		if ($("#inputNewPassword").val() != $("#inputRetypeNewPassword").val()) {
			$("#errorRetypeNewPassword").html("Password tidak sama");
			$("#errorRetypeNewPassword").attr("class", "");
		}
		else {
			$("#errorRetypeNewPassword").attr("class", "d-none");
		}
	});
}

function setUpDeleteAccount() {
	$("#deleteAccount").click(function() {
    Swal.fire({
      title: 'Apakah anda yakin ingin menghapus akun ?',
      showCancelButton: true,
      confirmButtonColor: '#d33',
      cancelButtonColor: '#3085d6',
      confirmButtonText: 'Ya',
      cancelButtonText : 'Tidak'
    }).then((result) => {
      if (result.value) {
        $.ajax({
          url : "/post/destroy_account",
          method : "POST"
        }).done(function(res) {
          if (res != "success") {
            Swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: res,
            });
          }
          else {
            window.location.href = "/";
          }
        });
      }
    });
	});
}