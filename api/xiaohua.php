<?php
session_start();
header('Content-Type: text/html; charset=utf-8');

$content = $this->message['content'];


if(!strncasecmp($_SESSION['sel'], "校花", 6)&&!strncasecmp($content, "P", 1)){
  $lines = $_SESSION['pages']*8+8;
  $_SESSION['pages'] = $_SESSION['pages']+1;
  $b = array();
  $res = file_get_contents("http://www.facejoking.com/api/top/2016/0/1");
  $xiaohua = json_decode($res,true);
  for($id=$lines;$id<$lines+8;$id++){
    $pic = "http://www.facejoking.com/pic/{$xiaohua[data][$id][pid]}.jpg";
    $url = "http://www.facejoking.com/people/{$xiaohua[data][$id][pid]}";
    $name = $xiaohua[data][$id][name];
    $rank = $xiaohua[data][$id][rank];
    if(!$name) break;
    $b[]=array("title"=>'TOP'.$rank.' '.$name,"url"=>$url,"picurl"=>$pic,"description"=>'');
  }
  if($xiaohua[data][$id][rank]) $b[]=array("title"=>'点击此处查看更多
你还可以回复【校草】查看校草排名
---------------
[输入0返回主页]',"url"=>'http://www.facejoking.com/top/2016/0/',"picurl"=>'',"description"=>'');
    else session_destroy();
    return $this->respNews($b); 
  }
else if($content == '校花'){
  $_SESSION['sel'] = '校花';
  $_SESSION['pages'] = 0;
  $b = array();
  $res = file_get_contents("http://www.facejoking.com/api/top/2016/0/1");
  $xiaohua = json_decode($res,true);
  $b[]=array("title"=>'上师大校花TOP100：
  (数据实时同步facejoking)',"url"=>'',"picurl"=>'',"description"=>'');
  for($id=0;$id<8;$id++){
    $pic = "http://www.facejoking.com/pic/{$xiaohua[data][$id][pid]}.jpg";
    $url = "http://www.facejoking.com/people/{$xiaohua[data][$id][pid]}";
    $name = $xiaohua[data][$id][name];
    $rank = $xiaohua[data][$id][rank];
    $b[]=array("title"=>'TOP'.$rank.' '.$name,"url"=>$url,"picurl"=>$pic,"description"=>'');
  }
  $b[]=array("title"=>'点击此处查看更多
你还可以回复【校草】查看校草排名
---------------
[输入0返回主页]',"url"=>'http://www.facejoking.com/top/2016/0/',"picurl"=>'',"description"=>'');
    return $this->respNews($b); 

}
if(!strncasecmp($_SESSION['sel'], "校草", 6)&&!strncasecmp($content, "P", 1)){
  $lines = $_SESSION['pages']*8+8;
  $_SESSION['pages'] = $_SESSION['pages']+1;
  $b = array();
  $res = file_get_contents("http://www.facejoking.com/api/top/2016/1/1");
  $xiaohua = json_decode($res,true);
  for($id=$lines;$id<$lines+8;$id++){
    $pic = "http://www.facejoking.com/pic/{$xiaohua[data][$id][pid]}.jpg";
    $url = "http://www.facejoking.com/people/{$xiaohua[data][$id][pid]}";
    $name = $xiaohua[data][$id][name];
    $rank = $xiaohua[data][$id][rank];
    if(!$name) break;
    $b[]=array("title"=>'TOP'.$rank.' '.$name,"url"=>$url,"picurl"=>$pic,"description"=>'');
  }
  if($xiaohua[data][$id][rank]) $b[]=array("title"=>'点击此处查看更多
你还可以回复【校花】查看校花排名
---------------
[输入0返回主页]',"url"=>'http://www.facejoking.com/top/2016/1/',"picurl"=>'',"description"=>'');
    return $this->respNews($b); 
  }
else if($content == '校草'){
  $_SESSION['sel'] = '校草';
  $_SESSION['pages'] = 0;
  $b = array();
  $res = file_get_contents("http://www.facejoking.com/api/top/2016/1/1");
  $xiaohua = json_decode($res,true);
  $b[]=array("title"=>'上师大校草TOP100：
  (数据实时同步facejoking)',"url"=>'',"picurl"=>'',"description"=>'');
  for($id=0;$id<8;$id++){
    $pic = "http://www.facejoking.com/pic/{$xiaohua[data][$id][pid]}.jpg";
    $url = "http://www.facejoking.com/people/{$xiaohua[data][$id][pid]}";
    $name = $xiaohua[data][$id][name];
    $rank = $xiaohua[data][$id][rank];
    $b[]=array("title"=>'TOP'.$rank.' '.$name,"url"=>$url,"picurl"=>$pic,"description"=>'');
  }
  $b[]=array("title"=>'点击此处查看更多
你还可以回复【校花】查看校花排名
---------------
[输入0返回主页]',"url"=>'http://www.facejoking.com/top/2016/1/',"picurl"=>'',"description"=>'');
    return $this->respNews($b); 

}
else return $this->respText('error');

?>