<div class="items">
		<div class="clear"></div>
		<img class="foto" src="<?=SITE_TEMPLATE_PATH;?>/images/blog/foto.png"></td>
		<div class="info">
			<a href="/community/user/2/blog/">��������� ��������</a> <span class="rating">�������</span> +37</td>
		</div>
		<div class="clear"></div>
		<div class="status">
			<div class="tvr">
			<div>������ ������ � </div>
			<table>
			<tr><td>
			<?=ShowIImage(SITE_TEMPLATE_PATH."/images/blog/foto.png", 48, 48);?>
			</td><td><a href="/community/user/2/blog/">��������� ���������</a>
			<?$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH."/includes/raiting.php", array(), array("MODE"=>"html") );?>
			</td></tr>
			</table>
			</div>
		</div>
		<?$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH."/includes/blog/panel.php", array(), array("MODE"=>"html") );?>
	</div>