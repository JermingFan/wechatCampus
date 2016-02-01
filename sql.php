<?php
/*替换为你自己的数据库名（可从管理中心查看到）*/
$dbname = 'AioMKkFWwHnapCfnGDae';
 
/*从环境变量里取出数据库连接需要的参数*/
$host = getenv('HTTP_BAE_ENV_ADDR_SQL_IP');
$port = getenv('HTTP_BAE_ENV_ADDR_SQL_PORT');
$user = 'II02YEkveZyPR2cBbGr3bKw0';
$pwd = '2jqyWZQVIWlDva7FSDoSPdKHo8es7Eqo';
//echo 'host:'.$host.'</br>'; echo 'port:'.$port.'</br>';
//echo 'user:'.$user.'</br>'; echo 'pwd:'.$pwd.'</br>';  
/*接着调用mysql_connect()连接服务器*/
$link = @mysql_connect("{$host}:{$port}",$user,$pwd,true);
if(!$link) {
    die("Connect Server Failed: " . mysql_error());
}
/*连接成功后立即调用mysql_select_db()选中需要连接的数据库*/
if(!mysql_select_db($dbname,$link)) {
    die("Select Database Failed: " . mysql_error($link));
}

//创建一个数据库表
function _create_table($sql){
    mysql_query($sql) or die('创建表失败，错误信息：'.mysql_error());
    return "创建表成功";
}

//插入数据
function _insert_data($sql){
      if(!mysql_query($sql)){
        return 0;    //插入数据失败
    }else{
          if(mysql_affected_rows()>0){
              return 1;    //插入成功
          }else{
              return 2;    //没有行受到影响
          }
    }
}

//删除数据
function _delete_data($sql){
      if(!mysql_query($sql)){
        return 0;    //删除失败
      }else{
          if(mysql_affected_rows()>0){
              return 1;    //删除成功
          }else{
              return 2;    //没有行受到影响
          }
    }
}

//修改数据
function _update_data($sql){
      if(!mysql_query($sql)){
        return 0;    //更新数据失败
    }else{
          if(mysql_affected_rows()>0){
              return 1;    //更新成功;
          }else{
              return 2;    //没有行受到影响
          }
    }
}

function _select_data($sql){
    $ret = mysql_query($sql) or die('SQL语句有错误，错误信息：'.mysql_error());
    return $ret;
}

function _drop_table($sql){
    mysql_query($sql) or die('删除表失败，错误信息：'.mysql_error());
    return "删除表成功";
}
?>