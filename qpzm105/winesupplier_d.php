<?php include('session_check.php'); ?>
<?php require_once('../Connections/iwine.php'); ?>
<?php 

$id = $_GET['id'];
$strSQL = "delete from wine_supplier where id='$id'";
mysql_select_db($database_iwine, $iwine);
$Result1 = mysql_query($strSQL, $iwine) or die(mysql_error());
	
	msg_box('刪除成功!');
	go_to('winesupplier_l.php');
	exit;

?>