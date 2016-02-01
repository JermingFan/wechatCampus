<?php
function _cet($keyword)
{
   	$id=substr($keyword,0,15);
	$name=substr($keyword,15);
	$ch = curl_init();
	$url ="http://www.chsi.com.cn/cet/query?zkzh={$id}&xm={$name}";
	curl_setopt ($ch, CURLOPT_REFERER, "http://www.chsi.com.cn ");		 //模拟来源
	curl_setopt($ch, CURLOPT_URL, $url);			//url  
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	$a = curl_exec($ch);
	$match="#<t[hd].*?>(.*?)</t[hd]>#is";
	preg_match_all($match,$a,$b);
	$b[1][13] = preg_replace('/\s/', '', strip_tags($b[1][13]));
    /*print_r($b[1][3]);
	print_r($b[1][5]);
	print_r($b[1][7]);
	print_r($b[1][12]);
	print_r($b[1][13]);*/
    $yourname= $b[1][3];
    $school= $b[1][5];
    $cet= $b[1][7];
    $score= $b[1][13];
	return array('school'=>$school,'name'=>$yourname,'cet'=>$cet,'score'=>$score);
}
?>