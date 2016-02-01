<?php 
function _zxgg()
{
    $url  = 'http://www.shnu.edu.cn/IndexPage.html';  //这儿填页面地址
    $info = file_get_contents($url);
    header("Content-type: text/html; charset=utf-8");
    preg_match_all('|black" title="(.*?)"|i',$info,$m);
    preg_match_all('|class="viewsblack".+?href="(.*?)"|is',$info,$n);
    $news   = array();
    $news[] = array('Title' => "最新公告", 'Description' =>'', 'PicUrl' => 'http://1.shnuzs.sinaapp.com/images/newsPic1.jpg', 'Url' => "http://m.baidu.com/from=1097d/bd_page_type=1/ssid=0/uid=0/pu=usm%400%2Csz%401320_2001%2Cta%40iphone_1_5.1_3_534/baiduid=CA4D2C10847CE4AF6D88E201861BB22B/w=0_10_shnu/t=iphone/l=3/tc?m=8&srd=1&dict=21&language=zh-CN&src=http%3A%2F%2Fwww.shnu.edu.cn%2FDefault.aspx%3Ftabid%3D2564");
    for ($i = 8; $i <=14; $i++)
    {
        $news[] = array
            (
                'Title' => $m[1][$i],
                'Description' => '',
                'PicUrl' => 'http://1.shnuzs.sinaapp.com/images/shnuicon.png',
                'Url' => "http://www.shnu.edu.cn". str_replace('amp;', '', $n[1][$i]) 
            //'Url' => "http://m.baidu.com/from=1097d/bd_page_type=1/ssid=0/uid=0/pu=usm%400%2Csz%401320_2001%2Cta%40iphone_1_5.1_3_534/baiduid=CA4D2C10847CE4AF6D88E201861BB22B/w=0_10_shnu/t=iphone/l=3/tc?m=8&srd=1&dict=21&src=http%3A%2F%2Fwww.shnu.edu.cn". strtr($n[1][$i], "["=>"%5B", "]"=>"%5D", "/"=>"%2F", "?"=>"%3F", "="=>"%3D", "&amp;"=>"%26") 
            );
    }
    //print_r($news);
    return $news;
}
?>