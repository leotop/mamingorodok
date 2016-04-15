<div class="banners">
			<div class="banner_left">
				<?$APPLICATION->IncludeComponent("bitrix:advertising.banner", "template1", array(
	"TYPE" => "FOOTER_LEFT",
	"NOINDEX" => "Y",
	"CACHE_TYPE" => "A",
	"CACHE_TIME" => "0"
	),
	false
);?>
			</div>
			<div class="banner_right">
				<?$APPLICATION->IncludeComponent("bitrix:advertising.banner", "template2", Array(
	"TYPE" => "FOOTER_RIGHT",	// Тип баннера
	"NOINDEX" => "Y",	// Добавлять в ссылки noindex/nofollow
	"CACHE_TYPE" => "A",	// Тип кеширования
	"CACHE_TIME" => "0",	// Время кеширования (сек.)
	),
	false
);?>
			</div>
		</div>
		<div class="clear"></div>
		<?=showNoindex()?>
		<div class="bottom_menu">
			<div>
			<?$APPLICATION->IncludeComponent(
	"bitrix:main.include",
	"",
	Array(
		"AREA_FILE_SHOW" => "file",
		"PATH" => "/includes/fcol1.php",
		"EDIT_TEMPLATE" => ""
	),
false
);?>
			</div>
			<div>
			<?$APPLICATION->IncludeComponent(
	"bitrix:main.include",
	"",
	Array(
		"AREA_FILE_SHOW" => "file",
		"PATH" => "/includes/fcol2.php",
		"EDIT_TEMPLATE" => ""
	),
false
);?>
			</div>
			<div>
			<?$APPLICATION->IncludeComponent(
	"bitrix:main.include",
	"",
	Array(
		"AREA_FILE_SHOW" => "file",
		"PATH" => "/includes/fcol3.php",
		"EDIT_TEMPLATE" => ""
	),
false
);?>
			</div>
			<div>
			<?$APPLICATION->IncludeComponent(
	"bitrix:main.include",
	"",
	Array(
		"AREA_FILE_SHOW" => "file",
		"PATH" => "/includes/fcol4.php",
		"EDIT_TEMPLATE" => ""
	),
false
);?>
			</div>
		</div>
		<?=showNoindex(false)?>
		<div class="clear"></div>