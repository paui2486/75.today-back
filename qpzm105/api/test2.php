<?php header('content-type: application/json; charset=utf-8');

require_once('../../Connections/iwine.php');
mysql_select_db($database_iwine, $iwine);

if (!function_exists("GetSQLValueString")) {
    function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
    {
      if (PHP_VERSION < 6) {
        $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
      }

      $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

      switch ($theType) {
        case "text": $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL"; break;    
        case "long":
        case "int": $theValue = ($theValue != "") ? intval($theValue) : "NULL"; break;
        case "double": $theValue = ($theValue != "") ? doubleval($theValue) : "NULL"; break;
        case "date": $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL"; break;
        case "defined": $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue; break;
      }
      return $theValue;
    }
}

$data = array();
$data['article'] = array();
$data['expert_article'] = array();
$colname_member = "-1";

mysql_select_db($database_iwine, $iwine);
$query_member = "SELECT n_id FROM article WHERE n_status =  'Y'";

$member = mysql_query($query_member, $iwine) or die(mysql_error());
$totalRows_member = mysql_num_rows($member);
$sym_id = array();

while($row_member = mysql_fetch_assoc($member)){
    $row_member['link'] = 'http://www.iwine.com.tw/article.php?n_id='.$row_member['n_id'];
    $data['article'][] = $row_member;
}

$query_member = "SELECT n_id FROM expert_article WHERE n_status =  'Y'";

$member = mysql_query($query_member, $iwine) or die(mysql_error());
$totalRows_member = mysql_num_rows($member);
$sym_id = array();

while($row_member = mysql_fetch_assoc($member)){
    $row_member['link'] = 'http://www.iwine.com.tw/expert_article.php?n_id='.$row_member['n_id'];
    $data['expert_article'][] = $row_member;
}



mysql_free_result($member);
print json_encode($data);
?>
