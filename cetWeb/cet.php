<html>
<head>
    <meta charset=UTF-8">
    <title>师大小伙伴</title>
    <meta name="viewport" content="width=device-width,height=device-height,inital-scale=1.0,maximum-scale=1.0,user-scalable=no;">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="format-detection" content="telephone=no">
    <link href="./cet_files/cet.css" rel="stylesheet" type="text/css">
    <style>
        .deploy_ctype_tip{z-index:1001;width:100%;text-align:center;position:fixed;top:50%;margin-top:-23px;left:0;}.deploy_ctype_tip p{display:inline-block;padding:13px 24px;border:solid #d6d482 1px;background:#f5f4c5;font-size:16px;color:#8f772f;line-height:18px;border-radius:3px;}
    </style>
</head>

<body id="wrap">
<div class="banner">
    <div id="wrapper">
        <div id="scroller" style="float:none">
            <ul id="thelist">
                <img src="./cet_files/logo.jpg" alt="" style="width:100%">
            </ul>
        </div>
    </div>
    <div class="clr"></div>
</div>
<div class="cardexplain">
    <ul class="round">
        <li>
            <h2>全国大学英语四六级考试成绩查询</h2>
            <div class="text">
                查询方法<br>
                ①搜索并关注公众号“师大小伙伴”<br>
                ②发送文字“四六级”进行查询<br>
                <br>提醒：<br>
                成绩查询范围是上次四六级成绩<br>
                例如当前查的是2014年12月的<br>
                则不能查询2013年12月和之前的<br>
            </div>
        </li>
    </ul>
    <form method="post" action="result.php" id="form" onsubmit="return tgSubmit()">
        <ul class="round">
            <li class="title mb"><span class="none">查分入口</span></li>
            <li class="nob">
                <table width="100%" border="0" cellspacing="0" cellpadding="0" class="kuang">
                    <tbody>
                    <tr>
                        <th>姓名</th>
                        <td><input type="text" class="px" maxlength="3" placeholder="请输入姓名" id="name" name="name" value="">
                        </td>
                    </tr>
                    </tbody>
                </table>
            </li>
            <li class="nob">
                <table width="100%" border="0" cellspacing="0" cellpadding="0" class="kuang">
                    <tbody>
                    <tr>
                        <th>准考试号</th>
                        <td><input type="text" class="px" placeholder="请输入15位准考证号" id="number" name="number" value="">
                        </td>
                    </tr>
                    </tbody>
                </table>
            </li>
        </ul>
        <div class="footReturn" style="text-align:center">
            <input type="hidden" name="appkey" value="trialuser">
            <input type="submit" style="margin:0 auto 20px auto;width:90%" class="submit" value="提交查询">
        </div>
    </form>
</div>
<script type="text/javascript" src="./cet_files/jquery.min.js"></script>
<script type="text/javascript" src="./cet_files/main.js"></script>
<script type="text/javascript">
    document.addEventListener('WeixinJSBridgeReady', function onBridgeReady() {
        WeixinJSBridge.call('hideToolbar');
    });
    function showTip(tipTxt) {
        var div = document.createElement('div');
        div.innerHTML = '<div class="deploy_ctype_tip"><p>' + tipTxt + '</p></div>';
        var tipNode = div.firstChild;
        $("#wrap").after(tipNode);
        setTimeout(function () {
            $(tipNode).remove();
        }, 1500);
    }
    function tgSubmit(){
        var name=$("#name").val();
        if($.trim(name) == ""){
            showTip('请输入姓名')
            return false;
        }
        var number=$("#number").val();
        if($.trim(number) == ""){
            showTip('请输入准考证号')
            return false;
        }
        var patrn = /^[0-9]{15}$/;
        if (!patrn.exec($.trim(number))) {
            showTip('请正确输入准考证号')
            return false;
        }
        return true;
    }
</script>

</body>
</html>