<?php include('session_check.php'); ?>
<?php require_once('../Connections/iwine.php'); ?>
<?php 

$p_id = $_GET['p_id'];
$strSQL = "delete from article where n_id='$p_id'";
mysql_select_db($database_iwine, $iwine);
$Result1 = mysql_query($strSQL, $iwine) or die(mysql_error());
	
	msg_box('刪除成功!');
	go_to('article_l.php');
	exit;

?>