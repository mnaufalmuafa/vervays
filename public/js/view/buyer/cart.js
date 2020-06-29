$(document).ready(function() {
	// displayExceptionSection();
});

function displayExceptionSection() {
	var kelas = $('.exception-container').attr("class");
	kelas = kelas.replace("none", "block");
	$('.exception-container').attr("class", kelas);
}