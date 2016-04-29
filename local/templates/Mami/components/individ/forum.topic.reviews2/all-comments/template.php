<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?//print_r($arResult);?>
<?if (!empty($arResult["MESSAGES"])):?>

    <h2>Отзывы</h2>
	<div id="reports"></div>
    <?foreach($arResult["MESSAGES"] as $key => $arMessage):?>
		<?//print_R($arMessage)?>
		<?if ($i == 1):?>
            <div id="open_review"><a href="?">Все <?=count($arResult["MESSAGES"])?> отзывов</a></div>
            <div id="hide_review" style="display: none;">                    
        <?endif?>
        <a name="message<?=$arMessage["ID"]?>"></a>
        <div class="comment top15" id="review<?=$arMessage["ID"]?>">
            <div class="head">
				<?if($arMessage["AUTHOR"]["PERSONAL_PHOTO"]>0):?>
					<?=ShowImage($arMessage["AUTHOR"]["PERSONAL_PHOTO"],41,41, "class='foto'")?>
				<?else:?>
					<?=ShowImage(SITE_TEMPLATE_PATH."/images/profile_img.png",41,41, "class='foto'")?>
				<?endif;?>
				<?
					$name = "";
					
					if(!empty($arMessage["AUTHOR"]["NAME"])){
						$name = $arMessage["AUTHOR"]["NAME"];
					}
					
					if(!empty($arMessage["AUTHOR"]["LAST_NAME"])){
						if(empty($name))
							$name = $arMessage["AUTHOR"]["LAST_NAME"];
						else
							$name .= " ".$arMessage["AUTHOR"]["LAST_NAME"];
					}
					
					if(empty($name)){
						$name = $arMessage["AUTHOR"]["LOGIN"];
					}
				?>
				<?//print_R($arMessage);?>
				<?if(intval($arMessage["AUTHOR_ID"])>0):?>
					<a class="boldLink" href="/community/user/<?=$arMessage["AUTHOR_ID"]?>/"><?=$name?></a>
				<?else:?>
					<span class="boldLink"><?=$arMessage["FOR_JS"]["AUTHOR_NAME"]?></span>
				<?endif;?>
                <div class="rat">
                     <?$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH."/includes/raiting.php", array('Raiting'=>$arMessage["RATING"]), array("MODE"=>"html") );?> <span class="data"><span class="date"><?=$arMessage["POST_DATE"]?></span></span>
                </div>
            </div>
            <div class="text">
                <?=$arMessage["POST_MESSAGE_TEXT"]?>
				
				<?//if()?>
				<!--<div class="edit"></div>-->
                <div class="clear"></div>
            </div>
        </div>           
        <?$i++;?>
    <?endforeach?> 

            
<?endif?>

<?if ($i > 1):?>
    </div>
    <div id="close_review"><a href="?">Закрыть отзывы</a></div>
<?endif?>
