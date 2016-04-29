<?
class CGeoIP
{
	public static function getLocationName() {
		return $GLOBALS["GEO_DATA_BITRIX"]["NAME"];
	}

	public static function getLocationID() {
		return $GLOBALS["GEO_DATA_BITRIX"]["ID"];
	}

	public function __construct($options = null)
	{
		if (!CModule::IncludeModule("sale")) die();

		$this->dirname = dirname(__file__);

		if(!empty($_REQUEST["IP"])) $options['ip'] = $_REQUEST["IP"];

		// ip
		if(!isset($options['ip']) OR !$this->is_valid_ip($options['ip']))
			$this->ip = $this->get_ip();
		elseif($this->is_valid_ip($options['ip']))
			$this->ip = $options['ip'];

		if(isset($options['charset']) && $options['charset'] && $options['charset'] != 'windows-1251')
			$this->charset = $options['charset'];

		if(!empty($_REQUEST["IP"])) {
			global $APPLICATION;
			$APPLICATION->set_cookie("skGeoBitrix", "", -1, "/");
			$GLOBALS["GEO_DATA"] = $this -> get_value(false, false);
		} else $GLOBALS["GEO_DATA"] = $this -> get_value();

		$this -> setBitrixCityData($GLOBALS["GEO_DATA"]);
	}

	public function setBitrixCityData($arGEOLocation, $isRenew = false) {
		if(empty($_COOKIE["skGeoBitrix"])) $GLOBALS["skGeoInit"] = 'Y';

		if(empty($_COOKIE["skGeoBitrix"]) || $isRenew) {
			$arAvailableLocations = getAvailableLocationID();
			if(!in_array($arGEOLocation["city"], $arAvailableLocations)) $arGEOLocation["city"] = -1;

			if(!empty($arGEOLocation["city"])) {
				if(intval($arGEOLocation["city"]) > 0)
					$arFilter = array("LID" => LANGUAGE_ID, "ID" => intval($arGEOLocation["city"]));
				else $arFilter = array("LID" => LANGUAGE_ID, "CITY_NAME" => $arGEOLocation["city"]);



				$rsLocation = CSaleLocation::GetList(array(), $arFilter);
				if($arLocation = $rsLocation -> Fetch()) {
					$arBitrixLocation = array(
						"ID" => $arLocation["ID"],
						"NAME" => $arLocation["CITY_NAME"],
					);
					setcookie('skGeoBitrix', serialize($arBitrixLocation), time() + 315360000, '/');
				}
			}
		}

		$GLOBALS["GEO_DATA_BITRIX"] = (isset($arBitrixLocation)?$arBitrixLocation:unserialize($_COOKIE["skGeoBitrix"]));
		if(intval($GLOBALS["GEO_DATA_BITRIX"]["ID"]) <= 0) {
			$GLOBALS["GEO_DATA_BITRIX"] = array("ID" => 1732, "NAME" => "������", "DEFAULT" => "Y");
			$arBitrixLocation = array(
				"ID" => 1732,
				"NAME" => "������ � ��",
			);
			setcookie('skGeoBitrix', serialize($arBitrixLocation), time() + 315360000, '/');
		}

	}

	/**
	 * ������� ��������� ���������� �������� �� ����������� ������� ������ �� ip
	 * @param string - ���� �������. ���� ���������� ���������� ��������.
	 * ���� ����� ���� ������ 'inetnum', 'country', 'city', 'region', 'district', 'lat', 'lng'
	 * @param bolean - ������������� ������� ������ � ���� ��� ���
	 * ���� true, �� � ���� ����� �������� ������ �� ip � ��������� ������� �� ipgeobase ����������� �� �����.
	 * ���� false, �� ������ ��������� ����� ������������� � ipgeobase
	 * @return array OR string - ������������� ������� ����������� ������ �������.
	 */
	function get_value($key = false, $cookie = true)
	{
		$key_array = array('inetnum', 'country', 'city', 'region', 'district', 'lat', 'lng');
		if(!in_array($key, $key_array))
			$key = false;

		// ���� ���������� ���� � �������� ��� �������, �� ������� � ���������� ������ �� ����
		if($cookie && isset($_COOKIE['geobase']) && $_REQUEST["GEO_TEST"] != "Y") {
			$data = unserialize($_COOKIE['geobase']);
			//echo '<pre>'.print_r($data, true).'</pre>';
			if(empty($data)) {
				$data = $this->get_geobase_data();
				setcookie('geobase', serialize($data), time() + 315360000, '/');
			}
		} else {
			$data = $this->get_geobase_data();

			setcookie('geobase', serialize($data), time() + 315360000, '/');
		}

		if($key)
			return $data[$key]; // ���� ������ ����, ���������� ������ � ������� �������
		else
			return $data; // ����� ���������� ������ �� ����� �������
	}

	/**
	 * ������� �������� ������ �� ip.
	 * @return array - ���������� ������ � �������
	 */
	function get_geobase_data()
	{
		// �������� ������ �� ip
		$link = 'ipgeobase.ru:7020/geo?ip='.$this->ip;

		if($_REQUEST["TEST_GEO"] == "Y") echo $this->ip;

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $link);
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_TIMEOUT, 3);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 3);


		$intMaxIteration = 5;

		$intIterationCnt = 0;
		while($intIterationCnt < $intMaxIteration) {
			$string = curl_exec($ch);

			if(strpos($string, "Moved Permanently") === false) {
				if($this->charset)
					$string = iconv('windows-1251', $this->charset, $string);
				$data = $this->parse_string($string);

				break;
			} else sleep(1);

			$intIterationCnt++;
		}

		if($_REQUEST["GEO_TEST"] == "Y") echo '<pre>'.print_r($data, true).'</pre>';

		return $data;
	}

	/**
	 * ������� ������ ���������� � XML ������ � ������, ���� �� ������� �� ����������� ���������� Simplexml
	 * @return array - ���������� ������ � �������
	 */

	function parse_string($string)
	{
		$pa['inetnum'] = '#<inetnum>(.*)</inetnum>#is';
		$pa['country'] = '#<country>(.*)</country>#is';
		$pa['city'] = '#<city>(.*)</city>#is';
		$pa['region'] = '#<region>(.*)</region>#is';
		$pa['district'] = '#<district>(.*)</district>#is';
		$pa['lat'] = '#<lat>(.*)</lat>#is';
		$pa['lng'] = '#<lng>(.*)</lng>#is';
		$data = array();
		foreach($pa as $key => $pattern) {
			if(preg_match($pattern, $string, $out)) {
				$data[$key] = trim($out[1]);
			}
		}
		return $data;
	}

	/**
	 * ������� ���������� ip ����� �� ����������� ������� $_SERVER
	 * ip ������ ����������� ������� � �������������, ��� ����������� ���������� ������������� ������
	 * @return ip-�����
	 */
	function get_ip()
	{
		if(!empty($_REQUEST["IP"]))
			return $_REQUEST["IP"];


		$ip = false;

		if ( $_SERVER ['REMOTE_ADDR']) {$ipa[] = $_SERVER ['REMOTE_ADDR'];}
		if ( getenv ('REMOTE_ADDR')) {$ipa[] = getenv ('REMOTE_ADDR');}
		if ( getenv ('HTTP_FORWARDED_FOR')) {$ipa[] = getenv ('HTTP_FORWARDED_FOR');}
		if ( getenv ('HTTP_X_FORWARDED_FOR')) {$ipa[] = getenv ('HTTP_X_FORWARDED_FOR');}
		if ( getenv ('HTTP_X_COMING_FROM')) {$ipa[] = getenv ('HTTP_X_COMING_FROM');}
		if ( getenv ('HTTP_VIA')) {$ipa[] = getenv ('HTTP_VIA');}
		if ( getenv ('HTTP_XROXY_CONNECTION')) {$ipa[] = getenv ('HTTP_XROXY_CONNECTION');}
		if ( getenv ('HTTP_CLIENT_IP')) {$ipa[] = getenv ('HTTP_CLIENT_IP');}

		// ��������� ip-������ �� ���������� ������� � �������������.
		foreach($ipa as $ips) {
			//  ���� ip �������� �������� ����, ��������� ip ����� � ���������� ���
			if($this->is_valid_ip($ips)) {
				$ip = $ips;
				break;
			}
		}

		if($_REQUEST["GEO_TEST"] == "Y") {
			echo '<pre>'.print_r($ipa, true).'</pre>';
			echo 'IP: '.$ip;
		}

		return $ip;

	}

	/**
	 * ������� ��� �������� ���������� ip ������
	 * @param ip ����� � ������� 1.2.3.4
	 * @return bolean : true - ���� ip ��������, ����� false
	 */
	function is_valid_ip($ip = null)
	{
		if(preg_match("#^([0-9]{1,3})\.([0-9]{1,3})\.([0-9]{1,3})\.([0-9]{1,3})$#", $ip))
			return true; // ���� ip-����� �������� ��� ���������� ���������, ���������� true

		return false; // ����� ���������� false
	}

}

?>