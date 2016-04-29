<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?
$pageId = "user_friends_invite";
$user_id = $arParams["USER_ID"];
//include("util_menu.php");
//include("util_profile.php");


?>

<div class="choose" style="width:350px;">
    <?if ($user_id > 0):?>
        <span><span><a href="/community/user/<?=$user_id?>/friends/">���</a></span></span>
        <span class="active"><span><a href="/community/user/<?=$user_id?>/friends/invite/">���������� ������</a></span></span>
    <?endif?>
    <span><span><a href="/community/search/">����� �� �����</a></span></span>
    <div class="clear"></div>
</div>


<?if (!empty($arResult["ERRORS"])):?>
    <div class="errortext">
        <?foreach($arResult["ERRORS"] as $error):?>
            <?=$error?><br />            
        <?endforeach?>
    </div>
<?endif?>

<?if (empty($arResult["ERRORS"]) && $_REQUEST["add_ok"] == "Y"):?>
    <div class="oktext">����������� ����������.</div>
<?else:?>

    <div class="top25"></div>
    <div class="MiniBtn">
        <form action="/community/user/<?=$arResult["CURRENT_USER"]?>/friends/invite/" class="jqtransform" method="post" enctype="multipart/form-data">

            <div id="comment" class="commentForm">
                <div class="leftTR"></div>
                <div class="leftBR"></div>
                <div class="rightTR"></div>
                <div class="rightBR"></div>
                <label>����:</label>
                <div class="clear"></div>
                <table width="100%"><tr><td>
                            <input type="text" value="" style="width:530px" id="who" name="emails">
                        </td><td>
                            <div class="inform">������ ����������� ����� ����� �������.</div>
                        </td></tr></table>
                <div class="clear"></div>

                <div class="loadFileMail">
                    <table>
                        <tr><td>
                                <label>���:</label>
                            </td><td>
                                <div class="fileMain">
									
                                    <div class="fileGet">
                                        <input name="friends_list_file" type="file" id="file1" value="��������� ����� �� �����" >
                                    </div>
									
                                    <input type="hidden" id="fileid" value="1" >
                                </div>
                            </td><td width="165px">
                                <div class="inform">
                                    ������ ������ ������ ���� ������� � ����� ������
                                </div>
                            </td></tr>
                    </table>
                </div>
                <div class="clear"></div>

                <div class="theme">
					<?$curUser = intval($arResult["CURRENT_USER"]);?>
					<?
					if($curUser>0){
					$rsUser = CUser::GetByID($curUser);
					$arUser = $rsUser->Fetch();
					
					$name = "";
					if(!empty($arUser["NAME"]))
						$name = $arUser["NAME"];
						
					if(!empty($arUser["LAST_NAME"]))
						if(empty($name))
							$name = $arUser["LAST_NAME"];
						else $name .= " ".$arUser["LAST_NAME"];
						
					if(empty($name))
						$name = $arUser["LOGIN"];
					}
					else{
					$name = "�����";
					}
					?>
                    <label class="light_grey">����:</label>
                    <div class="themeText"><?=$name?> ���������� ��� � "����� �������"</div>
                </div>
                <div class="clear"></div>
                <div  class="miniArea">
                    <table width="100%"><tr><td>
                                <textarea style="height:100px; width:530px;" name="message"></textarea>
                            </td><td width="165px">
                                <div class="inform notice">����� ���� ���������������� �� �������� ��������� �� �����.</div>
                            </td></tr></table>
                </div>
                <div class="clear"></div>
                <label>��� ������:</label>
                <div class="themeText">http://<?=SITE_SERVER_NAME?>/community/user/<?=$arParams['USER_ID']?>/</div>
                <div class="clear"></div>
            </div>
            <div class="sbmBtn">
                <input type="hidden" name="add_ok" value="Y" />
                <input type="submit" id="sBtnie7" value="��������� �����������">
            </div>
        </form>
    </div>
    
<?endif?>

