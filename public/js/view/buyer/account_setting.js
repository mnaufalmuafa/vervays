$(document).ready(function(){
	setUpGenderRadioButton();
	setChangeProfileFormOnSubmitListener();
	setUpChangePasswordForm();
	setUpDeleteAccount();
	setUpAlert();
});

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
		var con = confirm("Apakah anda yakin ingin menghapus akun ?");
		if(con) {
			$.ajax({
				url : "/post/destroy_account",
				method : "POST"
			}).done(function(res) {
				if (res != "success") {
					alert(res);
				}
				else {
					window.location.href = "/";
				}
			});
		}
	});
}