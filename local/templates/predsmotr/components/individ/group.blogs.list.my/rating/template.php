<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?if (!empty($arResult)):?>
    <h2>�����, � ������� ������� ������������</h2>
    <div class="items-group">
    <?foreach($arResult as $arBlog):?>
        <div class="item-group">
            <a href="<?=$arBlog["urlToBlog"]?>"><?=$arBlog["NAME"]?></a>
        </div>
    <?endforeach?>
    </div>
<div class="clear"></div>
<?endif?>