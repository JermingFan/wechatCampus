<?php 
$matchs = array();
$ret = preg_match('/^(?P<express>申通|圆通|中通|汇通|韵达|顺丰|ems) *(?P<sn>[a-z\d]{1,})$/i', $this->message['content'], $matchs);
if(!$ret) {
	return $this->respText('请输入合适的格式
快递公司+空格+单号
(当前支持申通,圆通,中通,汇通,韵达,顺丰,EMS)
例如: 申通 2309381801【中间加空格】
或<a href="http://m.kuaidi100.com/uc/index.html">点我查【全部】快递哦~</a>
---------------
[输入0返回主页]');
}
$express = $matchs['express'];
$sn = $matchs['sn'];
$mappings = array(
	'申通' => 'shentong',
	'圆通' => 'yuantong',
	'中通' => 'zhongtong',
	'汇通' => 'huitongkuaidi',
	'韵达' => 'yunda',
	'顺丰' => 'shunfeng',
	'ems' => 'ems',
);
$code = $mappings[$express];
$url = "http://www.kuaidi100.com/query?type={$code}&postid={$sn}";

$dat = ihttp_get($url);
$msg = '';
if(!empty($dat) && !empty($dat['content'])) {
	$traces = json_decode($dat['content'], true);
	if(is_array($traces)) {
		if($traces['message']) {
			$msg = $traces['message'];
		}
		$traces = $traces['data'];
		if(is_array($traces)) {
			$traces = array_reverse($traces);
			$reply = '';
			foreach($traces as $trace) {
				$reply .= "{$trace['time']} - {$trace['context']}\n";
			}
			if(!empty($reply)) {
				$replys = array();
				$replys[] = array(
					'title' => '已经为你查到相关快递记录',
					'picurl' => $GLOBALS['_W']['siteroot'] . '/source/modules/userapi/images/'.$code.'.png',
					'description' => $reply,
				);
				return $this->respNews($replys);
				$reply = "已经为你查到相关快递记录: \n" . $reply;
				return $this->respText($reply);
			}
		}
	}
}
if($msg) {
	$msg = ', 错误信息为: ' . $msg;
}
return $this->respText('没有查找到相关的数据' . $msg . '. 请检查您的输入格式, 正确格式为: 快递公司+空格+单号, 例如: 申通 2309381801');

