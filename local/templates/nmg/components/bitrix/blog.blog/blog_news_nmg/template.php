<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
CModule::IncludeModule("iblock");

if(count($arResult["POST"])>0)
{ ?>
<div class="main_product_headline">
	<p>Новое в интернет магазине "Мамин Городок"</p>
	<a class="index_all_news" href="/community/group/blog_news/">все новости</a>
	<div class="clear"></div>
</div>
<ul class="news_list"><?
	
	$i=0;
	$j=0;
	foreach($arResult["POST"] as $ind => $CurPost)
	{
		if($i%2==0 && $i>0) echo '
</ul>
<div class="clear"></div>
<ul class="news_list">';
		$intImage = array_shift($CurPost["IMAGES"]);
		if(intval($intImage)>0)
		{
			$arFile = CFile::GetFileArray($intImage);
			$arFileTmp = CFile::ResizeImageGet(
				$arFile,
				array("width" => 99, 'height' => 99),
				BX_RESIZE_IMAGE_PROPORTIONAL,
				false
			);
		}?>
	<li<?=($i%2==1?' class="second"':'')?>><?
		if(strlen($arFileTmp["src"])>0)
		{
			?><img src="<?=$arFileTmp["src"]?>" class="photo" alt="<?=$CurPost["TITLE"]?>" /><?
		}?>
		<div class="oh4"><?=CIBlockFormatProperties::DateFormat("j F", MakeTimeStamp($CurPost["DATE_CREATE"], CSite::GetDateFormat()))?></div>
		<p><a href="<?=$CurPost["urlToPost"]?>" title="<?=$CurPost["TITLE"]?>"><?=$CurPost["TITLE"]?></a></p>
		<br />
		<p><?=smart_trim(strip_tags($CurPost["TEXT_FORMATED"]), 250)?></p>
	</li>
		<?
		$i++;	
	}
	
	if($i%2==1) echo '<li>&nbsp;</li>';
	echo '</ul><div class="clear"></div>';
}
?>	