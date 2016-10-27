<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_iwine_shop = "localhost";
$database_iwine_shop = "iwine_shop";
$username_iwine_shop = "root";
$password_iwine_shop = "mysql2013";
$iwine_shop = mysql_pconnect($hostname_iwine_shop, $username_iwine_shop, $password_iwine_shop) or trigger_error(mysql_error(),E_USER_ERROR); 
date_default_timezone_set("Asia/Taipei");
mysql_query("SET NAMES 'UTF8'");
mysql_query("SET CHARACTER_SET_CLIENT='UTF8'"); 
mysql_query("SET CHARACTER_SET_RESULTS='UTF8'");
error_reporting(0);
?>
