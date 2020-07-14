$(document).ready(function(){
	setUpGenderRadioButton();
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