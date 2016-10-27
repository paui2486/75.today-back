<?php
header('Content-Type: text/xml');
?>
<?php require_once('../Connections/iwine.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

$colname_permission = "-1";
if (isset($_GET['id'])) {
  $colname_permission = $_GET['id'];
}
mysql_select_db($database_iwine, $iwine);
$query_permission = sprintf("SELECT * FROM acl_mapping WHERE admin_account_id = %s AND menu_detail_id <> '0'", GetSQLValueString($colname_permission, "int"));
$permission = mysql_query($query_permission, $iwine) or die(mysql_error());
$row_permission = mysql_fetch_assoc($permission);
$totalRows_permission = mysql_num_rows($permission);

unset($arr_xml);
do { 
  $arr_xml[$row_permission['menu_detail_id']]=true;
} while ($row_permission = mysql_fetch_assoc($permission));
	
mysql_select_db($database_iwine, $iwine);
$query_group = "SELECT * FROM menu_group ORDER BY group_order ASC";
$group = mysql_query($query_group, $iwine) or die(mysql_error());
$row_group = mysql_fetch_assoc($group);
$totalRows_group = mysql_num_rows($group);

do{
	$a .="\t". '<item text="'.$row_group['group_name'].'" id="group_'.$row_group['id'].'" open="1">'."\n";
	$menu_group_id = $row_group['id'];

	mysql_select_db($database_iwine, $iwine);
	$query_detail = "SELECT * FROM menu_detail WHERE group_id = '$menu_group_id' ORDER BY menu_detail_order ASC";
	$detail = mysql_query($query_detail, $iwine) or die(mysql_error());
	$row_detail = mysql_fetch_assoc($detail);
	$totalRows_detail = mysql_num_rows($detail);

	do{
		if($arr_xml[$row_detail['id']]===true){
					$check_value='checked="1"';
				}else{
					$check_value='';
				}
				$a .= "\t"."\t".'<item text="'.$row_detail['menu_detail_name'].'" id="'.$row_detail['id'].'" im0="iconText.gif" '.$check_value.'></item>'."\n";
				
	} while ($row_detail = mysql_fetch_assoc($detail));
		
	$a .= "\t".'</item>'."\n";//end group	

} while ($row_group = mysql_fetch_assoc($group));

echo "<?xml version='1.0' encoding='utf-8'?>
<tree id='0'>".
$a.
"</tree>";

mysql_free_result($permission);

mysql_free_result($group);

mysql_free_result($detail);
?>
