<?
    if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();


    $APPLICATION->SetTitle($arResult["NAME"]);
    $APPLICATION->SetPageProperty("description", $arResult["NAME"]);


    $filter = substr_count($_SERVER["REQUEST_URI"],"/filter/");

    $parent_catalog = substr_count($_SERVER["REQUEST_URI"],"/catalog/filter/");


    $isSearch = $arParams["SEARCH"] == "Y";

    $strH1 = $arResult["META"]["H1"];
    $strH2 = $arResult["META"]["H2"];

    if($GLOBALS["SET_SEO"]["type"] == 'producer')
    {
        $strCategoryName = $arResult["PATH"][count($arResult["PATH"])-1]["NAME"];
        $strProducer = $GLOBALS["SET_SEO"]["DATA"]["NAME"];

        $strH1 = $strCategoryName.' '.$strProducer;
    } elseif($GLOBALS["SET_SEO"]["type"] == 'property') {
        $strCategoryName = $arResult["PATH"][count($arResult["PATH"])-1]["NAME"];
        $strH1 = $strCategoryName.' '.ToLower($GLOBALS["SET_SEO"]["DATA"]["ENUM"]["VALUE"]);
        $strH2 = $strH1;
    }

    if(strlen($arResult["SEO"]["H1"])>0) $strH1 = $arResult["SEO"]["H1"];
    if(strlen($arResult["SEO"]["H2"])>0) $strH2 = $arResult["SEO"]["H2"];


    if(!$isSearch)
    {
        if(preg_match("#/catalog/filter/#", $APPLICATION->GetCurDir()) || preg_match("#/catalog/filter/#", $APPLICATION->GetCurDir()))
            $strH1Addon = 'Детские товары ';
        else $strH1Addon = '';

    ?>

    <div class="compare_comment" style="display: none;">
        <div class="compare_com">
            <p style="margin-top: 13px;">Товар добавлен в сравнение</p>
        </div>
    </div>
    <div class="like_comment" style="display: none;">
        <div class="like_com">
            <p style="margin-top: 13px;">Вам понравился товар</p>
        </div>
    </div>
    <div class="noRegister">
        <p class="title">Для того чтобы добавить товар в список "Избранное" требуется</p>
        <a href="/personal/registaration/" class="registation">регистрация</a>
        <span> или </span>
        <a href="/personal/profile/" class="">авторизация</a>
        <img src="/bitrix/templates/nmg/img/close_bg.png" class="closeAfterBuy">
    </div>
    <div class="overla"></div>
    <script type="text/javascript">
        $(function(){
            $(".fast_view").fancybox({
                'type'    :    'iframe',
                'width'   :    1000,
                'height'  :    720,
            });
        });
    </script>
    <style>
        .cn{
            display: none !important;
        }
        #fancybox-close{
            right: -40px !important;
            top:-10px !important;
        }
        .noRegister{
            display: none;
            width: 450px;
            height: 112px;
            position: fixed;
            top:50%;
            left:50%;
            margin: -56px 0 0 -225px;
            background-color: white;
            z-index:5005;
            border-radius:10px;
            text-align: center;
            font-size: 16px;
        }

        .bx-pager-item{
            display: none !important;
        }

        .noRegister{
            display: none;
            width: 450px;
            height: 112px;
            position: fixed;
            top:50%;
            left:50%;
            margin: -56px 0 0 -225px;
            background-color: white;
            z-index:5005;
            border-radius:10px;
            text-align: center;
            font-size: 16px;
        }
        .overla{
            position: fixed;
            width: 150%;
            height: 150%;
            left:-200px;
            top:-200px;
            z-index:5004;
            display: none;
            opacity: 0.5;
            background-color: black;
        }
        div.noRegister .title{
            text-align: center;
            padding-top: 10px;
        }
        div.noRegister .noRegister{
            padding-left: 42px;
            padding-right: 20px;
        }

        .closeAfterBuy{
            cursor: pointer;
            position: absolute;
            right: -5px;
            top: -5px;
        }

        div.card{
            overflow: hidden !important;
            height: 298px;
        }
        div.card:hover{
            overflow: visible;
            height: 320px;
            width: 218px !important;
            position: relative;
            left: -60px;
        }
        div.card:hover .carousel_contain{
            display: block;
        }
        div.card:hover .photo{
            margin-left: 60px !important;
        }
        div.card:hover .fast_view{
            position: relative;
            left:-15px;
        }
        .li_hover_mod:hover{
            height: 350px;
        }
        div.podrob{
            text-align: center;
            margin: 0 30px;
        }
        p.podrob{

        }
        p.rememb{
            padding-left: 28px;
        }
        div.rememb{
            float: left;
            width: 40px;
            margin-top: 1px;
            margin-left: 8px;
        }
        div.fast_vie{
            float: right;
            width: 120px;
            margin-top: 4px;
        }
        .heart_rem{
            float: left;
        }
        img.zoom{
            width: 20px;
            float: left;
            padding-top: 5px;
        }
        a.fast_view{
            font-size: 12px !important;
            height: 21px;
            padding-top: 4px;
            vertical-align: middle;
            width: 150px;
            margin-top: 2px;
        }
        a.fast_view:before{
            content: "";
            display: block;
            background-image: url("/i/zzoomm.png");
            background-size: 20px ;
            width: 20px;
            height: 20px;
            background-repeat: no-repeat;
            float: left;
            position: relative;
            /*top:7px;                                  */
            padding-right: 5px;
        }
        .compare{
            width: 17px;
            height: 17px;
            display: block;
            position: relative;
            float: left;
        }
        input[type="checkbox"]+span.com_span{
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background: url("/bitrix/templates/nmg/img/compare.png") no-repeat;
            cursor: pointer;
            background-position: 0 -17px;
        }
        .input29{
            opacity:0;
        }
        input[type="checkbox"]:checked + span.com_span      {
            background-position: 0 0;
        }
        .cn{
            display: none !important;
        }
        #fancybox-close{
            right: -40px !important;
            top:-10px !important;
        }
        .slider_element{
            height: 50px!important;
            width: 50px!important;
        }
        .carousel_contain{
            float: left;
            width: 55px;
            position: relative;
            display: none;
            /*   left: -60px;     */
        }
        .bx-pager-item{
            display: none !important;
        }
        .bx-viewport{
            height: 185px;
        }
        .tovar_card{
            height: 200px;
            width: 60px;
            overflow: hidden;
            /*  float: left;     */
            z-index: 1500;
            position: relative;

        }
        .carusel_body{
            height: 250px;
            display: none;
            width: 60px;
            float: left;
        }
        .carusel{
            width: 60px;
            position: relative;
        }
        div.card:hover .carusel_body{
            display: block;
        }
        .down{
            width: 20px;
            height: 30px;
            background: url(/i/up_ar.png) no-repeat;
            position: relative;
            cursor: pointer;
            left: 16px;
            top:7px;
        }
        .up{
            position: relative;
            width: 20px;
            height: 30px;
            background: url(/i/down_ar.png) no-repeat;
            cursor: pointer;
            left: 16px;
        }
        .info_block{
            position: absolute;
            right: 0;
            top: 205px;
            width: 164px;
            margin-right: 7px;
        }
        .catalog_list li .rating{
            margin: 5px 0 90px !important;
        }
        .catalog_list li .link{
            /*  text-align: center;    */
        }
        .catalog_list li .comparison{
            margin-top: 39px;
            padding: 2px 0 0 5px;
            margin-left: 63px;
        }
        .right_sitebar .catalog_list li{
            height: 342px;
        }
        .deleteFromWishListaa{
            float: left;
            position: relative;
            top:39px;
            left:10px;
        }
        .addToLikeListaa{
            float: left;
            position: relative;
            top:39px;
            left:10px;
        }
        .showpUpss{
            float: left;
            position: relative;
            top:39px;
            left:10px;
        }
        .like_com{
            width: 250px;
            height: 40px;
            position: fixed;
            left: 50%;
            top:50%;
            margin: -20px 0 0 -125px;
            border: 1px solid black;
            border-radius: 15px;
            background-color: white;
            z-index: 3000;
            text-align: center;
        }
        .compare_com{
            width: 250px;
            height: 40px;
            position: fixed;
            left: 50%;
            top:50%;
            margin: -20px 0 0 -125px;
            border: 1px solid black;
            border-radius: 15px;
            background-color: white;
            z-index: 3000;
            text-align: center;
        }
        .input21{
            width:162px!important;
        }
        .fast_view{
            color:#808080 !important;
            text-decoration: underline;
            font-size: 14px;
        }
        .remember{
            cursor: pointer;
        }
        div.card:hover .remember{
            position: relative;
            top:-30px;
            left:-10px;
        }
        div.card:hover .comparison{
            position: relative;
            top:-30px;
            left:-10px;
        }
        .white_plash .content{
            background: none;
        }
        .white_plash .content .content{
            background: none;
        }
        .heart_like{

        }
        .remembering{
            font-size: 14px;
            left: 20px;
            position: relative;
            top: -20px;
            margin-top: 4px!important;
            margin-left: 2px!important;
        }
        .action_body{
            border: 1px solid #83539F;
            margin-bottom: 20px;
            margin-top: 20px;
            padding: 12px;
        }
        .comparsion_title{
            color: #0086da;
            font-size: 14px;
            left: 20px;
            position: relative;
            text-decoration: underline;
            top: -18px!important;
            cursor: pointer;
            background: none!important;
        }
        .catalog_list li .price{
            height: 23px!important;
        }
        .action_pict{

        }
    </style>
    <script type="text/javascript">
        var i = 0;
        $(function(){
            $('body').on('click', '.compare',function(){
                var check_id = $(this).attr('data-check');
                if (check_id=='Y'){
                    $(this).attr('data-check','');
                }   else
                {
                    $('.compare_comment').css('display','block');
                    setTimeout(function(){$('.compare_comment').css('display','none')},1500);
                    $(this).attr('data-check','Y');
                }


            })
        })
        //----------------------------------Для списка товаров----------------------------------------

        $(function() {

            //Для динамически созданных
            $('body').on('click','.addToLikeListaa', function(){
                $('.like_comment').css('display','block');
                setTimeout(function(){$('.like_comment').css('display', 'none')},1500);

                var addDataId = $(this).attr("data-remId");
                var hrefClass = '.rememb_'+ addDataId;
                $.ajax({
                    type: "POST",
                    url: "/bitrix/templates/nmg/ajax/addToWish.php",
                    data: { addDataId: addDataId }
                }).done(function( strResult ) {
                    $(hrefClass).html('<a class="deleteFromWishListaa" data-id="'+strResult+'" data-remId="'+addDataId+'"  title="В избранном"><img src="/bitrix/templates/nmg/img/heart_t.png" width="20" height="17" alt="" /><p class="remembering">Запомнить</p></a>');
                    var count = $('#likeCount').attr('count');
                    count = parseInt(count) + 1;
                    $('#likeCount').attr('count', count);
                    $('#likeCount').html(count);
                    $('.wishQuant').fadeOut();
                    $('.wishQuant').html(count);
                    $('.wishQuant').fadeIn();
                    if (count==1) {
                        $('.flying-wish-list').fadeIn();
                    }
                });


            });

        });


        $(function() {

            //Для динамически созданных
            $('body').on('click','.userNoAuthaa', function(){
                var idItemAddToLike = $(this).attr('data-id');
                var hrefItemAddToLike = window.location.href;

                $.cookie('idElemToLike', idItemAddToLike , {path: '/',});
                $.cookie('hrefElemToLike', hrefItemAddToLike, {path: '/',});

            });

        });




        $(function() {

            //Для динамически созданных
            $('body').on('click','.deleteFromWishListaa', function(){
                var intID = $(this).attr("data-id");
                var ID_rem = $(this).attr("data-remId");
                var hrefClass = '.rememb_'+ ID_rem;
                $.ajax({
                    type: "POST",
                    url: "/personal/products/wishlist/",
                    data: { AJAXCALL: "Y", deleteID: intID }
                });
                var count = $('#likeCount').attr('count');
                count = count - 1;
                if (count==0) {
                    //            $('.flying-wish-list').css("display", "block");
                    $('.flying-wish-list').fadeOut();
                }
                $('#likeCount').attr('count', count);
                $('#likeCount').html(count);
                $('.wishQuant').fadeOut();
                $('.wishQuant').html(count);
                $('.wishQuant').fadeIn();
                var dataID = $("#elementDataIdAdd").val();
                $(hrefClass).html('<a class="add addToLikeListaa" data-id="'+dataID+'" data-remId="'+ID_rem+'"  title="Мне нравится"><img src="/bitrix/templates/nmg/img/heart_f.png" width="20" height="17" alt="" /><p class="remembering">Запомнить</p></a>');
                return false;
            });


        });
        //---------------------------------------------------------------------------
    </script>


    <br>
    <h1 class="secth"><?=$arResult["NAME"]?></h1>
    <div class="action_body">
        <?
            echo $arResult["~DESCRIPTION"];
        ?>
        <br>
        <img src="<?=$arResult['PICTURE']['SRC']?>" class="action_pict">
    </div>

    <?
        $dbActions = CIBlockSection::GetList(
            array("SORT"=>"DESC"),
            Array('ACTIVE'=>'Y','IBLOCK_ID'=>$arResult['IBLOCK_ID'],'SECTION_ID'=>$arResult['IBLOCK_SECTION_ID'],'<ID'=>$arResult['ID']),
            false,
            array('ID','NAME','XML_ID','SECTION_PAGE_URL','PICTURE'),
            array("nPageSize"=>'1')
        );
        while ($arSect = $dbActions->GetNext())
        {
            $rsFile = CFile::GetByID($arSect["PICTURE"]);
            $arFile = $rsFile->Fetch();
        ?>
        <div class="links">
            <div class="act_name">
                <p><?=$arSect['NAME']?></p>
                <a href="<?=$arSect['SECTION_PAGE_URL']?>">Предыдущая акция</a>
            </div>
            <a href="<?=$arSect['SECTION_PAGE_URL']?>"><img src="/upload/<?=$arFile['SUBDIR'].'/'.$arFile['FILE_NAME']?>"></a>
        </div>
        <?
        }
        $dbActions = CIBlockSection::GetList(
            array("SORT"=>"ASC"),
            Array('ACTIVE'=>'Y','IBLOCK_ID'=>$arResult['IBLOCK_ID'],'SECTION_ID'=>$arResult['IBLOCK_SECTION_ID'],'>ID'=>$arResult['ID']),
            false,
            array('ID','NAME','XML_ID','SECTION_PAGE_URL','PICTURE'),
            array("nPageSize"=>'1')
        );
        while ($arSect = $dbActions->GetNext())
        {
            $rsFile = CFile::GetByID($arSect["PICTURE"]);
            $arFile = $rsFile->Fetch();
        ?>

        <div class="links">
            <a href="<?=$arSect['SECTION_PAGE_URL']?>"><img src="/upload/<?=$arFile['SUBDIR'].'/'.$arFile['FILE_NAME']?>" class="left_imagine"></a>
            <div class="act_name">
                <p class="next_act"><?=$arSect['NAME']?></p>
                <a href="<?=$arSect['SECTION_PAGE_URL']?>" class="next_act">Следующая акция</a>
            </div>
        </div>
        <?
        }
    ?>


    <?

        if(strlen($arResult["DESCRIPTION"])>0 && $_REQUEST["PAGEN_1"]<=1 && $arResult["IBLOCK_SECTION_ID"]=='688')
        {
            $arPreview = smart_trim(strip_tags($arResult["~DESCRIPTION"]), 460, false, '<span class="full_hide">...</span>', true);
        ?>
        <?
        }

        if($arParams["brendID"]<=0)
        {
            if($_REQUEST["set_filter"] == "Y") $arResult["DESCRIPTION"] = '';
            if(strlen($arResult["SEO"]["SEO_TEXT"])>0)
            {
                $arResult["DESCRIPTION"] = $arResult["SEO"]["SEO_TEXT"];
                $arResult["~DESCRIPTION"] = $arResult["SEO"]["SEO_TEXT"];
            }
        }
    } else echo '<h1>Результаты поиска</h1>';

    if($_REQUEST["set_filter"]=="Y" && (count($arResult["ROWS"])<=0) || !is_array($arResult["ROWS"]))
    { ?>
    <div class="search-page">
        <div class="top15"></div>
        <div>Измените запрос или попробуйте поискать в <a href="/catalog/">каталоге</a>.</div>
    </div><?
        return false;
    } elseif($isSearch) {
        if((count($arResult["ROWS"])<=0) || !is_array($arResult["ROWS"]))
        {
        ?>
        <div class="search_block"><div class="inputs">
                <form action="/tools/search/">
                    <input type="text" value="<?=(strlen($_REQUEST["q"])>0?htmlspecialcharsEx($_REQUEST["q"]):'Поиск по городку')?>" name="q" class="input1 searchInputField noGray black">
                    <button value="" class="input2" type="submit" name="s" id=""><span class="png"><span class="png"><nobr></nobr></span></span></button>
                </form>
            </div><br clear="all"><br>По Вашему запросу ничего не найдено. Попробуйте изменить запрос или искать товар в каталоге.</div><?
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

    if($filter == 1 || (!($filter == 1) && $parent_catalog<1))
    {
    ?>
    <?//arshow($_GET);?>
    <div class="sorting_block"><?
            if(!$isSearch)
            {?>
            <?$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH.'/includes/catalog/choose_nmg.php',array("arChoose"=>array(
                    "0"=>array("NAME"=>"по скидкам", "CODE" => "PROPERTY_DISCOUNT", "sort"=>"DESC"),
                    "1"=>array("NAME"=>"новинкам", "CODE" => "PROPERTY_NOVINKA", "sort"=>"DESC"),
                    "2"=>array("NAME"=>"популярности", "CODE" => "PROPERTY_KHIT_PRODAZH", "sort"=>"DESC"),
                    "3"=>array("NAME"=>"названию", "CODE" => "NAME", "sort"=>"ASC"),
                    "4"=>array("NAME"=>"цене", "CODE"=> "CATALOG_PRICE_2", "sort"=>"ASC"),
                )));?><?
        }?>
        <?=$arResult["NAV_STRING"]?>
        <?
        ?>
        <div class="clear"></div>
    </div>
    <?
    }

?>
<script type="">
    function filter_click(){
        if($("#cat_for_access").prop("checked")){
            $.cookie('namber_order', 'checked');
        }else{
            $.cookie('namber_order', null);

        }
    }
</script>

<form method="POST" action="<?$APPLICATION->GetCurPage()?>" name="orders_filter" style="margin: 20px 0">
    <div class="access_check fl">
        <input value="" <?=$_COOKIE["namber_order"];?> name="namber_order"  onclick="filter_click();submit();" type="checkbox" id="cat_for_access" class="fl">
        <label for="cat_for_access">Отображать только имеющиеся в наличии</label>
    </div>
</form>
<div class="catalog_block">
    <ul class="catalog_list"><?
            $intLastSection = 0;
            foreach($arResult["ROWS"] as $arRow)
            {
                foreach($arRow as $arElement)
                {
                    $this->AddEditAction($arElement['ID'], $arElement['EDIT_LINK'], $strElementEdit);
                    $this->AddDeleteAction($arElement['ID'], $arElement['DELETE_LINK'], $strElementDelete, $arElementDeleteParams);
                    $strMainID = $this->GetEditAreaId($arElement['ID']);

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
                <li id="<?=$strMainID?>" class="li_hover_mod">
                    <?
                        //      $smallImg=null;
                        //      $torgPred=0;
                        //---------------------------------------------------получаем картинки----------------------------------------------------------------------
                        /*      $rsOffers = CCatalogSKU::getOffersList($arElement["ID"],0,array(),array('XML_ID'));   //получаем список торговых предложений
                        foreach($rsOffers[$arElement["ID"]] as $arTovar){

                        $imgName=GetImgNameArray($arTovar["XML_ID"]);
                        if (!empty($imgName)){
                        $smallImg[$arTovar["ID"]] = CFile::ResizeImageGet($imgName["MAXI"], array("width"=>52, "height"=>55), BX_RESIZE_IMAGE_PROPORTIONAL);
                        ++$torgPred;
                        }
                        }        */
                        //-----------------------------------------------------------------------------------------------------------------------------------------
                        //     $width=count($smallImg)*60;
                    ?>
                    <style>
                        <?echo('.carusel_'.$arElement["ID"])?>{
                        width: 60px;
                        position: relative;
                        top:0;
                        }
                    </style>
                    <div class="catalog_bg stock-item card">
                        <div class="carusel_body">
                            <?if($torgPred>4){?><div class="down" data-id="<?echo($arElement["ID"])?>" data-width="<?echo $width?>"></div><?}
                                else{?><div style="height: 26px;"></div><?}?>
                            <div class="tovar_card">
                                <div class="<?echo('carusel_'.$arElement["ID"])?>">
                                    <?foreach($smallImg as $pict){?>
                                        <div class="slider_element"><img src="<?=(empty($pict["src"])?'/img/no_photo_52x52.png':$pict["src"])?>" titile="" alt="<?=$strH1orName?>"> </div>
                                        <?}?>
                                </div>
                            </div>
                            <?if($torgPred>4){?><div class="up" data-id="<?echo($arElement["ID"])?>" data-width="<?echo $width?>"></div><?}?>
                        </div>
                        <?
                            if($arElement["ACTIVE"] == "N")
                                echo '<div class="element_inactive">Деактивирован</div>';
                            if(isset($arResult["ACTIONS_ITEMS"][$arElement["ID"]]))
                            {
                                $arAction = $arResult["ACTIONS"][$arResult["ACTIONS_ITEMS"][$arElement["ID"]]];
                                $isSpecOffer = $arAction["PROPERTY_SPECOFFER_ENUM_ID"]>0;

                                if($isSpecOffer)
                                {?>
                                <div class="wrap-specialoffert">
                                    <a href="<?=$arElement['DETAIL_PAGE_URL']?>" title="Спецпредложение!" class="btt-specialoffert">Спецпредложение!</a></div><?
                            }?>
                            <div class="prize"><?
                                    if(!$isSpecOffer)
                                    {?>
                                    <a href="#" target="_blank"><div class="gift_bg"></div></a><?
                                }?>
                                <div class="gift_info ">
                                    <div class="gift_info_text">
                                        <div style="text-align: center;">Акция!</div> <?=$arAction["PREVIEW_TEXT"]?>
                                    </div><div class="gift_info_bg"></div></div></div><?
                            }

                            if(!empty($arElement["DETAIL_PICTURE"]["ID"])){
                                $arFileTmp = CFile::ResizeImageGet(
                                    $arElement["DETAIL_PICTURE"]["ID"],
                                    array("width" => 160, 'height' => 160),
                                    BX_RESIZE_IMAGE_PROPORTIONAL,
                                    false
                                );
                            }else{
                                $arFileTmp["src"] = "/img/no_foto.jpg";
                                $arFileTmp["width"] = "160";
                                $arFileTmp["height"] = "160";
                            }

                            if($arFileTmp["height"] == 0){$arFileTmp["height"] = "auto" ;}else {$arFileTmp["height"] = "160";}
                            if($arFileTmp["width"] == 0){$arFileTmp["width"] = "auto";}else {$arFileTmp["width"] = "160";}

                        ?>
                        <div class="photo">
                            <?$APPLICATION->IncludeFile("/includes/shields.php",array("props" => $arElement["PROPERTIES"]),array("SHOW_BORDER" => false))?>
                            <p><i title="<?=$arElement['DETAIL_PAGE_URL']?>"><img width="<?=$arFileTmp["width"]?>" height="<?=$arFileTmp["height"]?>" src="<?=$arFileTmp["src"]?>" alt="<?=(empty($arElement["PROPERTIES"]["SEO_H1"]["~VALUE"])?$arElement["NAME"]:$arElement["PROPERTIES"]["SEO_H1"]["~VALUE"])?>"></i><span>&nbsp;</span></p>
                        </div>
                        <?
                            $strAddon = "";
                            if(!$isSearch) {
                                $strAddon = '<a class="comment grey" href="'.$arElement['DETAIL_PAGE_URL'].'#comment">Написать отзыв</a>';

                            }
                            else  {
                                $strAddon = '<a class="comment grey" href="'.$arElement['DETAIL_PAGE_URL'].'#comment">Написать отзыв</a>';
                            }
                            if(strlen($arElement["PROPERTIES"]["MODEL_3D"]["VALUE"])>0) {
                                $strAddon .= '<a class="ttp_lnk 3dlink" onclick="window.open(\'/view360.php?idt='.$arElement["ID"].'\', \'wind1\',\'width=900, height=600, resizable=no, scrollbars=yes, menubar=no\')" href="javascript:" title="Подробная 3D - Модель"><i class="img360">3D модель</i></a>';
                            }
                            $APPLICATION->IncludeFile(SITE_TEMPLATE_PATH."/includes/raiting.php", array("strAddon" => $strAddon, 'Raiting'=>$arElement["PROPERTIES"]['RATING']["VALUE"]), array("MODE"=>"html"));
                            ?>
                        <div class="info_block">
                            <div class="link"><a href="<?=$arElement['DETAIL_PAGE_URL']?>" title="<?=$arElement["NAME"]?>"><?=smart_trim($arElement['NAME'], 70)?></a></div><?
                                if(false)
                                {?>
                                <div class="textPreview"><?=smart_trim(strip_tags($arElement["DETAIL_TEXT"]), 120)?></div><?
                            }?>
                            <div class="price">
                                <?
                                    $arElement["PROPERTIES"]["PRICE_CODE"]["VALUE"] = substr($price, 0, strlen($price)-3);
                                    $price = GetOfferMinPrice($arParams["IBLOCK_ID"],$arElement["ID"]);

                                    if($price == 0 || $arElement["PROPERTIES"]["STATUS_TOVARA"]["VALUE"] !="" || $arElement["COUNT_SKLAD"] <=0) //проверка цены если больше 0 ....//если количество товаров меньше 2
                                        echo '<span class="currency" style="width: 100%;font-size:12px">Нет в наличии</span>';
                                    else
                                    {?>


                                    <span class="currency" style="width: auto;"><?=CurrencyFormat($price, "RUB")?></span>
                                    <!-- <span class="currency" style="width: auto;"><?=CurrencyFormat($arElement["PROPERTIES"]["PRICE"]["VALUE"], "RUB")?></span>--><?
                                        if($arElement["PROPERTIES"]["OLD_PRICE"]["VALUE"]>0)
                                        {?>
                                        <i><?=CurrencyFormat($arElement["PROPERTIES"]["OLD_PRICE"]["VALUE"], "RUB")?></i><?
                                        };
                                }?>
                            </div><?
                                if(strlen($arElement["PROPERTIES"]["CH_SNYATO"]["VALUE_ENUM_ID"]) <= 0 || $arElement["PROPERTIES"]["CH_SNYATO"]["VALUE_ENUM_ID"] == 2100923)
                                {
                                ?><!--<i class="addToCartList" title="<?=$arElement["DETAIL_PAGE_URL"]?>"><button type="button" class="input21">Купить</button></i>-->
                                <a href="<?=$arElement["DETAIL_PAGE_URL"]?>?pred=Y" class="fast_view">Быстрый просмотр</a>
                                <?
                                } elseif($arElement["PROPERTIES"]["CH_SNYATO"]["VALUE_ENUM_ID"] == 2100920) {
                                ?>Новинка! Ожидаем поставку.<?
                                }

                            ?>
                        </div>

                        <div class="<?echo('rememb_'.$arElement['ID'])?> remember">
                            <?if($USER->GetID() > 0){
                                    $rsI = CIBlockElement::GetList(Array("ID" => "DESC"), array(
                                        "ACTIVE" => "Y",
                                        "IBLOCK_ID" => 8,
                                        "PROPERTY_DELETED" => false,
                                        "PROPERTY_USER_ID" => $USER -> GetID(),
                                        "PROPERTY_PRODUCT_ID" => $arElement['ID']
                                        ), false, false, array(
                                            "ID",
                                            "IBLOCK_ID", "PROPERTY_PRODUCT_ID", "PROPERTY_STATUS",
                                            "PROPERTY_PRODUCT_ID.DETAIL_PAGE_URL",
                                            "PROPERTY_PRODUCT_ID.NAME",
                                            "PROPERTY_PRODUCT_ID.PREVIEW_PICTURE"
                                    ));
                                    if($arI = $rsI->GetNext()){
                                        echo ('<a class="deleteFromWishListaa" data-id="'.$arI["ID"].'" data-remId="'.$arElement["ID"].'"  title="В избранное"><img class="heart_like" src="/bitrix/templates/nmg/img/heart_t.png" width="20" height="17" alt="" /><p class="remembering">Запомнить</p></a>');

                                    }
                                    else{
                                        echo ('<a class="add addToLikeListaa" data-remId="'.$arElement["ID"].'"  title="В избранное"><img class="heart_like" src="/bitrix/templates/nmg/img/heart_f.png" width="20" height="17" alt="" /><p class="remembering">Запомнить</p></a> ');

                                    }
                                }
                                else{
                                    echo ('<a class="showpUpss" class="userNoAuthaa" data-id="'.$arElement["ID"].'" href="#messageNoUser1" title="В избранное"><img class="heart_like" src="/bitrix/templates/nmg/img/heart_f.png" width="20" height="17" alt="" /><p class="remembering">Запомнить</p></a>');
                            }?>


                        </div>



                        <div class="comparison">
                            <label class="compare"><input type="checkbox" class="input29 add-to-compare-list-ajax" value="<?=$arElement["ID"]?>" /><span class="com_span" data-check=''></span><span class="comparsion_title">Сравнить</span></label>

                        </div>

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
                                echo str_replace(array("#TITLE_HERE#", "<BR><br />"), array('<br><br>', '<br />'), $strMoreText); // <div class="name">Характеристики:</div>?>
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
        if($filter == 1 || (!($filter == 1) && $parent_catalog<1))
        {?>
        <div class="sorting_block"><?
                if(!$isSearch)
                {?>
                <?$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH.'/includes/catalog/choose_nmg.php',array("arChoose"=>array(
                        "0"=>array("NAME"=>"по скидкам", "CODE" => "PROPERTY_DISCOUNT", "sort"=>"DESC"),
                        "1"=>array("NAME"=>"новинкам", "CODE" => "PROPERTY_NOVINKA", "sort"=>"DESC"),
                        "2"=>array("NAME"=>"популярности", "CODE" => "PROPERTY_KHIT_PRODAZH", "sort"=>"DESC"),
                        "3"=>array("NAME"=>"названию", "CODE" => "NAME", "sort"=>"ASC"),
                        "4"=>array("NAME"=>"цене", "CODE"=> "CATALOG_PRICE_2", "sort"=>"ASC"),
                    )));?><?
            }?>
            <? if(strlen($arResult["NAV_STRING"])>0) echo $arResult["NAV_STRING"].'<br><br><br>'; ?>
            <div class="clear"></div>
        </div><?


        }

        if ($parent_catalog<1) {
            echo $arResult["SEO_LINKING"];

    } ?>
    <?
        if(strlen($arResult["DESCRIPTION"])>0 && $_REQUEST["PAGEN_1"]<=1 && $arResult["IBLOCK_SECTION_ID"]!='688')
        {
            $arPreview = smart_trim(strip_tags($arResult["~DESCRIPTION"]), 460, false, '<span class="full_hide">...</span>', true);
        ?>
        <div class="catalogFilter">
            <h2 class="underlined"><?=$strH2?></h2>
            <div class="stext"><?
                if(strlen($arResult["~UF_DESCR_PREVIEW"])>0)
                {
                    echo $arResult["~UF_DESCR_PREVIEW"];
                    if(strlen($arResult["~DESCRIPTION"])>0) echo '<span class="more_text">'.$arResult["~DESCRIPTION"].'</span><span class="showMore"><a href="#">Подробнее</a><br clear="all"><br><a href="#" class="hidden float">Скрыть</a></span><br clear="all"><br>';
                } else {
                    if($arPreview["PREVIEW"] != strip_tags($arResult["~DESCRIPTION"]))
                    {
                        echo '<span class="less_text">'.$arPreview["PREVIEW"].'</span><span class="more_text">'.$arResult["~DESCRIPTION"].'</span> <span class="showMore"><a href="#">Подробнее</a><a href="#" class="hidden float">Скрыть</a></span><br clear="all"><br>';
                    } else echo $arPreview["PREVIEW"];
                }
            ?></div>
        </div><?
        }

?></div>
<script>
    $('.down').click(function(){
        var id=$(this).attr("data-id");
        var carusel_id='.carusel_'+id;
        var width=$(this).attr("data-width")
        var war=parseInt(width);
        var top_val=parseInt($(carusel_id).css('top'));
        if(top_val<0){
            $(carusel_id).animate({top:'+=50px'},500);
        }
    });
    $('.up').click(function(){
        var id=$(this).attr("data-id");
        var carusel_id='.carusel_'+id;
        var width=$(this).attr("data-width");
        var carus=parseInt(width);
        var top_val=parseInt($(carusel_id).css('top'));
        var card=parseInt($('.tovar_card').css('height'));
        if ((card-top_val)<carus){
            $(carusel_id).animate({top:'-=50px'},500);
        }
    });
    $('.showpUpss').click(function(){
        $(".noRegister").show();
        $(".overla").show();
    })
    $('.closeAfterBuy').click(function(){
        $(".noRegister").hide();
        $(".overla").hide();
    });

</script>
<?

    if(isset($arResult["META"]["UF_KEYWORDS"]) && !empty($arResult["META"]["UF_KEYWORDS"])) {
        $APPLICATION->SetPageProperty("keywords",$arResult["META"]["UF_KEYWORDS"]);
    }

    //если есть SEO

    if(isset($arResult["SEO"]["KEYWORDS"]) && !empty($arResult["SEO"]["KEYWORDS"])) {
        $APPLICATION->SetPageProperty("keywords",$arResult["SEO"]["KEYWORDS"]);
    }

    $GLOBALS["ALLELEMENT"] = $arResult["ALLELEMENT"];?>