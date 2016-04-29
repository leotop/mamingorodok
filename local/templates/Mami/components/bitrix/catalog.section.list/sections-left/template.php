<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<div id="LeftMenu">
    <ul>
        <?foreach($arResult["SECTIONS"] as $key => $arSection):?>
            <li class="sliderMenu"><a class="slide" href="/catalog/<?=$arSection["ID"]?>/"><?=$arSection["NAME"]?></a>
				<?if(isset($arSection["SUBSECTION"]) && count($arSection["SUBSECTION"])>0):?>
				<div class="nodisplay" id="submenu">
					<ul>
						<?foreach($arSection["SUBSECTION"] as $subSection):?>
						<li><a href="/catalog/<?=$subSection["ID"]?>/"><?=$subSection["NAME"]?></a></li>
						<?endforeach;?>
					</ul>
				</div>
				<?endif?>
			</li>
        <?endforeach?>
    </ul>
</div>


