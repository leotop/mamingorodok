<?
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/auxiliary/all_prolog.php");
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/auxiliary/setting.php");

//Название листов
define("SECTION_WORKSHEETS", 'Sections');
define("MANUFACTURER_WORKSHEETS", 'Manufacturer');
define("PROPERTIES_WORKSHEETS", 'Properties');
define("ENUMLIST_WORKSHEETS", 'EnumList');
define("ELEMENT_WORKSHEETS", 'Elements');
define("COLOR_WORKSHEETS", 'ColorSize');
define("PRODUCERS_PROPERTY_FILTER", "FILTER_LINK");

//Название файлов
define("GOODS_FILES", 'import_goods');
define("MANUFACTURER_FILES", 'import_manufacturer');
define("PROPERTY_FILES", 'properties_goods');


define("COLOR_PROPERTY_FILE", 'IMG_BIG');
define("COLOR_PROPERTY_MODEL_3D", 'MODEL_3D');

define("isCronImport", true);
define("wideDebug", true);


function wideDebug($str, $rn = true)
{
	global $handleLog;
	if(wideDebug) {
		echo  $str.($rn?"<br>\r\n":"");
		//fwrite($handleLog, $str.($rn?"\r\n":""));
	}
};



if(CModule::IncludeModule("iblock")) {
	$path = $_SERVER["DOCUMENT_ROOT"]."/skock/import/";

	global $watermark, $watermarkPicture, $temps;
	$handleLog;
	//$watermark = new watermark();

	//$watermarkPicture = $path."default/watermark.png";
	$temps = $path."temp/";
	$arAllPrice = array();

	if(!function_exists('getFileDir')) //Получение файлов из директории
	{
		function getFileDir($dir)
		{
			if(!empty($dir)) {
				if(is_dir($dir)) {
					$files = scandir($dir);
					array_shift($files);
					array_shift($files);

					return $files;
				}
			}
			return array();
		}
	}


	//массив с файликами
	$files = getFileDir($path);

	$have_goods = false;
	foreach($files as $file) {
		if(preg_match("/".GOODS_FILES.".*?\.xls/is", $file)) {
			$have_goods = true;
			break;
		}
	}

	$handleLog = fopen($filelog, ($arParams["STEP"]<2?'w':'a'));
	if(!$have_goods) {
		fwrite($handleLog, "NO impot_goods file\r\n");
		fclose($filelog, 'w');
		die("NO impot_goods file.");
	}



	//echo "Обновление цветоразмеров<br>\r\n";
	fwrite($handleLog, "Update colorsize\r\n");

	if(empty($arElem)) { // если запускаем поэтапно
		$rsI = CIBlockElement::GetList(Array("SORT" => "ASC"), array("IBLOCK_ID" => 2), false, false, array("ID", "NAME", "XML_ID"));
		while($arI = $rsI->Fetch()) {
			$arElem[$arI["XML_ID"]]["ID"] = $arI["ID"];
			$arElem[$arI["XML_ID"]]["NAME"] = $arI["NAME"];
		}
	}

	//структура файлика цветных элементов
	$elementsColorRealStruct = array();
	//поля файлика цветных элементов
	$elementsColorStruct = array("ELEMENT_XML_ID", "XML_ID", "ACTIVE", "COLOR_CODE", "COLOR", "SIZE", "QUANTITY", "PRICE", "OLD_PRICE", "SORT", "PIC_UPD");



	//добавление элементов
	foreach($files as $file) {
		if(preg_match("/".GOODS_FILES.".*?\.xls/is", $file)) {
			$xml = new CIExcelReader($path.$file);
			$arProperty = $xml->GetWorksheets();
			$pagearProperty = false;
			$pagearProperty = array_search(COLOR_WORKSHEETS, $arProperty);

			$intCounter = 0;
			if($pagearProperty !== false) {
				$i = 0;

				while($arRowDateInfo = $xml->GetNextDataFromWorksheet($pagearProperty)) {
					echo '<pre>'.print_r($arRowDateInfo, true).'</pre>';
					$intCounter++;
					$strWideDebug = $intCounter.' ';

					if($i == 0) {
						foreach($elementsColorStruct as $elementsElem) {
							$elementsElem = trim($elementsElem);
							if(in_array($elementsElem, $arRowDateInfo))
								$elementsColorRealStruct[$elementsElem] = array_search($elementsElem, $arRowDateInfo);
						}
					} else {
						foreach($arRowDateInfo as $strFID => $strFValue)
							$arRowDateInfo[$strFID] = trim($strFValue);

						echo $arRowDateInfo[$elementsColorRealStruct["ELEMENT_XML_ID"]];
						var_dump($arElem[$arRowDateInfo[$elementsColorRealStruct["ELEMENT_XML_ID"]]]);
						echo strlen($arRowDateInfo[$elementsColorRealStruct["ELEMENT_XML_ID"]]);


						$NAME = $arElem[$arRowDateInfo[$elementsColorRealStruct["ELEMENT_XML_ID"]]]["NAME"];
						$XML_ID = $arRowDateInfo[$elementsColorRealStruct["XML_ID"]];
						if(empty($XML_ID)) {
							fwrite($handleLog, "Error: У одной из цветоразмера не задан XML_ID ".$XML_ID."\r\n");
							continue;
						}

						echo "Process ".$XML_ID;

						$PIC_UPD = "";
						if($elementsColorRealStruct["PIC_UPD"] !== false)
							$PIC_UPD = $arRowDateInfo[$elementsColorRealStruct["PIC_UPD"]];
						if(!empty($PIC_UPD)) $PIC_UPD = "Y";

						$el = trim($arRowDateInfo[$elementsColorRealStruct["ELEMENT_XML_ID"]]);
						$ELEMENT_ID = intval(trim($arElem[$el]["ID"]));

						if($ELEMENT_ID > 0) {
							$PARENT_XML = trim($arRowDateInfo[$elementsColorRealStruct["ELEMENT_XML_ID"]]);

							$COLOR_CODE = trim($arRowDateInfo[$elementsColorRealStruct["COLOR_CODE"]]);
							$SIZE = $arRowDateInfo[$elementsColorRealStruct["SIZE"]];
							if(empty($COLOR_CODE) && empty($SIZE)) {
								fwrite($handleLog, "Error: У цветоразмера XML_ID ".$XML_ID." пропущен цвет и размер (Parent XML: ".$PARENT_XML.") "."<pre>".print_r($arRowDateInfo, true)."</pre>; | ".$elementsColorRealStruct["COLOR_CODE"]." | ".$elementsColorRealStruct["SIZE"]."\r\n");
								unset($arResult["ALL_OFFERS"][$ar_fields["ID"]]);
								continue;
							}

							$COLOR = $arRowDateInfo[$elementsColorRealStruct["COLOR"]];
							$ACTIVE = $arRowDateInfo[$elementsColorRealStruct["ACTIVE"]];
							$QUANTITY = intval($arRowDateInfo[$elementsColorRealStruct["QUANTITY"]]);
							$PRICE = floatval($arRowDateInfo[$elementsColorRealStruct["PRICE"]]);
							$OLD_PRICE = floatval($arRowDateInfo[$elementsColorRealStruct["OLD_PRICE"]]);
							$SORT = $arRowDateInfo[$elementsColorRealStruct["SORT"]];

							if(empty($XML_ID)) $XML_ID = $PARENT_XML."_".$COLOR_CODE."_".$SIZE;

							if(empty($NAME) || empty($XML_ID))
								break;

							if(!empty($COLOR)) $NAME .= " ".$COLOR;
							if(!empty($QUANTITY)) $NAME .= " ".$QUANTITY;

							$arFilter = Array(
								"IBLOCK_ID" => OFFERS_IBLOCK_ID,
								"XML_ID" => $XML_ID
							);

							if($ACTIVE != "Y") $ACTIVE = "N";

							$res = CIBlockElement::GetList(Array("SORT" => "ASC"), $arFilter, false, false, array("ID", "PROPERTY_PICTURE_MINI", "PROPERTY_PICTURE_MIDI", "PROPERTY_PICTURE_MAXI", "TIMESTAMP_X", "PROPERTY_UPDATE_HASH"));

							$MINI_DEL = "";
							$MIDI_DEL = "";
							$MAXI_DEL = "";
							$ID = 0;
							if($ar_fields = $res->GetNext()) {
								$strUpdateHash = $ar_fields["PROPERTY_UPDATE_HASH_VALUE"];

								echo ' found [BitrixID='.$ar_fields["ID"].']';



								unset($arResult["ALL_OFFERS"][$ar_fields["ID"]]);
								$ID = $ar_fields["ID"];
								$db_props = CIBlockElement::GetProperty(OFFERS_IBLOCK_ID, $ID, array("sort" => "asc"), Array("CODE" => "PICTURE_MINI"));
								while($ar_props = $db_props->Fetch()) {
									$MINI_DEL = $ar_props["VALUE"];
									$arTmpPic = CFile::GetFileArray($MINI_DEL);
									if($arTmpPic["ID"] <= 0) {
										$prop["PICTURE_MINI"] = array("del" => "Y");
										$MINI_DEL = '';
									}
								}
								$db_props = CIBlockElement::GetProperty(OFFERS_IBLOCK_ID, $ID, array("sort" => "asc"), Array("CODE" => "PICTURE_MIDI"));
								while($ar_props = $db_props->Fetch()) {
									$MIDI_DEL = $ar_props["VALUE"];
									$arTmpPic = CFile::GetFileArray($MIDI_DEL);
									if($arTmpPic["ID"] <= 0) {
										$prop["PICTURE_MIDI"] = array("del" => "Y");
										$MIDI_DEL = '';
									}
								}

								$db_props = CIBlockElement::GetProperty(OFFERS_IBLOCK_ID, $ID, array("sort" => "asc"), Array("CODE" => "PICTURE_MAXI"));
								while($ar_props = $db_props->Fetch()) {
									$MAXI_DEL = $ar_props["VALUE"];
									$arTmpPic = CFile::GetFileArray($MAXI_DEL);
									if($arTmpPic["ID"] <= 0) {
										$prop["PICTURE_MAXI"] = array("del" => "Y");
										$MAXI_DEL = '';
									}
								}
							}
							else $ID = 0;
							$SORT = intval(str_replace(" ", "", $SORT));

							$el = new CIBlockElement;

							$arLoadProductArray = Array(
								"IBLOCK_ID" => OFFERS_IBLOCK_ID,
								"XML_ID" => $XML_ID,
								"NAME" => $NAME,
								"ACTIVE" => $ACTIVE,
								"SORT" => $SORT
							);

							$prop = array();

							if(!empty($COLOR_CODE)) $prop["COLOR_CODE"] = $COLOR_CODE;
							if(!empty($COLOR)) $prop["COLOR"] = $COLOR;
							if(!empty($SIZE)) $prop["SIZE"] = $SIZE;
							if($ELEMENT_ID > 0) $prop["MAIN_PRODUCT"] = $ELEMENT_ID;
							if($OLD_PRICE > 0) $prop["OLD_PRICE"] = $OLD_PRICE;

							$MINI = "";
							$MIDI = "";
							$MAXI = "";

							$file_path = $path."goods_files/".$PARENT_XML."/";
							$file_path_temp = $path."temp/";
							$picture_file = getFileDir($file_path);
							if($ID == 0) {
								$arFileHash = array();
								foreach($picture_file as $file)
									$arFileHash[] = trim($file."|".filesize($file));
								$strCurrentPicHash = md5(implode("::", $arFileHash));

								$have = 0;
								foreach($picture_file as $k => $v) {
									if(preg_match("/^.*?".$COLOR_CODE."+?[ ]*?\.[a-zA-Z]{2,}?$/i", $v)) {
										$have++;
										if(preg_match("/MINI_.*?/i", $v)) {
											if(file_exists($file_path.$v)) {
												$MINI = CFile::MakeFileArray($file_path.$v);
												echo ' | found mini';
											}
											else $MINI = "";
										}
										elseif(preg_match("/MIDI_.*?/i", $v)) {
											if(file_exists($file_path.$v)) {
												$MIDI = CFile::MakeFileArray($file_path.$v);
												echo ' | found midi';
											}
											else $MIDI = "";
										}
										else {
											if(file_exists($file_path.$v)) {
												$MAXI = CFile::MakeFileArray($file_path.$v);
												echo ' | found maxi';
											}
											else $MAXI = "";
										}
									}
								}

								if($have == 0)
									fwrite($handleLog, "Warning: У цветоразмера XML_ID ".$XML_ID." не найдено фото для COLOR_CODE: ".$COLOR_CODE."\r\n");
							}

							if(is_array($MINI))
								$prop["PICTURE_MINI"] = $MINI;
							elseif(is_array($MAXI)) $prop["PICTURE_MINI"] = CIBlock::ResizePicture(array_merge($MAXI, array("COPY_FILE" => "Y")), array("WIDTH" => 64, "HEIGHT" => 64, "METHOD" => "resample", "COMPRESSION" => 95));

							if(is_array($MIDI)) {
								CFile::ResizeImage($MIDI, array('width' => 256, 'height' => 256), BX_RESIZE_IMAGE_PROPORTIONAL);
								$prop["PICTURE_MIDI"] = $MIDI;

								if(isset($MIDI_DEL) && $MIDI_DEL > 0) CFile::Delete($MIDI_DEL);
							}
							elseif(is_array($MAXI)) $prop["PICTURE_MIDI"] = CIBlock::ResizePicture(array_merge($MAXI, array("COPY_FILE" => "Y")), array("WIDTH" => 256, "HEIGHT" => 256, "METHOD" => "resample", "COMPRESSION" => 95));

							if(is_array($MAXI)) {
								$prop["PICTURE_MAXI"] = $MAXI;
								//$prop["PICTURE_MAXI"]["del"] = "Y";
								if(isset($MAXI_DEL) && $MAXI_DEL > 0) CFile::Delete($MAXI_DEL);
							}
							elseif(!empty($MAXI_DEL)) {
								//$rsFile = CFile::GetByID($MAXI_DEL);
								//if($arFile = $rsFile->Fetch())  $prop["PICTURE_MAXI"] = $arFile;
							}

							$prop["PHASH"] = $strCurrentPicHash;
							$arLoadProductArray["PROPERTY_VALUES"] = $prop;
							$arLoadProductArray["PROPERTY_VALUES"]["SERVICE_QSORT"] = $QUANTITY > 0 ? 1 : 0;

							// add fake quantity and price prop
							$arLoadProductArray["QUANTITY"] = $QUANTITY;
							$arLoadProductArray["CATALOG_PRICE"] = $PRICE;

							$arLoadProductArray["PROPERTY_VALUES"]["UPDATE_HASH"] = md5(serialize($arLoadProductArray));

							echo '<pre>'.print_r($arLoadProductArray, true).'</pre>';

							if($strUpdateHash != $arLoadProductArray["PROPERTY_VALUES"]["UPDATE_HASH"])
								echo 'update';

//							if($ID > 0) {
//								if($strUpdateHash != $arLoadProductArray["PROPERTY_VALUES"]["UPDATE_HASH"]) {
//									if(!$PRODUCT_ID = $el->Update($ID, $arLoadProductArray, false, false, false)) {
//										fwrite($handleLog, "Error Color Element Update: ".$XML_ID." ".$el->LAST_ERROR."\r\n");
//										continue;
//									}
//									else $strWideDebug .= ' colorsize updated';
//								} else $strWideDebug .= ' colorsize hash match';
//							}
//							else {
//								if(!$PRODUCT_ID = $el->Add($arLoadProductArray, false, false, false)) {
//									fwrite($handleLog, "Error Color Element Add: ".$XML_ID." ".$el->LAST_ERROR."\r\n");
//									continue;
//								}
//								else {
//									$ID = $PRODUCT_ID;
//									$strWideDebug .= ' colorsize added';
//								}
//							}

//							if($ID > 0 && $strUpdateHash != $arLoadProductArray["PROPERTY_VALUES"]["UPDATE_HASH"]) {
//								$arFields = Array(
//									"PRODUCT_ID" => $ID,
//									"CATALOG_GROUP_ID" => 1,
//									"PRICE" => $PRICE,
//									"CURRENCY" => "RUB"
//								);
//
//								if($arLoadProductArray["ACTIVE"] == "Y" && $PRICE > 0)
//									$arAllPrice[$arLoadProductArray["PROPERTY_VALUES"]["MAIN_PRODUCT"]][] = $PRICE;
//
//								if(CModule::IncludeModule("catalog")) {
//									$res = CPrice::GetList(array(), array("PRODUCT_ID" => $ID));
//
//									$pr = new CPrice;
//									if($arr = $res->Fetch()) {
//										if(!CPrice::Update($arr["ID"], $arFields)) {
//											fwrite($handleLog, "Error Price Color Element Update: ".$XML_ID." ".$pr->LAST_ERROR."\r\n");
//											continue;
//										}
//										else $IDD = $arr["ID"];
//									}
//									else {
//										$IDD = 0;
//										if(!$IDD = CPrice::Add($arFields)) {
//											fwrite($handleLog, "Error Price Color Element Add: ".$XML_ID." ".$pr->LAST_ERROR."\r\n");
//											continue;
//										}
//									}
//
//									$IDD = intval($IDD);
//
//									if($ID > 0) {
//										$arF = array(
//											"QUANTITY" => $QUANTITY,
//											"QUANTITY_TRACE" => "N",
//											"PRICE_TYPE" => "S",
//										);
//
//										$db_res = CCatalogProduct::GetList(array("QUANTITY" => "DESC"), array("ID" => $ID), false, false, array("QUANTITY", "ID"));
//										if($ar_res = $db_res->Fetch()) {
//											if(!CCatalogProduct::Update($ar_res["ID"], $arF)) {
//												echo "Error Quantity Color Element Update: ";
//												fwrite($handleLog, "Error Quantity Color Element Update: ".$ar_res["ID"]."\r\n");
//												continue;
//											}
//										}
//										else {
//											$arF["ID"] = $ID;
//											if(!CCatalogProduct::Add($arF)) {
//												fwrite($handleLog, "Error Quantity Color Element Add: ".$ID."\r\n");
//												continue;
//											}
//										}
//
//									}
//								}
//							}

							wideDebug($strWideDebug);
						}
						else {
//							$el = trim($arRowDateInfo[$elementsColorRealStruct["ELEMENT_XML_ID"]]);
//							echo $elementsColorRealStruct["ELEMENT_XML_ID"];
//							echo ' | '.$arRowDateInfo[$elementsColorRealStruct["ELEMENT_XML_ID"]];
//							echo ' | '.$el;
//							echo " | ".$arElem[$el]["ID"];
//							die();


						}
					}
					$i++;
				}
			}
		}
	}
}
