<?php include('session_check.php'); ?>
<?php require_once('../Connections/iwine.php'); ?>
<?php 

$ap_id = $_GET['ap_id'];
$strSQL = "delete from seek_detail where ap_id='$ap_id'";
mysql_select_db($database_iwine, $iwine);
$Result1 = mysql_query($strSQL, $iwine) or die(mysql_error());
	
	msg_box('刪除成功!');
	go_to('seek_l.php');
	exit;

?>