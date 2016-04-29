<div class="certificate-item">
	<div class="award-info">
	<?=showIImage(SITE_TEMPLATE_PATH."/images/award.png",100,100);?>
		<div class="award-info-nd">
			<div class="award-info-num"><span>1 500</span> руб.</div>
			<div class="award-info-date">4 октября 2010</div>
		</div>
	</div>
	<?if($PRESENTED=="Y"):?>
	<div class="award-info-present-center">
		<?if($PRESENT=="Y"):?>
			<div class="present-status-img">
				<div class="present-yes"></div>
			</div>
			<div class="present-info">
				<div class="award-present">Я подарил:</div>
				<a class="award-present-lnk" href="/community/user/2/blog/">Иван Грозный</a>
				<div class="award-present-status">Он принял</div>
			</div>
		<?else:?>
			<div class="present-status-img">
				<div class="present-no"></div>
			</div>
			<div class="present-info">
				<div class="award-present">Я подарил:</div>
				<a class="award-present-lnk" href="/community/user/2/blog/">Иван Грозный</a>
				<div class="award-present-status">Он не принял</div>
			</div>
		<?endif;?>
	</div>
	<?else:?>
	<div class="award-info-center">
		<?if($MY!="Y"):?>
			<div class="award-present">Подарил:</div>
			<a class="award-present-lnk" href="/community/user/2/blog/">Иван Василич</a>
		<?else:?>
			<div class="award-buy">Я купил</div>
		<?endif;?>
	</div>
	<div class="award-info-right">
		<?if($MY!="Y"):?>
		<a href="#" class="greydot nothanks">Отказаться</a>
		<?endif;?>
	</div>
	<?endif;?>
</div>
<div class="clear"></div>