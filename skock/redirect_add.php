<?
die();

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
CModule::IncludeModule("iblock");


$arRedirect = array(
	"/catalog/komplekty-v-krovatku/komplekt-postelnogo-belya-bombus-ilyusha-3-predmeta" => "/catalog/komplekty-v-krovatku/",
	"/catalog/avtokresla/avtokreslo-cybex-free" => "/catalog/avtokresla/",
	"/catalog/konverty/konvert-sonnyy-gnomik-masha-i-medved_2" => "/catalog/konverty/",
	"/catalog/igrushki-i-razvitie/igrushka-fisher-price-t7178-veselye-gonshchiki" => "/catalog/igrushki-i-razvitie/",
	"/community/blog/obsujdenie_tovarov/405" => "/community/blog/obsujdenie_tovarov/",
	"/catalog/kolyaski/kolyaska-2-v-1-roan-marita-elegance" => "/catalog/kolyaski/",
	"/catalog/krovatki/detskaya-krovatka_transformer-73003-ckv" => "/catalog/krovatki/",
	"/catalog/igrushki/stolik-muzykalnyy-dlya-igr-chicco-modo-67259" => "/catalog/igrushki/",
	"/catalog/kolyaski/kolyaska-progulochnaya-chicco-lite-way-glam-79301" => "/catalog/kolyaski/",
	"/catalog/konverty-na-vypisku/odeyalo_konvert-sonnyy-gnomik-malyutka" => "/catalog/konverty-na-vypisku/",
	"/community/group/obsujdenie_tovarov/658" => "/community/group/obsujdenie_tovarov/",
	"/catalog/krovatki/detskaya-krovatka_transformer-73001-skv" => "/catalog/krovatki/",
	"/community/group/obsujdenie_tovarov/460" => "/community/group/obsujdenie_tovarov/",
	"/catalog/sterilizatory/sterilizator-elektricheskiy-chicco-67288_10" => "/catalog/sterilizatory/",
	"/catalog/igrushki/kukla-myagkaya-fisher-price-v4724-corolle-granatovyy-elf" => "/catalog/igrushki/",
	"/catalog/avtokresla/avtokreslo-2_3-besafe-izi-up-x2" => "/catalog/avtokresla/",
	"/catalog/komplekty-v-krovatku/komplekt-v-krovatku-sonnyy-gnomik-afrika-7-predmetov" => "/catalog/komplekty-v-krovatku/",
	"/catalog/krovatki/detskaya-krovatka_transformer-73002-skv" => "/catalog/krovatki/",
	"/catalog/kolyaski/kolyaska-chetyryekhkolyesnaya-3-v-1-cam-comby-family" => "/catalog/kolyaski/",
	"/catalog/avtokresla/avtokreslo-0_-maxi_cosi-citi" => "/catalog/avtokresla/",
	"/catalog/avtokresla/avtokreslo-britax-evolva-1_2_3" => "/catalog/avtokresla/",
	"/catalog/avtokresla/tip-isofix/isofix" => "/catalog/avtokresla/",
	"/catalog/avtokresla/avtokreslo-s-bazoy-romer-baby-safe-shr-ii" => "/catalog/avtokresla/",
	"/catalog/kolyaski/tip-3-v-1/chicco" => "/catalog/kolyaski/",
	"/catalog/aksessuary-dlya-kolyasok/konvert-sonnyy-gnomik-arktika" => "/catalog/aksessuary-dlya-kolyasok/",
	"/catalog/kolyaski/tip-progulochnaya/3" => "/catalog/kolyaski/",
	"/community/group/obsujdenie" => "/community/group/obsujdenie_tovarov/",
	"/catalog/kolyaski/kolyaska-progulochnaya-chicco-lite-way-top-glam-79302-s-nakidkoy-dlya-nog" => "/catalog/kolyaski/",
	"/catalog/komplekty-v-krovatku/komplekt-v-krovatku-makkaroni-kids-volshebnaya-skazka-7-predmetov" => "/catalog/komplekty-v-krovatku/",
	"/catalog/komplekty-v-krovatku/komplekt-v-krovatku-bombus-veselaya-semeyka-7-predmetov" => "/catalog/komplekty-v-krovatku/",
	"/catalog/krovatki/�������" => "/catalog/krovatki/",
	"/catalog/konverty-dlya-progulok/konvert-voksi-urban" => "/catalog/konverty-dlya-progulok/",
	"/catalog/konverty-dlya-progulok/konvert-voksi-classic-mini" => "/catalog/konverty-dlya-progulok/",
	"/catalog/komplekty-v-krovatku/komplekt-v-krovatku-sonnyy-gnomik-lezheboki-3-predmeta" => "/catalog/komplekty-v-krovatku/",
	"/catalog/kolyaski/�������" => "/catalog/kolyaski/",
	"/catalog/krovatki/��������" => "/catalog/krovatki/",
	"/catalog/kolyaski/tip-progulochnaya/�����������" => "/catalog/kolyaski/tip-progulochnaya/",
	"/catalog/sterilizatory/������������" => "/catalog/sterilizatory/",
	"/catalog/kolyaski/tip-dlya-dvoyni/�������" => "/catalog/kolyaski/tip-dlya-dvoyni/",
	"/catalog/ryukzaki_-kenguru_-slingi/������" => "/catalog/ryukzaki_-kenguru_-slingi/",
	"/catalog/stulchiki-dlya-kormleniya/��������" => "/catalog/stulchiki-dlya-kormleniya/",
	"/catalog/manezhi/�����" => "/catalog/manezhi/",
	"/catalog/podogrevateli/�������������" => "/catalog/podogrevateli/",
	"/catalog/pelenalnye-stoliki/�����������" => "/catalog/pelenalnye-stoliki/",
	"/catalog/kolyaski/tip-transformer/�������" => "/catalog/kolyaski/tip-transformer/",
	"/catalog/konverty-na-vypisku/�������" => "/catalog/konverty-na-vypisku/",
	"/catalog/kolyaski/tip-progulochnaya/�������" => "/catalog/kolyaski/tip-progulochnaya/",
	"/catalog/krovatki/��������" => "/catalog/krovatki/",
	"/catalog/kolyaski/tip-lyulka/�������" => "/catalog/kolyaski/tip-lyulka/",
	"/catalog/kolyaski/tip-lyulka/�������" => "/catalog/kolyaski/tip-lyulka/",
	"/catalog/krovatki/tip-transformeri/��������" => "/catalog/krovatki/tip-transformeri/",
	"/catalog/komody/�����" => "/catalog/komody/",
	"/catalog/podogrevateli/��������" => "/catalog/podogrevateli/",
	"/catalog/manezhi/�������" => "/catalog/manezhi/",
	"/catalog/kolyaski/tip-2-v-1/�������" => "/catalog/kolyaski/tip-2-v-1/",
	"/catalog/kolyaski/tip-progulochnaya/�����������" => "/catalog/kolyaski/tip-progulochnaya/",
	"/catalog/komody/�����������" => "/catalog/komody/",
	"/catalog/shezlongi-kacheli/�������" => "/catalog/shezlongi-kacheli/",
	"/catalog/kormlenie-grudyu/�����������" => "/catalog/kormlenie-grudyu/",
	"/catalog/shezlongi-kacheli/��������" => "/catalog/shezlongi-kacheli/",
	"/catalog/krovatki/�������" => "/catalog/krovatki/�������",
	"/catalog/kolyaski/tip-progulochnaya/�������" => "/catalog/kolyaski/tip-progulochnaya/",
	"/catalog/radio-i-videonyani/���������" => "/catalog/radio-i-videonyani/",
	"/catalog/komody/�������" => "/catalog/komody/",
	"/catalog/manezhi/�������" => "/catalog/manezhi/",
	"/catalog/kolyaski/tip-progulochnaya/������" => "/catalog/kolyaski/tip-progulochnaya/",
	"/catalog/kolyaski/tip-transformer/�������" => "/catalog/kolyaski/tip-transformer/",
	"/catalog/kolyaski/progulochnaya-kolyaska-casualplay-vintage-3" => "/catalog/kolyaski/progulochnaya-kolyaska-casualplay-vintage-3",
	"/catalog/kolyaski/tip-3-v-1/�������" => "/catalog/kolyaski/tip-3-v-1/",
	"/catalog/shezlongi-kacheli/�������" => "/catalog/shezlongi-kacheli/",
	"/catalog/shkafy/�������" => "/catalog/shkafy/�������",
	"/catalog/podogrevateli/���������" => "/catalog/podogrevateli/",
	"/catalog/konverty-na-vypisku/��������" => "/catalog/konverty-na-vypisku/",
	"/catalog/radio-i-videonyani/���������" => "/catalog/radio-i-videonyani/",
	"/catalog/manezhi/������" => "/catalog/manezhi/",
	"/catalog/ryukzaki_-kenguru_-slingi/�����" => "/catalog/ryukzaki_-kenguru_-slingi/",
	"/catalog/kolyaski/tip-progulochnaya/�������" => "/catalog/kolyaski/tip-progulochnaya/",
	"/catalog/krovatki/������" => "/catalog/krovatki/",
	"/catalog/komplekty-v-krovatku/komplekt-v-krovatku-makkaroni-kids-charm-7-predmetov" => "/catalog/komplekty-v-krovatku/",
	"/catalog/shkafy/����" => "/catalog/shkafy/����",
	"/catalog/krovatki/tip-transformeri/��������" => "/catalog/krovatki/tip-transformeri/",
	"/catalog/kolyaski/�������" => "/catalog/kolyaski/",
	"/catalog/kolyaski/�������" => "/catalog/kolyaski/",
	"/catalog/igrushki/igrushka-fisher-price-b4253-zhiraf-s-kubikami" => "/catalog/igrushki/",
	"/catalog/igrovaya-mebel-dlya-ulitsy/stol_pesochnitsa-marian-plast-art_-375" => "/catalog/igrovaya-mebel-dlya-ulitsy/",
	"/catalog/shkafy/�������" => "/catalog/shkafy/",
	"/catalog/radio-i-videonyani/�����" => "/catalog/radio-i-videonyani/",
	"/catalog/stulchiki-dlya-kormleniya/�����" => "/catalog/stulchiki-dlya-kormleniya/",
	"/catalog/stulchiki-dlya-kormleniya/�������" => "/catalog/stulchiki-dlya-kormleniya/",
	"/catalog/podogrevateli/������" => "/catalog/podogrevateli/",
	"/catalog/manezhi/�������" => "/catalog/manezhi/",
	"/catalog/bampery-v-krovatku-_bortiki/bortik-v-krovatku-sonnyy-gnomik-afrika" => "/catalog/bampery-v-krovatku-_bortiki/",
	"/catalog/stulchiki-dlya-kormleniya/������" => "/catalog/stulchiki-dlya-kormleniya/",
	"/catalog/kolyaski/tip-transformer/�������" => "/catalog/kolyaski/tip-transformer/",
	"/catalog/kolyaski/tip-lyulka/�������" => "/catalog/kolyaski/tip-lyulka/",
	"/catalog/konverty-na-vypisku/������" => "/catalog/konverty-na-vypisku/",
	"/catalog/shezlongi-kacheli/������" => "/catalog/shezlongi-kacheli/",
	"/catalog/konverty-na-vypisku/�������" => "/catalog/konverty-na-vypisku/",
	"/catalog/shezlongi-kacheli/�����������" => "/catalog/shezlongi-kacheli/",
	"/catalog/stulchiki-dlya-kormleniya/�������" => "/catalog/stulchiki-dlya-kormleniya/",
	"/catalog/kolyaski/tip-dlya-dvoyni/�������" => "/catalog/kolyaski/tip-dlya-dvoyni/",
	"/catalog/kolyaski/tip-3_kh-kolesnye/�������" => "/catalog/kolyaski/tip-3_kh-kolesnye/",
	"/catalog/kolyaski/tip-3_kh-kolesnye/������������" => "/catalog/kolyaski/tip-3_kh-kolesnye/",
	"/catalog/krovatki/���" => "/catalog/krovatki/",
	"/catalog/komody/������" => "/catalog/komody/",
	"/catalog/kolyaski/tip-3_kh-kolesnye/������������" => "/catalog/kolyaski/tip-3_kh-kolesnye/",
	"/catalog/krovatki/�����" => "/catalog/krovatki/",
	"/catalog/ryukzaki_-kenguru_-slingi/�������������" => "/catalog/ryukzaki_-kenguru_-slingi/",
	"/catalog/kolyaski/kolyaska-3-v-1-concord-trevel-set-neo-quantum-2011" => "/catalog/kolyaski/",
	"/catalog/krovatki/�����" => "/catalog/krovatki/",
	"/catalog/komody/13������" => "/catalog/komody/",
	"/catalog/kolyaski/������" => "/catalog/kolyaski/",
	"/catalog/kolyaski/tip-3-v-1/�������" => "/catalog/kolyaski/tip-3-v-1/",
	"/catalog/manezhi/������" => "/catalog/manezhi/",
	"/catalog/kolyaski/tip-dlya-dvoyni/�������" => "/catalog/kolyaski/tip-dlya-dvoyni/�������",
	"/catalog/pelenalnye-stoliki/������" => "/catalog/pelenalnye-stoliki/",
	"/catalog/shkafy/�����" => "/catalog/shkafy/",
	"/catalog/krovatki/�������" => "/catalog/krovatki/",
	"/catalog/komplekty-v-krovatku/postelnoe-bele-bombus-katyusha-3-predmeta" => "/catalog/komplekty-v-krovatku/",
	"/catalog/komody/������" => "/catalog/komody/������",
	"/catalog/shkafy/�������" => "/catalog/shkafy/�������",
	"/catalog/kolyaski/tip-progulochnaya/����������" => "/catalog/kolyaski/tip-progulochnaya/",
	"/catalog/krovatki/tip-transformeri/�������" => "/catalog/krovatki/tip-transformeri/",
	"/catalog/krovatki/������" => "/catalog/krovatki/",
	"/catalog/kolyaski/tip-progulochnaya/������" => "/catalog/kolyaski/tip-progulochnaya/",
	"/catalog/krovatki/���" => "/catalog/krovatki/",
	"/catalog/kolyaski/������" => "/catalog/kolyaski/",
	"/catalog/kolyaski/tip-progulochnaya/������" => "/catalog/kolyaski/tip-progulochnaya/",
	"/catalog/stulchiki-dlya-kormleniya/�������" => "/catalog/stulchiki-dlya-kormleniya/",
	"/catalog/kolyaski/tip-progulochnaya/�������" => "/catalog/kolyaski/tip-progulochnaya/",
	"/catalog/stulchiki-dlya-kormleniya/����������" => "/catalog/stulchiki-dlya-kormleniya/",
	"/catalog/katalki_-kachalki/kachalka-_quot_loshadka_quot_-marian-plast-337" => "/catalog/katalki_-kachalki/",
	"/catalog/kolyaski/�����" => "/catalog/kolyaski/�����",
	"/catalog/radio-i-videonyani/�����" => "/catalog/radio-i-videonyani/",
	"/catalog/pelenalnye-stoliki/������" => "/catalog/pelenalnye-stoliki/",
	"/catalog/kolyaski/tip-lyulka/������" => "/catalog/kolyaski/tip-lyulka/",
	"/catalog/pelenalnye-stoliki/�������" => "/catalog/pelenalnye-stoliki/",
	"/catalog/stulchiki-dlya-kormleniya/���������" => "/catalog/stulchiki-dlya-kormleniya/",
	"/catalog/stulchiki-dlya-kormleniya/����������" => "/catalog/stulchiki-dlya-kormleniya/",
	"/catalog/kolyaski/tip-progulochnaya/�������������" => "/catalog/kolyaski/tip-progulochnaya/",
	"/catalog/komody/�������" => "/catalog/komody/",
	"/catalog/radio-i-videonyani/���" => "/catalog/radio-i-videonyani/",
	"/catalog/kolyaski/tip-progulochnaya/�����" => "/catalog/kolyaski/tip-progulochnaya/",
	"/catalog/manezhi/�������" => "/catalog/manezhi/",
	"/catalog/kolyaski/��������" => "/catalog/kolyaski/",
	"/catalog/kolyaski/��������" => "/catalog/kolyaski/",
	"/catalog/sterilizatory/������" => "/catalog/sterilizatory/",
	"/catalog/krovatki/���������" => "/catalog/krovatki/",
	"/catalog/radio-i-videonyani/�������" => "/catalog/radio-i-videonyani/",
	"/catalog/podogrevateli/����������" => "/catalog/podogrevateli/",
	"/catalog/kolyaski/tip-transformer/�����" => "/catalog/kolyaski/tip-transformer/",
	"/catalog/kolyaski/tip-progulochnaya/�������" => "/catalog/kolyaski/tip-progulochnaya/",
	"/catalog/shezlongi-kacheli/�������������" => "/catalog/shezlongi-kacheli/",
	"/catalog/manezhi/����������" => "/catalog/manezhi/",
	"/catalog/igrushki/razvivayushchiy-kovrik-fisher-price-n8850-zhivaya-planeta" => "/catalog/igrushki/",
	"/catalog/shkafy/������" => "/catalog/shkafy/",
	"/catalog/krovatki/6�������" => "/catalog/krovatki/",
	"/catalog/kolyaski/tip-progulochnaya/�����" => "/catalog/kolyaski/tip-progulochnaya/",
	"/catalog/kolyaski/tip-progulochnaya/�������" => "/catalog/kolyaski/tip-progulochnaya/",
	"/catalog/kolyaski/tip-3_kh-kolesnye/�������" => "/catalog/kolyaski/tip-3_kh-kolesnye/",
	"/catalog/kolyaski/tip-progulochnaya/������������" => "/catalog/kolyaski/tip-progulochnaya/",
	"/catalog/igrushki/kubiki-c-syurprizami-fisher-price-v6940-veseloe-pianino" => "/catalog/igrushki/",
	"/catalog/sterilizatory/���" => "/catalog/sterilizatory/",
	"/catalog/shkafy/�������" => "/catalog/shkafy/",
	"/catalog/podogrevateli/�������" => "/catalog/podogrevateli/",
	"/catalog/kolyaski/tip-dlya-dvoyni/���" => "/catalog/kolyaski/tip-dlya-dvoyni/",
	"/catalog/pelenalnye-stoliki/�������" => "/catalog/pelenalnye-stoliki/",
	"/catalog/podogrevateli/�����������" => "/catalog/podogrevateli/",
	"/catalog/kolyaski/tip-progulochnaya/�����" => "/catalog/kolyaski/tip-progulochnaya/",
	"/catalog/stulchiki-dlya-kormleniya/�������" => "/catalog/stulchiki-dlya-kormleniya/",
	"/catalog/kolyaski/tip-transformer/��������" => "/catalog/kolyaski/tip-transformer/",
	"/catalog/ryukzaki_-kenguru_-slingi/������������" => "/catalog/ryukzaki_-kenguru_-slingi/",
	"/catalog/shezlongi-kacheli/������" => "/catalog/shezlongi-kacheli/",
	"/catalog/kolyaski/tip-3-v-1/4�������" => "/catalog/kolyaski/tip-3-v-1/",
	"/catalog/kolyaski/tip-progulochnaya/��������" => "/catalog/kolyaski/tip-progulochnaya/",
	"/catalog/avtokresla/tip-isofix/42����������" => "/catalog/avtokresla/tip-isofix/",
	"/catalog/sterilizatory/����������������" => "/catalog/sterilizatory/",
	"/catalog/posuda/�������" => "/catalog/posuda/",
	"/catalog/komody/19�������" => "/catalog/komody/",
	"/catalog/kormlenie-grudyu/�������" => "/catalog/kormlenie-grudyu/",
	"/catalog/podogrevateli/28��������" => "/catalog/podogrevateli/",
	"/catalog/kolyaski/tip-2-v-1/�������" => "/catalog/kolyaski/tip-2-v-1/",
	"/catalog/kolyaski/tip-progulochnaya/�������" => "/catalog/kolyaski/tip-progulochnaya/",
	"/catalog/avtokresla/tip-isofix/����������" => "/catalog/avtokresla/tip-isofix/",
	"/catalog/baldakhiny-i-derzhateli/baldakhin-feretti-princess" => "/catalog/baldakhiny-i-derzhateli/",
	"/catalog/stulchiki-dlya-kormleniya/������������" => "/catalog/stulchiki-dlya-kormleniya/",
	"/catalog/komody/���" => "/catalog/komody/",
	"/catalog/krovatki/�����" => "/catalog/krovatki/",
	"/catalog/pelenalnye-stoliki/����" => "/catalog/pelenalnye-stoliki/",
	"/catalog/krovatki/���������" => "/catalog/krovatki/",
	"/catalog/manezhi/����������" => "/catalog/manezhi/",
	"/catalog/kolyaski/tip-lyulka/�����" => "/catalog/kolyaski/tip-lyulka/",
	"/catalog/krovatki/�����������" => "/catalog/krovatki/",
	"/catalog/kolyaski/������������" => "/catalog/kolyaski/",
	"/catalog/kolyaski/tip-transformer/�����" => "/catalog/kolyaski/tip-transformer/",
	"/catalog/ryukzaki_-kenguru_-slingi/�������" => "/catalog/ryukzaki_-kenguru_-slingi/",
	"/catalog/stulchiki-dlya-kormleniya/�������" => "/catalog/stulchiki-dlya-kormleniya/",
	"/catalog/radio-i-videonyani/�����" => "/catalog/radio-i-videonyani/",
	"/catalog/kolyaski/tip-progulochnaya/��������" => "/catalog/kolyaski/tip-progulochnaya/",
	"/catalog/komplekty-v-krovatku/postelnoe-bele-bombus-zayka-lnyanoy-3-predmeta" => "/catalog/komplekty-v-krovatku/",
	"/about-baby-list.php." => "/about-baby-list.php",
	"/catalog/kolyaski/�����" => "/catalog/kolyaski/",
	"/catalog/sterilizatory/�����" => "/catalog/sterilizatory/",
	"/catalog/ryukzaki_-kenguru_-slingi/�������" => "/catalog/ryukzaki_-kenguru_-slingi/",
	"/catalog/pelenalnye-stoliki/�����������" => "/catalog/pelenalnye-stoliki/",
	"/catalog/kolyaski/tip-progulochnaya/�������" => "/catalog/kolyaski/tip-progulochnaya/",
	"/catalog/krovatki/������" => "/catalog/krovatki/",
	"/catalog/krovatki/������" => "/catalog/krovatki/",
	"/catalog/manezhi/�������" => "/catalog/manezhi/",
	"/catalog/kolyaski/�������" => "/catalog/kolyaski/",
	"/catalog/sterilizatory/�����" => "/catalog/sterilizatory/",
	"/catalog/krovatki/��������" => "/catalog/krovatki/",
	"/catalog/krovatki/����������" => "/catalog/krovatki/",
	"/catalog/kormlenie-grudyu/������" => "/catalog/kormlenie-grudyu/",
	"/catalog/radio-i-videonyani/�����" => "/catalog/radio-i-videonyani/",
	"/catalog/komody/13�����������" => "/catalog/komody/13�����������",
	"/catalog/kormlenie-grudyu/���������" => "/catalog/kormlenie-grudyu/",
	"/catalog/kolyaski/tip-transformer/�������" => "/catalog/kolyaski/tip-transformer/",
	"/catalog/kolyaski/tip-progulochnaya/������" => "/catalog/kolyaski/tip-progulochnaya/",
	"/catalog/kolyaski/tip-3_kh-kolesnye/�������" => "/catalog/kolyaski/tip-3_kh-kolesnye/",
	"/catalog/kolyaski/tip-progulochnaya/�������" => "/catalog/kolyaski/tip-progulochnaya/",
	"/catalog/pelenalnye-stoliki/40�����������" => "/catalog/pelenalnye-stoliki/",
	"/catalog/igrushki/igrushka-fisher-price-c0244-slonenok-s-kubikami" => "/catalog/igrushki/",
	"/catalog/krovatki/�����" => "/catalog/krovatki/",
	"/catalog/krovatki/������" => "/catalog/krovatki/",
	"/catalog/kolyaski/�������" => "/catalog/kolyaski/",
	"/catalog/kolyaski/tip-2-v-1/������" => "/catalog/kolyaski/tip-2-v-1/",
	"/catalog/konverty-na-vypisku/24�������" => "/catalog/konverty-na-vypisku/",
	"/catalog/sterilizatory/�������������" => "/catalog/sterilizatory/",
	"/catalog/kolyaski/�������" => "/catalog/kolyaski/",
	"/catalog/kormlenie-grudyu/�������" => "/catalog/kormlenie-grudyu/",
	"/catalog/kolyaski/tip-2-v-1/��������" => "/catalog/kolyaski/tip-2-v-1/",
	"/catalog/kormlenie-grudyu/����������" => "/catalog/kormlenie-grudyu/",
	"/catalog/kolyaski/tip-progulochnaya/������" => "/catalog/kolyaski/tip-progulochnaya/",
	"/catalog/kolyaski/tip-progulochnaya/�������" => "/catalog/kolyaski/tip-progulochnaya/",
	"/catalog/kolyaski/tip-dlya-dvoyni/��������" => "/catalog/kolyaski/tip-dlya-dvoyni/",
	"/catalog/kolyaski/tip-transformer/�������������" => "/catalog/kolyaski/tip-transformer/",
	"/catalog/krovatki/���" => "/catalog/krovatki/",
	"/catalog/shkafy/������" => "/catalog/shkafy/",
	"/catalog/krovatki/�����" => "/catalog/krovatki/",
	"/catalog/krovatki/�����" => "/catalog/krovatki/",
	"/catalog/kolyaski/�����" => "/catalog/kolyaski/",
	"/catalog/manezhi/������" => "/catalog/manezhi/",
	"/catalog/kolyaski/������" => "/catalog/kolyaski/",
	"/catalog/krovatki/�������" => "/catalog/krovatki/",
	"/catalog/krovatki/�������" => "/catalog/krovatki/",
	"/catalog/krovatki/30��������" => "/catalog/krovatki/",
	"/catalog/podogrevateli/�������" => "/catalog/podogrevateli/",
	"/catalog/kormlenie-grudyu/������" => "/catalog/kormlenie-grudyu/",
	"/catalog/kolyaski/tip-lyulka/�����" => "/catalog/kolyaski/tip-lyulka/",
	"/catalog/konverty-na-vypisku/�����" => "/catalog/konverty-na-vypisku/",
	"/catalog/shezlongi-kacheli/������" => "/catalog/shezlongi-kacheli/",
	"/catalog/komody/17�����������" => "/catalog/komody/",
	"/catalog/radio-i-videonyani/������" => "/catalog/radio-i-videonyani/",
	"/catalog/stulchiki-dlya-kormleniya/���" => "/catalog/stulchiki-dlya-kormleniya/",
	"/catalog/konverty-na-vypisku/������" => "/catalog/konverty-na-vypisku/",
	"/catalog/ryukzaki_-kenguru_-slingi/���" => "/catalog/ryukzaki_-kenguru_-slingi/",
	"/catalog/stulchiki-dlya-kormleniya/�����" => "/catalog/stulchiki-dlya-kormleniya/",
	"/catalog/krovatki/tip-transformeri/������" => "/catalog/krovatki/tip-transformeri/",
	"/catalog/kolyaski/tip-progulochnaya/������" => "/catalog/kolyaski/tip-progulochnaya/",
	"/catalog/pelenalnye-stoliki/����������" => "/catalog/pelenalnye-stoliki/",
	"/catalog/kolyaski/tip-progulochnaya/������" => "/catalog/kolyaski/tip-progulochnaya/",
	"/catalog/kolyaski/tip-2-v-1/����������" => "/catalog/kolyaski/tip-2-v-1/",
	"/catalog/ryukzaki_-kenguru_-slingi/�������" => "/catalog/ryukzaki_-kenguru_-slingi/",
	"/catalog/kormlenie-grudyu/�������������" => "/catalog/kormlenie-grudyu/",
	"/catalog/kolyaski/tip-3-v-1/���������������" => "/catalog/kolyaski/tip-3-v-1/",
	"/catalog/kolyaski/������" => "/catalog/kolyaski/",
	"/catalog/komody/�������" => "/catalog/komody/",
	"/catalog/kolyaski/tip-2-v-1/������" => "/catalog/kolyaski/tip-2-v-1/",
	"/catalog/kolyaski/tip-lyulka/������" => "/catalog/kolyaski/tip-lyulka/",
	"/catalog/kolyaski/tip-transformer/������" => "/catalog/kolyaski/tip-transformer/",
	"/catalog/kolyaski/tip-progulochnaya/������" => "/catalog/kolyaski/tip-progulochnaya/",
	"/catalog/sterilizatory/�������������" => "/catalog/sterilizatory/",
	"/catalog/kolyaski/tip-progulochnaya/����������" => "/catalog/kolyaski/tip-progulochnaya/",
	"/catalog/igrovaya-mebel-dlya-ulitsy/domik-_-kukhnya-marian-plast-663" => "/catalog/igrovaya-mebel-dlya-ulitsy/",
	"/catalog/kolyaski/tip-lyulka/������" => "/catalog/kolyaski/tip-lyulka/",
	"/catalog/aksessuary-dlya-avtokresla/letnie-chekhly-na-avtokresla-kiddy-b_cool" => "/catalog/aksessuary-dlya-avtokresla/",
	"/catalog/kolyaski/�������" => "/catalog/kolyaski/",
	"/catalog/krovatki/30�������" => "/catalog/krovatki/",
	"/catalog/krovatki/28�����������" => "/catalog/krovatki/",
	"/catalog/krovatki/23�����������" => "/catalog/krovatki/",
	"/catalog/kolyaski/tip-dlya-dvoyni/�����" => "/catalog/kolyaski/tip-dlya-dvoyni/",
	"/catalog/kolyaski/tip-progulochnaya/������" => "/catalog/kolyaski/tip-progulochnaya/",
	"/catalog/kolyaski/tip-progulochnaya/���������" => "/catalog/kolyaski/tip-progulochnaya/",
	"/catalog/komody/���" => "/catalog/komody/",
	"/catalog/krovatki/����" => "/catalog/krovatki/",
	"/catalog/krovatki/�������" => "/catalog/krovatki/",
	"/catalog/krovatki/��������" => "/catalog/krovatki/",
	"/catalog/konverty-na-vypisku/���" => "/catalog/konverty-na-vypisku/",
	"/catalog/pelenalnye-stoliki/�����" => "/catalog/pelenalnye-stoliki/",
	"/catalog/kolyaski/tip-2-v-1/�������" => "/catalog/kolyaski/tip-2-v-1/",
	"/catalog/kolyaski/tip-transformer/������" => "/catalog/kolyaski/tip-transformer/",
	"/catalog/kolyaski/tip-3_kh-kolesnye/������" => "/catalog/kolyaski/tip-3_kh-kolesnye/",
	"/catalog/kolyaski/tip-progulochnaya/�������" => "/catalog/kolyaski/tip-progulochnaya/",
	"/catalog/kolyaski/tip-lyulka/�����������" => "/catalog/kolyaski/tip-lyulka/",
	"/catalog/stulchiki-dlya-kormleniya/���������" => "/catalog/stulchiki-dlya-kormleniya/",
	"/catalog/avtokresla/tip-isofix/�������������" => "/catalog/avtokresla/tip-isofix/",
	"/catalog/igrushki/razvivayushchaya-igrushka-fisher-price-t5053-morskie-chudesa" => "/catalog/igrushki/",
	"/catalog/sterilizatory/��" => "/catalog/sterilizatory/",
	"/catalog/komody/22�����" => "/catalog/komody/",
	"/catalog/kolyaski/������" => "/catalog/kolyaski/",
	"/catalog/konverty-na-vypisku/����" => "/catalog/konverty-na-vypisku/",
	"/catalog/komody/27�����������" => "/catalog/komody/",
	"/catalog/podogrevateli/16��������" => "/catalog/podogrevateli/",
	"/catalog/kolyaski/tip-progulochnaya/���" => "/catalog/kolyaski/tip-progulochnaya/",
	"/catalog/krovatki/������������" => "/catalog/krovatki/",
	"/catalog/kolyaski/tip-2-v-1/��������" => "/catalog/kolyaski/tip-2-v-1/",
	"/catalog/kolyaski/tip-transformer/�����" => "/catalog/kolyaski/tip-transformer/",
	"/catalog/kolyaski/tip-progulochnaya/�����" => "/catalog/kolyaski/tip-progulochnaya/",
	"/catalog/ryukzaki_-kenguru_-slingi/������" => "/catalog/ryukzaki_-kenguru_-slingi/",
	"/catalog/kormlenie-grudyu/�����������" => "/catalog/kormlenie-grudyu/",
	"/catalog/kolyaski/tip-transformer/�������" => "/catalog/kolyaski/tip-transformer/",
	"/catalog/komplekty-v-krovatku/komplekt-v-krovatku-bombus-marisha-7-predmetov" => "/catalog/komplekty-v-krovatku/",
	"/catalog/komplekty-v-krovatku/komplekt-postelnogo-belya-bombus-detki-3-predmeta" => "/catalog/komplekty-v-krovatku/",
	"/catalog/komody/���" => "/catalog/komody/",
	"/catalog/komody/7������" => "/catalog/komody/",
	"/catalog/kolyaski/tip-lyulka/��������" => "/catalog/kolyaski/tip-lyulka/",
	"/catalog/kolyaski/tip-transformer/������" => "/catalog/kolyaski/tip-transformer/",
	"/catalog/komplekty-v-krovatku/komplekt-v-krovatku-bombus-bombus-premium-8-predmetov" => "/catalog/komplekty-v-krovatku/",
	"/catalog/manezhi/���" => "/catalog/manezhi/",
	"/catalog/krovatki/����" => "/catalog/krovatki/",
	"/catalog/shkafy/�����" => "/catalog/shkafy/",
	"/catalog/komody/20�����" => "/catalog/komody/",
	"/catalog/kolyaski/������" => "/catalog/kolyaski/",
	"/catalog/krovatki/9�������" => "/catalog/krovatki/",
	"/catalog/krovatki/��������" => "/catalog/krovatki/",
	"/catalog/kolyaski/��������" => "/catalog/kolyaski/",
	"/catalog/krovatki/21�������" => "/catalog/krovatki/",
	"/catalog/krovatki/�����������" => "/catalog/krovatki/",
	"/catalog/avtokresla/tip-isofix/�������" => "/catalog/avtokresla/tip-isofix/",
	"/catalog/kolyaski/tip-3-v-1/���������" => "/catalog/kolyaski/tip-3-v-1/",
	"/catalog/kormlenie-grudyu/43�����������" => "/catalog/kormlenie-grudyu/",
	"/catalog/kolyaski/tip-dlya-dvoyni/����������" => "/catalog/kolyaski/tip-dlya-dvoyni/",
	"/catalog/kolyaski/tip-dlya-dvoyni/������������" => "/catalog/kolyaski/tip-dlya-dvoyni/",
	"/catalog/igrovaya-mebel-dlya-ulitsy/gorka-_-bashnya-marian-plast-377" => "/catalog/igrovaya-mebel-dlya-ulitsy/",
	"/catalog/igrovaya-mebel-dlya-doma/stol-igrovoy-so-stulyami-i-aplikatsiey-disney-tt87382ps-printsessa" => "/catalog/igrovaya-mebel-dlya-doma/",
	"/catalog/komody/7�����" => "/catalog/komody/",
	"/catalog/krovatki/������" => "/catalog/krovatki/",
	"/catalog/komody/25������" => "/catalog/komody/",
	"/catalog/kolyaski/�������" => "/catalog/kolyaski/",
	"/catalog/krovatki/����������" => "/catalog/krovatki/",
	"/catalog/kolyaski/tip-dlya-dvoyni/���" => "/catalog/kolyaski/tip-dlya-dvoyni/",
	"/catalog/komody/14�����������" => "/catalog/komody/",
	"/catalog/kolyaski/tip-dlya-dvoyni/������" => "/catalog/kolyaski/tip-dlya-dvoyni/",
	"/catalog/kolyaski/tip-dlya-dvoyni/������" => "/catalog/kolyaski/tip-dlya-dvoyni/",
	"/catalog/stulchiki-dlya-kormleniya/������" => "/catalog/stulchiki-dlya-kormleniya/",
	"/catalog/kolyaski/tip-3_kh-kolesnye/������" => "/catalog/kolyaski/tip-3_kh-kolesnye/",
	"/catalog/podogrevateli/�������������" => "/catalog/podogrevateli/",
	"/catalog/avtokresla/tip-isofix/���������" => "/catalog/avtokresla/tip-isofix/",
	"/catalog/kolyaski/tip-2-v-1/�����������" => "/catalog/kolyaski/tip-2-v-1/",
	"/catalog/kolyaski/tip-progulochnaya/�������" => "/catalog/kolyaski/tip-progulochnaya/",
	"/catalog/avtokresla/tip-isofix/40���������" => "/catalog/avtokresla/tip-isofix/",
	"/catalog/kolyaski/tip-dlya-dvoyni/�����������" => "/catalog/kolyaski/tip-dlya-dvoyni/",
	"/catalog/kolyaski/tip-progulochnaya/�����������" => "/catalog/kolyaski/tip-progulochnaya/",
	"/catalog/kormlenie-grudyu/30����������������" => "/catalog/kormlenie-grudyu/",
	"/catalog/aksessuary-dlya-avtokresla/chekhol-dlya-maxi_cosi-rodi-xp" => "/catalog/aksessuary-dlya-avtokresla/",
	"/catalog/igrovaya-mebel-dlya-ulitsy/gorka-_-pelikan-marian-plast-607" => "/catalog/igrovaya-mebel-dlya-ulitsy/",
	"/catalog/manezhi/��������" => "/catalog/manezhi/",
	"/catalog/podogrevateli/��������" => "/catalog/podogrevateli/",
	"/catalog/komody/�����" => "/catalog/komody/",
	"/catalog/manezhi/�����" => "/catalog/manezhi/",
	"/catalog/kolyaski/������" => "/catalog/kolyaski/",
	"/catalog/krovatki/������" => "/catalog/krovatki/",
	"/catalog/kolyaski/�������" => "/catalog/kolyaski/",
	"/catalog/manezhi/��������" => "/catalog/manezhi/",
	"/catalog/krovatki/��������" => "/catalog/krovatki/",
	"/catalog/krovatki/��������" => "/catalog/krovatki/",
	"/catalog/krovatki/19�������" => "/catalog/krovatki/",
	"/catalog/krovatki/���������" => "/catalog/krovatki/",
	"/catalog/sterilizatory/�������" => "/catalog/sterilizatory/",
	"/catalog/konverty-na-vypisku/�����" => "/catalog/konverty-na-vypisku/",
	"/catalog/kolyaski/tip-lyulka/�����" => "/catalog/kolyaski/tip-lyulka/",
	"/catalog/pelenalnye-stoliki/38������" => "/catalog/pelenalnye-stoliki/",
	"/catalog/kolyaski/������������" => "/catalog/kolyaski/",
	"/catalog/konverty-na-vypisku/�������" => "/catalog/konverty-na-vypisku/",
	"/catalog/kolyaski/tip-dlya-dvoyni/�����" => "/catalog/kolyaski/tip-dlya-dvoyni/",
	"/catalog/kolyaski/tip-transformer/�����" => "/catalog/kolyaski/tip-transformer/",
	"/catalog/avtokresla/tip-isofix/�������" => "/catalog/avtokresla/tip-isofix/",
	"/catalog/avtokresla/tip-isofix/�������" => "/catalog/avtokresla/tip-isofix/",
	"/catalog/konverty-na-vypisku/��������" => "/catalog/konverty-na-vypisku/",
	"/catalog/kolyaski/tip-dlya-dvoyni/������" => "/catalog/kolyaski/tip-dlya-dvoyni/",
	"/catalog/kolyaski/tip-dlya-dvoyni/������" => "/catalog/kolyaski/tip-dlya-dvoyni/",
	"/catalog/ryukzaki_-kenguru_-slingi/������" => "/catalog/ryukzaki_-kenguru_-slingi/",
	"/catalog/radio-i-videonyani/����������" => "/catalog/radio-i-videonyani/",
	"/catalog/kolyaski/tip-dlya-dvoyni/�������" => "/catalog/kolyaski/tip-dlya-dvoyni/",
	"/catalog/kolyaski/tip-transformer/�������" => "/catalog/kolyaski/tip-transformer/",
	"/catalog/ryukzaki_-kenguru_-slingi/�������" => "/catalog/ryukzaki_-kenguru_-slingi/",
	"/catalog/sterilizatory/�������������" => "/catalog/sterilizatory/",
	"/catalog/kormlenie-grudyu/������������" => "/catalog/kormlenie-grudyu/",
	"/catalog/avtokresla/tip-isofix/����������" => "/catalog/avtokresla/tip-isofix/",
	"/catalog/igrushki/khodunki-fisher-price-c5843-begemot-s-kubikami" => "/catalog/igrushki/",
	"/catalog/igrovaya-mebel-dlya-doma/podushka-disney-13289-mikki-na-nebe" => "/catalog/igrovaya-mebel-dlya-doma/",
	"/catalog/krovatki/�������" => "/catalog/krovatki/",
	"/catalog/radio-i-videonyani/������" => "/catalog/radio-i-videonyani/",
	"/catalog/kolyaski/tip-dlya-dvoyni/����" => "/catalog/kolyaski/tip-dlya-dvoyni/",
	"/catalog/pelenalnye-stoliki/37������" => "/catalog/pelenalnye-stoliki/",
	"/catalog/konverty-na-vypisku/��������" => "/catalog/konverty-na-vypisku/",
	"/catalog/konverty-na-vypisku/���������" => "/catalog/konverty-na-vypisku/",
	"/catalog/kolyaski/tip-progulochnaya/�������" => "/catalog/kolyaski/tip-progulochnaya/",
	"/catalog/kolyaski/tip-transformer/������������" => "/catalog/kolyaski/tip-transformer/",
	"/catalog/kolyaski/tip-2-v-1/���������������" => "/catalog/kolyaski/tip-2-v-1/",
	"/catalog/kolyaski/tip-progulochnaya/�����������" => "/catalog/kolyaski/tip-progulochnaya/",
	"/catalog/kolyaski/tip-3_kh-kolesnye/���������������" => "/catalog/kolyaski/tip-3_kh-kolesnye/",
	"/catalog/komplekty-v-krovatku/komplekt-v-krovatku-bombus-kiryusha-7-predmetov" => "/catalog/komplekty-v-krovatku/",
	"/catalog/kolyaski/tip-progulochnaya/�����" => "/catalog/kolyaski/tip-progulochnaya/",
	"/catalog/kolyaski/tip-3_kh-kolesnye/�������" => "/catalog/kolyaski/tip-3_kh-kolesnye/",
	"/catalog/igrushki/razvivayushchaya-igrushka-fisher-price-v6997-noutbuk" => "/catalog/igrushki/",
	"/catalog/kolyaski/�����������" => "/catalog/kolyaski/",
	"/catalog/krovatki/24�����" => "/catalog/krovatki/",
	"/catalog/krovatki/��������" => "/catalog/krovatki/",
	"/catalog/krovatki/tip-transformeri/���" => "/catalog/krovatki/tip-transformeri/",
	"/catalog/pelenalnye-stoliki/38�������" => "/catalog/pelenalnye-stoliki/",
	"/catalog/kolyaski/tip-transformer/��������" => "/catalog/kolyaski/tip-transformer/",
	"/catalog/kolyaski/tip-lyulka/�����������" => "/catalog/kolyaski/tip-lyulka/",
	"/catalog/komody/14���" => "/catalog/komody/",
	"/catalog/kolyaski/�����" => "/catalog/kolyaski/",
	"/catalog/krovatki/�������" => "/catalog/krovatki/",
	"/catalog/kolyaski/�������" => "/catalog/kolyaski/",
	"/catalog/krovatki/�������" => "/catalog/krovatki/",
	"/catalog/radio-i-videonyani/���" => "/catalog/radio-i-videonyani/",
	"/catalog/krovatki/26��������" => "/catalog/krovatki/",
	"/catalog/podogrevateli/��������" => "/catalog/podogrevateli/",
	"/catalog/konverty-na-vypisku/������" => "/catalog/konverty-na-vypisku/",
	"/catalog/konverty-na-vypisku/������" => "/catalog/konverty-na-vypisku/",
	"/catalog/kolyaski/tip-lyulka/������" => "/catalog/kolyaski/tip-lyulka/",
	"/catalog/podogrevateli/19��������" => "/catalog/podogrevateli/",
	"/catalog/konverty-na-vypisku/������" => "/catalog/konverty-na-vypisku/",
	"/catalog/kolyaski/tip-3-v-1/�������" => "/catalog/kolyaski/tip-3-v-1/",
	"/catalog/kolyaski/tip-progulochnaya/���" => "/catalog/kolyaski/tip-progulochnaya/",
	"/catalog/kolyaski/tip-2-v-1/�������" => "/catalog/kolyaski/tip-2-v-1/",
	"/catalog/kormlenie-grudyu/���������" => "/catalog/kormlenie-grudyu/",
	"/catalog/kolyaski/tip-progulochnaya/�����" => "/catalog/kolyaski/tip-progulochnaya/",
	"/catalog/radio-i-videonyani/����������" => "/catalog/radio-i-videonyani/",
	"/catalog/kolyaski/tip-dlya-dvoyni/�������" => "/catalog/kolyaski/tip-dlya-dvoyni/",
	"/catalog/kolyaski/tip-transformer/���������" => "/catalog/kolyaski/tip-transformer/",
	"/catalog/aksessuary/pelenalnyy-matrasik-bombus-sloniki" => "/catalog/aksessuary/",
	"/catalog/kolyaski/tip-progulochnaya/�����������" => "/catalog/kolyaski/tip-progulochnaya/",
	"/catalog/baldakhiny-i-derzhateli/baldakhin-feretti-tropical-island" => "/catalog/baldakhiny-i-derzhateli/",
	"/catalog/krovatki/detskaya-krovatka-gandylyan_anzhelika-poperechnyy-mayatnik" => "/catalog/krovatki/",
	"/catalog/krovatki/��������" => "/catalog/krovatki/",
	"/catalog/avtokresla/tip-isofix/������" => "/catalog/avtokresla/tip-isofix/",
	"/catalog/igrovaya-mebel-dlya-doma/podushka-s-igrushkoy-disney-11927-oslik-ia" => "/catalog/igrovaya-mebel-dlya-doma/",
	"/catalog/igrovaya-mebel-dlya-ulitsy/domik-_-garazh-_-kukhnya-marian-plast-665" => "/catalog/igrovaya-mebel-dlya-ulitsy/",
	"/catalog/komplekty-v-krovatku/komplekt-v-krovatku-bombus-tsarevna-lebed-8-predmetov" => "/catalog/komplekty-v-krovatku/",
	"/catalog/kolyaski/���" => "/catalog/kolyaski/",
	"/catalog/kolyaski/�����" => "/catalog/kolyaski/",
	"/catalog/kormlenie-grudyu/�����" => "/catalog/kormlenie-grudyu/",
	"/catalog/kolyaski/tip-lyulka/�����" => "/catalog/kolyaski/tip-lyulka/",
	"/catalog/kolyaski/tip-transformer/�������" => "/catalog/kolyaski/tip-transformer/",
	"/catalog/igrushki/obuchayushchaya-knizhka-fisher-price-v5080-druzya-na-ferme" => "/catalog/igrushki/",
	"/catalog/manezhi/�����" => "/catalog/manezhi/",
	"/catalog/krovatki/������" => "/catalog/krovatki/",
	"/catalog/manezhi/�������" => "/catalog/manezhi/",
	"/catalog/kormlenie-grudyu/���" => "/catalog/kormlenie-grudyu/",
	"/catalog/krovatki/14�������" => "/catalog/krovatki/",
	"/catalog/pelenalnye-stoliki/26���" => "/catalog/pelenalnye-stoliki/",
	"/catalog/komody/20�����������" => "/catalog/komody/",
	"/catalog/krovatki/������������" => "/catalog/krovatki/",
	"/catalog/konverty-na-vypisku/�������" => "/catalog/konverty-na-vypisku/",
	"/catalog/pelenalnye-stoliki/��������" => "/catalog/pelenalnye-stoliki/",
	"/catalog/kolyaski/tip-dlya-dvoyni/�����" => "/catalog/kolyaski/tip-dlya-dvoyni/",
	"/catalog/kolyaski/tip-3-v-1/���������" => "/catalog/kolyaski/tip-3-v-1/",
	"/catalog/pelenalnye-stoliki/����������" => "/catalog/pelenalnye-stoliki/",
	"/catalog/stulchiki-dlya-kormleniya/�������" => "/catalog/stulchiki-dlya-kormleniya/",
	"/catalog/kolyaski/tip-transformer/��������" => "/catalog/kolyaski/tip-transformer/",
	"/catalog/avtokresla/tip-isofix/����������" => "/catalog/avtokresla/tip-isofix/",
	"/catalog/baldakhiny-i-derzhateli/baldakhin-feretti-bella" => "/catalog/baldakhiny-i-derzhateli/",
	"/catalog/baldakhiny-i-derzhateli/baldakhin-feretti-safari" => "/catalog/baldakhiny-i-derzhateli/",
	"/catalog/komplekty-v-krovatku/postelnoe-bele-bombus-mishki-v-gamake-3-predmeta" => "/catalog/komplekty-v-krovatku/",
	"/catalog/igrushki/razvivayushchaya-igrushka-fisher-price-p5965-obuchayushchie-klyuchiki" => "/catalog/igrushki/",
	"/catalog/manezhi/�������" => "/catalog/manezhi/",
	"/catalog/kolyaski/tip-dlya-dvoyni/������" => "/catalog/kolyaski/tip-dlya-dvoyni/",
	"/catalog/podogrevateli/podogrevatel-dlya-butylochek-chicco-71553-strong" => "/catalog/podogrevateli/",
	"/catalog/igrushki/igrushka-fisher-price-g3743-displey-yarkie-vyrazheniya" => "/catalog/igrushki/",
	"/catalog/komody/�����" => "/catalog/komody/",
	"/catalog/kolyaski/�������" => "/catalog/kolyaski/",
	"/catalog/kolyaski/tip-3-v-1/������" => "/catalog/kolyaski/tip-3-v-1/",
	"/catalog/krovatki/�������������" => "/catalog/krovatki/",
	"/catalog/kolyaski/tip-dlya-dvoyni/�������" => "/catalog/kolyaski/tip-dlya-dvoyni/",
	"/catalog/kolyaski/tip-progulochnaya/�����������" => "/catalog/kolyaski/tip-progulochnaya/",
	"/catalog/kolyaski/������" => "/catalog/kolyaski/",
	"/catalog/kolyaski/tip-2-v-1/�������" => "/catalog/kolyaski/tip-2-v-1/",
	"/catalog/igrushki/razvivayushchaya-igrushka-fisher-price-n1880-pelikan" => "/catalog/igrushki/",
	"/catalog/podogrevateli/podogrevatel-dlya-butylochek-chicco-60080-step-up" => "/catalog/podogrevateli/",
	"/catalog/komplekty-v-krovatku/komplekt-v-krovatku-bombus-mishki-v-gamake-7-predmetov" => "/catalog/komplekty-v-krovatku/",
	"/catalog/aksessuary-dlya-kolyasok/chekhol-ot-dozhdya-bebe-confort-dlya-lyulki-streety-prozrachnyy" => "/catalog/aksessuary-dlya-kolyasok/",
	"/catalog/avtokresla/tip-isofix/bebe" => "/catalog/avtokresla/tip-isofix/",
	"/catalog/kormlenie-grudyu/���������" => "/catalog/kormlenie-grudyu/",
	"/catalog/ryukzaki_-kenguru_-slingi/�����" => "/catalog/ryukzaki_-kenguru_-slingi/",
	"/catalog/igrushki/igrushka-fisher-price-m4046-veselyy-pingvin" => "/catalog/igrushki/",
	"/catalog/konverty-na-vypisku/konvert-na-vypisku-s-bantom-picci-etoile" => "/catalog/konverty-na-vypisku/",
	"/catalog/igrovaya-mebel-dlya-ulitsy/dom-igrovoy-marian-plast-kotedzh-560" => "/catalog/igrovaya-mebel-dlya-ulitsy/",
	"/catalog/verkhnyaya-odezhda/kombinezon_transformer-little-people-zimushka" => "/catalog/verkhnyaya-odezhda/",
	"/catalog/komplekty-v-krovatku/komplekt-v-krovatku-bombus-sashenka-7-predmetov" => "/catalog/komplekty-v-krovatku/",
	"/catalog/bampery-v-krovatku-_bortiki/bortik-v-krovatku-sonnyy-gnomik-mishkin-son" => "/catalog/bampery-v-krovatku-_bortiki/",
	"/catalog/aksessuary-dlya-kolyasok/chekhol-ot-dozhdya-bebe-confort-windoo-prozrachnyy" => "/catalog/aksessuary-dlya-kolyasok/",
	"/catalog/igrovaya-mebel-dlya-ulitsy/pesochnitsa-_quot_kvadratnaya_quot_-marian-plast-374" => "/catalog/igrovaya-mebel-dlya-ulitsy/",
	"/catalog/kolyaski/kolyaska-progulochnaya-jane-slalom-pro-reverse" => "/catalog/kolyaski/kolyaska-progulochnaya-jane-slalom-reverse/",
	"/catalog/324/27982" => "/catalog/krovatki/"
);

$skRedirect = new skRedirect();
$skRedirect -> addRedirect($arRedirect);

echo 'import completed';