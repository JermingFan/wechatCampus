<?php
require_once ('./BaeMemcache.class.php');
/*Cache配置信息，可查询Cache详情页*/
$cacheid = 'xxx';
$host = 'cache.duapp.com';
$port = '20243';
$user = 'xxx';
$pwd = 'xxx';
$mem = new BaeMemcache($cacheid,$host. ': '. $port, $user, $pwd);
$mem->set("key","value");
echo $mem->get("key");
else echo "error";
?>
