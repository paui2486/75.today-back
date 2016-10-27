<?php require_once('public_include.php'); ?>
<?php
include_once 'securimage/securimage.php';
$securimage = new Securimage();
?>
<?php require_once('../Connections/iwine.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

if ($securimage->check($_POST['capacha_code']) == false) {
  msg_box('驗證碼錯誤,請重新輸入!');
  $_err_url = "login.php";
  go_to($_err_url);
  exit;
}else{

$colname_member = "stranger";
if ($_POST['account_pid'] <> "") {
  $colname_member = $_POST['account_pid'];
}
$colname2_member = "-1";
if (isset($_POST['account_pwd'])) {
  $colname2_member = md5($_POST['account_pwd']);
}
mysql_select_db($database_iwine, $iwine);
$query_member = sprintf("SELECT * FROM admin_account WHERE account_pid = '%s' AND account_pwd = '%s'", GetSQLValueString($colname_member, "text"),GetSQLValueString($colname2_member, "text"));
$member = mysql_query($query_member, $iwine) or die(mysql_error());
$row_member = mysql_fetch_assoc($member);
$totalRows_member = mysql_num_rows($member);

if($totalRows_member == 0){

$now_date = date('Y-m-d H:i:s');
$client_ip = get_client_ip();	
$insertSQL = sprintf("INSERT INTO login_log (account_pid, login_ip, login_time, status) VALUES ('%s', '%s', '%s', 'F')",
                       GetSQLValueString($colname_member, "text"),
					   GetSQLValueString($client_ip, "text"),
                       GetSQLValueString($now_date, "date"));

  mysql_select_db($database_iwine, $iwine);
  $Result1 = mysql_query($insertSQL, $iwine) or die(mysql_error());
	msg_box('帳號或密碼錯誤，請重新輸入!');
	go_to(-1);
	//exit;
}else{
$_admin_id = $row_member['id'];	
$now_date = date('Y-m-d H:i:s');
$client_ip = get_client_ip();	
$insertSQL = sprintf("INSERT INTO login_log (account_pid, login_ip, login_time, status) VALUES ('%s', '%s', '%s', 'T')",
                       GetSQLValueString($_POST['account_pid'], "text"),
                       GetSQLValueString($client_ip, "text"),
                       GetSQLValueString($now_date, "date"));

  mysql_select_db($database_iwine, $iwine);
  $Result1 = mysql_query($insertSQL, $iwine) or die(mysql_error());
  
$updateSQL = sprintf("UPDATE admin_account SET last_lgoin_ip = '%s', last_login_time = '%s', login_times = login_times + 1 WHERE id = '%s'",
                       GetSQLValueString($client_ip, "text"),
                       GetSQLValueString($now_date, "date"),
					   GetSQLValueString($_admin_id, "int"));

  mysql_select_db($database_iwine, $iwine);
  $Result2 = mysql_query($updateSQL, $iwine) or die(mysql_error());
	
	 $_SESSION['ADMIN_ID'] = $row_member['id'];
	 $_SESSION['ADMIN_ACCOUNT'] = $row_member['account_pid'];
	 $_SESSION['ADMIN_NAME'] = $row_member['name'];
	 $_SESSION['ADMIN_TIMES'] = $row_member['login_times'] + 1;
	msg_box('登入成功');
	go_to('index.php');
	//exit;
}

}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>iWine - 後台管理系統</title>
<style type="text/css">
<!--
body {
	background-color: #315C7C;
	margin-left: 0px;
	margin-top: 0px;
}

-->
</style>

</head>

<body>
</body>
</html>
<?php
mysql_free_result($member);
?>
