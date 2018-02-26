$(".alert-success").show("slow").delay(2000).hide("slow");

$(document).ready(function() {
	$('#btnGenerate').on("click", function() {
		window.open("display-results.php");
	})
})