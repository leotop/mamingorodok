<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
header("Content-type: text/html; charset=windows-1251");
?>
<div class="enter_popap hidden popupContainer" id="feedbackFormDiv">
	<h1>Обратная связь</h1>
	<form action="/bitrix/templates/nmg/ajax/feedbackSend.php" method="post" id="fbForm">
		<input type="hidden" name="frmFBSent" value="Y" />
		<div class="notify"></div>
		<input type="text" name="fbNameLast" value="" class="i capfield">
		<ul>
			<li>Имя *</li>
			<li><input type="text" name="fbName" value="" class="i"></li>
			<li>Email *</li>
			<li><input type="text" name="fbEmail" value="" class="i"></li>
			<li>Телефон *</li>
			<li><input type="text" name="fbPhone" value="" class="i"></li>
			<li>Текст сообщения *</li>
			<li><textarea style="width:268px;" name="fbComment"></textarea></li>		
			<li class="last"><input type="button" value="Отправить" id="fbSend" class="input2"></li>
		</ul>
		<a title="" href="#" onClick="$('.popupContainer').hide(); $('.overlay').remove(); return false;" class="closePopupContainer close1"></a>
	</form>
</div>
<script type="text/javascript">
$(document).ready(function() {
	$("#fbSend").click(function() {
		strSend = '';
		$.ajax({
			type: $("#fbForm").attr('method'),
			url:  $("#fbForm").attr('action'),
			data: $("#fbForm").serialize(),
			success: function(result) {
				showPopupContainer($("#feedbackFormDiv"));
				$("#feedbackFormDiv .notify").html(result);
			}
		})
	});
})
</script>
