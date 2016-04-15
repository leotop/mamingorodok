<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

$wish_id = intval($_REQUEST["id"]);
$status = $_REQUEST["status"];

if ($wish_id > 0 && strlen($status) > 0)
{
    switch($status)
    {
        case 'want':
            $status_id = WISHLIST_PROPERTY_STATUS_WANT_ENUM_ID;
            break;
        case 'necessary':
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
    CIBlockElement::SetPropertyValuesEx($wish_id, WISHLIST_IBLOCK_ID, array("STATUS" => $status_id));

}
?>   