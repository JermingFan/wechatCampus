<html>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0" />
    <head>
        <link rel="stylesheet" href="http://code.jquery.com/mobile/1.3.2/jquery.mobile-1.3.2.min.css">
        <script src="http://code.jquery.com/jquery-1.8.3.min.js"></script>
        <script src="http://code.jquery.com/mobile/1.3.2/jquery.mobile-1.3.2.min.js"></script>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0" />

    </head>
    <?php

    $mc=memcache_init();
    $arr_title=memcache_get($mc,$_GET[key]."_title");
    $arr_zuozhe=memcache_get($mc,$_GET[key]."_zuozhe");
    $arr_url=memcache_get($mc,$_GET[key]."_url");
    for($i=120;$i>=0;$i--)
    {
        if($arr_title[$i])
        {
            $count=$i;
            break;
        }
    }
    ?>
    <ol data-role="listview">
        <?php for($i=81;$i<=$count;$i++) { ?>
            <li><a href="http://1.shnupartner.sinaapp.com/library/lib_data.php?url=<?php echo $arr_url[$i]; ?>&title=<?php echo $arr_title[$i];?>" target="_blank"><?php echo $arr_title[$i] ?>--<?php echo $arr_zuozhe[$i] ?></a></li>

        <?php }?>

    </ol>

</html>