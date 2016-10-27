<?php include('session_check.php'); ?>
<?php require_once('../Connections/iwine.php'); ?>
<?php 

$ap_id = $_GET['ap_id'];
$am_id = $_GET['am_id'];
$strSQL = "delete from alliance_project where ap_id='$ap_id'";
mysql_select_db($database_iwine, $iwine);
$Result1 = mysql_query($strSQL, $iwine) or die(mysql_error());

$_url = "alliance_member_s.php?am_id=".$am_id;
	
	msg_box('刪除成功!');
	go_to($_url);
	exit;

?>