<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();


// �������� ��� ������� 2 ������ ��� �������
$rsSec = CIBlockSection::GetList(Array("SORT"=>"ASC", "NAME"=>"ASC"), array("IBLOCK_ID"=>$arParams["IBLOCK_ID"], "ACTIVE"=>"Y", "GLOBAL_ACTIVE" => "Y", "DEPTH_LEVEL" => 2));
while($arSec = $rsSec -> GetNext()) 
{
    //arshow($arSec);
    $arResult["SUBSECTIONS"][$arSec["IBLOCK_SECTION_ID"]][] = '<li><a href="/catalog/'.$arSec["CODE"].'/">'.$arSec["NAME"].'</a></li>';
}

//arshow($arResult["SUBSECTIONS"]);
?>
<div class="left_column_bg">
    <div class="oh3 discounts">
		<a href="/catalog/raspradazha/">����������</a><br><br>
        <a href="/discounts/">�����</a>

    </div><?

$strTmp = '';
foreach($arResult["SECTIONS"] as $key => $arSection)
{   //echo $arSection["ID"];
    //arshow($arResult["SUBSECTIONS"]);
    if(is_array($arResult["SUBSECTIONS"][$arSection["ID"]]) && count($arResult["SUBSECTIONS"][$arSection["ID"]])>0)
    {   
        $strTmp .= '<div class="oh3">'.$arSection["NAME"].'</div><ul>'.implode(" ", $arResult["SUBSECTIONS"][$arSection["ID"]]).'</ul>';
    }
    elseif($arSection["ID"] == 432) {
        $strTmp .= '<div class="oh3"><a href="'.$arSection["SECTION_PAGE_URL"].'">'.$arSection["NAME"].'</a></div>';
    }
}
echo $strTmp;
?>
</div>