<?
RegisterModuleDependences('iblock', 'OnIBlockPropertyBuildList', 'main', 'sk_deliveryProp', 'GetUserTypeDescription', 100);

if(CModule::IncludeModule("sale") && !class_exists("sk_menuProp")) {
	class sk_deliveryProp
	{
		function GetUserTypeDescription()
		{
			return array(
				"PROPERTY_TYPE" => "S",
				"USER_TYPE" => "sk_deliveryProp",
				"DESCRIPTION" => "Привязка к местоположению",
				"GetPropertyFieldHtml" => array("sk_deliveryProp", "GetPropertyFieldHtml"),
				"ConvertToDB" => array("sk_deliveryProp", "ConvertToDB"),
				"ConvertFromDB" => array("sk_deliveryProp", "ConvertFromDB")
			);
		}

		function GetPropertyFieldHtml($arProperty, $value, $strHTMLControlName)
		{
			$strL = '<select name="'.$strHTMLControlName["VALUE"].'">';
			$rsL = CSaleLocation::GetList(array("SORT" => "ASC", "CITY_NAME_LANG" => "ASC"), array("LID" => LANGUAGE_ID, "COUNTRY_ID" => 19), false, false, array());
			while($arL = $rsL -> GetNext())
				$strL .= '<option'.($value["VALUE"]==$arL["ID"]?' selected="selected"':'').' value="'.$arL["ID"].'">'.$arL["CITY_NAME"].'</option>';
			$strL .= '</select>';

			return $strL;
		}

		function ConvertToDB($arProperty, $value)
		{
			$return = array();
			$return["VALUE"] = $value["VALUE"];

			return $return;
		}

		function ConvertFromDB($arProperty, $value)
		{
			$return = array();
			$return["VALUE"] = $value["VALUE"];

			return $return;
		}
	}
}