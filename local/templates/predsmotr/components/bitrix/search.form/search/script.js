$(document).ready(function() {
	$(".searchInputField").focus(function() {
		obThis = $(this);
		if(obThis.val() == '����� �� �������') obThis.val("");
		obThis.addClass("black");
	}).blur(function() {
		if(obThis.val() == '')
		{
			obThis.val("����� �� �������");
			obThis.removeClass("black");
		}
		
		if(!obThis.hasClass("noGray"))
			obThis.removeClass("black");
	});
});