<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_lovelove = "localhost";
$database_lovelove = "iwine_shop";
$username_lovelove = "iwine_user";
$password_lovelove = "mysql2013";
$lovelove = mysql_pconnect($hostname_lovelove, $username_lovelove, $password_lovelove) or trigger_error(mysql_error(),E_USER_ERROR); 
date_default_timezone_set("Asia/Taipei");
mysql_query("SET NAMES 'UTF8'");
mysql_query("SET CHARACTER_SET_CLIENT='UTF8'"); 
mysql_query("SET CHARACTER_SET_RESULTS='UTF8'");
error_reporting(0);
?>