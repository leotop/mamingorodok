<?php

AddEventHandler('sale', 'OnOrderAdd', Array('CSaleGuestHandlers', 'OnOrderUpdateHandler'));
AddEventHandler('sale', 'OnSaleComponentOrderOneStepProcess', Array('CSaleGuestHandlers', 'OnSaleComponentOrderOneStepProcessHandler'));
AddEventHandler('sale', 'OnSaleComponentOrderOneStepComplete', Array('CSaleGuestHandlers', 'OnSaleComponentOrderOneStepCompleteHandler'));
AddEventHandler('sale', 'OnSaleComponentOrderOneStepFinal', Array('CSaleGuestHandlers', 'OnSaleComponentOrderOneStepFinalHandler'));

class CSaleGuestHandlers {

	private static $bGuestOrder = false;

	public static function OnOrderUpdateHandler($ID, $arFields) {
		if (self::$bGuestOrder && $GLOBALS['USER']->IsAuthorized() && isset($arFields['PRICE'])) {
			$_SESSION['SAVED_UID'] = $GLOBALS['USER']->GetID();
			$GLOBALS['USER']->Logout();
		}
	}

	public static function OnSaleComponentOrderOneStepProcessHandler($arResult, $arUserResult, $arParams) {
		if (empty($arResult['ERROR']) && $arUserResult['CONFIRM_ORDER']=='Y' && !$GLOBALS['USER']->IsAuthorized()) {
			if ($arUser = CUser::GetList($by='id', $order='asc', array('=EMAIL' => $arUserResult['USER_EMAIL']))->Fetch()) {
				if (!in_array(1, CUser::GetUserGroup($arUser['ID']))) {
					$GLOBALS['USER']->Authorize($arUser['ID']);
					self::$bGuestOrder = true;
				}
			}
		}
	}

	public static function OnSaleComponentOrderOneStepCompleteHandler($ID, $arOrder, $arParams) {
		if ($ID <= 0) {
			if (self::$bGuestOrder) {
				$GLOBALS['USER']->Logout();
			}
		}
	}

	public static function OnSaleComponentOrderOneStepFinalHandler($ID, $arOrder, $arParams) {
		if ((!$GLOBALS['USER']->IsAuthorized() && $_SESSION['SAVED_UID']!=$arOrder['USER_ID']) ||
			($GLOBALS['USER']->IsAuthorized() && $GLOBALS['USER']->GetID()!=$arOrder['USER_ID'])
		) {
			$arOrder = array();
		}
	}
}