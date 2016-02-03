<html>
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0" />
    <center><h2><?php echo $_GET[title]; ?></h2></center>
  <?php
// 1. 初始化
$ch = curl_init();
// 2. 设置选项，包括URL//$_GET[url]是推送给用户的消息链接中传递过来的对应书的网址
curl_setopt($ch, CURLOPT_URL, $_GET[url]);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_HEADER, 0);
// 3. 执行并获取HTML文档内容
$output = curl_exec($ch);
// 4. 释放curl句柄
curl_close($ch);
$pattern = '/<table.*?>(.+?)<\/table>/is';//抽取只有索书号和位置信息的部分，方便浏览
preg_match($pattern, $output, $match);
echo $match[0];
?>
</html> 