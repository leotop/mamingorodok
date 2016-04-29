<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?

?>

<div id="blog-posts-content">
<?
if(!empty($arResult["OK_MESSAGE"]))
{
	?>
	<div class="blog-notes blog-note-box">
		<div class="blog-note-text">
			<ul>
				<?
				foreach($arResult["OK_MESSAGE"] as $v)
				{
					?>
					<li><?=$v?></li>
					<?
				}
				?>
			</ul>
		</div>
	</div>
	<?
}
if(!empty($arResult["MESSAGE"]))
{
	?>
	<div class="blog-textinfo blog-note-box">
		<div class="blog-textinfo-text">
			<ul>
				<?
				foreach($arResult["MESSAGE"] as $v)
				{
					?>
					<li><?=$v?></li>
					<?
				}
				?>
			</ul>
		</div>
	</div>
	<?
}
if(!empty($arResult["ERROR_MESSAGE"]))
{
	?>
	<div class="blog-errors blog-note-box blog-note-error">
		<div class="blog-error-text">
			<ul>
				<?
				foreach($arResult["ERROR_MESSAGE"] as $v)
				{
					?>
					<li><?=$v?></li>
					<?
				}
				?>
			</ul>
		</div>
	</div>
	<?
}
if(count($arResult["POST"])>0)
{
	$i=0;
	foreach($arResult["POST"] as $ind => $CurPost)
	{
		?>
			<div class="items">
				<a href="<?=$CurPost["urlToPost"]?>" title="<?=$CurPost["TITLE"]?>"><?=$CurPost["TITLE"]?></a>
				<div>
					<?=substr(strip_tags($CurPost["TEXT_FORMATED"]),0,250)?><?if(strlen($CurPost["TEXT_FORMATED"])>250):?>...<?endif;?>
				</div>				
			</div>
			<?
			$i++;
			if($i==2){
			?>
				<div class="clear"></div>
			<?
			$i = 0;
			}
			?>
		<?
	}
    ?>
    <div class="clear"></div>
    <div class="floatObz"><a href="/community/group/<?=$arResult["BLOG"]["URL"]."/"?>">Все обсуждения</a></div>
    <?
}
elseif(!empty($arResult["BLOG"]))
	echo GetMessage("BLOG_BLOG_BLOG_NO_AVAIBLE_MES");
?>	
</div>