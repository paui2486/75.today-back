<?php include('session_check.php'); ?>
<?php require_once('../Connections/iwine.php'); ?>
<?php 

$p_id = $_GET['p_id'];//從vedio-l.php 傳過來
$strSQL = "delete from Wine_section where id='$p_id'";
mysql_select_db($database_iwine, $iwine);
$Result1 = mysql_query($strSQL, $iwine) or die(mysql_error());
	
	msg_box('刪除成功!');
	go_to('wine-section-l.php');
	exit;

?>