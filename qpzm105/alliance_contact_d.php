<?php include('session_check.php'); ?>
<?php require_once('../Connections/iwine.php'); ?>
<?php 

$c_id = $_GET['c_id'];
$strSQL = "delete from alliance_contact where c_id='$c_id'";
mysql_select_db($database_iwine, $iwine);
$Result1 = mysql_query($strSQL, $iwine) or die(mysql_error());
	
	msg_box('刪除成功!');
	go_to('alliance_contact_history_l.php');
	exit;

?>