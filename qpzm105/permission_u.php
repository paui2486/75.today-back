<?php require_once('../Connections/iwine.php'); ?>
<?php require('../func/func.php'); ?>
<?php 
$id = trim($_GET['id']);

$strSQL = "delete from acl_mapping where admin_account_id='$id'";
mysql_select_db($database_iwine, $iwine);
$Result1 = mysql_query($strSQL, $iwine) or die(mysql_error());
//echo $_POST['total_id'];
foreach(explode(',',GetSQLValueString(trim($_POST['total_id']))) as $vv){
	//echo $vv."<br>";
	if(preg_match('^[0-9]+$^',$vv,$reg)){
		$strSQL2 = "insert into acl_mapping values(null,'$id','$vv')";
		mysql_select_db($database_iwine, $iwine);
		$Result1 = mysql_query($strSQL2, $iwine) or die(mysql_error());
		//echo $strSQL2.'<br>';
	}

}
	msg_box('修改成功!');
	go_to("permission_s.php?id=$id");
	//echo $strSQL;
	exit;
?>