<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();?>
<?
$arGPictures = array(
	'/i/g1.jpg',
	'/i/g2.jpg',
	'/i/g3.jpg',
);
$arItems = array();
$arItems[] = array('NAME'=>'ѕлатье Sue Wong Ombre Beaded Lo...', 'PIC'=>$arGPictures[rand(0, count($arGPictures)-1)], 'RAITING'=>rand(0, 5), 'OLD_PRICE'=>rand(10, 100000), 'PRICE'=>rand(1500, 20000));
$arItems[] = array('NAME'=>'»грушка "Sue Wong";', 'PIC'=>$arGPictures[rand(0, count($arGPictures)-1)], 'RAITING'=>rand(0, 5), 'OLD_PRICE'=>rand(10, 100000), 'PRICE'=>rand(100, 100000));
$arItems[] = array('NAME'=>'ћ€гка€ игрушка "Avent Cat"', 'PIC'=>$arGPictures[rand(0, count($arGPictures)-1)], 'RAITING'=>rand(0, 5), 'OLD_PRICE'=>rand(10, 100000), 'PRICE'=>rand(10, 20000));
$arItems[] = array('NAME'=>'»грушка "—неговик-моговик" м€гка€ с носом-морковкой', 'PIC'=>$arGPictures[rand(0, count($arGPictures)-1)], 'RAITING'=>rand(0, 5), 'OLD_PRICE'=>rand(10, 100000), 'PRICE'=>rand(100, 20000));


$arItem = $arItems[rand(0, count($arItems)-1)];

?>
<div class="item <?=($FirstItem ? 'first' : ($LastItem ? 'last' : ''))?>"><div class="align_center_to_left">
	<?if($WithClose):?>
		<div class="ItemClose"></div>
	<?endif;?>
	<div class="align_center_to_right"><a class="Pic" href="/catalog/2/385/"><?=ShowIImage($arItem['PIC'])?></a></div>
	<?if(!$NoRaiting):?>
		<div class="align_center_to_right"><?$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH.'/includes/raiting.php', array('Raiting'=>$arItem['RAITING']));?></div>
	<?endif?>
	<div class="align_center_to_right"><a class="Name" href="/catalog/2/385/"><?=$arItem['NAME']?></a></div>
	<?if($WithDisc):?>
		<div class="align_center_to_right"><div class="OldPrice"><?=number_format($arItem['OLD_PRICE'], 0, '.', ' ')?> <span class="Currency">руб</span></div></div>
		<div class="align_center_to_right"><div class="NewPrice"><?=number_format($arItem['PRICE'], 0, '.', ' ')?> <span class="Currency">руб</span></div></div>
	<?else:?>
		<div class="align_center_to_right"><div class="Price"><?=number_format($arItem['PRICE'], 0, '.', ' ')?> <span class="Currency">руб</span></div></div>
	<?endif;?>
	<?if($InBasket):?>
		<div class="align_center_to_right"><div class="ToBasket"></div></div>
	<?endif;?>
</div></div>
<?if($BrList):?><div class="clear"></div><?endif;?>