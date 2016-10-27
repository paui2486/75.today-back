<?php
session_set_cookie_params(3600);
session_start();
date_default_timezone_set("Asia/Taipei");
//if(!($_SERVER["REMOTE_ADDR"]=="118.163.125.13") && !($_SERVER["REMOTE_ADDR"]=="220.132.120.171") && !($_SERVER["REMOTE_ADDR"]=="123.192.136.181"))
// {
//	echo "access denied.";
//	exit; 
// }
include('func.php');
if($_SESSION['ADMIN_ID']=="" || !isset($_SESSION['ADMIN_ID'])){
	//$_page = $_SERVER['REQUEST_URI'];
	$_goto = "login.php";
	//msg_box('尚未登入或登入後停止活動時間過久，請重新登入!');
	go_top($_goto);
	exit;
}
?>