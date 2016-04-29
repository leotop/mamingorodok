<?if($arChoose):?>
<?//xvar_dump($arChoose);?>
<div class="choose">
<?foreach($arChoose as $arCh):?>
	<span <?=($arCh['ACTIVE'] ? 'class="active"' : '')?>><span><a href="<?if(!empty($arCh["LINK"])):?><?=$arCh["LINK"];?><?else:?>?<?endif;?>"><?=$arCh['NAME']?><?if($arCh['ACTIVE'] && $arCh['SORT']=='UP'):?><i class="up"></i><?elseif($arCh['ACTIVE'] && $arCh['SORT']=='DOWN'):?><i class="down"></i><?endif;?></a></span></span>
<?endforeach?>
<div class="clear"></div>
</div>
<?endif;?>