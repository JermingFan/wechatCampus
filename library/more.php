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
    require_once './BaeMemcache.class.php';
    /*Cache配置信息，可查询Cache详情页*/
    $cacheid = 'XXX';
    $host = 'cache.duapp.com';
    $port = '20243';
    $user = 'XXX';
    $pwd = 'XXX';
    $mc = new BaeMemcache($cacheid,$host. ': '. $port, $user, $pwd);
    // $mc=memcache_init();
    $arr_title=memcache_get($mc,$_GET[key]."_title");
    $arr_zuozhe=memcache_get($mc,$_GET[key]."_zuozhe");
    $arr_url=memcache_get($mc,$_GET[key]."_url");
    for($i=40;$i>=0;$i--)
    {
        if($arr_title[$i])
        {
            $count=$i;
            break;
        }
    }
    ?>
    <ol data-role="listview">
        <?php for($i=1;$i<=$count;$i++) { ?>
            <li><a href="http://1.shnupartner.sinaapp.com/library/lib_data.php?url=<?php echo $arr_url[$i]; ?>&title=<?php echo $arr_title[$i];?>" target="_blank"><?php echo $arr_title[$i] ?>--<?php echo $arr_zuozhe[$i] ?></a></li>

        <?php }?>

    </ol>
    <?php if($count==40){ ?>
        <a href="http://1.shnupartner.sinaapp.com/library/more2.php?sch_url=<?php echo $_GET[sch_url] ?>&type=<?php echo $_GET[type] ?>&key=<?php echo $_GET[key]; ?>" target="_blank"><button><center>下一页</center></button></a>
    <?php }?>
</html>