<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");?>

<?      /*
    //������ ����� ��������� ��
    $emptyFROM = array();  //�������� � ����� �� ��� ���������
    $emptyTO = array();
    $elsFROM = CIBlockElement::GetList(array(), array("IBLOCK_ID"=>26), false, false, array("PROPERTY_CML2_ARTICLE","ID","NAME","XML_ID"));
    echo "����� ��������� � �� 26: ".$elsFROM->SelectedRowsCount();
    //�������� �������� �� ������ ��
    while($arElsFrom = $elsFROM->Fetch()) {
        //arshow($arElsFrom);
        //���� � �������� ��� �������� - ���������� ��� � ����. ������
        if (!$arElsFrom["PROPERTY_CML2_ARTICLE_VALUE"]) {
            $emptyFROM[$arElsFrom["ID"]] = $arElsFrom["NAME"];   
        }
        //���� ������� ���� - �������� ����� � ������ �� ��������������� �����          
        else {
            $elTO = CIBlockElement::GetList(array(), array("IBLOCK_ID"=>2,"PROPERTY_ARTICUL"=>$arElsFrom["PROPERTY_CML2_ARTICLE_VALUE"]), false, false, array("ID"));  
            //���� ����� ����� � ����������� ���������, �������������� � ���� ������� ���
            if($arElTo = $elTO->Fetch()) {
                $el = new CIBlockElement;                

                $arLoadProductArray = Array(
                    "XML_ID" => $arElsFrom["XML_ID"]
                );        
              //  $res = $el->Update($arElTo["ID"], $arLoadProductArray);    
            }
            //���� ����� �� �����, ����� ������� � ��������������� ������
            else {
                $emptyTO[$arElsFrom["ID"]] = $arElsFrom["PROPERTY_CML2_ARTICLE_VALUE"]; 
            }       

        }     
    }
    echo "<br>��������� ��� ��������� � �� 26: ".count($emptyFROM)."<br>";
    arshow($emptyFROM);
    echo "<br>��������� �� ������� � �� 2: ".count($emptyTO)."<br>";
    arshow($emptyTO); 
    */
    
    //�������� �� �� 2, ������� �� ���������� 12.03
    
    $notUpdate = array();
    $els = CIBLockElement::GetList(array(), array("IBLOCK_ID"=>2, "<=TIMESTAMP_X"=>date($DB->DateFormatToPHP(CLang::GetDateFormat("SHORT")), mktime(0,0,0,03,12,2015))), false, false, array("ID","PROPERTY_ARTICUL"));
    while($arElement = $els->Fetch()) {
       $notUpdate[$arElement["ID"]] = $arElement["PROPERTY_ARTICUL_VALUE"];
    }
    echo "�� ��������� ���������: ".count($notUpdate);
    arshow($notUpdate);
?>