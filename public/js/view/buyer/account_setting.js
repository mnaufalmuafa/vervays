$(document).ready(function(){
	setUpGenderRadioButton();
	setChangeProfileFormOnSubmitListener();
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
		console.log({firstName, lastName, birthDay, phoneNum, gender});
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
		});
	});
}