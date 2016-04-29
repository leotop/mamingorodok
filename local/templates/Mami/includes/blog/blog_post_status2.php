<div class="items">
		<div class="clear"></div>
		<img class="foto" src="<?=SITE_TEMPLATE_PATH;?>/images/blog/foto.png"></td>
		<div class="info">
			<a href="/community/user/2/blog/">Анастасия Ивановна</a> <span class="rating">Рейтинг</span> +37</td>
		</div>
		<div class="clear"></div>
		<div class="status">
			<div>Просит написать отзыв</div>
			<div class="tvr">
			<table>
			<tr><td>
			<?=ShowIImage(SITE_TEMPLATE_PATH."/images/img_sneg.png", 48, 48);?>
			</td><td><a href="/catalog/2/385/">Коньки</a>
			<?$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH."/includes/raiting.php", array(), array("MODE"=>"html") );?>
			</td></tr>
			</table>
			</div>
		</div>
		<?$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH."/includes/blog/panel.php", array(), array("MODE"=>"html") );?>
	</div>