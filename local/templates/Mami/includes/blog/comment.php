	<?if(!empty($arParams["LAVEL"])):?>
	<? $commentMargin = "style='margin-left:".(50*intval($arParams["LAVEL"]))."px'";?>
	<?endif?>
	<div class="comment top15" <?=$commentMargin?>>
		<div class="head">
		<img class="foto" src="<?=SITE_TEMPLATE_PATH?>/images/blog/famous_people.png">
		<a href="/community/user/2/blog/" class="boldLink">јнастаси€ »ванова</a>
		<?if($arParams["RAITE"]!="Y"):?>
		<span class="date">2 феврал€, 9:51</span>
		<?endif;?>
		<div class="rat">
		<?if($arParams["RAITE"]=="Y"):?>
		<?$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH."/includes/raiting.php", array(), array("MODE"=>"html") );?> <span class="data">2 феврал€</span>
		<?else:?>
		+6 <span class="add"></span>
		<?endif;?>
		</div>
		</div>
		<div class="text">ƒети индиго Ч псевдонаучный термин, введЄнный экстрасенсом Ќэнси Ённ “эпп[1] дл€ обозначени€ детей, которые, по еЄ мнению, обладают аурой цвета индиго. Ўирокую известность термин получил в конце 1990-х благодар€ упоминанию в источниках, имеющих отношение к движению нью-эйдж.
		<div class="clear"></div>
		<?if($arParams["RAITE"]=="Y"):?>
		<?/*<a href="" class="grey">¬се 11 отзывов</a>*/?>
		<?else:?>
		<a href="#" class="boldLink">ќтветить</a>
		<?endif;?>
		</div>
	</div>