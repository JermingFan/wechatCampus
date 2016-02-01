<?php
function _sdyw()
{
    $url  = 'xxx';
    $info = file_get_contents($url);
    header("Content-type: text/html; charset=utf-8");
    preg_match_all('|black" title="(.*?)"|i',$info,$m);
    preg_match_all('|class="viewsblack".+?href="(.*?)"|is',$info,$n);
    $news   = array();
    $news[] = array('Title' => "师大要闻", 'Description' =>'', 'PicUrl' => 'http://1.shnuzs.sinaapp.com/images/newsPic2.jpg', 'Url' => "xxx");
    for ($i = 0; $i <=7; $i++)
    {
        $news[] = array
        (
            'Title' => $m[1][$i],
            'Description' => '',
            'PicUrl' => 'http://1.shnuzs.sinaapp.com/images/shnuicon.png',
            'Url' => "xxxx". str_replace('amp;', '', $n[1][$i])
        );
    }
    //print_r($news);
    return $news;
}
?>