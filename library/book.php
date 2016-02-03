<?php
require_once './BaeMemcache.class.php';

function _book($from_Content,$fromUsername,$toUsername,$time)
{
    ini_set('default_charset','utf-8');
// 1. 初始化
    /*Cache配置信息，可查询Cache详情页*/
    $cacheid = 'XXX';
    $host = 'cache.duapp.com';
    $port = '20243';
    $user = 'XXX';
    $pwd = 'XXX';
    $mc = new BaeMemcache($cacheid,$host. ': '. $port, $user, $pwd);
//以下的几个语句，用作拥有自定义菜单的，可以设置对书名，作者，任意词对应查询，当然需要在消息处理页面设置对应memcache

// 2. 设置选项，包括URL
    $sch_url="http://202.121.55.6:8080/opac/";
    $type=any;
    $shu=120;

    curl_setopt($ch, CURLOPT_URL, $sch_url."openlink.php?strSearchType=title&match_flag=forward&historyCount=1&strText=".$from_Content."&doctype=ALL&displaypg=120&showmode=list&sort=CATA_DATE&orderby=desc&location=ALL");

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HEADER, 0);
// 3. 执行并获取HTML文档内容
    $output = curl_exec($ch);
// 4. 释放curl句柄
    curl_close($ch);
    $key=$from_Content;

    $pattern = '/<table.*?>(.+?)<\/table>/is';//正则表达式，不同的图书馆根据代码内容可对应修改
    preg_match($pattern, $output, $match);
//$match[0] 即为<table></table>之间代码

//然后再提取<tr></tr>之间的内容
    $pattern = '/<tr.*?>(.+?)<\/tr>/is';

    preg_match_all($pattern, $match[0], $results,PREG_SET_ORDER);

    $s=$results;


    for ($i=1; $i<=120; $i++)//微信多图文一次只能传递10个图文，所以进行限制
    {

        $pattern = '/<a href=.*?>(.+?)<\/a>/is';//书名
        preg_match_all($pattern, $s[$i-1][1], $results,PREG_SET_ORDER);
        $arr_title[$i]=html_entity_decode($results[0][1], ENT_QUOTES,'utf-8');
        $pattern1 = '/<\/span.*?>(.+?)<br.*?>/is';//作者
        preg_match_all($pattern1, $s[$i-1][1], $results,PREG_SET_ORDER);
        $arr_zuozhe[$i]= html_entity_decode($results[1][1], ENT_QUOTES,'utf-8');
        $preg='/<a .*?href="(.*?)".*?>/is';//提取链接
        preg_match_all($preg, $s[$i-1][1], $results,PREG_SET_ORDER);
        $arr_url[$i]="http://202.121.55.6:8080/opac/".$results[0][1];
    }

    memcache_set($mc,$from_Content."_title",$arr_title);
    memcache_set($mc,$from_Content."_zuozhe",$arr_zuozhe);
    memcache_set($mc,$from_Content."_url",$arr_url);
//计算出有多少结果
    $count;
    for ($i=10; $i>=0; $i--)
    {
        if($arr_title[$i])
        { $count=$i;
            break;
        }
        else continue;
    }
    $from_Content=URLEncode($from_Content);//经测试微信图文链接无法传递汉字参数
    if($count>=10)//多余10个结果就在最后一个图文添加查看更多
    {
        $resultStr="<xml>
           <ToUserName><![CDATA[".$fromUsername."]]></ToUserName>
           <FromUserName><![CDATA[".$toUsername."]]></FromUserName>
<CreateTime>$time</CreateTime>
<MsgType><![CDATA[news]]></MsgType>
<ArticleCount>$count</ArticleCount>
<Articles>


<item>
           <Title><![CDATA[1.".$arr_title[1]."  --".$arr_zuozhe[1]."]]></Title> 
         <PicUrl><![CDATA[http://1.shnupartner.sinaapp.com/images/lib.png]]></PicUrl> 
         <Url><![CDATA[http://shnucs.duapp.com/library/lib_data.php?url=".$arr_url[1]."&title=".URLEncode($arr_title[1])."]]></Url>
</item>

<item>
     <Title><![CDATA[2.".$arr_title[2]."  --".$arr_zuozhe[2]."]]></Title> 
      
    <Url><![CDATA[http://shnucs.duapp.com/library/lib_data.php?url=".$arr_url[2]."&title=".URLEncode($arr_title[2])."]]></Url>
</item>
<item>
     <Title><![CDATA[3.".$arr_title[3]."  --".$arr_zuozhe[3]."]]></Title>   
    <Url><![CDATA[http://shnucs.duapp.com/library/lib_data.php?url=".$arr_url[3]."&title=".URLEncode($arr_title[3])."]]></Url>
</item>
<item>
    <Title><![CDATA[4.".$arr_title[4]."  --".$arr_zuozhe[4]."]]></Title>       
    <Url><![CDATA[http://shnucs.duapp.com/library/lib_data.php?url=".$arr_url[4]."&title=".URLEncode($arr_title[4])."]]></Url>
</item>
<item>
     <Title><![CDATA[5.".$arr_title[5]."  --".$arr_zuozhe[5]."]]></Title> 
    <Url><![CDATA[http://shnucs.duapp.com/library/lib_data.php?url=".$arr_url[5]."&title=".URLEncode($arr_title[5])."]]></Url>
</item>
<item>
     <Title><![CDATA[6.".$arr_title[6]."  --".$arr_zuozhe[6]."]]></Title> 
    
    <Url><![CDATA[http://shnucs.duapp.com/library/lib_data.php?url=".$arr_url[6]."&title=".URLEncode($arr_title[6])."]]></Url>
</item>
<item>
     <Title><![CDATA[7.".$arr_title[7]."  --".$arr_zuozhe[7]."]]></Title> 
    
    <Url><![CDATA[http://shnucs.duapp.com/library/lib_data.php?url=".$arr_url[7]."&title=".URLEncode($arr_title[7])."]]></Url>
</item>
<item>
     <Title><![CDATA[8.".$arr_title[8]."  --".$arr_zuozhe[8]."]]></Title>      
    <Url><![CDATA[http://shnucs.duapp.com/library/lib_data.php?url=".$arr_url[8]."&title=".URLEncode($arr_title[8])."]]></Url>
</item>
<item>
    <Title><![CDATA[9.".$arr_title[9]."  --".$arr_zuozhe[9]."]]></Title> 
    
    <Url><![CDATA[http://shnucs.duapp.com/library/lib_data.php?url=".$arr_url[9]."&title=".URLEncode($arr_title[9])."]]></Url>
</item>
<item>
    <Title><![CDATA[点击查看更多相关书籍]]></Title>
      
    <Url><![CDATA[http://shnucs.duapp.com/library/more.php?key=".$from_Content."&sch_url=".$sch_url."&type=".$type."]]></Url>
</item>



</Articles>
</xml>  ";
        echo $resultStr;
        exit;

    }
    else {
        $resultStr="<xml>
           <ToUserName><![CDATA[".$fromUsername."]]></ToUserName>
           <FromUserName><![CDATA[".$toUsername."]]></FromUserName>
<CreateTime>.time().</CreateTime>
<MsgType><![CDATA[news]]></MsgType>
<ArticleCount>$count</ArticleCount>
<Articles>

<item>
           <Title><![CDATA[1.".$arr_title[1]."  --".$arr_zuozhe[1]."]]></Title> 
         <PicUrl><![CDATA[http://1.shnupartner.sinaapp.com/images/lib.png]]></PicUrl> 
         <Url><![CDATA[http://1.shnupartner.sinaapp.com/library/lib_data.php?url=".$arr_url[1]."&title=".URLEncode($arr_title[1])."]]></Url>
</item>

<item>
     <Title><![CDATA[2.".$arr_title[2]."  --".$arr_zuozhe[2]."]]></Title> 
      
    <Url><![CDATA[http://1.shnupartner.sinaapp.com/library/lib_data.php?url=".$arr_url[2]."&title=".URLEncode($arr_title[2])."]]></Url>
</item>
<item>
     <Title><![CDATA[3.".$arr_title[3]."  --".$arr_zuozhe[3]."]]></Title>   
    <Url><![CDATA[http://1.shnupartner.sinaapp.com/library/lib_data.php?url=".$arr_url[3]."&title=".URLEncode($arr_title[3])."]]></Url>
</item>
<item>
    <Title><![CDATA[4.".$arr_title[4]."  --".$arr_zuozhe[4]."]]></Title>       
    <Url><![CDATA[http://1.shnupartner.sinaapp.com/library/lib_data.php?url=".$arr_url[4]."&title=".URLEncode($arr_title[4])."]]></Url>
</item>
<item>
     <Title><![CDATA[5.".$arr_title[5]."  --".$arr_zuozhe[5]."]]></Title> 
    <Url><![CDATA[http://1.shnupartner.sinaapp.com/library/lib_data.php?url=".$arr_url[5]."&title=".URLEncode($arr_title[5])."]]></Url>
</item>
<item>
     <Title><![CDATA[6.".$arr_title[6]."  --".$arr_zuozhe[6]."]]></Title> 
    
    <Url><![CDATA[http://1.shnupartner.sinaapp.com/library/lib_data.php?url=".$arr_url[6]."&title=".URLEncode($arr_title[6])."]]></Url>
</item>
<item>
     <Title><![CDATA[7.".$arr_title[7]."  --".$arr_zuozhe[7]."]]></Title> 
    
    <Url><![CDATA[http://1.shnupartner.sinaapp.com/library/lib_data.php?url=".$arr_url[7]."&title=".URLEncode($arr_title[7])."]]></Url>
</item>
<item>
     <Title><![CDATA[8.".$arr_title[8]."  --".$arr_zuozhe[8]."]]></Title>      
    <Url><![CDATA[http://1.shnupartner.sinaapp.com/library/lib_data.php?url=".$arr_url[8]."&title=".URLEncode($arr_title[8])."]]></Url>
</item>
<item>
    <Title><![CDATA[9.".$arr_title[9]."  --".$arr_zuozhe[9]."]]></Title> 
    
    <Url><![CDATA[http://1.shnupartner.sinaapp.com/library/lib_data.php?url=".$arr_url[9]."&title=".URLEncode($arr_title[9])."]]></Url>
</item>
<item>
    <Title><![CDATA[9.".$arr_title[10]."  --".$arr_zuozhe[10]."]]></Title> 
    
    <Url><![CDATA[http://1.shnupartner.sinaapp.com/library/lib_data.php?url=".$arr_url[10]."&title=".URLEncode($arr_title[10])."]]></Url>
</item>
</Articles>
</xml>  ";
        echo $resultStr;
        exit;

    }
}