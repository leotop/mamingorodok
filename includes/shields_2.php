 <?
 //входные параметры  $props - массив свойств элемента
 //                   $size - размер спрайта
 //                   $align - массив (left => ... , right => ... , ...)
 
$keys=array("ACTION", "NOVINKA", "KHIT_PRODAZH", "RASPRODAZHA"); //символьные кода свойств

//получаем включенные свойства 
$arShields = array();      
 
foreach ($keys as $key)
{
    if ($props[$key]["VALUE"] == 'Да')
    {
        $arShields[]=$key;
    } 
     
}
          
//высота спрайта            
if (is_set($size))
{
    $height = $size;
}     
else
{
    $height = 36;
}

$defaultAlign = array("left" => "0px", "right" => "auto", "top" => "0px", "bottom" => "auto");
      
if (is_set($align))
{
    $align = array_merge($defaultAlign, $align);    
}
else
{
   $align = $defaultAlign;
}

$alignStyle="";
foreach ($align as $key => $value)
{
    $alignStyle.=$key.':'.$value.';';  
}

?>
<div class="shields" style="<?=$alignStyle?>"><?   
    foreach ($arShields as $shield)
    {?>
        <div class="shield" 
            style="width: <?=$height?>px; 
                height: <?=$height?>px; 
                -o-background-size: <?=$height?>px;
                -moz-background-size: <?=$height?>px;
                -webkit-background-size: <?=$height?>px;
                background-size: <?=$height?>px;    
                <? 
                switch (GetOffset($keys, $shield, $height)) {
                    case 0:
                        echo 'background-image: url(/i/shield_gift.png);';
                        break;
                    case $height:
                        echo 'background-image: url(/i/shield_new.png);';
                        break;
                    case $height*2:
                        echo 'background-image: url(/i/shield_hit.png);';
                        break;
                    case $height*3:
                        echo 'background-image: url(/i/shield_percent.png);';
                        break;
                }?>
                ">
        </div>
    <?    
    }
    ?>
</div>
        