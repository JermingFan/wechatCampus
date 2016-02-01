<?php
function _zxgg()
{
    $url  = 'xxx';
    $info = file_get_contents($url);
    header("Content-type: text/html; charset=utf-8");
    preg_match_all('|black" title="(.*?)"|i',$info,$m);
    preg_match_all('|class="viewsblack".+?href="(.*?)"|is',$info,$n);
    $news   = array();
    $news[] = array('Title' => "最新公告", 'Description' =>'', 'PicUrl' => 'http://1.shnuzs.sinaapp.com/images/newsPic1.jpg', 'Url' => "xxx");
    for ($i = 8; $i <=14; $i++)
    {
        $news[] = array
        (
            'Title' => $m[1][$i],
            'Description' => '',
            'PicUrl' => 'http://1.shnuzs.sinaapp.com/images/shnuicon.png',
            'Url' => "xxx". str_replace('amp;', '', $n[1][$i])
        );
    }
    return $news;
}
?>