<div class="commentForm" id="comment">
		<div class="leftTR"></div>
		<div class="leftBR"></div>
		<div class="rightTR"></div>
		<div class="rightBR"></div>
		<?if($arParams["SCORE"]!="Y"):?>
		<div class="title">�������� ���� �����������</div>
		<?endif;?>
		<?if($arParams["SCORE"]=="Y"):?>
		<div class="info">
		<div class="fll">���� ������:</div>
		<ul class="score">
		<li><a href="">������</a></li>
		<li><a href="">�����</a></li>
		<li><div>�����������������</div></li>
		<li><a href="">������</a></li>
		<li><a href="">�������</a></li>
		</ul>
		</div>
		<div class="clear"></div>
		<div class="top15"></div>
		<?else:?>
		<div class="info">�� ����� ��� <a href="/community/user/1/blog/">��������</a>. <a href="#" class="grey">�����?</a> </div>
		<?endif;?>
			<textarea class="textcom"></textarea>
		<?if($arParams["SCORE"]!="Y"):?>
			<input type="submit" class="purple fll" value="�������� �����������">
		<?else:?>
			<input type="submit" class="purple fll disable" value="�������� �����" disabled="disabled">
		<?endif?>
		<?if($arParams["SCORE"]=="Y"):?>
		<div class="pd15">��  ����� �� �������� 1 ����.</div>
		<?endif;?>
		<div class="clear"></div>
	</div>