<?
    require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
    /* $dirPath = "sitemap_000.xml";
    $xml = simplexml_load_file($dirPath);
    foreach ($xml-> url as $key => $url ) {
    $loc=$url->loc;
    $strLoc=$loc->asXML();
    if (!(strpos($strLoc, "catalog"))) {
    //            arshow($strLoc);
    unset($xml->url[$key]);
    }
    }
    arshow($xml->asXML());                   */
    echo 123;
    $xml = simplexml_load_file('sitemap_000.xml');
    $url_total = count($xml->url);
    for ($i = ($url_total - 1); $i >= 0; --$i) {
        if (strpos($xml->url[$i]->loc, 'catalog')) {        
            continue;
        } else {
            unset($xml->url[$i]);
        }
    }
    arshow($xml->asXML("sitemap_000_new.xml"));

    echo '<br>123'

?>