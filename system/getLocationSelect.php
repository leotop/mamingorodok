<?
header("Content-type: text/html; charset=windows-1251");
define("STOP_STATISTICS", true);
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

if (!CModule::IncludeModule("sale") || !CModule::IncludeModule("iblock")) die();

if(strlen($_REQUEST["strLetter"]) <= 0) {
	$intCurrentLocation = $GLOBALS["CGeoIP"] -> getLocationID();
	$arResult["LOCATION"] = CSaleLocation::GetByID($intCurrentLocation, LANGUAGE_ID);
	$strLetter = substr($arResult["LOCATION"]["CITY_NAME"], 0, 1);
} else {
	$strLetter = trim(iconv("utf-8", "windows-1251", $_REQUEST["strLetter"]));
}


$arLocationIDs = getAvailableLocationID();


$obCache = new CPageCache;

ob_start();
if($obCache->StartDataCache(86400, "locationSelectCities|".$strLetter."|".md5(serialize($arLocationIDs)), "/")) { // 86400
	$strLocations = '';
	$rsLocation = CSaleLocation::GetList(
		array("SORT" => "ASC", "CITY_NAME_LANG" => "ASC"),
		array("LID" => LANGUAGE_ID, "~CITY_NAME" => $strLetter.'%', "COUNTRY_ID" => 19, "ID" => $arLocationIDs), false, false, array()
	);
	while($arLocation = $rsLocation -> Fetch()) {
		$strLocations .= '<dd><a data-id="'.$arLocation["ID"].'" href="#">'.$arLocation["CITY_NAME"].'</a></dd>';
	}
	if(!empty($strLocations)) echo'<dl id="sk-city-choose-sk-cityList" class="sk-city-choose-sk-cityList">'.$strLocations.'</dl>';
	$obCache->EndDataCache();
}
$strLocations = ob_get_clean();

if(strlen($_REQUEST["strLetter"]) <= 0) { ?>
<div class="sk-city-choose">
	<div class="sk-city-choose-body_full">
		<ul class="sk-city-choose-ABC" id="selectLocationLetter"><?
			if($obCache->StartDataCache(86400, "locationSelectLettersLine|".$strLetter."|".md5(serialize($arLocationIDs)), "/")) { // 86400
				$rsLocation = CSaleLocation::GetList(
					array("SORT" => "ASC", "CITY_NAME_LANG" => "ASC"),
					array("LID" => LANGUAGE_ID, "COUNTRY_ID" => 19, "!CITY_NAME" => false, "ID" => $arLocationIDs), false, false, array()
				);

				while($arLocation = $rsLocation->Fetch()) {
					$arResult["ALL_CITY"][substr($arLocation["CITY_NAME"], 0, 1)] = false;
				}

				$strLetters = '';
				foreach($arResult["ALL_CITY"] as $strCLetter => $srFoo)
					$strLetters .= '<li'.($strLetter === $strCLetter ? ' class="sk-city-choose-ABC_act"' : '').'><a data-letter="'.$strCLetter.'" href="#">'.$strCLetter.'</a></li>';

				echo $strLetters;

				$obCache->EndDataCache();
			}; ?>
		</ul><?=$strLocations?>
	</div>
</div><?
} else echo $strLocations;






die();


$intCurrentLocation = $GLOBALS["CGeoIP"]->getLocationID();
$arResult["LOCATION"] = CSaleLocation::GetByID(1732, LANGUAGE_ID);
$arResult["LOCATION"]["LETTER"] = substr($arResult["LOCATION"]["CITY_NAME"], 0, 1);

if(isset($_REQUEST["locationLetter"]))
	$strLocationLetter = trim($_REQUEST["locationLetter"]);
else $strLocationLetter = $arResult["LOCATION"]["LETTER"];

$rsLocation = CSaleLocation::GetList(
	array("SORT" => "ASC", "CITY_NAME_LANG" => "ASC"),
	array("LID" => LANGUAGE_ID, "COUNTRY_ID" => 19), false, false, array()
);

while($arLocation = $rsLocation->Fetch())
	$arResult["ALL_CITY"][substr($arLocation["CITY_NAME"], 0, 1)] = false;



?>
<div class="sk-city-choose"><?
	if(false) {
		?>
		<div class="sk-city-choose-district">
		<div class="sk-city-choose-district-head">–егион</div>
		<div class="sk-city-choose-scrollHolder">
			<div class="sk-city-choose-scrollHolder-w">
				<ul class="sk-city-choose-districtList" id="selectLocation"><?
					foreach($arResult["REGION"] as $arRegion)
						echo '<li'.($arRegion["ID"] == $arResult["LOCATION"]["REGION_ID"] ? ' class="sk-city-choose-districtList_act"' : '').'><a href="#">'.$arRegion["NAME"].'</a></li>';?>
				</ul>
			</div>
		</div>
		</div><?
	} ?>
	<!-- длч версии без рагинов добавл€тьс€ стиль sk-city-choose-body_full / sk-city-choose-body -->
	<div class="sk-city-choose-body_full">
		<ul class="sk-city-choose-ABC" id="selectLocationLetter"><?
			foreach($arResult["ALL_CITY"] as $strLetter => $srFoo)
				echo '<li'.($arResult["LOCATION"]["LETTER"] == $strLetter ? ' class="sk-city-choose-ABC_act"' : '').'><a data-letter="'.$strLetter.'" href="#">'.$strLetter.'</a></li>';?>
		</ul><?

		?>
	</div>
</div>
