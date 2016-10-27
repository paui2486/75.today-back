<?php include('session_check.php'); ?>
<?php require_once('../Connections/iwine.php'); ?>
<?php 

$su_id = $_GET['su_id'];
$strSQL = "delete from short_url where su_id='$su_id'";
mysql_select_db($database_iwine, $iwine);
$Result1 = mysql_query($strSQL, $iwine) or die(mysql_error());

$_url = "short_url_l.php";
	
	msg_box('刪除成功!');
	go_to($_url);
	exit;

?>