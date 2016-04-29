<div class="commentForm" id="comment">
		<div class="leftTR"></div>
		<div class="leftBR"></div>
		<div class="rightTR"></div>
		<div class="rightBR"></div>
		<?if($arParams["SCORE"]!="Y"):?>
		<div class="title">Добавить свой комментарий</div>
		<?endif;?>
		<?if($arParams["SCORE"]=="Y"):?>
		<div class="info">
		<div class="fll">Ваша оценка:</div>
		<ul class="score">
		<li><a href="">ужасно</a></li>
		<li><a href="">плохо</a></li>
		<li><div>удовлетворительно</div></li>
		<li><a href="">хорошо</a></li>
		<li><a href="">отлично</a></li>
		</ul>
		</div>
		<div class="clear"></div>
		<div class="top15"></div>
		<?else:?>
		<div class="info">Вы вошли как <a href="/community/user/1/blog/">Анжелика</a>. <a href="#" class="grey">Выйти?</a> </div>
		<?endif;?>
			<textarea class="textcom"></textarea>
		<?if($arParams["SCORE"]!="Y"):?>
			<input type="submit" class="purple fll" value="Добавить комментарий">
		<?else:?>
			<input type="submit" class="purple fll disable" value="Добавить отзыв" disabled="disabled">
		<?endif?>
		<?if($arParams["SCORE"]=="Y"):?>
		<div class="pd15">За  отзыв вы получите 1 балл.</div>
		<?endif;?>
		<div class="clear"></div>
	</div>