<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'):
    
$productID = intval($_GET['id']);
$action = $_GET['action'];
$count = intval($_GET['quantity']);
$user_id = intval($_GET['user_id']);

$strOk = '';
$strError = '';

if($action=="ADD2BASKET"){
	if($count>0 && $user_id>0 && $productID>0){
		$strOk = "Товар успешно добавлен";
		$_SESSION["buyfriend"][$user_id][$productID] = $count;
	}
	else{
		$strError = "Ошибка добавления товара";
	}
}

if(strlen($strError) > 0)
{
    ShowError($strError);
}
?>
<div id="message-body">
    <?if (strlen($strError) == 0):?>
        Товар успешно добавлен в корзину
        <br /><br />
        <a href="/basketFriend/<?=$user_id?>/" id="canbuyfriend">оформить заказ</a>&nbsp;&nbsp;&nbsp;<a class="fancybox-close-basket" href="#">добавить еще товаров</a>
    <?endif?>
</div>

<style type="text/css">
    #message-body {
        width:450px;
        height:60px;
        text-align: center;
    }
</style>

<script type="text/javascript">
$(".fancybox-close-basket").click(function(){
    $("#fancybox-content").bind('click', $.fancybox.close);
	
});
</script>



<?else:?>

    <?CHTTP::SetStatus("404 Not Found");
    @define("ERROR_404","Y");
    $APPLICATION->SetTitle("Страница не найдена");?>

<?endif?>