<?
class cSKTools {
	const strHashAddon = 'dd.87';

	public static function checkHash($arData, $strHash) {
		if(!is_array($arData)) $arData = array($arData);

		$strSalt = substr($strHash, 0, strlen($strHash) - 32);

		return $strHash == cSKTools::getHash($arData, $strSalt);
	}

	public static function getHash($arData, $strSalt = '') {
		if(!is_array($arData)) $arData = array($arData);

		$arTmp = array_values($arData);
		sort($arTmp);

		if(empty($strSalt)) $strSalt = randString(8);
		return $strSalt.md5($strSalt.serialize($arTmp).cSKTools::strHashAddon);
	}

	public static function prePropcessRequestDataFunction($strData, $convertTo1251 = false) {
		$strTmp = addslashes(urldecode(trim($strData)));
		if($convertTo1251) $strTmp = iconv ('utf-8', 'windows-1251', $strTmp);

		return $strTmp;
	}

	public static function dataToURL($arData, $strUrl='') {
		$arTmp = array();

		foreach($arData as $key => $val)
			$arTmp[] = $key.'='.$val;

		return $strUrl.(strpos("?", $strUrl)===false?'?':'').implode("&", $arTmp);
	}

	public static function prePropcessRequestData($obData, $convertTo1251=false) {
		if(is_array($obData)) {
			$arResult = array();
			foreach($obData as $key1 => $val1) {
				if(is_array($val1)) {
					foreach($val1 as $key2 => $val2)
						$arResult[$key1][$key2] = cSKTools::prePropcessRequestDataFunction($val2, $convertTo1251);
				} else $arResult[$key1] = cSKTools::prePropcessRequestDataFunction($val1, $convertTo1251);
			}
			return $arResult;
		} else return cSKTools::prePropcessRequestDataFunction($obData, $convertTo1251);
	}

	public static function safeText($strText) {
		return trim(htmlspecialchars($strText));
	}

	public static function arrayToJSON($array)
	{
		if(!is_array($array)) {
			return false;
		}

		$associative = count(array_diff(array_keys($array), array_keys(array_keys($array))));
		if($associative) {

			$construct = array();
			foreach($array as $key => $value) {

				if(is_numeric($key)) {
					$key = "key_$key";
				}
				$key = '"'.addslashes($key).'"';

				if(is_array($value)) {
					$value = cSKTools::arrayToJSON($value);
				}
				else if(!is_numeric($value) || is_string($value)) {
					$value = '"'.addslashes($value).'"';
				}

				$construct[] = "$key: $value";
			}

			$result = "{ ".implode(", ", $construct)." }";

		} else {
			$construct = array();
			foreach($array as $value) {

				if(is_array($value)) {
					$value = cSKTools::arrayToJSON($value);
				}
				else if(!is_numeric($value) || is_string($value)) {
					$value = '"'.addslashes($value).'"';
				}

				$construct[] = $value;
			}

			$result = "[ ".implode(", ", $construct)." ]";
		}

		return $result;
	}
}

class skRedirect {
	public static function checkRedirect($strUrl) {
		$strUrl = iconv("utf8", "windows-1251", urldecode(trim($strUrl)));
		if(!empty($strUrl)) {
			if(CModule::IncludeModule("iblock")) {
				$rsI = CIBlockElement::GetList(Array(), array(
					"ACTIVE" => "Y",
					"IBLOCK_ID" => REDIRECT_IBLOCK_ID,
				   "PREVIEW_TEXT" => $strUrl
				), false, false, array("DETAIL_TEXT"));
				if($arI = $rsI->Fetch()) {
					if(!empty($arI["DETAIL_TEXT"]))
						LocalRedirect($arI["DETAIL_TEXT"], false, "301 Moved permanently");
				}
			}
		}
	}

	public function addRedirect($arRedirect) {
		if(empty($arRedirect) || !is_array($arRedirect)) return false;

		if(CModule::IncludeModule("iblock")) {
			$arAllRedirect = array();
			$rsI = CIBlockElement::GetList(Array(), array("IBLOCK_ID" => REDIRECT_IBLOCK_ID), false, false, array("ID", "IBLOCK_ID", "PREVIEW_TEXT", "DETAIL_TEXT"));
			while($arI = $rsI->Fetch())
				$arAllRedirect[$arI["~PREVIEW_TEXT"]] = $arI;

			$el = new CIBlockElement;
			foreach($arRedirect as $strOldUrl => $strNewUrl) {
				$strOldUrl = trim($strOldUrl);
				$strNewUrl = trim($strNewUrl);

				if(!empty($strOldUrl) && !empty($strNewUrl)) {
					if(isset($arAllRedirect[$strOldUrl])) {
						$el->Update($arAllRedirect[$strOldUrl]["ID"], array("DETAIL_TEXT" => $strNewUrl, "ACTIVE" => "Y"));
					} else {
						$arNewRedirectFields = array(
							"IBLOCK_ID" => REDIRECT_IBLOCK_ID,
							"ACTIVE" => "Y",
							"NAME" => $strOldUrl,
							"PREVIEW_TEXT" => $strOldUrl,
							"DETAIL_TEXT" => $strNewUrl,
							"PREVIEW_TEXT_TYPE" => "text",
							"DETAIL_TEXT_TYPE" => "text"
						);
						$el->Add($arNewRedirectFields);
					}
				}
			}
		}
	}
}