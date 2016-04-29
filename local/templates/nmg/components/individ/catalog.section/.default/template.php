<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

$isSearch = $arParams["SEARCH"] == "Y";

$strH1 = $arResult["META"]["H1"];
$strH2 = $arResult["META"]["H2"];

if($GLOBALS["SET_SEO"]["type"] == 'producer')
{
  $strCategoryName = $arResult["PATH"][count($arResult["PATH"])-1]["NAME"];
  $strProducer = $GLOBALS["SET_SEO"]["DATA"]["NAME"];
  
  //$strH1 = "������� ".ToLower($strCategoryName).' '.$strProducer;
  $strH1 = $strCategoryName.' '.$strProducer;
  //$strH2 = $strH1;
} elseif($GLOBALS["SET_SEO"]["type"] == 'property') {
  $strCategoryName = $arResult["PATH"][count($arResult["PATH"])-1]["NAME"];
  $strH1 = $strCategoryName.' '.ToLower($GLOBALS["SET_SEO"]["DATA"]["ENUM"]["VALUE"]);
  $strH2 = $strH1;
}

if(strlen($arResult["SEO"]["H1"])>0) $strH1 = $arResult["SEO"]["H1"];
if(strlen($arResult["SEO"]["H2"])>0) $strH2 = $arResult["SEO"]["H2"];



if(!$isSearch)
{
	if(preg_match("#/catalog/brend-.*/#", $APPLICATION->GetCurDir()))
		$strH1Addon = '������� ������ ';
	else $strH1Addon = '';
?><br>
<h1 class="secth"><?=$strH1Addon.$strH1?></h1><?

if($arParams["brendID"]<=0)
{
    if($_REQUEST["set_filter"] == "Y") $arResult["DESCRIPTION"] = '';
    if(strlen($arResult["SEO"]["SEO_TEXT"])>0)
    {
      $arResult["DESCRIPTION"] = $arResult["SEO"]["SEO_TEXT"];
      $arResult["~DESCRIPTION"] = $arResult["SEO"]["SEO_TEXT"];
    }
  }
} else echo '<h1>���������� ������</h1>';

if($_REQUEST["set_filter"]=="Y" && (count($arResult["ROWS"])<=0) || !is_array($arResult["ROWS"]))
{ ?>
<div class="search-page">
  <div class="top15"></div>
  <div>�������� ������ ��� ���������� �������� � <a href="/catalog/">��������</a>.</div>
</div><?
  return false;
} elseif($isSearch) {
  if((count($arResult["ROWS"])<=0) || !is_array($arResult["ROWS"]))
  {
  ?>
<div class="search_block"><div class="inputs">
  <form action="/tools/search/">
    <input type="text" value="<?=(strlen($_REQUEST["q"])>0?htmlspecialcharsEx($_REQUEST["q"]):'����� �� �������')?>" name="q" class="input1 searchInputField noGray black">
    <button value="" class="input2" type="submit" name="s" id=""><span class="png"><span class="png"><nobr></nobr></span></span></button>
  </form>
</div><br clear="all"><br>�� ������ ������� ������ �� �������. ���������� �������� ������ ��� ������ ����� � ��������.</div><?
  } else {
    if(strlen($_REQUEST["q"])>0)
    { ?>
<script type="text/javascript">
  $(document).ready(function() {
    $("#searchInputField").val("<?=htmlspecialcharsEx($_REQUEST["q"])?>").addClass("black");
  });
</script><?
    }
  }
}

if(empty($_REQUEST["brendCode"]))
{
  echo showNoindex();
?>
<div class="sorting_block"><?
  if(!$isSearch)
  {?>
  <?$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH.'/includes/catalog/choose_nmg.php',array("arChoose"=>array(
        "0"=>array("NAME"=>"�� ����", "CODE"=>'PROPERTY_PRICE'),
       // "1"=>array("NAME"=>"�������", "CODE" => "PROPERTY_NEW"),
       // "2"=>array("NAME"=>"�������", "CODE" => "SORT"),
       // "3"=>array("NAME"=>"�������", "CODE" => "PROPERTY_RATING"),
      //  "4"=>array("NAME"=>"������������", "CODE" => "PROPERTY_SALES_RATING"),
    )));?><?
  }?>
  <?=$arResult["NAV_STRING"]?>
  <div class="clear"></div>
</div>
<?=showNoindex(false)?><?
}

?>
<div class="catalog_block">
  <ul class="catalog_list"><?
$intLastSection = 0;
foreach($arResult["ROWS"] as $arRow)
{
  foreach($arRow as $arElement)
  {
    if (intval($arElement["ID"])==0) continue;

    if($arParams["brendID"]>0)
    {
      if($arElement["IBLOCK_SECTION_ID"] != $intLastSection)
      {
        if($intLastSection > 0) echo '<div class="clear"></div>';
        echo '<div class="crumbs"><a href="'.$arResult["BREND_SECTIONS"][$arElement["IBLOCK_SECTION_ID"]]["SECTION_PAGE_URL"].'proizvoditel_'.$arResult["BREND"]["CODE"].'/">'.$arResult["BREND_SECTIONS"][$arElement["IBLOCK_SECTION_ID"]]["NAME"].' '.$arResult["BREND"]["NAME"].'</a></div>';
        $intLastSection = $arElement["IBLOCK_SECTION_ID"];
      }
    }
    ?>
    <li>
      <div class="catalog_bg stock-item"><?   
    if($arElement["ACTIVE"] == "N")
      echo '<div class="element_inactive">�������������</div>';
    if(isset($arResult["ACTIONS_ITEMS"][$arElement["ID"]]))
    {
      $arAction = $arResult["ACTIONS"][$arResult["ACTIONS_ITEMS"][$arElement["ID"]]];
      $isSpecOffer = $arAction["PROPERTY_SPECOFFER_ENUM_ID"]>0;
      
      if($isSpecOffer)
      {?>
<div class="wrap-specialoffert">
  <a href="<?=$arElement['DETAIL_PAGE_URL']?>" title="���������������!" class="btt-specialoffert">���������������!</a></div><?
      }?>
        <div class="prize"><?
      if(!$isSpecOffer)
      {?>
          <a href="#" target="_blank"><div class="gift_bg"></div></a><?
      }?>
        <div class="gift_info ">
        <div class="gift_info_text">
            <div style="text-align: center;">�����!</div> <?=$arAction["PREVIEW_TEXT"]?>                                         
        </div><div class="gift_info_bg"></div></div></div><?
    }

        $arFileTmp = CFile::ResizeImageGet(
          $arElement["PREVIEW_PICTURE"]["ID"],
          array("width" => 160, 'height' => 160),
          BX_RESIZE_IMAGE_PROPORTIONAL,
          false
        ); 
    
        ?>
        <div class="photo">
            <?$APPLICATION->IncludeFile("/includes/shields_2.php",array("props" => $arElement["PROPERTIES"]),array("SHOW_BORDER" => false))?>
            
            <p>
                <i title="<?=$arElement['DETAIL_PAGE_URL']?>">
                    <img 
                        src="<?=$arFileTmp["src"]?>" 
                        alt="<?=(empty($arElement["PROPERTY_SEO_H1_VALUE"])?$arElement["NAME"]:$arElement["PROPERTY_SEO_H1_VALUE"])?>"
                    >
                </i>
                <span>&nbsp;</span>
            </p>
        </div>
          <?
    if(!$isSearch)
      $strAddon = '#REPORT_COUNT_'.$arElement["ID"].'#';
    else $strAddon = '<a class="comment grey" href="'.$arElement['DETAIL_PAGE_URL'].'/#comment">�������� �����</a>';
    if(strlen($arElement["PROPERTIES"]["MODEL_3D"]["VALUE"])>0)
      $strAddon .= '<a class="ttp_lnk 3dlink" onclick="window.open(\'/view360.php?idt='.$arElement["ID"].'\', \'wind1\',\'width=900, height=600, resizable=no, scrollbars=yes, menubar=no\')" href="javascript:" title="��������� 3D - ������"><i class="img360">3D ������</i></a>';
          echo showNoindex();
          $APPLICATION->IncludeFile(SITE_TEMPLATE_PATH."/includes/raiting.php", array("strAddon" => $strAddon, 'Raiting'=>$arElement["PROPERTIES"]['RATING']["VALUE"]), array("MODE"=>"html"));
          echo showNoindex(false); ?>
        <div class="link"><a href="<?=$arElement['DETAIL_PAGE_URL']?>" title="<?=$arElement["NAME"]?>"><?=smart_trim($arElement['NAME'], 70)?></a></div><?
    if(false)
    {?>
        <div class="textPreview"><?=smart_trim(strip_tags($arElement["DETAIL_TEXT"]), 120)?></div><?
    }?>
        <div class="price">
          <?
    if(($arElement["PROPERTY_CH_SNYATO_ENUM_ID"] == 2100916) || (empty($arElement["PROPERTIES"]["PRICE"]["VALUE"])))
      echo '<span class="currency" style="width: 100%;font-size:12px">��� � �������</span>';
    else {
        ?><span class="currency" style="width: auto;"><?=CurrencyFormat($arElement["PROPERTIES"]["PRICE"]["VALUE"], "RUB")?></span><?
      if($arElement["PROPERTIES"]["OLD_PRICE"]["VALUE"]>0)
      {?>
            <i><?=CurrencyFormat($arElement["PROPERTIES"]["OLD_PRICE"]["VALUE"], "RUB")?></i><?
      };
    }?>
        </div><?
    if(strlen($arElement["PROPERTY_CH_SNYATO_ENUM_ID"]) <= 0 || $arElement["PROPERTY_CH_SNYATO_ENUM_ID"] == 2100923)
    {
      ?><i class="addToCartList" title="<?=$arElement["DETAIL_PAGE_URL"]?>"><button type="button" class="input21">������</button></i><?
    } elseif($arElement["PROPERTY_CH_SNYATO_ENUM_ID"] == 2100920) {
      ?>�������! ������� ��������.<?
    }
    
    /*
    if($arElement["COUNT_SKLAD"] == 0)
    {?>
        <a class="notifyMeButton" href="#ng_<?=$arElement["ID"]?>"><input type="button" class="input1_notify" value="" /></a><?
    } else {?>
        <a class="addToCartList" href="<?=$arElement["DETAIL_PAGE_URL"]?>#showOffers"><input type="button" class="input1" value="" /></a><?
    }
    */
    echo showNoindex();
    ?>
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
        <div class="clear"></div><?
    if(false)
    {?>
        <div class="info"><?
    $maxChars = 270;
    $strMoreText = smart_trim(strip_tags($arElement["DETAIL_TEXT"]), $maxChars);
    
    $strMoreText .= '#TITLE_HERE#';
    foreach($arResult["UF_HARACTERISTICS"] as $arPropertyName)
    {
      $arProperty = $arElement["PROPERTIES"][$arPropertyName["CODE"]];
      
      if($arProperty["VALUE"]["TYPE"]=="html" || $arProperty["VALUE"]["TYPE"]=="HTML")
      {
        if(strlen($arProperty["VALUE"]["TEXT"])>0)
        {
          $strMoreText .= $arPropertyName["NAME"].': ';
          $strMoreText .=  htmlspecialchars_decode($arProperty["VALUE"]["TEXT"]).(strpos(htmlspecialchars_decode($arProperty["VALUE"]["TEXT"]), "<br")===false?"<br />":'');
        }
      }
      elseif($arProperty["VALUE"]["TYPE"]=="text" || $arProperty["VALUE"]["TYPE"]=="TEXT") {
        if(strlen($arProperty["~VALUE"]["TEXT"])>0)
        {
          $strMoreText .= '- '.$arPropertyName["NAME"].': ';
          $strMoreText .= "<pre>".$arProperty["VALUE"]["TEXT"]."</pre>";
        }
      } else {
        if(is_array($arProperty["VALUE"]) && count($arProperty["VALUE"])>0)
          $arProperty["VALUE"] = implode(", ",$arProperty["VALUE"]);
        
        if(strlen($arProperty["VALUE"])>0) $strMoreText .= '- '.$arPropertyName["NAME"].': '.htmlspecialchars_decode($arProperty["VALUE"]).(strpos($arPropertyName["NAME"].': '.$arProperty["VALUE"], "<br")===false?'<br />':'');
      }
      
      if($maxChars < strlen($strMoreText)) break;
    }
    echo str_replace(array("#TITLE_HERE#", "<BR><br />"), array('<br><br>', '<br />'), $strMoreText); // <div class="name">��������������:</div>?>
        </div><?
    }?>
      </div>
    </li>
    <?
  }?>
    <div class="clear"></div>
    <?
}?>
  </ul>
  <div class="clear"></div>
  <div style="margin-top:60px"></div><?
  if(empty($_REQUEST["brendCode"]))
  {?>
  <div class="sorting_block"><?
showNoindex();
if(!$isSearch)
{?>
  <?$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH.'/includes/catalog/choose_nmg.php',array("arChoose"=>array(
        "0"=>array("NAME"=>"����", "CODE"=>'PROPERTY_PRICE'),
       // "1"=>array("NAME"=>"�������", "CODE" => "PROPERTY_NEW"),
        //"2"=>array("NAME"=>"�������", "CODE" => "SORT"),
        //"3"=>array("NAME"=>"�������", "CODE" => "PROPERTY_RATING"),
        //"4"=>array("NAME"=>"������������", "CODE" => "PROPERTY_SALES_RATING"),
    )));?><?
}?>
  <? if(strlen($arResult["NAV_STRING"])>0) echo $arResult["NAV_STRING"].'<br><br><br>'; 
echo showNoindex(false);?>
  <div class="clear"></div>
</div><?

echo $arResult["SEO_LINKING"];
  }

if(strlen($arResult["DESCRIPTION"])>0 && $_REQUEST["PAGEN_1"]<=1)
{
  $arPreview = smart_trim(strip_tags($arResult["~DESCRIPTION"]), 460, false, '<span class="full_hide">...</span>', true);
  ?>
<div class="catalogFilter">
  <h2 class="underlined"><?=$strH2?></h2>
  <div class="stext"><?
    if(strlen($arResult["~UF_DESCR_PREVIEW"])>0)
    {
      echo $arResult["~UF_DESCR_PREVIEW"];
      if(strlen($arResult["~DESCRIPTION"])>0) echo '<span class="more_text">'.$arResult["~DESCRIPTION"].'</span><span class="showMore"><a href="#">���������</a><br clear="all"><br><a href="#" class="hidden float">������</a></span><br clear="all"><br>';
    } else {
      if($arPreview["PREVIEW"] != strip_tags($arResult["~DESCRIPTION"]))
      {
          echo '<span class="less_text">'.$arPreview["PREVIEW"].'</span><span class="more_text">'.$arResult["~DESCRIPTION"].'</span> <span class="showMore"><a href="#">���������</a><a href="#" class="hidden float">������</a></span><br clear="all"><br>';
      } else echo $arPreview["PREVIEW"];
    }
  ?></div>
</div><?
}
?></div>