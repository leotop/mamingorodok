<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();?>
<?
	global $USER;
	if(isset($arCrumb)):
		$arCrumb = intval($arCrumb);
		$APPLICATION->AddChainItem("�������", "/catalog/");
		if($arCrumb<2)
			$APPLICATION->AddChainItem("�������", "");
		else
			$APPLICATION->AddChainItem("�������", "/basket/");
		if(!$USER->IsAuthorized()){
			if($arCrumb<3)
				$APPLICATION->AddChainItem("�����������", "");
			else
				$APPLICATION->AddChainItem("�����������", "2");
		}
		if($arCrumb<4)
			$APPLICATION->AddChainItem("��������", "");
		else
			$APPLICATION->AddChainItem("��������", "/basket/order/");
			
		if($arCrumb<5)
			$APPLICATION->AddChainItem("������ ������", "");
		else
			$APPLICATION->AddChainItem("������ ������", "4");
		if($arCrumb<6)	
			$APPLICATION->AddChainItem("������������ ������", "");
		else
			$APPLICATION->AddChainItem("������������ ������", "5");
	endif;
?>
