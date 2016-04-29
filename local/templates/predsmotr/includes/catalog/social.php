<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

if(SITE_TEMPLATE_ID == "predsmotr")
{ ?>
<div style="float:left; margin-right:10px;">
    <div id="fb-root"></div>
    <script src="http://connect.facebook.net/ru_RU/all.js#xfbml=1"></script>
    <fb:like href="http://<?=$_SERVER["HTTP_HOST"]?><?=$APPLICATION->GetCurPage();?>" send="false" layout="button_count" width="100" show_faces="true" font=""></fb:like>
</div>
<div style="float:left; width:55px;">
<!-- Place this tag where you want the +1 button to render. -->
<div class="g-plusone" data-size="medium"></div>

<!-- Place this tag after the last +1 button tag. -->
<script type="text/javascript">
  window.___gcfg = {lang: 'ru'};

  (function() {
    var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
    po.src = 'https://apis.google.com/js/plusone.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
  })();
</script>
</div>
<div style="float:right;"><script type="text/javascript">
  VK.init({apiId: 2463401, onlyWidgets: true});
</script> 
    <!-- Put this div tag to the place, where the Like block will be -->
    <div id="vk_like"></div>
    <script type="text/javascript">
VK.Widgets.Like("vk_like", {type: "button", pageTitle: '<?=$arResult["NAME"]?>'});
</script>
</div>


<?
} else {
    ?>
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
<div id="fb-root"></div>
<script src="http://connect.facebook.net/ru_RU/all.js#xfbml=1"></script>
<fb:like href="http://<?=$_SERVER["HTTP_HOST"]?><?=$APPLICATION->GetCurPage();?>" send="false" layout="button_count" width="100" show_faces="true" font=""></fb:like>
<?
}
?>
