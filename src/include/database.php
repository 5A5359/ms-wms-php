<?php //建立MySql连接
    $con = mysql_connect("localhost","root","1234") or die("不能连接到Mysql Server");
    mysql_select_db("ms_wms_php", $con) or die("数据库选择失败");
    mysql_query("set names utf8 ");
?>