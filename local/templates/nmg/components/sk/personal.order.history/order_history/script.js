$(document).ready(function() {
	$("#btnOrderQuestion").click(function() {
		alert('dd');

		return false;
	});
});

function sendPopupQuestionOrder() {
	$.ajax({
		type: "POST",
		url: "/system/sendOrderQuestion.php",
		data: $("#sk-popup #frmOrderQuestion").serialize()
	})
		.done(function( strResult ) {
			if(strResult.indexOf("error") > -1)
				$("#sk-popup #popupOrderQuestionError").html(strResult+"<br /><br />");
			else $("#sk-popup #popupOrderQuestionOuter").html(strResult);
		});
}

function showPopupQuestionOrder(intOrderID) {
	var obPopup = new PopUps();
	obPopup.open("askOrderQuestionContainer");
	$(".sk-popup-holder #orderIDQuestion").val(intOrderID);
}