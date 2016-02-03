<?php 
$url = 'http://news.163.com/special/00011K6L/rss_newstop.xml';

$resp = ihttp_get($url);
if ($resp['code'] = 200 && $resp['content']) {
	$obj = simplexml_load_string($resp['content'], 'SimpleXMLElement', LIBXML_NOCDATA);
	$news = array();
	$news[] = array('title' => '网易头条新闻', 'description' => '网易门户新闻中心', 'url' => 'http://news.163.com', 'picurl' => 'http://cimg.163.com/news/0408/20/netease-logo.gif');
	$cnt = min(count($obj->channel->item), 8);
	for($i = 0; $i < $cnt; $i++) {
		$row = $obj->channel->item[$i];
		$news[] = array(
			'title' => strval($row->title),
			'description' => strval($row->description),
			'picurl' => '',
			'url' => strval($row->link)
		);
	}
	return $this->respNews($news);

}
return $this->respText('没有找到结果, 要不过一会再试试?');
