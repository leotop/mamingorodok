<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?
if (strlen($arResult["PAGE_URL"]) > 0):

	?>
	<div class="share-window-parent">
	<div id="share-dialog<?echo $arResult["COUNTER"]?>" class="share-dialog share-dialog-<?=$arParams["ALIGN"]?>" style="display: <?=(array_key_exists("HIDE", $arParams) && $arParams["HIDE"] == "Y" ? "none" : "block")?>;">
		<div class="share-dialog-inner share-dialog-inner-<?=$arParams["ALIGN"]?>">
		<? if (is_array($arResult["BOOKMARKS"]) && count($arResult["BOOKMARKS"]) > 0): ?>	
			<table cellspacing="0" cellpadding="0" border="0" class="bookmarks-table">
			<tr>
			<?
			foreach($arResult["BOOKMARKS"] as $name => $arBookmark)
			{
				?><td class="bookmarks"><?=$arBookmark["ICON"]?></td><?
			}
			?>
			
			</tr>		
			</table>	
		<? endif; ?>
		</div>		
	</div>
	</div>
	&nbsp;
	<?
endif;
?>