<?php header('content-type: application/json; charset=utf-8');

require_once('../../Connections/iwine.php');
mysql_select_db($database_iwine, $iwine);

if (!function_exists("GetSQLValueString")) {
    function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = ""){
      if (PHP_VERSION < 6) { $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue; }
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
$colname_member = "-1";
if ($_POST['mem_id'] <> "") {
  $colname_member = $_POST['mem_id'];
}
$colname2_member = "-1";
if (isset($_POST['mem_passwd'])) {
  $colname2_member = md5($_POST['mem_passwd']);
}
mysql_select_db($database_iwine, $iwine);
$query_member = "SELECT * FROM member WHERE m_account = '".$colname_member."' ";
$member = mysql_query($query_member, $iwine) or die(mysql_error());
$row_member = mysql_fetch_assoc($member);
$totalRows_member = mysql_num_rows($member);
$sym_id = array();
$result = array();
if($totalRows_member == 0){
    $code = 101;
    $status = "account not exists";
}elseif($totalRows_member == 1){
    if($row_member['m_passwd_md5'] == htmlspecialchars($colname2_member)){
        $row_member['m_passwd_md5']="disable";
        $result['data'] = $row_member;
        $code = 100;
        $status = "success";
        $query_symorders ="SELECT symposium_id FROM symposium_orders WHERE member_id = '".$row_member['m_id']."' ";
        $symorders = mysql_query($query_symorders, $iwine) or die(mysql_error());
        $totalRows_symorders = mysql_num_rows($symorders);
        $i = 0;
        while($each_row = mysql_fetch_assoc($symorders)){
            $sym_id[$i] = $each_row['symposium_id'];
            $i++;
        }
        $result['data']['symposium'] = $sym_id;
        mysql_free_result($symorders);
        $_mem_id = $row_member['m_id'];	
        $now_date = date('Y-m-d H:i:s');
        $updateSQL = "UPDATE member SET last_login = '".$now_date."' WHERE m_id = '".$row_member['m_id']."'";
        mysql_select_db($database_iwine, $iwine);
        $Result2 = mysql_query($updateSQL, $iwine) or die(mysql_error());
    }else{
        $code = 102;
        $status = "password incorrect";
    }
}
$result['code'] = $code;
$result['status'] = $status;

mysql_free_result($member);
print json_encode($result);
?>
