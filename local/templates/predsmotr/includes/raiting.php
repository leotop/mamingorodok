<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
?><div class="rating"><?
for($si = 0; $si<5; $si++)
{
	?><span <?=($si+1 <= $Raiting ? 'class="on"':'')?>></span> <?
}
echo $strAddon;
?></div>