<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();?>


<script type="text/javascript">
  VK.init({apiId: 2463401, onlyWidgets: true});
</script>

<!-- Put this div tag to the place, where the Like block will be -->
<div id="vk_like"></div>
<script type="text/javascript">
VK.Widgets.Like("vk_like", {type: "button", pageTitle: 'test!!'});
</script>
<div class="clear"></div>
<br />
<?global $APPLICATION;?>
<div id="fb-root"></div><script src="http://connect.facebook.net/ru_RU/all.js#xfbml=1"></script><fb:like href="http://<?=$_SERVER["HTTP_HOST"]?><?=$APPLICATION->GetCurPage();?>" send="false" layout="button_count" width="100" show_faces="true" font=""></fb:like>