<div class="title-line baby-list">
    <ul>
        <li>
            <?if($LOOK=="BABY_LIST"):?>
                Список малыша
                <?else:?>
                <a href="#">Список малыша</a>
                <?endif?>
        </li>
        <li>
            <?if($LOOK=="FRIENDS"):?>
                Друзья
                <?else:?>
                <a href="friends/">Друзья</a>
                <?endif?>
        </li>
        <?/*            <li>
            <?if($LOOK=="BABY"):?>
            Дети
            <?else:?>
            <a href="#">Дети</a>
        <?endif?>*/?>
        </li>
        <li>
            <?if($LOOK=="RATING"):?>
                Рейтинг
                <?else:?>
                <a href="/community/user/2/rating/">Рейтинг</a>
            <?endif?></li>
    </ul>
    <div class="clear"></div>
</div>