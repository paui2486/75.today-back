<?php include('session_check.php'); ?>
<?php require_once('../Connections/iwine.php'); ?>
<?php 

$ac_id = $_GET['ac_id'];
$strSQL = "delete from alliance_case where ac_id='$ac_id'";
mysql_select_db($database_iwine, $iwine);
$Result1 = mysql_query($strSQL, $iwine) or die(mysql_error());
	
	msg_box('刪除成功!');
	go_to('alliance_case_l.php');
	exit;

?>