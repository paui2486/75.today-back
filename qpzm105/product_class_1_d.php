<?php include('session_check.php'); ?>
<?php require_once('../Connections/iwine.php'); ?>
<?php //require('../func/func.php'); ?>
<?php 

$pc_id = $_GET['pc_id'];
$strSQL = "delete from Product_Class where pc_id='$pc_id'";
mysql_select_db($database_iwine, $iwine);
$Result1 = mysql_query($strSQL, $iwine) or die(mysql_error());
	
	msg_box('刪除成功!');
	go_to('product_class_1_l.php');
	exit;

?>