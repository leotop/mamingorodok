<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
if(is_array($arResult["ROWS"]) && count($arResult["ROWS"])>0)
{ ?>


<div class="main_product_headline"><?
    global $arrFilterNew;
    if($arrFilterNew["PROPERTY_NOVINKA_VALUE"] == "��"){?>
       <p>�������</p>                        
    <?}else if($arrFilterNew["PROPERTY_KHIT_PRODAZH_VALUE"] == "��"){?>
       <p>���� ������</p>  
    <?}
	if(false)
	{?>
	<a href="/catalog/title/desired/" title="�������� ���">�������� ���</a><?
	}?>
	<div class="clear"></div>
</div>
<ul class="main_product_list"><?
	foreach($arResult["ROWS"] as $arItems)
	{
		foreach($arItems as $intCnt => $arElement)
		{

			$arFileTmp = CFile::ResizeImageGet(
				$arElement["DETAIL_PICTURE"],
				array("width" => 160, 'height' => 160),
				BX_RESIZE_IMAGE_PROPORTIONAL,
				false
			);
            $price = GetOfferMinPrice($arParams["IBLOCK_ID"],$arElement["ID"]);
			?>
            <?if(!empty($arElement)){?>
	        <li<?=(($intCnt+1)%4==0?' class="last"':'')?>><?
			    if(strlen($arFileTmp["src"])>0)
			    {?> <?//arshow($arElement["PROPERTIES"]["KHIT_PRODAZH"],true)?>
		            <div class="photo">
                        <?$APPLICATION->IncludeFile("/includes/shields_2.php",array("props" => $arElement["PROPERTIES"], "size" => 25, /*"align" => array("left" => "auto","right" => "0px")*/),array("SHOW_BORDER" => false))?>

                        <p><a href="<?=$arElement['DETAIL_PAGE_URL']?>" title="<?=$arElement['NAME']?>"><img src="<?=$arFileTmp["src"]?>" alt="<?=$arElement['NAME']?>" /></a><span>&nbsp;</span></p>
		            </div><?
			    }?>
		        <?$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH.'/includes/raiting.php', array('Raiting'=>$arElement["PROPERTIES"]['RATING']["VALUE"]));?>
		        <div class="link"><a href="<?=$arElement['DETAIL_PAGE_URL']?>" title="<?=$arElement['NAME']?>" ><?=smart_trim($arElement['NAME'], 48)?></a></div>

		<!--<span class="fat top_price"><?=CurrencyFormat($arElement["PROPERTIES"]['PRICE']["VALUE"], "RUB")?></span> --> 
                <?
                    

			        if($price <= 0 or $price == ""){
				        echo '<span class="fat top_price" style="font-size:16px">��� � �������</span>';
			        }else 
                    {?>
                        <span class="fat top_price"><?=number_format($price, 0, '.', ' ' );?> <div class="rub_none">���.</div><span class="rouble">a</span></span><?
                    }?>
                            <?
				            /*if($arElement["PROPERTIES"]['OLD_PRICE']["VALUE"])
			{
				?><i class="oldprice"><?=CurrencyFormat($arElement["PROPERTIES"]['OLD_PRICE']["VALUE"], "RUB")?></i><?
			}*/?>
                    <?echo showNoindex();?>
                    <div class="comparison">
                        <input type="checkbox" class="input2 add-to-compare-list-ajax" value="<?=$arElement["ID"]?>" />
                        <i title="/catalog/compare/">��������</i>
                        <?
                        if(false)
                        {
                            ?><span></span><?
                        }?>
                    </div><?
                    echo showNoindex(false);?>
            
                    <?if(strlen($arElement["PROPERTY_CH_SNYATO_ENUM_ID"]) <= 0 || $arElement["PROPERTY_CH_SNYATO_ENUM_ID"] == 2100923)
                    {
                        ?><i class="addToCartList" title="<?=$arElement["DETAIL_PAGE_URL"]?>"><button type="button" class="input21">������</button></i><?
                    } elseif($arElement["PROPERTY_CH_SNYATO_ENUM_ID"] == 2100920) {
                        ?>�������! ������� ��������.<?
                    }?>

	</li>
    <?}?>
    <?
		}
	}?>
</ul><?
}
?>
<div class="clear"></div>