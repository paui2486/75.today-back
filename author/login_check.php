<?php session_start(); ?>
<?php
include_once 'securimage/securimage.php';
$securimage = new Securimage();
include('func/func.php');
?>
<?php require_once('../Connections/iwine.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
    function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") {
        if (PHP_VERSION < 6) { $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue; }
        $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);
        switch ($theType) {
            case "text": $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL"; break;    
            case "long":
            case "int": $theValue = ($theValue != "") ? intval($theValue) : "NULL"; break;
            case "double": $theValue = ($theValue != "") ? doubleval($theValue) : "NULL"; break;
            case "date": $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL"; break;
            case "defined": $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue; break;
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

$colname_member = "-1";
if ($_POST['mem_id'] <> "") {
  $colname_member = $_POST['mem_id'];
}
$colname2_member = "-1";
if (isset($_POST['mem_passwd'])) {
  $colname2_member = md5($_POST['mem_passwd']);
}
mysql_select_db($database_iwine, $iwine);
$query_member = sprintf("SELECT * FROM member WHERE m_account = %s AND m_passwd_md5 = %s", GetSQLValueString($colname_member, "text"),GetSQLValueString($colname2_member, "text"));
$member = mysql_query($query_member, $iwine) or die(mysql_error());
$row_member = mysql_fetch_assoc($member);
$totalRows_member = mysql_num_rows($member);

mysql_select_db($database_iwine, $iwine);
$query_is_expert = sprintf("SELECT * FROM expert WHERE member_id = %s", GetSQLValueString($row_member['m_id'], "int"));
$is_expert = mysql_query($query_is_expert, $iwine) or die(mysql_error());
$row_isexpert = mysql_fetch_assoc($is_expert);
$totalRows_isexpert = mysql_num_rows($is_expert);

if($totalRows_member == 0){

    msg_box('帳號或密碼錯誤，請重新輸入!');
    $_err_url = "login.php?page=".$_POST['page'];
    go_to($_err_url);
    //exit;
}else{
    $_mem_id = $row_member['m_id'];	
    $now_date = date("Y-m-d H:i:s");
    $client_ip = get_client_ip();	
  
	 $_SESSION['MEM_ID'] = $row_member['m_id'];
	 $_SESSION['MEM_ACCOUNT'] = $row_member['m_account'];
	 $_SESSION['MEM_NAME'] = $row_member['m_name'];
	 $_SESSION['MEM_ZIP'] = $row_member['m_zip'];
	 $_SESSION['MEM_ADDRESS'] = $row_member['m_county'].$row_member['m_city'].$row_member['m_address'];
	 $_SESSION['MEM_EMAIL'] = $row_member['m_email'];
	 $_SESSION['MEM_MOBILE'] = $row_member['m_mobile_code'].$row_member['m_mobile'];
	 $_SESSION['MEM_BUY'] = $row_member['m_everbuy'];
	 $_SESSION['MEM_POINT'] = $row_member['m_point'];
     
	 if($totalRows_isexpert > 0){
        $_SESSION['IS_EXPERT'] = true;
        $_SESSION['EXPERT_ID'] = $row_isexpert['id'];
        $_SESSION['EXPERT_NAME'] = $row_isexpert['name'];
        msg_box('登入成功');
     }else{
        msg_box('沒有達人上稿的權限喔！');
     }
	
	
	if($row_member['m_name'] == ""){ $_url = "expert_article_l.php";}
    else{
        if($_POST['page']<>""){
            $_url = $_POST['page'];
        }else{
            $_url = "expert_article_l.php";
        }
    }
	
	go_to($_url);
	//exit;
}

}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>登入檢查中...</title>
</head>
<body>
</body>
</html>
<?php
mysql_free_result($member);
mysql_free_result($is_supplier);
?>
