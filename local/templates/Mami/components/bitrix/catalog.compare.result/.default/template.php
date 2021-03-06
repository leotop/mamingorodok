<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?        
global $USER;
$user_id = $USER->GetID();
// �������� ��� ���������� id ��������������
foreach($arResult["ITEMS"] as $k => $arItem)
{
    foreach($arItem["PROPERTIES"] as $arProp)
    {
        if ($arProp["CODE"] != "CH_PRODUCER")
            continue;
            
        foreach($arProp["VALUE"] as $value)
        {   
            if (!in_array($value, $arProducerIDs))
                $arProducerIDs[] = $value;
        }
    }
      
	if(!$USER->IsAuthorized()):
		$arResult["ITEMS"][$k]["ADD_TO_WISH"] = '<div id="BabyList"><div class="BabyListCenter"><div class="DIcon" ></div> <a class="showpUp greydot heartDICON" href="#messageNoUser1">� ������ ������</a><div class="clear"></div></div></div>';
	else:	  
		$dbEl = CIBlockElement::GetList(Array(), Array("IBLOCK_ID"=>WISHLIST_IBLOCK_ID, "ACTIVE"=>"Y", "PROPERTY_USER_ID" => $user_id, "PROPERTY_PRODUCT_ID" => $arItem["ID"]), false, false, array("ID", "IBLOCK_ID"));
		if($obEl = $dbEl->GetNext())
			$arResult["ITEMS"][$k]["ADD_TO_WISH"] = '<div class="action prod_id'.$arItem["ID"].'" id="BabyList"><div class="DIcon" ></div> <a href="/community/user/'.$user_id.'/">��� � ������ ������</a><div class="clear"></div></div>';
		else
			$arResult["ITEMS"][$k]["ADD_TO_WISH"] = '<div class="action prod_id'.$arItem["ID"].'" id="BabyList"><div class="DIcon" ></div> <a class="add" href="#">� ������ ������</a><div class="clear"></div></div>';
	endif;
}

// �������� �� �������� �������������� �� �� id
$dbEl = CIBlockElement::GetList(Array(), Array("IBLOCK_ID"=>PRODUCERS_IBLOCK_ID, "ACTIVE"=>"Y", "ID" => $arProducerIDs), false, false, array("ID", "IBLOCK_ID", "NAME"));    
while($obEl = $dbEl->GetNext())    
{           
    $arGetProducerNameByID[$obEl["ID"]] = $obEl["NAME"];
}

foreach($arResult["ITEMS"][0]["PROPERTIES"] as $arProperty)
{
    if (strpos($arProperty["CODE"], "CH_") !== false)
        $arProperties[] = $arProperty;
}

?>
<div id="compare-list">
<div id="user-id" style="display:none;"><?=$user_id;?></div>
<table class="CompareCatalog" width="100%">
    <tr class="Pictures">
        <td class="first">&nbsp;</td>
        <?foreach($arResult["ITEMS"] as $arItem):?>
            <td><a href="?ID[]=<?=$arItem["ID"]?>&action=DELETE_FROM_COMPARE_RESULT&IBLOCK_ID=<?=CATALOG_IBLOCK_ID?>" class="remove"></a><a href="<?=$arItem["DETAIL_PAGE_URL"]?>"><?=ShowImage($arItem["PREVIEW_PICTURE"]["SRC"],150,150)?></a></td>    
        <?endforeach?>
    </tr>
    <tr class="Names">
        <td class="first">&nbsp;</td>
        <?foreach($arResult["ITEMS"] as $arItem):?>
            <td><a href="<?=$arItem["DETAIL_PAGE_URL"]?>"><?=$arItem["NAME"]?></a></td>
        <?endforeach?>
    </tr>
    <tr class="Prices">
        <td class="first">&nbsp;</td>
        <?foreach($arResult["ITEMS"] as $arItem):?>
            <td><?=$arItem["PROPERTIES"]["PRICE"]["VALUE"]?> <span>���.</span></td>
        <?endforeach?>
    </tr>
    <tr class="Basket">
        <td class="first">&nbsp;</td>
        <?foreach($arResult["ITEMS"] as $arItem):?>
            <td>
			<?if($arItem["SHOW_BACKET"]==1):?>
			<a href="/select-color-and-size.php?id=<?=$arItem["ID"]?>" class="ToBasket-compare add-to-basket"></a>
			<?else:?>
			<div class="add-to-basket-none"></div>
			<?endif;?>
			</td>
        <?endforeach?>
    </tr>
    
    <tr class="Actions">
        <td class="first">
            <div class="choose">
                <span class="active"><span><a href="?">�������</a></span></span>
                <span><span><a href="?">��� ��������������</a></span></span>
                <div class="clear"></div>
            </div>
        </td>
        <?foreach($arResult["ITEMS"] as $arItem):?>
            <td><div id="product-id<?=$arItem["ID"];?>" style="display:none;"><?=$arItem["ID"]?></div><?=$arItem["ADD_TO_WISH"];?></td>
        <?endforeach?>
    </tr>
    <tr class="Reviews">
        <td class="first">&nbsp;</td>
        <?foreach($arResult["ITEMS"] as $arItem):?>
            <td>
			<?if(is_array($arItem["blog"])):?>
			<a href="<?=$arItem["blog"]["PATH"]?>">��������� ����� ������</a>
			<?else:?>
			&nbsp;
			<?endif;?>
			</td>
        <?endforeach?>      
    </tr>
    <tr class="do-compare">
        <td class="first">�������</td>
        <?foreach($arResult["ITEMS"] as $arItem):?>
            <td><?$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH."/includes/raiting.php", array('Raiting'=>$arItem["PROPERTIES"]['RATING']["VALUE"]), array("MODE"=>"html") );?></td>
        <?endforeach?>
    </tr>
    <?foreach($arProperties as $arProp):?>
	<?if(in_array($arProp["CODE"],$arResult["HAVE"])):?>
    <tr class="do-compare">
        <td class="first"><?=$arProp["NAME"]?></td>
        <?foreach($arResult["ITEMS"] as $arItem):?>     
            <td>
                <?if ($arProp["CODE"] == "CH_PRODUCER"):?>
                    <?=$arGetProducerNameByID[$arItem["PROPERTIES"][$arProp["CODE"]]["VALUE"][0]]?>
				<?elseif ($arProp["CODE"] == "CH_OSOBEN"):?>
					<?if(!empty($arItem["PROPERTIES"][$arProp["CODE"]]["VALUE"]["TEXT"])):?>
						<?=$arItem["PROPERTIES"][$arProp["CODE"]]["~VALUE"]["TEXT"];?>
						<?//print_R(arItem["PROPERTIES"][$arProp["CODE"]]);?>
					<?else:?>
						<center><div class="compare_dot"></div></center>
					<?endif;?>
				<?elseif ($arProp["CODE"] == "CH_INSTR1"):?>
					<?//=$arItem["PROPERTIES"][$arProp["CODE"]]["VALUE"]["TEXT"];?>
                <?else:?>
					<?if(is_array($arItem["PROPERTIES"][$arProp["CODE"]]["VALUE"])):?>
						<?if(!empty($arItem["PROPERTIES"][$arProp["CODE"]]["VALUE"])):?>
							<?=implode(", ",$arItem["PROPERTIES"][$arProp["CODE"]]["VALUE"])?>
						<?else:?>
							<center><div class="compare_dot"></div></center>
						<?endif;?>
					<?else:?>
						<?if(!empty($arItem["PROPERTIES"][$arProp["CODE"]]["VALUE"])):?>
							<?=$arItem["PROPERTIES"][$arProp["CODE"]]["VALUE"]?>
						<?else:?>
							<center><div class="compare_dot"></div></center>
						<?endif;?>
						
					<?endif;?>
                <?endif?>
                
            </td>
        <?endforeach?>
    </tr>
	<?endif;?>
    <?endforeach?>
</table>
</div>


<div id="messageNoUser1" class="CatPopUp">
<div class="white_plash">
<div class="exitpUp"></div>
<div class="cn tl"></div>
<div class="cn tr"></div>
<div class="content">
<div class="content">
<div class="content">
<div class="clear"></div>
	��� ���� ����� �������� ����� � "������ ������" ��������� <a href="/personal/registaration/">�����������</a>.
</div>
</div>
</div>
<div class="cn bl"></div>
<div class="cn br"></div>
</div>
</div>
