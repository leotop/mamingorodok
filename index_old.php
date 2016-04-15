<? 
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
$APPLICATION->SetPageProperty("description", "Интернет-магазин детских товаров «Мамин городок». Кроватки, коляски от лучших итальянских и российских производителей. Конкурентные цены. Москва. Доставка в регионы.");
$APPLICATION->SetPageProperty("keywords", "детские товары, товары для детей, магазин детских товаров, магазин товаров для детей, интернет магазин детских товаров, интернет магазин товаров для детей");
$APPLICATION->SetPageProperty("title", "Товары для детей: детские товары в Москве с доставкой – интернет-магазин «Мамин городок»");
if(true)
{
	include($_SERVER['DOCUMENT_ROOT'].'/index_new.php');
	die();
}  
$NO_BROAD = true;
$HIDE_LEFT_COLUMN = true;
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_after.php");

$APPLICATION->SetTitle("Товары для детей: детские товары в Москве с доставкой – интернет-магазин «Мамин городок»");

?> <?$APPLICATION->IncludeFile($APPLICATION->GetTemplatePath(SITE_TEMPLATE_PATH."/includes/carts.php"), array(), array("MODE"=>"html") );?> <?$APPLICATION->IncludeComponent("bitrix:catalog.section.list", "mainReviewsList", array(
	"IBLOCK_TYPE" => "catalog",
	"IBLOCK_ID" => "7",
	"SECTION_ID" => "",
	"SECTION_CODE" => "",
	"COUNT_ELEMENTS" => "N",
	"TOP_DEPTH" => "1",
	"SECTION_FIELDS" => array(
		0 => "DESCRIPTION",
		1 => "PICTURE",
		2 => "",
	),
	"SECTION_USER_FIELDS" => array(
		0 => "UF_MAIN_SHOW",
		1 => "",
	),
	"SECTION_URL" => "",
	"CACHE_TYPE" => "A",
	"CACHE_TIME" => "36000000",
	"CACHE_GROUPS" => "Y",
	"ADD_SECTIONS_CHAIN" => "Y"
	),
	false
);?> 
<div class="twoColons"> 
  <table> 
    <tbody>
      <tr><td> 
          <div class="goods" id="elemSH">
			<input type="hidden" id="nohide" value="1">
            <h2>Самые желанные <a href="/catalog/title/desired/" >Показать все</a></h2>           
            <div class="item_list"> 
			<?$APPLICATION->IncludeComponent("bitrix:catalog.top", "main-block", array(
	"IBLOCK_TYPE" => "catalog",
	"IBLOCK_ID" => "2",
	"ELEMENT_SORT_FIELD" => "PROPERTY_WISH_RATING",
	"ELEMENT_SORT_ORDER" => "desc",
	"ELEMENT_COUNT" => "8",
	"LINE_ELEMENT_COUNT" => "4",
	"PROPERTY_CODE" => array(
		0 => "NEW",
		1 => "WISHES",
		2 => "RATING",
		3 => "OLD_PRICE",
		4 => "PRICE",
		5 => "WISH_RATING",
	),
	"SECTION_URL" => "",
	"DETAIL_URL" => "",
	"BASKET_URL" => "/personal/basket.php",
	"ACTION_VARIABLE" => "action",
	"PRODUCT_ID_VARIABLE" => "id",
	"PRODUCT_QUANTITY_VARIABLE" => "quantity",
	"PRODUCT_PROPS_VARIABLE" => "prop",
	"SECTION_ID_VARIABLE" => "SECTION_ID",
	"CACHE_TYPE" => "A",
	"CACHE_TIME" => "36000000",
	"CACHE_GROUPS" => "Y",
	"DISPLAY_COMPARE" => "N",
	"PRICE_CODE" => array(
	),
	"USE_PRICE_COUNT" => "N",
	"SHOW_PRICE_COUNT" => "1",
	"PRICE_VAT_INCLUDE" => "Y",
	"PRODUCT_PROPERTIES" => array(
	),
	"USE_PRODUCT_QUANTITY" => "N"
	),
	false
);?></div>          
            <div> 
              <div class="clear"></div>
             
              <div class="review block">
            <h2>Обсуждения товаров</h2>   
            <?$APPLICATION->IncludeComponent("bitrix:blog.blog", "goods_review", array(
	"YEAR" => $year,
	"MONTH" => $month,
	"DAY" => $day,
	"CATEGORY_ID" => $category,
	"BLOG_URL" => "obsujdenie_tovarov",
	"FILTER_NAME" => "arFilter",
	"MESSAGE_COUNT" => "4",
	"DATE_TIME_FORMAT" => "d.m.Y H:i:s",
	"NAV_TEMPLATE" => "",
	"IMAGE_MAX_WIDTH" => "600",
	"IMAGE_MAX_HEIGHT" => "600",
	"PATH_TO_BLOG" => "/community/group/",
	"PATH_TO_BLOG_CATEGORY" => "",
	"PATH_TO_POST" => "/community/group/#blog#/#post_id#/",
	"PATH_TO_POST_EDIT" => "",
	"PATH_TO_USER" => "",
	"CACHE_TYPE" => "A",
	"CACHE_TIME" => "7200",
	"CACHE_TIME_LONG" => "604600",
	"PATH_TO_SMILE" => "/bitrix/images/blog/smile/",
	"SET_NAV_CHAIN" => "N",
	"SET_TITLE" => "N",
	"POST_PROPERTY_LIST" => array(
	),
	"SHOW_RATING" => "N",
	"BLOG_VAR" => "",
	"POST_VAR" => "",
	"USER_VAR" => "",
	"PAGE_VAR" => ""
	),
	false
);?></div>
             </div>
          </div>
        </td> <td class="secondColon"> <?$APPLICATION->IncludeComponent("bitrix:advertising.banner", ".default", array(
	"TYPE" => "main_right",
	"NOINDEX" => "Y",
	"CACHE_TYPE" => "A",
	"CACHE_TIME" => "0"
	),
	false
);?> 
          <div class="consultation">
          <h2 class="h2Consultation">Все вопросы и ответы 
          <?$APPLICATION->IncludeComponent(
                "bitrix:blog.rss.link",
                "",
                Array(
                        "RSS1"                => "N",
                        "RSS2"                => "Y",
                        "ATOM"                => "N",
                        "BLOG_VAR"            => "",
                        "POST_VAR"            => "",
                        "GROUP_VAR"            => "",
                        "PATH_TO_RSS"        => "/community/blog/#blog#/rss/#type#",
                        "PATH_TO_RSS_ALL"    => "/community/blog/rss/#type#/#group_id#",
                        "BLOG_URL"            => "our_help",
                        "MODE"                => "B",
                    ),
                $component 
            );
        ?></h2>
          <?$APPLICATION->IncludeComponent("bitrix:blog.blog", "our_help", array(
	"YEAR" => $year,
	"MONTH" => $month,
	"DAY" => $day,
	"CATEGORY_ID" => $category,
	"BLOG_URL" => "our_help",
	"FILTER_NAME" => "arFilter",
	"MESSAGE_COUNT" => "2",
	"DATE_TIME_FORMAT" => "d.m.Y H:i:s",
	"NAV_TEMPLATE" => "",
	"IMAGE_MAX_WIDTH" => "600",
	"IMAGE_MAX_HEIGHT" => "600",
	"PATH_TO_BLOG" => "/community/group/",
	"PATH_TO_BLOG_CATEGORY" => "",
	"PATH_TO_POST" => "/community/group/#blog#/#post_id#/",
	"PATH_TO_POST_EDIT" => "",
	"PATH_TO_USER" => "",
	"CACHE_TYPE" => "A",
	"CACHE_TIME" => "7200",
	"CACHE_TIME_LONG" => "604600",
	"PATH_TO_SMILE" => "/bitrix/images/blog/smile/",
	"SET_NAV_CHAIN" => "N",
	"SET_TITLE" => "N",
	"POST_PROPERTY_LIST" => array(
	),
	"SHOW_RATING" => "N",
	"BLOG_VAR" => "",
	"POST_VAR" => "",
	"USER_VAR" => "",
	"PAGE_VAR" => ""
	),
	false
);?></div>
         </td> </tr>
     </tbody>
  </table>
</div>
<div class="news block">
<h2>Новости магазина
<?$APPLICATION->IncludeComponent(
        "bitrix:blog.rss.link",
        "",
        Array(
                "RSS1"                => "N",
                "RSS2"                => "Y",
                "ATOM"                => "N",
                "BLOG_VAR"            => "",
                "POST_VAR"            => "",
                "GROUP_VAR"            => "",
                "PATH_TO_RSS"        => "/community/blog/#blog#/rss/#type#",
                "PATH_TO_RSS_ALL"    => "/community/blog/rss/#type#/#group_id#",
                "BLOG_URL"            => "blog_news",
                "MODE"                => "B",
            ),
        $component 
    );
?></h2>
<?$APPLICATION->IncludeComponent("bitrix:blog.blog", "blog_news", array(
	"YEAR" => $year,
	"MONTH" => $month,
	"DAY" => $day,
	"CATEGORY_ID" => $category,
	"BLOG_URL" => "blog_news",
	"FILTER_NAME" => "",
	"MESSAGE_COUNT" => "6",
	"DATE_TIME_FORMAT" => "d.m.Y H:i:s",
	"NAV_TEMPLATE" => "",
	"IMAGE_MAX_WIDTH" => "600",
	"IMAGE_MAX_HEIGHT" => "600",
	"PATH_TO_BLOG" => "/community/group/",
	"PATH_TO_BLOG_CATEGORY" => "",
	"PATH_TO_POST" => "/community/group/#blog#/#post_id#/",
	"PATH_TO_POST_EDIT" => "",
	"PATH_TO_USER" => "",
	"CACHE_TYPE" => "A",
	"CACHE_TIME" => "3600",
	"CACHE_TIME_LONG" => "3600",
	"PATH_TO_SMILE" => "/bitrix/images/blog/smile/",
	"SET_NAV_CHAIN" => "N",
	"SET_TITLE" => "N",
	"POST_PROPERTY_LIST" => array(
	),
	"SHOW_RATING" => "N",
	"BLOG_VAR" => "",
	"POST_VAR" => "",
	"USER_VAR" => "",
	"PAGE_VAR" => ""
	),
	false
);?>
</div>
 <?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>