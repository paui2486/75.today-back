<?php include('session_check.php'); ?>
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

$_level = $_GET['level'];
$_level_parent = $_GET['parent'];

if($_level == 1){
	
mysql_select_db($database_iwine, $iwine);
$query_getClass = "SELECT * FROM Product_Class WHERE pc_level1 = '$_level_parent' AND pc_level2 = '0' ORDER BY pc_order ASC";
$getClass = mysql_query($query_getClass, $iwine) or die(mysql_error());
$row_getClass = mysql_fetch_assoc($getClass);
$totalRows_getClass = mysql_num_rows($getClass);

}elseif($_level == 2){
		
mysql_select_db($database_iwine, $iwine);
$query_getClass = "SELECT * FROM Product_Class WHERE pc_level2 = '$_level_parent' AND pc_level1 <> '0' ORDER BY pc_order ASC";
$getClass = mysql_query($query_getClass, $iwine) or die(mysql_error());
$row_getClass = mysql_fetch_assoc($getClass);
$totalRows_getClass = mysql_num_rows($getClass);
}


do { 

echo "<option value=\"".$row_getClass['pc_id']."\">".$row_getClass['pc_name']."</option>";
  
 } while ($row_getClass = mysql_fetch_assoc($getClass)); 
?>
<?php
mysql_free_result($getClass);
?>
