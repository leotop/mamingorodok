<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
header("Content-type: text/html; charset=windows-1251");
?>
<div class="enter_popap hidden popupContainer" id="naDiv">
	<h1>Укажите Ваши данные, чтобы мы могли оповестить Вас</h1>
	<form action="/bitrix/templates/nmg/ajax/notifyAvail.php" method="post" id="naForm">
		<input type="hidden" name="frmNASent" value="Y">
		<input type="hidden" name="naProduct" id="naProduct" value="">
		<input type="hidden" name="naOffer" id="naOffer" value="">
		<div class="notify"></div>
		<ul>
			<li>Имя*</li>
			<li>
				<input type="text" name="naName" value="" class="i">
			</li>
			<li>Телефон*</li>
			<li>
				<input type="text" name="naPhone" value="" class="i">
			</li>
			<li>Email*</li>
			<li>
				<input type="text" name="naEmail" value="" class="i">
			</li>
			<li class="last">
				<input type="button" value="Отправить" id="naSend" class="input2" onclick="submitForm();">
			</li>
		</ul>
		<a title="" href="#" onClick="$('.popupContainer').hide(); $('.overlay').hide(); return false;" class="closePopupContainer close1"></a>
	</form>  
</div>
<script type="text/javascript">
/*$(document).ready(function() {
	$("#naSend").click(function() {
        alert(result);
		strSend = '';
		$.ajax({
			type: $("#naForm").attr('method'),
			url:  $("#naForm").attr('action'),
			data: $("#naForm").serialize(),
			success: function(result) {
				//showPopupContainer($("#naDiv"));
				$("#naDiv .notify").html(result);
			}
		})
	});
})*/
function submitForm() {

        strSend = '';
        $.ajax({
            type: $("#naForm").attr('method'),
            url:  $("#naForm").attr('action'),
            data: $("#naForm").serialize(),
            success: function(result) {
                showPopupContainer($("#naDiv"));
                $("#naDiv .notify").html(result);
                $(".popupContainer h1").html('Товар добавлен в список ожидания');
            }
        })  
}
</script>
