<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_iwine = "localhost";
$database_iwine = "iwine";
$username_iwine = "iwine_user";
$password_iwine = "mysql2013";
$iwine = mysql_pconnect($hostname_iwine, $username_iwine, $password_iwine) or trigger_error(mysql_error(),E_USER_ERROR); 
date_default_timezone_set("Asia/Taipei");
mysql_query("SET NAMES 'UTF8'");
mysql_query("SET CHARACTER_SET_CLIENT='UTF8'"); 
mysql_query("SET CHARACTER_SET_RESULTS='UTF8'");
error_reporting(0);
?>