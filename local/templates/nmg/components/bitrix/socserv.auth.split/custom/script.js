$(function() {
	$("#soclink .bx-auth-serv-icons a").each(function() {
		var obT = $(this);

		obT.find("i").after(obT.attr("title"));
	});
})