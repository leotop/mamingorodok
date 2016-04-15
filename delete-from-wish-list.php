<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'):

$wish_list_item_id = intval($_REQUEST["wish_list_item_id"]);

global $USER;
$user_id = $USER->GetID();

if ($wish_list_item_id > 0 && $user_id > 0)
{
    CModule::IncludeModule('iblock');

    $dbEl = CIBlockElement::GetList(Array(), Array("IBLOCK_ID"=>WISHLIST_IBLOCK_ID, "ACTIVE"=>"Y", "ID" => $wish_list_item_id), false, false, array("ID", "IBLOCK_ID", "PROPERTY_USER_ID", "PROPERTY_PRODUCT_ID"));    
    if($obEl = $dbEl->GetNext())    
    {           
        
        if ($obEl["PROPERTY_USER_ID_VALUE"] == $user_id)
        {
            $DB->StartTransaction();    
            if(!CIBlockElement::Delete($wish_list_item_id))   
            {       
                $strWarning .= 'Error!';       
                $DB->Rollback();    
            }   
            else        
            {
				$DB->Commit();

                // -1 к рейтингу желанности товара
                $dbProduct = CIBlockElement::GetList(Array(), Array("IBLOCK_ID"=>CATALOG_IBLOCK_ID, "ACTIVE"=>"Y", "ID" => $obEl["PROPERTY_PRODUCT_ID_VALUE"]), false, false, array("ID", "IBLOCK_ID", "PROPERTY_WISH_RATING"));    
                if($arProduct = $dbProduct->GetNext())    
                {           
                    $wish_rating = $arProduct["PROPERTY_WISH_RATING_VALUE"];
                }
                if($wish_rating > 0)
                    $res = CIBlockElement::SetPropertyValuesEx($arProduct["ID"], false, array("WISH_RATING" => $wish_rating-1));                      
			}
        }
    }    
        
}
?>   


<?else:?>

    <?CHTTP::SetStatus("404 Not Found");
    @define("ERROR_404","Y");
    $APPLICATION->SetTitle("—траница не найдена");?>

<?endif?>