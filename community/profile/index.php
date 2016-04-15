<?define("NEED_AUTH", true);?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");?>
<?$APPLICATION->SetTitle("Профиль");?>
<?
global $USER;
$user_id = $USER->GetID();
if (CModule::IncludeModule("blog")):
	$arBlog = CBlog::GetByOwnerID($user_id);
	//print_R($arBlog);
	if(is_array($arBlog)) 
		
		$user_blog = $arBlog["URL"];
endif;
?> 
<div class="wish-list-light"> 
  <table width="100%"> 
    <tbody> 
      <tr><td width="50%"> 
          <h2 class="grey">Персональная информация</h2>
         
          <div class="items-group"> 
            <div class="item-group"> <a class="otzlnk" href="/personal/profile/" >Изменить личные данные</a> <a class="otzlnk" href="/community/user/<?=$user_id?>/?showMe=Y" >Посмотреть личные данные</a> <a class="otzlnk" href="/personal/profile/change-password/" >Изменить пароль</a> <a class="otzlnk" href="/personal/profile/forgot-password/" >Восстановить пароль</a> </div>
           </div>
         
          <h2 class="grey">Друзья</h2>
         
          <div class="items-group"> 
            <div class="item-group"> <a class="otzlnk" href="/community/user/<?=$user_id?>/friends/" >Посмотреть список друзей</a> <a class="otzlnk" href="/community/user/<?=$user_id?>/friends/invite/" >Пригласить друзей на сайт</a> <a class="otzlnk" href="/community/search/" >Найти друзей на сайте</a></div>
           </div>
         
          <h2 class="grey">Сертификаты</h2>
         
          <div class="items-group"> 
            <div class="item-group"> <a class="otzlnk" href="/community/user/<?=$user_id?>/certificates/already-have/" >Посмотреть мои сертификаты</a> <a class="otzlnk" href="/community/user/<?=$user_id?>/certificates/presented/" >Я подарил</a> <a class="otzlnk showpUp" href="#certificateBuy" >Купить сертификат</a> </div>
           </div>
         </td> <td width="50%"> 
          <h2 class="grey">Рассылки</h2>
         
          <div class="items-group"> 
            <div class="item-group"> <a class="otzlnk" href="/personal/subscribe/" >Изменить подписку</a> </div>
           </div>
         
          <h2 class="grey">Мой блог</h2>
         
          <div class="items-group"> 
            <div class="item-group"> <a class="otzlnk" href="/community/blog/<?=$user_blog?>/" >Посмотреть блог</a> <a class="otzlnk" href="/community/blog/<?=$user_blog?>/post_edit/new/" >Добавить запись</a> </div>
           </div>
         
          <h2 class="grey">Рейтинг</h2>
         
          <div class="items-group"> 
            <div class="item-group"> <a class="otzlnk" href="/community/user/<?=$user_id?>/rating/" >Посмотреть личную информацию</a> </div>
           </div>
         
          <h2 class="grey">Список малыша</h2>
         
          <div class="items-group"> 
            <div class="item-group"> <a class="otzlnk" href="/community/user/<?=$user_id?>/" >Посмотреть список малыша</a> </div>
           </div>
		   
		    <h2 class="grey">Награды</h2>
         
          <div class="items-group"> 
            <div class="item-group"> <a class="otzlnk" href="/community/user/<?=$user_id?>/awards/" >Посмотреть список наград</a> </div>
           </div>
         </td> </tr>
     </tbody>
   </table>
 </div>
 
 <div id="certificateBuy" class="CatPopUp">
    <div class="white_plash">
    <div class="exitpUp"></div>
    <div class="cn tl"></div>
    <div class="cn tr"></div>
    <div class="content"><div class="content"><div class="content"> <div class="clear"></div>
		<div class="clear"></div>
		<div class="title">Выберите сертификаты</div>
		<div class="sub-title">Купить сертификаты в магазине</div>
       <div class="data">
		<?$APPLICATION->IncludeComponent("bitrix:news.list", "certificate.buy", Array(
	"IBLOCK_TYPE" => "certificate",	// Тип информационного блока (используется только для проверки)
	"IBLOCK_ID" => "4",	// Код информационного блока
	"NEWS_COUNT" => "20",	// Количество новостей на странице
	"SORT_BY1" => "ACTIVE_FROM",	// Поле для первой сортировки новостей
	"SORT_ORDER1" => "DESC",	// Направление для первой сортировки новостей
	"SORT_BY2" => "SORT",	// Поле для второй сортировки новостей
	"SORT_ORDER2" => "ASC",	// Направление для второй сортировки новостей
	"FILTER_NAME" => "",	// Фильтр
	"FIELD_CODE" => array(	// Поля
		0 => "",
		1 => "",
	),
	"PROPERTY_CODE" => array(	// Свойства
		0 => "PRICE",
		1 => "",
	),
	"CHECK_DATES" => "Y",	// Показывать только активные на данный момент элементы
	"DETAIL_URL" => "",	// URL страницы детального просмотра (по умолчанию - из настроек инфоблока)
	"AJAX_MODE" => "Y",	// Включить режим AJAX
	"AJAX_OPTION_SHADOW" => "Y",	// Включить затенение
	"AJAX_OPTION_JUMP" => "N",	// Включить прокрутку к началу компонента
	"AJAX_OPTION_STYLE" => "Y",	// Включить подгрузку стилей
	"AJAX_OPTION_HISTORY" => "N",	// Включить эмуляцию навигации браузера
	"CACHE_TYPE" => "A",	// Тип кеширования
	"CACHE_TIME" => "36000000",	// Время кеширования (сек.)
	"CACHE_FILTER" => "N",	// Кешировать при установленном фильтре
	"CACHE_GROUPS" => "Y",	// Учитывать права доступа
	"PREVIEW_TRUNCATE_LEN" => "",	// Максимальная длина анонса для вывода (только для типа текст)
	"ACTIVE_DATE_FORMAT" => "d.m.Y",	// Формат показа даты
	"SET_TITLE" => "N",	// Устанавливать заголовок страницы
	"SET_STATUS_404" => "N",	// Устанавливать статус 404, если не найдены элемент или раздел
	"INCLUDE_IBLOCK_INTO_CHAIN" => "N",	// Включать инфоблок в цепочку навигации
	"ADD_SECTIONS_CHAIN" => "N",	// Включать раздел в цепочку навигации
	"HIDE_LINK_WHEN_NO_DETAIL" => "N",	// Скрывать ссылку, если нет детального описания
	"PARENT_SECTION" => "",	// ID раздела
	"PARENT_SECTION_CODE" => "",	// Код раздела
	"DISPLAY_TOP_PAGER" => "N",	// Выводить над списком
	"DISPLAY_BOTTOM_PAGER" => "Y",	// Выводить под списком
	"PAGER_TITLE" => "Новости",	// Название категорий
	"PAGER_SHOW_ALWAYS" => "N",	// Выводить всегда
	"PAGER_TEMPLATE" => "",	// Название шаблона
	"PAGER_DESC_NUMBERING" => "N",	// Использовать обратную навигацию
	"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",	// Время кеширования страниц для обратной навигации
	"PAGER_SHOW_ALL" => "N",	// Показывать ссылку "Все"
	"DISPLAY_DATE" => "Y",	// Выводить дату элемента
	"DISPLAY_NAME" => "Y",	// Выводить название элемента
	"DISPLAY_PICTURE" => "Y",	// Выводить изображение для анонса
	"DISPLAY_PREVIEW_TEXT" => "Y",	// Выводить текст анонса
	"AJAX_OPTION_ADDITIONAL" => "",	// Дополнительный идентификатор
	),
	false
);?>
       </div> 
    </div></div></div>
    <div class="cn bl"></div>
    <div class="cn br"></div>
    </div>
</div>
 
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>