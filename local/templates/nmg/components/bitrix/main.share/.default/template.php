<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
if (strlen($arResult["PAGE_URL"]) > 0):

	?>

		<? if (is_array($arResult["BOOKMARKS"]) && count($arResult["BOOKMARKS"]) > 0): ?>	
			<?
			foreach($arResult["BOOKMARKS"] as $name => $arBookmark)
			{
				?><?=$arBookmark["ICON"]?><?
				//if ($name == 0)
				//	echo htmlspecialchars($arBookmark["ICON"]);
			}
			?>
			
		<? endif; ?>
	<?
endif;
?>