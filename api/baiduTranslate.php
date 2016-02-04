<?php
$apikey='';
$about = "<a href=\"http://fanyi.baidu.com/translate#auto/zh/\">更多翻译</a> ";
$content = preg_replace('/^翻译/', '', $this->message['content']);
$content = trim($content);
// $content = 'today';
if ($content) {
    $url = 'http://openapi.baidu.com/public/2.0/bmt/translate?client_id='.$apikey.'&q='.urlencode($content).'&from=auto&to=auto';
    $data = file_get_contents($url);
    $rs_arry = json_decode($data,true);
    if ($rs_arry['error_code']) {
        $result = "翻译系统异常，请稍候尝试！";
    } else {
        foreach ($rs_arry['trans_result'] as $value) {
            $result.=$value['dst'];
        }
    }
} else {
    $result = "师大小伙伴提供专业的多语言翻译服务，目前支持多种翻译方向\n    中 -> 英\n    英 -> 中\n    日 -> 中\n使用示例：\n    翻译你好
翻译partner\n\n".$about;
}
return $this->respText($result);