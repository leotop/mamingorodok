<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'):

$product_id = intval($_REQUEST["product_id"]);
$user_id = intval($_REQUEST["user_id"]);
$status = $_REQUEST["status"];

// ищем есть ли такой элемент для такого пользователя
if ($product_id > 0 && $user_id > 0 && strlen($status) > 0)
{
    switch($status)
    {
        case 'want':
            $status_id = WISHLIST_PROPERTY_STATUS_WANT_ENUM_ID;
            break;
        case 'necessery':
            $status_id = WISHLIST_PROPERTY_STATUS_NECESSARY_ENUM_ID;
            break;
        case 'going_to_die':
            $status_id = WISHLIST_PROPERTY_STATUS_GOING_TO_DIE_ENUM_ID;
            break;
        case 'already_have':
            $status_id = WISHLIST_PROPERTY_STATUS_ALREADY_HAVE_ENUM_ID;
            break;
        default:
            break;    
        
    }
    
    CModule::IncludeModule('iblock');
    
    // проверяем есть ли товар в вишлисте для текущего пользователя
    $dbEl = CIBlockElement::GetList(Array(), Array("IBLOCK_ID"=>WISHLIST_IBLOCK_ID, "ACTIVE"=>"Y", "PROPERTY_USER_ID" => $user_id, "PROPERTY_PRODUCT_ID" => $product_id, "!PROPERTY_STATUS"=> WISHLIST_PROPERTY_STATUS_ALREADY_HAVE_ENUM_ID ), false, false, array("ID", "IBLOCK_ID"));    
    if($obEl = $dbEl->GetNext())    
        $already_in_wish_list = true;

    // если нет - создаем
    if (!$already_in_wish_list)
    {
        $el = new CIBlockElement;
        $PROP = array();
        $PROP[WISHLIST_PRODUCT_ID_PROPERTY_ID] = $product_id; 
        $PROP[WISHLIST_USER_ID_PROPERTY_ID] = $user_id;  
        $PROP[WISHLIST_STATUS_PROPERTY_ID] = $status_id;        
        $arLoadProductArray = Array(  
            "MODIFIED_BY"    => $user_id, // элемент изменен текущим пользователем  
            "IBLOCK_SECTION_ID" => false,          // элемент лежит в корне раздела  
            "IBLOCK_ID"      => WISHLIST_IBLOCK_ID,  
            "PROPERTY_VALUES"=> $PROP,  
            "NAME"           => $product_id,  
            "ACTIVE"         => "Y",            // активен  
        );
        if(!$wish_item_id = $el->Add($arLoadProductArray)){
			echo "Error: ".$el->LAST_ERROR;
		}
        
        $dbProduct = CIBlockElement::GetList(Array(), Array("IBLOCK_ID"=>CATALOG_IBLOCK_ID, "ACTIVE"=>"Y", "ID" => $product_id), false, false, array("ID", "IBLOCK_ID", "PROPERTY_WISH_RATING"));    
        if($arProduct = $dbProduct->GetNext())    
        {           
            $wish_rating = $arProduct["PROPERTY_WISH_RATING_VALUE"];
        }
        $res = CIBlockElement::SetPropertyValuesEx($product_id, false, array("WISH_RATING" => $wish_rating+1));                      
    }
    
}

?>   


<?else:?>

    <?CHTTP::SetStatus("404 Not Found");
    @define("ERROR_404","Y");
    $APPLICATION->SetTitle("Страница не найдена");?>

<?endif?>