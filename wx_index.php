<?php
require_once './sql.php';
//require_once './robot.php';
require_once './sdyw.php';
require_once './zxgg.php';
require_once './cet.php';
require_once './scenery.php';
require_once './library/book.php';
require_once './stu.php';
define("TOKEN", "weixin");
$wechatObj = new wechatCallbackapiTest();
$wechatObj->responseMsg();
class wechatCallbackapiTest {
    public function valid() {
        $echoStr = $_GET["echostr"];
        //valid signature , option
        if ($this->checkSignature()) {
            echo $echoStr;
            exit;
        }
    }
    public function responseMsg() {
        //get post data, May be due to the different environments
        $postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
        //extract post data
        if (!empty($postStr)) {
            $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
            $fromUsername = $postObj->FromUserName;
            $toUsername = $postObj->ToUserName;
            $keyword = trim($postObj->Content);
            $time = time();
            $event = $postObj->Event;
            /******************************************* 文字信息模板 ***********************************************************/
            $textTpl = "<xml>
                            <ToUserName><![CDATA[%s]]></ToUserName>
                            <FromUserName><![CDATA[%s]]></FromUserName>
                            <CreateTime>%s</CreateTime>
                            <MsgType><![CDATA[text]]></MsgType>
                            <Content><![CDATA[%s]]></Content>
                            </xml>";
            /******************************************* 图文信息模板 ***********************************************************/
            $imageTpl = "<xml>
                            <ToUserName><![CDATA[%s]]></ToUserName>
                            <FromUserName><![CDATA[%s]]></FromUserName>
                            <CreateTime>%s</CreateTime>
                            <MsgType><![CDATA[news]]></MsgType>//消息类型为news（图文）
                            <ArticleCount>1</ArticleCount>//图文数量为1（单图文）
                            <Articles>
                            <item>//第一张图文消息
                            <Title><![CDATA[%s]]></Title> //标题
                            <Description><![CDATA[%s]]></Description>//描述
                            <PicUrl><![CDATA[%s]]></PicUrl>//打开前的图片链接地址
                            <Url><![CDATA[%s]]></Url>//点击进入后显示的图片链接地址
                            </item>
                            </Articles>
                            </xml> ";
            /********************************************* 关注事件 **************************************************************/
            if (!empty($event)) {
                /* $sql = "insert into sleep_man (`from_user`,`flag`) VALUES ('$fromUsername',0)";
                 _insert_data($sql);*/
                $contentStr = "发送对应数字或关键词进行使用：\n【1】师大要闻\n【2】最新公告\n【3】查询成绩[需绑定]\n【4】查询四六级成绩\n【5】查询图书馆藏书\n【6】在线翻译\n【7】校园地图\n【8】查询快递单号\n【9】睡觉签到[8~12点]\n【10】玩游戏\n【11】阅览新闻\n【12】微社区[荐]\n【#】取消学号绑定\n【0】返回主界面\n" . '<a href="http://1.shnupartner.sinaapp.com/stu.php?openid=' . $postObj->FromUserName . '">绑定教务使用全部功能</a>' . "\n-----------------------\n此外你还可以尝试发送如：奉贤天气、火车票、飞机票等关键词~\n更多的彩蛋等待着你的发现*^_^* \n[注]:由于手机屏幕、字体大小等因素，小伙伴发送的消息样式无法做到统一，但不影响功能使用，敬请谅解。\n问题反馈及合作请发送邮件至\nff66@vip.qq.com\n<!-- Thanks -->";
                $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $contentStr);
                echo $resultStr;
            }
            /******************************************************  判断用户状态，若状态与上次不一致，则删除上次状态  **********************************************************/
            $sql = "SELECT flag_id FROM user_flags WHERE from_user = '$fromUsername'";
            $result = _select_data($sql);
            while (!!$rows = mysql_fetch_array($result)) {
                $user_flag = $rows[flag_id];
            }
            if (trim($keyword) <> $user_flag && is_numeric($keyword)) {
                $user_flag = '';
                $sql = "DELETE FROM user_flags WHERE from_user = '$fromUsername'";
                _delete_data($sql);
            }
            /*********************************************** flag为空时，选择的路径 **************************************/
            if (empty($user_flag)) {
                //要闻
                if ($keyword == '1' || $keyword == "要闻" || $keyword == "师大要闻") {
                    $items = _sdyw();
                    $itemTpl = "<item>
                                    <Title><![CDATA[%s]]></Title>
                                    <Description><![CDATA[%s]]></Description>
                                    <PicUrl><![CDATA[%s]]></PicUrl>
                                    <Url><![CDATA[%s]]></Url>
                                    </item>";
                    $articles = '';
                    foreach ($items as $key) {
                        $articles.= sprintf($itemTpl, $key['Title'], $key['Description'], $key['PicUrl'], $key['Url']);
                    }
                    $newsTpl = "<xml>
                                   <ToUserName><![CDATA[%s]]></ToUserName>
                                   <FromUserName><![CDATA[%s]]></FromUserName>
                                   <CreateTime>%s</CreateTime>
                                   <MsgType><![CDATA[%s]]></MsgType>
                                   <ArticleCount><![CDATA[%s]]></ArticleCount>
                                   <Articles>%s</Articles>
                                   </xml>";
                    echo sprintf($newsTpl, $fromUsername, $toUsername, $time, 'news', count($items) , $articles);
                }
                //公告
                else if ($keyword == '2' || $keyword == "公告" || $keyword == "最新公告") {
                    $items = _zxgg();
                    $itemTpl = "<item>
                                    <Title><![CDATA[%s]]></Title>
                                    <Description><![CDATA[%s]]></Description>
                                    <PicUrl><![CDATA[%s]]></PicUrl>
                                    <Url><![CDATA[%s]]></Url>
                                    </item>";
                    $articles = '';
                    foreach ($items as $key) {
                        $articles.= sprintf($itemTpl, $key['Title'], $key['Description'], $key['PicUrl'], $key['Url']);
                    }
                    $newsTpl = "<xml>
                                   <ToUserName><![CDATA[%s]]></ToUserName>
                                   <FromUserName><![CDATA[%s]]></FromUserName>
                                   <CreateTime>%s</CreateTime>
                                   <MsgType><![CDATA[%s]]></MsgType>
                                   <ArticleCount><![CDATA[%s]]></ArticleCount>
                                   <Articles>%s</Articles>
                                   </xml>";
                    echo sprintf($newsTpl, $fromUsername, $toUsername, $time, 'news', count($items) , $articles);
                }
                // shudong
                //                     else if ($keyword == '18' || $keyword == "树洞" || $keyword == "吐槽"|| $keyword == "师大树洞"|| $keyword == "表白"|| $keyword == "问答"|| $keyword == "微社区")
                //                     {
                //                         $contentStr = '<a href="http://1.shnushudong.sinaapp.com/w/">点击进入师大树洞(*^__^*) </a>
                // ---------------
                // [输入0返回主页]';
                //                         $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $contentStr);
                //                         echo $resultStr;
                //                     }
                //校园地图
                else if ($keyword == '8' || $keyword == "地图" || $keyword == "校园" || $keyword == "校园地图") {
                    $items = _trip();
                    $itemTpl = "<item>
                                   <Title><![CDATA[%s]]></Title>
                                   <Description><![CDATA[%s]]></Description>
                                   <PicUrl><![CDATA[%s]]></PicUrl>
                                   <Url><![CDATA[%s]]></Url>
                                   </item>";
                    $articles = '';
                    foreach ($items as $key) {
                        $articles.= sprintf($itemTpl, $key['Title'], $key['Description'], $key['PicUrl'], $key['Url']);
                    }
                    $newsTpl = "<xml>
                                    <ToUserName><![CDATA[%s]]></ToUserName>
                                    <FromUserName><![CDATA[%s]]></FromUserName>
                                    <CreateTime>%s</CreateTime>
                                    <MsgType><![CDATA[%s]]></MsgType>
                                    <ArticleCount><![CDATA[%s]]></ArticleCount>
                                    <Articles>%s</Articles>
                                    </xml>";
                    echo sprintf($newsTpl, $fromUsername, $toUsername, $time, 'news', count($items) , $articles);
                }
                // 成绩查询（post函数在主页）
                else if ($keyword == '3' || $keyword == "成绩" || $keyword == "查成绩" || $keyword == "查询成绩" || $keyword == "考试成绩" || $keyword == "成绩查询") {
                    $sql = "select stu_no,stu_wd from students where from_user = '$fromUsername'";
                    $result = _select_data($sql);
                    if (!!$rows = mysql_fetch_array($result)) {
                        $i = _post($fromUsername);
                        $title = "查询";
                        //标题
                        $PicUrl = "";
                        //图片链接
                        $Description = $i;
                        //图文描述
                        $Url = "";
                        //打开后的图片链接
                        $resultStr = sprintf($imageTpl, $fromUsername, $toUsername, $time, $title, $Description, $PicUrl, $Url);
                        echo $resultStr;
                    } else {
                        // $msgType = "text";
                        $contentStr = '<a href="http://shnucs.duapp.com/stu.php?openid=' . $postObj->FromUserName . '">请先点击绑定学号╮(╯_╰)╭</a>
---------------
[输入0返回主页]';
                        $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $contentStr);
                        echo $resultStr;
                    }
                }
                //四六级查询（二级菜单）
                else if ($keyword == '4' || $keyword == "四六级" || $keyword == "四级" || $keyword == "六级") {
                    $sql = "insert into user_flags(from_user,flag_id) values('$fromUsername','4')";
                    $contentStr = '请输入要您的四级或六级
考号+姓名(无空格)
格式如：12345***123李四
或<a href="http://1.shnuweb.sinaapp.com/siliuji/cet.php">点击此处进入查询~</a>
---------------
[输入0返回主页]';
                    $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $contentStr);
                    echo $resultStr;
                }
                //别踩白块
                else if ($keyword == '19' || $keyword == "最火游戏" || $keyword == "游戏" || $keyword == "玩游戏" || $keyword == "最新游戏") {
                    $contentStr = '点击【每一行】文字进入游戏~
<a href="http://1.shnugame.sinaapp.com/sjm2/index.html">① 围住神经猫Ⅱ</a>
<a href="http://1.shnupartner.sinaapp.com/2048/2048-master/index.html">② 2048</a>
<a href="http://1.shnupartner.sinaapp.com/games/bcbk.html">③ 别踩白块</a>
<a href="http://1.shnugame.sinaapp.com/onedie/index.htm">④ 一个都不能死</a>
---------------
[输入0返回主页]';
                    $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $contentStr);
                    echo $resultStr;
                }
                //校园卡
                else if ($keyword == "校园卡" || $keyword == "9" || $keyword == "校园卡挂失") {
                    $contentStr = '<a href="http://mp.weixin.qq.com/s?__biz=MzA5OTY1NDUyOA==&mid=200492552&idx=1&sn=bcf9597271864cd357a1364c40089999#rd">点击此处进入校园卡挂失๑•ิ .•ั๑</a>
---------------
[输入0返回主页]';
                    $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $contentStr);
                    echo $resultStr;
                }
                //维修
                else if ($keyword == "维修" || $keyword == "数码维修" || $keyword == "手机维修" || $keyword == "电脑维修") {
                    $contentStr = '<a href="https://www.jinshuju.net/f/PdYNu4">点击此处进入数码维修服务๑•ิ .•ั๑</a>
---------------
[输入0返回主页]';
                    $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $contentStr);
                    echo $resultStr;
                }
                // 睡觉
                // else if($keyword == '90' || $keyword == "睡觉" || $keyword == "我要睡觉")
                // {
                //     //查是否睡过
                //     $shijian=strtotime("20:00:00")-time();
                //     if($shijian>0)
                //     {
                //         $sql = "select sleep_num from sleep";
                //         $query=_select_data($sql);
                //         $rs=mysql_fetch_array($query);
                //         $b= $rs['sleep_num'];
                //         if ($b == 0)
                //         {
                //             $contentStr = "哎呀呀~ 不要睡这么早啦 8点之后再睡嘛 出去逛逛吧~";
                //         }
                //         else
                //         {
                //             $sql="UPDATE `sleep` SET `sleep_num`= 0";       //数字不能加‘0’（单引号）
                //             _update_data($sql);
                //             $sql="delete from sleep_man";
                //             _delete_data;
                //             $contentStr = "哎呀呀~ 不要睡这么早啦 8点之后再睡嘛 出去逛逛吧~";
                //         }
                //     }
                //     else
                //     {
                //         $sql="SELECT from_user FROM sleep_man WHERE from_user =  '$fromUsername'";
                //         $query=_select_data($sql);
                //         $rs=mysql_fetch_array($query);
                //         $c= $rs[from_user];
                //         if ($c==$fromUsername)
                //         {
                //             $contentStr = "你肿么又睡觉，今天不是都睡过了嘛,快睡吧~不要这么顽皮 明天还有课呢~";
                //         }
                //         else
                //         {
                //                 $sql="insert into sleep_man (`from_user`) VALUES ('$fromUsername')";
                //                 _insert_data($sql);
                //                 $sql="SELECT `sleep_num` FROM `sleep`";     ////// 查是第几个睡的
                //                 $query=_select_data($sql);
                //                 $rs=mysql_fetch_array($query);
                //                 $b= $rs['sleep_num'];
                //                 $contentStr = "有".$b."个小伙伴比你睡得早哦~";
                //                 $b++;
                //                 $sql="UPDATE `sleep` SET `sleep_num`='$b'";
                //                 _update_data($sql);
                //         }
                //     }
                //     $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $contentStr);
                //     echo $resultStr;
                // }
                //取消绑定学号
                else if ($keyword == '#' || $keyword == "取消绑定" || $keyword == "取消绑定学号") {
                    $sql = "select stu_no from students where from_user = '$fromUsername'";
                    $result = _select_data($sql);
                    $row = mysql_fetch_array($result);
                    $no = $row[stu_no];
                    $sql = "delete from students where from_user = '$fromUsername'";
                    $result = _delete_data($sql);
                    if ($result == 1) {
                        $contentStr = "取消绑定学号" . $no . "成功，重新发送【3】查询成绩进行绑定~~~";
                        $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $contentStr);
                        echo $resultStr;
                    } else {
                        $contentStr = "取消绑定失败，请重新尝试";
                        $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $contentStr);
                        echo $resultStr;
                    }
                }
                //图书
                else if ($keyword == '5' || $keyword == "图书" || $keyword == "图书馆" || $keyword == "图书检索" || $keyword == "图书查询" || $keyword == "查询图书") {
                    $sql = "insert into user_flags(from_user,flag_id) values('$fromUsername','5')";
                    $contentStr = "请输入要查询图书的关键字：\n---------------\n[输入0返回主页]";
                    $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $contentStr);
                    echo $resultStr;
                }
                //秒杀
                // else if ($keyword == "秒杀")
                // {
                //     $shijian=strtotime("2015-05-18 13:00:00")-time();      //
                //     if($shijian>0)
                //     {
                //         $contentStr = "对不起，秒杀还没开始，2013年6月5日21点开始"; //
                //     }
                //     else
                //     {
                //         $sql="SELECT from_user FROM miaosha_man WHERE from_user =  '$fromUsername'";
                //         $query=_select_data($sql);
                //         $rs=mysql_fetch_array($query);
                //         $c= $rs[from_user];
                //         if ($c==$fromUsername)
                //         {
                //            $contentStr = "你已经秒杀过了哦~";
                //         }
                //         else
                //         {
                //            $sql="insert into miaosha_man (`from_user`) VALUES ('$fromUsername')";
                //            $a = _insert_data($sql);
                //            $sql="SELECT `num` FROM `miaosha`";
                //            $query=_select_data($sql);
                //            $rs=mysql_fetch_array($query);
                //            $b= $rs['num'];
                //            if ($b>0)
                //            {
                //                 $contentStr = "恭喜你秒杀成功，凭此条微信"; //
                //                 $b--;
                //                 $sql="UPDATE `miaosha` SET `num`='$b'";
                //                 _update_data($sql);
                //             }
                //             else
                //             {
                //                 $contentStr = "很遗憾，你没有秒杀成功，下次再来吧。。。";
                //             }
                //         }
                //     }
                //     $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $contentStr);
                //     echo $resultStr;
                // }
                // 机器人
                // else
                // {
                //     $contentStr = getXiaoiInfo($fromUsername, $keyword);
                //     $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $contentStr);
                //     echo $resultStr;
                // }
                /************************************* 插入数据 ****************************************/
                if (!empty($sql)) {
                    _insert_data($sql);
                }
            }
            /*************************************************** flag不为空时，选择的路径（二级菜单）*********************************************************/
            else {
                if ($user_flag == '4') //四六级
                {
                    $b = _cet($keyword);
                    $contentStr = "学校：" . $b[school] . "\n" . "姓名：" . $b[name] . "\n" . "等级：" . $b[cet] . "\n" . "分数：" . $b[score];
                    $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $contentStr);
                    echo $resultStr;
                } else if ($user_flag == '5') //图书
                {
                    _book($keyword, $fromUsername, $toUsername, $time);
                    /*$url = "http://202.121.55.6:8080/opac/search_rss.php?location=ALL&title={$keyword}&doctype=ALL&lang_code=ALL&match_flag=forward&displaypg=20&showmode=list&orderby=DESC&sort=CATA_DATE&onlylendable=yes&with_ebook=&with_ebook=";
                    $fa = file_get_contents($url);
                    $f = simplexml_load_string($fa);
                    foreach($f->channel->item as $reply)
                    {
                        foreach($reply->title as $re)
                        {
                            $a[] = $re;
                        }
                    }
                    $no = count($a);
                    if ($no > 10)
                    {
                        $no = 10;   
                    }
                    $bookTpl = 
                        "<xml>
                        <ToUserName><![CDATA[%s]]></ToUserName>
                        <FromUserName><![CDATA[%s]]></FromUserName>
                        <CreateTime>%s</CreateTime>
                        <MsgType><![CDATA[news]]></MsgType>
                        <ArticleCount>$no</ArticleCount>
                        <Articles>";
                    foreach($a as $id=>$b)
                    {
                        if($id>$no) break;
                        else null;
                    $bookTpl.=
                        "<item>
                        <Title>$b</Title> 
                        <Description><![CDATA[s]]></Description>
                        <PicUrl><![CDATA[]]></PicUrl>  
                        <Url><![CDATA[]]></Url>
                        </item>";
                    }
                    $bookTpl.=
                        "</Articles>
                        <FuncFlag>1</FunFlag>
                        </xml>";
                    $resultStr = sprintf($bookTpl, $fromUsername, $toUsername, $time);
                    echo $resultStr;*/
                }
            }
        } else {
            echo "";
            exit;
        }
    }
    private function checkSignature() {
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];
        $token = TOKEN;
        $tmpArr = array(
            $token,
            $timestamp,
            $nonce
        );
        sort($tmpArr, SORT_STRING);
        $tmpStr = implode($tmpArr);
        $tmpStr = sha1($tmpStr);
        if ($tmpStr == $signature) {
            return true;
        } else {
            return false;
        }
    }
}
?>
