<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
$APPLICATION->IncludeComponent("bitrix:sale.basket.basket.small", "template1", Array(
    "PATH_TO_BASKET" => "/basket/",    // �������� �������
        "PATH_TO_ORDER" => "/basket/order/",    // �������� ���������� ������
        "SHOW_DELAY" => "Y",    // ���������� ���������� ������
        "SHOW_NOTAVAIL" => "Y",    // ���������� ������, ����������� ��� �������
        "SHOW_SUBSCRIBE" => "Y",    // ���������� ������, �� ������� �������� ����������
    ),
    false
);?>