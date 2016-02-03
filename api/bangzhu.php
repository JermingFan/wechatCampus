<?php 

	$news = array();
	$news[] = array('title' => "欢迎关注师大小伙伴^_^
请按照各栏目提示进行使用", 'description' => '', 'picurl' =>'', 'url' =>'');
	$news[] = array('title' => "【师大校园】--输入文字或对应数字\n
    [1]师大要闻             [2]最新公告
    [3]考试成绩             [4]四六级
    [5]图书检索             [6]校历
    [7]校园地图             [#]取消绑定", 'description' => '', 'picurl' => '', 'url' => '');
	$news[] = array('title' => "【师大生活】--输入对应文字或关键词\n
    ●快递                        ●二手
    ●天气                        ●失物
    ●百科                        ●翻译
    ●校花                        ●校草
    ●游戏                        ●网易头条", 'description' => '', 'picurl' => '', 'url' => '');
	$news[] = array('title' => "【✐Tips】--输入[0]或[功能]返回主页
[注]:各手机消息排版可能不同,但不影响使用
(WP系统微信版本较低，主页显示有所不同)", 'description' => '', 'picurl' => '', 'url' => '');
	return $this->respNews($news);

?>
