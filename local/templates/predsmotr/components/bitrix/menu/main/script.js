$(document).ready(function() {
	$(".menuhover").mouseover(function () {
		$(this).next().addClass("hvrLnk");
		return false;
	});
	$(".menuhover").mouseout( function(){
		$(this).next().removeClass("hvrLnk");
		return false;
	});

});