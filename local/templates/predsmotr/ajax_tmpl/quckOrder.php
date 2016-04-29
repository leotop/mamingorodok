<?
header("Content-type: text/html; charset=windows-1251");
?>
<div class="enter_popap hidden popupContainer" id="quickOrderDiv">
	<form action="/bitrix/templates/nmg/ajax/quickOrder.php" method="post" id="quickOrderForm">
		<input type="hidden" name="frmQuickOrderSent" value="Y">
		<input type="hidden" name="qoProduct" id="qoProduct" value="">
		<div class="notify"></div>
		<ul>
			<li>Имя*</li>
			<li>
				<input type="text" name="qoName" value="" class="i">
			</li>
			<li>Телефон*</li>
			<li>
				<input type="text" name="qoPhone" value="" class="i">
			</li>
			<li>Email*</li>
			<li>
				<input type="text" name="qoEmail" value="" class="i">
			</li>
			<li>Комментарий</li>
			<li>
				<textarea style="width:268px;" name="qoComment"></textarea>
			</li>
			<li class="last">
				<input type="button" value="Оформить заказ" id="qoSend" class="input2">
			</li>
		</ul>
		<a title="" href="#" onClick="$('.popupContainer').hide(); $('.overlay').remove(); return false;" class="closePopupContainer close1"></a>
	</form>
</div>
<script type="text/javascript">
$(document).ready(function() {
	$("#qoSend").click(function() {
		strSend = '';
		$.ajax({
			type: $("#quickOrderForm").attr('method'),
			url:  $("#quickOrderForm").attr('action'),
			data: $("#quickOrderForm").serialize(),
			success: function(result) {
				showPopupContainer($("#quickOrderDiv"));
				$("#quickOrderDiv .notify").html(result);
			}
		})
	});
})
</script>
