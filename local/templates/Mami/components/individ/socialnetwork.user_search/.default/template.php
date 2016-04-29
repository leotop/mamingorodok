<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
    global $USER;
    $user_id = $USER->GetID();    
    
?>
<div class="catalogFilter">
    <div id="trueLink">
        <?$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH.'/includes/catalog/choose.php',array("arChoose"=>$arChoose));?>
    </div>
    <div class="clear"></div>

    <div class="top25"></div>
    <div class="MiniBtn">
        <form action="<?= $arResult["Urls"]["UserSearch"] ?>" class="bx-selector-form filter-form jqtransform" name="bx_users_filter_simple_form">
            <?
                foreach ($arResult["Params"]["UserSearch"] as $key => $value)
                    echo "<input type=\"hidden\" name=\"".$key."\" value=\"".$value."\" />";
            ?>
            <input type="hidden" name="current_view" value="<?=htmlspecialchars($arResult['CURRENT_VIEW'])?>" />
            <input type="hidden" name="current_filter" value="simple" />
            <div id="comment" class="commentForm">
                <div class="leftTR"></div>
                <div class="leftBR"></div>
                <div class="rightTR"></div>
                <div class="rightBR"></div>

                <div  class="block">
                    <label>�������, ���</label>
                    <div class="clear"></div>
                    <input type="text" value="<?= htmlspecialcharsex($_REQUEST["FLT_FIO"]) ?>" style="width:530px" id="who" name="FLT_FIO">
                    <div class="clear"></div>
                </div>

                <div class="block">
                    <label>�����</label>
                    <div class="clear"></div>
                    <input type="text" value="<?=$_REQUEST["flt_personal_city"]?>" style="width:530px" id="who" name="flt_personal_city" />
                    <div class="clear"></div>
                </div>

                <div class="block">
                    <label>���</label>
                    <div class="clear"></div>
                    <table class="sex">
                        <tr>
                            <td><input type="radio" name="flt_personal_gender" value="" checked><span class="pol">�� ����� ��������</span></td>
                            <td><input type="radio" name="flt_personal_gender" value="M"<?if ($_REQUEST["flt_personal_gender"] == "M"):?> checked<?endif?>><span class="pol">�������</span></td>
                            <td><input type="radio" name="flt_personal_gender" value="F"<?if ($_REQUEST["flt_personal_gender"] == "F"):?> checked<?endif?>><span class="pol">�������</span></td>
                        </tr>
                    </table>
                    <div class="clear"></div>
                </div>

                <div class="block">
                    <label>�������</label>
                    <div class="clear"></div>
                    <input type="text" value="<?=$_REQUEST["USER_AGE"]?>" style="width:530px" id="who" name="USER_AGE">
                    <div class="clear"></div>
                </div>
            </div>
            <div class="sbmBtn">
                <input type="submit" id="sBtnie7" value="������">
            </div>
        </form>
    </div>

</div>
<div class="clear"></div>
<div class="top15"></div>

<div>
    <?if(count($arResult["SEARCH_RESULT"])>0):?>
	<?$j=0?>
	<?foreach ($arResult["SEARCH_RESULT"] as $arUser):?>
        <div class="friendProf">
			<div class="fotototo">
            <center><?=$arUser["IMAGE_IMG"]?></center>
			</div>
			<div class="clear"></div>
			<div class="namenamename">
            <a href="<?=$arUser["URL"]?>"><?=ShowFullName($arUser["NAME"], $arUser["SECOND_NAME"], $arUser["LAST_NAME"])?></a>
			</div>
			<?$age = GetAge($arUser["PERSONAL_BIRTHDAY"]);?>
            <div class="age"><?if($age!=0):?><?=$age?>, <?endif;?><?=$arUser["PERSONAL_CITY"]?></div>
            <!--div class="children">����: �����, �������</div-->
			
            <?if ($user_id > 0):?>
                <?if (CSocNetUserRelations::IsFriends($user_id, $arUser["ID"])):?>
                    <div class="generalFriend">����� ����</div>
                <?elseif($user_id != $arUser["ID"]):?>
                    <a class="lnk grey marginLnk" href="<?=$arUser["ADD_TO_FRIENDS_LINK"]?>">�������� � ������</a>
                <?else:?>
                    <div class="generalFriend">��� ��!</div>                        
                <?endif?>
            <?endif?>
        </div>
	<?$j++?>
	<?if ($j == 4):?>
	<div class="clear"></div>
	<?$j=0?>
	<?endif?>
    <?endforeach?>
	<?else:?>
		<div class="notetext">
			�� ������ ������� ������ �� �������.
		</div>
	<?endif;?>
    <div class="clear"></div>
</div>
<?=$arResult["NAV_STRING"]?>