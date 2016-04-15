<?if (!isset($_GET["referer1"]) || strlen($_GET["referer1"])<=0) $_GET["referer1"] = "yandext";?><?if (!isset($_GET["referer2"])) $_GET["referer2"] = "";?><? header("Content-Type: text/xml; charset=windows-1251");?><? echo "<"."?xml version=\"1.0\" encoding=\"windows-1251\"?".">"?>
<!DOCTYPE yml_catalog SYSTEM "shops.dtd">
<yml_catalog date="2015-05-29 10:00">
<shop>
<name>Мамин Городок</name>
<company>Мамин Городок</company>
<url>http://www.mamingorodok.ru</url>
<currencies>
<currency id="RUB" rate="1"/>
<currency id="USD" rate="33.7"/>
<currency id="EUR" rate="42"/>
</currencies>
