<?php include('session_check.php'); ?>
<?php require_once('../Connections/iwine.php'); ?>
<?php require('func.php'); ?>
<?php 

$n_id = $_GET['n_id'];
$strSQL = "delete from cf_video where n_id='$n_id'";
mysql_select_db($database_iwine, $iwine);
$Result1 = mysql_query($strSQL, $iwine) or die(mysql_error());
	
	msg_box('刪除成功!');
	go_to('video_l.php');
	exit;

?>