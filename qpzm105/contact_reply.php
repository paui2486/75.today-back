<?php include('session_check.php'); ?>
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


$_reply_datetime = date('Y-m-d H:i:s');

$updateSQL = sprintf("UPDATE contact SET c_status='1', c_reply=%s, c_reply_title=%s, c_reply_datetime=%s, c_reply_who=%s WHERE c_id=%s",
                       GetSQLValueString($_POST['c_cont'], "text"),
					   GetSQLValueString($_POST['c_reply_title'], "text"),
					   GetSQLValueString($_reply_datetime, "date"),
					   GetSQLValueString($_SESSION['ADMIN_NAME'], "text"),
                       GetSQLValueString($_POST['c_id'], "int"));

  mysql_select_db($database_iwine, $iwine);
  $Result1 = mysql_query($updateSQL, $iwine) or die(mysql_error());

$_mailtitle = iconv('UTF-8','BIG5',$_POST['c_reply_title']);

$content = $_POST['c_cont']."<p>－－－－－－－－－－－－－－－－－－－－－－－－－－－－－－－－－－－－－</p>
<p><strong>☆此信件為系統信箱發出，請勿直接回覆本郵件；如有其他疑問，請至<a href=\"http://www.iwine.com.tw/service.php\">【iWine】「聯絡我們」</a>提出☆</strong></p>";

$_maillist = $_POST['c_email'];

$mailtype='Content-Type:text/html;charset=big5';
$mailFrom="service@iwine.com.tw";
$mailTo=$_maillist;
$mailCC="";
$mailBCC="";
$mailSubject=$_mailtitle;
$mailContent = iconv('UTF-8','BIG5',$content);
$maildata = "From:$mailFrom\r\n";
if ($mailCC != '') {
$maildata .= "CC:$mailCC\r\n";
}
if ($mailBCC != '') {
$maildata .= "BCC:$mailBCC\r\n";
}
$maildata .= "$mailtype";
mail($mailTo,$mailSubject,$mailContent,$maildata);
  echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />";
  msg_box('已送出您的回覆!');
  if($_POST['page']==0){
	  go_to('win_close.php');
	  exit;
  }else{
	  go_to('win_close.php');
	  exit;
  }

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>iWine - 後台管理系統</title>
</head>
<body>
</body>
</html>