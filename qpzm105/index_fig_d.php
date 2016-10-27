<?php include('session_check.php'); ?>
<?php require_once('../Connections/iwine.php'); ?>
<?php require('func.php'); ?>
<?php 

$b_id = $_GET['b_id'];
$strSQL = "delete from index_fig where b_id='$b_id'";
mysql_select_db($database_iwine, $iwine);
$Result1 = mysql_query($strSQL, $iwine) or die(mysql_error());
	
	msg_box('刪除成功!');
	go_to('index_fig_l.php');
	exit;

?>