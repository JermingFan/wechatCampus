<html>
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
    <title>
        师大小伙伴学号绑定
    </title>
    <link rel="stylesheet" type="text/css" href="style.css" />
</head>
<body>


<?php
$fromUsername=$_GET["openid"];

if(isset($_POST["submit"]))
{
    bangding($fromUsername,urlencode($_POST["txtUserID"]),urlencode($_POST["txtUserPwd"]));
    exit();   /**************跳转到新的页面******************/
}
//$user=$_POST["txtUserID"];
//$password=$_POST["txtUserPwd"];
function bangding($fromUsername,$usersno,$password)
{
    require_once './sql.php';
    $sql = "SELECT stu_no, stu_wd FROM students WHERE from_user = '$fromUsername'";
    $result = _select_data($sql);       //查找是否已存在信息
    while (!!$rows = mysql_fetch_array($result))
    {
        $no = $rows[stu_no];
    }
    if (empty($no))
    {
        $sql = "insert into students (from_user, stu_no, stu_wd) values('$fromUsername', '$usersno', '$password')";
        _insert_data($sql);
        $contentStr = "绑定成功 ↖点击此处返回<br/>重新发送'3'成绩即可<br/>密码错误发送'#'取消绑定，进行重新绑定";
        echo  $contentStr;
    }
    else echo "绑定失败<br/>请重新绑定";
}

echo' <div id="wrapper">
    <form name="login-form" class="login-form" action="" method="post">
    <div class="header">
    <h1>绑 定 教 务</h1>
    <span>初始密码为身份证后6位<br/>[密码错误，将无法查询到成绩]</span>
    </div>
    <div class="form">
    <form action="http://shnucs.duapp.com/stu.php?openid='.$fromUsername.'" method="post">
    <div align="center" class="row">
    <div class="content">
    <input name="txtUserID" type="text" class="input txtUserID" value="" placeholder="学 号[9位]" />
    <input name="txtUserPwd" type="password" class="input txtUserPwd" value="" placeholder="密 码" />
    </div>
    <div class="footer">
    <input type="submit" name="submit" value="点击绑定" id="btnLogin" class="button" onsubmit="return check()"/>
    <span>Copyright ©2014 Powered By Fancy & Rourou Version 1.0.0 </span>
    </div>
    </form>
    </div>
    <div class="gradient"></div> ';


?>
</body>
</html>