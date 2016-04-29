<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();?> 
<div class="basket_all"> 
    <div class="basket_margin"> 
        <?
		CModule::IncludeModule("iblock");
        
        if(CModule::IncludeModule("sale")) {
            $dbBasketItems = CSaleBasket::GetList(
            array(
                    "NAME" => "ASC",
                    "ID" => "ASC"
                    ),
            array(
                    "FUSER_ID" => CSaleBasket::GetBasketUserID(),
                    "LID" => SITE_ID,
                    "ORDER_ID" => "NULL"
                    ),
            false,
            false,
            array()
            );
            while ($arItems = $dbBasketItems->Fetch())
            {
                $arBasketItems[] = $arItems;
            }
            if(count($arBasketItems)>0) {
                $qua='';
                foreach($arBasketItems as $v) {
                    $qua += $v["QUANTITY"];
                }
            }
        }    
        
        global $USER;
        $user_id = $USER->GetID();
        if(intval($user_id)>0){
            // получаем кол-во товаров в списке малыша
            $arFilter = array(
                "IBLOCK_ID"=>WISHLIST_IBLOCK_ID,
                "ACTIVE"=>"Y",
                "PROPERTY_USER_ID" => $user_id,
                "PROPERTY_STATUS" => '',
                "ALL_EXCEPT_ALREADY_HAVE" => "Y",
                "!PROPERTY_STATUS" => WISHLIST_PROPERTY_STATUS_ALREADY_HAVE_ENUM_ID
            );
            $dbWish = CIBlockElement::GetList(array(), $arFilter, false, false, array("ID", "IBLOCK_ID", 'NAME', 'PREVIEW_TEXT', "PROPERTY_PRODUCT_ID", "PROPERTY_STATUS"));    
            while($obEl = $dbWish->GetNext())    
            {           
                $arWishlist[] = $obEl;
            }
        }
		
        ?>
        <?if ($user_id > 0 && count($arWishlist) > 0):?>
            <a href="/community/user/<?=$user_id?>/" class="desire" ><span></span>Список<br />малыша<div class="counter"><?=count($arWishlist)?></div></a> 
		<?elseif ($user_id >0):?>
			<a href="/community/user/<?=$user_id?>/" class="desire" ><span></span>Список<br />малыша</a>
        <?else:?>
            <a href="/about-baby-list.php" class="desire" ><span></span>Список<br />малыша</a> 
        <?endif?>
            <a href="/basket/" class="basket"><span><?if($qua && $qua>0):?><img src="/basket_number.php?qua=<?=$qua?>" alt="" width="44" height="31" /><?endif;?></span><?if($qua && $qua>0):?><a href="/basket/" style="margin-left:41px;color:#808080;"><?endif;?>Корзина<?if($qua && $qua>0):?></a><?endif;?></a>
    </div>
</div>