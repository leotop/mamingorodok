<?
$strTmp = $APPLICATION -> GetCurpageParam(); // для формирования ссылок
$arTmp = parse_url($_SERVER["REQUEST_URI"]);
$APPLICATION->SetCurPage($arTmp["path"], $arTmp["query"]);

if($arChoose)
{
    
	if (empty($_REQUEST["orderby"])) $_REQUEST["orderby"] = "";
	if (empty($_REQUEST["sort"])) $_REQUEST["sort"] = "DESC";
   // arshow($arChoose);
?>

<ul class="sorting_list">
	<li class="sort_title">Сортировать: </li><?
	foreach($arChoose as $arItem)
	{
            echo '<li'.($_REQUEST["orderby"] == $arItem["CODE"]?' class="active'.($_REQUEST["sort"] == "ASC"?' reverse':'').'"':'').'>';
                if ($_REQUEST["orderby"] == $arItem["CODE"] || count($arChoose) == 1)
                {
                    if ($_REQUEST["sort"] == "DESC")
                    {?>                                                                              
                        <a href="<?=$APPLICATION->GetCurPageParam('orderby='.$arItem["CODE"].'&sort=ASC', array('sort', 'orderby', "producerCode", "sef"))?>"><?=$arItem["NAME"]?></a><?
                    } else {?>
                        <a href="<?=$APPLICATION->GetCurPageParam('orderby='.$arItem["CODE"].'&sort=DESC', array('sort', 'orderby', "producerCode", "sef"))?>"><?=$arItem["NAME"]?></a></span></span><?
                    }
                } else {?>
                        <a href="<?=$APPLICATION->GetCurPageParam('orderby='.$arItem["CODE"].'&sort='.$arItem["sort"], array('sort', 'orderby', "producerCode", "sef"))?>"><?=$arItem["NAME"]?></a><?    
                    } 	
        echo '</li>';
	}?>
    
</ul><?
}

$strTmp = $APPLICATION -> GetCurpageParam(); // возвращаем чтобы ничего не сломать
$arTmp = parse_url($strTmp);
$APPLICATION->SetCurPage($arTmp["path"], $arTmp["query"]);
?>
