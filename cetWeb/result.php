<?php
//echo $_POST['name'];
//echo $_POST['number'];

if (empty($_POST['name'])||empty($_POST['number']))
{
    echo  "<script LANGUAGE='javascript'>alert('请正确输入你的 准考证号 和 考生姓名');self.location='cet.php'; </script>";
}

function get_td_array($table) {
    $table = preg_replace("'<table[^>]*?>'si","",$table);
    $table = preg_replace("'<tr[^>]*?>'si","",$table);
    $table = preg_replace("'<td[^>]*?>'si","",$table);
    $table = str_replace("</tr>","{tr}",$table);
    $table = str_replace("</td>","{td}",$table);
    //去掉 HTML 标记
    $table = preg_replace("'<[/!]*?[^<>]*?>'si","",$table);
    //去掉空白字符
    $table = preg_replace("'([ ])[s]+'","",$table);
    $table = str_replace(" ","",$table);
    $table = str_replace(" ","",$table);

    $table = explode('{tr}', $table);
    array_pop($table);
    foreach ($table as $key=>$tr) {
        $td = explode('{td}', $tr);
        array_pop($td);
        $td_array[] = $td;
    }
    return $td_array;
}

$zkz=$_POST['number'];
$xm1=$_POST['name'];
//echo urlencode($xm);
$ch=curl_init('http://www.chsi.com.cn/cet/query?zkzh='.$zkz.'&xm='.urlencode($xm1).'');
curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
curl_setopt($ch, CURLOPT_HEADER, 1);
$head[]='Referer:http://www.chsi.com.cn/cet/';
$head[]='User-Agent:Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/34.0.1847.116 Safari/537.36';
curl_setopt($ch, CURLOPT_HTTPHEADER,$head);
$str1=curl_exec($ch);
//print_r($str1);
curl_close($ch);

preg_match('|<table border="0" align="center" cellpadding="0" cellspacing="6" class="cetTable">(.*?)</table>|s',$str1,$table);
//print_r($table);

$array=get_td_array($table[0]);
//print_r($array);
$xm=str_replace("姓名：","",trim($array[0][0]));
$xx=str_replace("学校：","",trim($array[1][0]));
$kslb=str_replace("考试类别：","",trim($array[2][0]));
$zkzh=str_replace("准考证号：","",trim($array[3][0]));
$kssj=str_replace("考试时间：","",trim($array[4][0]));

$key= str_replace("\r\n","",trim($array[5][0]));
preg_match_all("/[0-9]+/",$key,$b);
?>

<html>
<head>
    <meta charset=UTF-8">
    <title>师大小伙伴</title>
    <meta name="viewport" content="width=device-width,height=device-height,inital-scale=1.0,maximum-scale=1.0,user-scalable=no;">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="format-detection" content="telephone=no">
    <link href="./cet_files/cet.css" rel="stylesheet" type="text/css">
</head>

<body id="wrap">
<div class="banner">
    <div id="wrapper">
        <div id="scroller" style="float:none">
            <ul id="thelist">
                <li style="float:none">
                    <img src="./cet_files/logo.jpg" alt="" style="width:100%">
                </li>
            </ul>
        </div>
    </div>
    <div class="clr"></div>
</div>
<div class="cardexplain">
    <ul class="round roundyellow" id="success">
        <li style="height:40px;line-height:40px; font-size:16px; text-align:center"><?php if($b[0][0]>=425) {echo "成功通过考试";}else{ echo "革命尚未成功，同志仍需努力";}    ?></li>
    </ul>
    <ul class="round">
        <li class="title mb"><span class="none">查询结果</span></li>
        <li class="nob" style="height:30px;line-height:30px;">
            <table width="100%" border="0" cellspacing="0" cellpadding="0" class="kuang">
                <tbody>
                <tr>
                    <th>考生姓名</th>
                    <td><?php echo $xm ?></td>
                </tr>
                </tbody>
            </table>
        </li>
        <li class="nob" style="height:30px;line-height:30px;">
            <table width="100%" border="0" cellspacing="0" cellpadding="0" class="kuang">
                <tbody>
                <tr>
                    <th>学校</th>
                    <td><?php echo $xx ?></td>
                </tr>
                </tbody>
            </table>
        </li>
        <li class="nob" style="height:30px;line-height:30px;">
            <table width="100%" border="0" cellspacing="0" cellpadding="0" class="kuang">
                <tbody>
                <tr>
                    <th>准考证号</th>
                    <td><?php echo $zkzh ?></td>
                </tr>
                </tbody>
            </table>
        </li>

        <li class="nob" style="height:30px;line-height:30px;">
            <table width="100%" border="0" cellspacing="0" cellpadding="0" class="kuang">
                <tbody>
                <tr>
                    <th>考试类别</th>
                    <td><?php echo $kslb ?></td>
                </tr>
                </tbody>
            </table>
        </li>

        <li class="nob" style="height:30px;line-height:30px;">
            <table width="100%" border="0" cellspacing="0" cellpadding="0" class="kuang">
                <tbody>
                <tr>
                    <th>考试时间</th>
                    <td><?php echo $kssj ?></td>
                </tr>
                </tbody>
            </table>
        </li>

        <li class="nob" style="height:30px;line-height:30px;">
            <table width="100%" border="0" cellspacing="0" cellpadding="0" class="kuang">
                <tbody>
                <tr>
                    <th>听力</th>
                    <td><?php echo $b[0][1] ?></td>
                </tr>
                </tbody>
            </table>
        </li>
        <li class="nob" style="height:30px;line-height:30px;">
            <table width="100%" border="0" cellspacing="0" cellpadding="0" class="kuang">
                <tbody>
                <tr>
                    <th>阅读</th>
                    <td><?php echo $b[0][2] ?></td>
                </tr>
                </tbody>
            </table>
        </li>
        <li class="nob" style="height:30px;line-height:30px;">
            <table width="100%" border="0" cellspacing="0" cellpadding="0" class="kuang">
                <tbody>
                <tr>
                    <th>写作翻译</th>
                    <td><?php echo $b[0][3] ?></td>
                </tr>
                </tbody>
            </table>
        </li>
        <li class="nob" style="height:30px;line-height:30px;">
            <table width="100%" border="0" cellspacing="0" cellpadding="0" class="kuang">
                <tbody>
                <tr>
                    <th>成绩总分</th>
                    <td><?php echo $b[0][0] ?></td>
                </tr>
                </tbody>
            </table>
        </li>
    </ul>
    <div id="mcover" onclick="document.getElementById(&#39;mcover&#39;).style.display=&#39;&#39;;" style=""><img src="./cet_files/guide.png"></div>
    <div id="mess_share">
        <div id="share_1">
            <button class="button2" onclick="document.getElementById(&#39;mcover&#39;).style.display=&#39;block&#39;;"><img src="./cet_files/icon_msg.png"> 发送给朋友</button>
        </div>
        <div id="share_2">
            <button class="button2" onclick="document.getElementById(&#39;mcover&#39;).style.display=&#39;block&#39;;"><img src="./cet_files/icon_timeline.png"> 分享到朋友圈</button>
        </div>
    </div>
</div>
<script type="text/javascript">
    document.addEventListener('WeixinJSBridgeReady', function onBridgeReady() {
        // 发送给好友
        WeixinJSBridge.on('menu:share:appmessage', function (argv) {
            WeixinJSBridge.invoke('sendAppMessage', {
                "img_url": "http://g.hiphotos.bdimg.com/wisegame/pic/item/462dd42a2834349b3d99e9c1cbea15ce37d3bed3.jpg",
                "img_width": "160",
                "img_height": "160",
                "link": "http://mp.weixin.qq.com/s?__biz=MzA5OTY1NDUyOA==&mid=200440301&idx=1&sn=49e39688d1d1fbcf73fcfcf730606346#rd",
                "desc":  "全国英语四六级考试成绩查询微信入口",
                "title": "全国英语四六级考试成绩查询微信入口"
            }, function (res) {
                _report('send_msg', res.err_msg);
            })
        });

        // 分享到朋友圈
        WeixinJSBridge.on('menu:share:timeline', function (argv) {
            WeixinJSBridge.invoke('shareTimeline', {
                "img_url": "http://g.hiphotos.bdimg.com/wisegame/pic/item/462dd42a2834349b3d99e9c1cbea15ce37d3bed3.jpg",
                "img_width": "160",
                "img_height": "160",
                "link": "http://mp.weixin.qq.com/s?__biz=MzA5OTY1NDUyOA==&mid=200440301&idx=1&sn=49e39688d1d1fbcf73fcfcf730606346#rd",
                "desc":  "全国英语四六级考试成绩查询微信入口",
                "title": "全国英语四六级考试成绩查询微信入口"
            }, function (res) {
                _report('timeline', res.err_msg);
            });
        });
    }, false)
</script>
<script type="text/javascript">
    document.addEventListener('WeixinJSBridgeReady', function onBridgeReady() {
        WeixinJSBridge.call('hideToolbar');
    });
</script>
<script type="text/javascript" src="./cet_files/jquery.min.js"></script>
<script type="text/javascript" src="./cet_files/main.js"></script>

</body></html>