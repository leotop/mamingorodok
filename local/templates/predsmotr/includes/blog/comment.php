	<?if(!empty($arParams["LAVEL"])):?>
	<? $commentMargin = "style='margin-left:".(50*intval($arParams["LAVEL"]))."px'";?>
	<?endif?>
	<div class="comment top15" <?=$commentMargin?>>
		<div class="head">
		<img class="foto" src="<?=SITE_TEMPLATE_PATH?>/images/blog/famous_people.png">
		<a href="/community/user/2/blog/" class="boldLink">��������� �������</a>
		<?if($arParams["RAITE"]!="Y"):?>
		<span class="date">2 �������, 9:51</span>
		<?endif;?>
		<div class="rat">
		<?if($arParams["RAITE"]=="Y"):?>
		<?$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH."/includes/raiting.php", array(), array("MODE"=>"html") );?> <span class="data">2 �������</span>
		<?else:?>
		+6 <span class="add"></span>
		<?endif;?>
		</div>
		</div>
		<div class="text">���� ������ � ������������� ������, �������� ������������ ����� ��� ����[1] ��� ����������� �����, �������, �� � ������, �������� ����� ����� ������. ������� ����������� ������ ������� � ����� 1990-� ��������� ���������� � ����������, ������� ��������� � �������� ���-����.
		<div class="clear"></div>
		<?if($arParams["RAITE"]=="Y"):?>
		<?/*<a href="" class="grey">��� 11 �������</a>*/?>
		<?else:?>
		<a href="#" class="boldLink">��������</a>
		<?endif;?>
		</div>
	</div>