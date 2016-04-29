<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<div class="marginingie"></div>
 
<div class="pcihotypes"> 	
  <div class="arrow"></div>
 	
  <div class="lmt"></div>
 	
  <div class="rmt"></div>
 	
  <div class="lmb"></div>
 	
  <div class="rmb"></div>
 	
  <div class="hd">Выберите какая вы мама и смотрите рекомендации товаров!</div>
 	
  <table> 	
    <tbody>
		<?$i=0;
		$j=0;
		?>
		<?foreach($arResult["SECTIONS"] as $arSection):?>
		<?if($j<6):?>
		<?if($i==0):?>
			<tr>
		<?endif;?>
			<td width="300px"> 		
				<div class="pcihotype"><a class="fotolink" href="<?=$arSection["SECTION_PAGE_URL"]?>"><?=ShowImage($arSection["PICTURE"]["ID"],100,100);?></a> 			
            <div> 			<a href="<?=$arSection["SECTION_PAGE_URL"]?>"><?=$arSection["NAME"]?></a>	
			<?
				if(!empty($arSection["UF_MAIN_SHOW"])):
				$arSection["DESCRIPTION"] = $arSection["UF_MAIN_SHOW"];
				endif;
				$arSection["DESCRIPTION"] = str_replace("&nbsp;"," ",$arSection["DESCRIPTION"]);?>
              <div class="rel"><?=substr($arSection["DESCRIPTION"],0,75)?><?if(strlen($arSection["DESCRIPTION"])>75):?>...<?endif;?>
			  </div>
			  
             			</div>
           		</div>
         		</td> 	
		
		<?$i++;?>
		<?if($i%3==0):?>
			</tr>
			<?$i=0;?>
		<?endif;?>
		<?$j++;?>
		<?endif;?>
		<?endforeach;?>
			<?while($i%3!=0):?>
				<td align="<?if($i%3==0):?>left<?elseif($i%2==0):?>right<?else:?>center<?endif?>">&nbsp;</td> 
				<?$i++;?>
			<?endwhile;?>
			</tr>
		  </table>
  <div class="clear"></div>
 </div>