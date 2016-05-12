<?
    if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

    $url = "http://universe.uiscom.ru/centrex/callme/make_call/";
    $h = $arParams["h"];
    $number = "";
    if(preg_match("/[0-9]+?/i",$_POST["number1"]) && preg_match("/[0-9]+?/i",$_POST["number2"]))
        $number = "+7".$_POST["number1"].$_POST["number2"];

    $capcha_key="";
    if(preg_match("/[0-9a-z]+?/i",$_POST["capcha_key"]))
        $capcha_key = $_POST["capcha_key"];

    $capcha_word ="";
    if(preg_match("/[0-9a-zA_Z]+?/i",$_POST["capcha_word"]))
        $capcha_word = $_POST["capcha_word"];

    $arResult["CALLING"] = "NO";

    $alfa = "0123456789abcdef";
    $countalfa = strlen($alfa)-1;

    function curl_post($url,$XPost){
        $ch = curl_init(); // initialize curl handle 
        curl_setopt($ch, CURLOPT_URL, $url); // set url to post to 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // return into a variable 
        curl_setopt($ch, CURLOPT_TIMEOUT, 40); // times out after 4s 
        curl_setopt($ch, CURLOPT_POSTFIELDS, $XPost); // add POST fields 
        curl_setopt($ch, CURLOPT_POST, 1); 
        return curl_exec($ch); // run the whole process 
    }

    if(!empty($number)){
        $arResult["CALLING"] = "YES";

        if(!empty($capcha_key) && !empty($capcha_word)){
            $pst = "h=".$h."&captcha_key=".$capcha_key."&captcha_value=".$capcha_word."&phone=".$number;
            $result = curl_post($url,$pst);
            if(preg_match("/state=captcha_incorrect.*?/i",$result)){
                $arResult["CALLING"] = "NO";
                $arResult["ERROR"] = "Код введен не верно.";
            }
            if(preg_match("/state=failed.*?/i",$result)){
                $arResult["CALLING"] = "NO";
                $arResult["ERROR"] = "Услуга не активна.";
            }

            $result = iconv("UTF-8","Windows-1251",$result);
        }
        else{
            $arResult["CALLING"] = "NO";
        }
    }

    if($arResult["CALLING"]=="NO"){
        $key = "";

        for($i=0;$i<65;$i++){
            $key .= $alfa[mt_rand(0,$countalfa)];
        }

        $arResult["KEY"] = $key;
    }

    $this->IncludeComponentTemplate();	

?>