<?php
function _post($fromUsername)
{
    $cookie_file = tempnam('./temp','cookie');
    $login_url   = 'xxx';
    $ch          = curl_init($login_url);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_fields);
    curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie_file);
    $contents = curl_exec($ch);
    preg_match_all('/<input type="hidden" name="__VIEWSTATE" id="__VIEWSTATE" value="(.+?)"/is',$contents,$arr);
    $VIEWSTATE = $arr[1][0];
    preg_match_all('/<input type="hidden" name="__EVENTVALIDATION" id="__EVENTVALIDATION" value="(.+?)"/is',$contents,$arr);
    $EVENTVALIDATION = $arr[1][0];
    preg_match_all('/<input type="hidden" name="__VIEWSTATEGENERATOR" id="__VIEWSTATEGENERATOR" value="(.+?)"/is',$contents,$arr);
    $VIEWSTATEGENERATOR = $arr[1][0];
    curl_close($ch);
    require_once './sql.php';
    $sql = "SELECT stu_no, stu_wd FROM students WHERE from_user = '$fromUsername'";
    $result = _select_data($sql);
    $rows = mysql_fetch_array($result);
    $user        = $rows[stu_no];
    $password    = $rows[stu_wd];
    $cookie_file = tempnam('./temp','cookie');
    $url   = 'xxx';
    $post_fields = array("__VIEWSTATE"=>
        $VIEWSTATE,"__EVENTVALIDATION"=>$EVENTVALIDATION,"__VIEWSTATEGENERATOR"=>$VIEWSTATEGENERATOR,"btnLogin"=>"登录","txtUserID"=>$user,"txtUserPwd"=>$password);
    $ch          = curl_init($url);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    $header[] = 'xxx';
    $header[] = 'User-Agent: Mozilla/5.0 (Windows NT 6.1; rv:28.0) Gecko/20100101 Firefox/28.0';
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_fields);
    curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie_file);
    curl_exec($ch);
    curl_close($ch);
    $url = 'xxx';
    $ch  = curl_init($url);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie_file);
    $header[] = 'xxx';
    $header[] = 'User-Agent: Mozilla/5.0 (Windows NT 6.1; rv:28.0) Gecko/20100101 Firefox/28.0';
    $contents = curl_exec($ch);
    $td=get_td_array($contents);
    foreach($td as $v)
    {
        if($v[10])
        {
            $table.="$v[9]===$v[1]===$v[5]"."\n";
        }
    }
    return $table;

}

function get_td_array($table)
{
    //$table = array();
    $table = preg_replace("/<table[^>]*?>/is","",$table);
    $table = preg_replace("/<tr[^>]*?>/si","",$table);
    $table = preg_replace("/<td[^>]*?>/si","",$table);
    $table = str_replace("</tr>","{tr}",$table);
    $table = str_replace("</td>","{td}",$table);
    //去掉 HTML 标记
    $table = preg_replace("'<[/!]*?[^<>]*?>'si","",$table);
    //去掉空白字符
    $table = preg_replace("'([rn])[s]+'","",$table);
    $table = str_replace(" ","",$table);
    $table = str_replace(" ","",$table);
    $table = str_replace("&nbsp;","",$table);
    $table = explode('{tr}', $table);
    array_pop($table);
    foreach ($table as $key=>$tr)
    {
        $td = explode('{td}', $tr);
        $td = explode('{td}', $tr);
        array_pop($td);
        $td_array[] = $td;
    }
    return $td_array;
}
?>