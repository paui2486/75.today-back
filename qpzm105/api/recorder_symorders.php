<?php header('content-type: application/json; charset=utf-8');
//print '000';
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

$data = array();
//print 100;
if ($_POST['member_id'] <> "" && isset($_POST['member_id'])) {
  $member_id = $_POST['member_id'];
}else{
    $data['code'] = 199;
    $data['status'] = 'no post member_id';
    print json_encode($data);
    exit;
}
//print "member_id = ".$member_id."<br>";
if ($_POST['symposium_id'] <> "" && isset($_POST['symposium_id'])) {
  $symposium_id = $_POST['symposium_id'];
}else{
    $data['code'] = 199;
    $data['status'] = 'no post symposium_id';
    print json_encode($data);
    exit;
}

//check symrecord
$query_check_symposium = "SELECT * FROM symposium WHERE id = ".$symposium_id;
$check_symposium = mysql_query($query_check_symposium, $iwine) or die(mysql_error());
$totalRows_check_symposium = mysql_num_rows($check_symposium);

//check member
$query_check_member = "SELECT * FROM member WHERE m_id = ".$member_id;
$check_member = mysql_query($query_check_member, $iwine) or die(mysql_error());
$totalRows_check_member = mysql_num_rows($check_member);

//check symrecord
$query_check_symrecord = "SELECT * FROM symposium_apprecorder WHERE symposium_id = ".$symposium_id." AND member_id = ".$member_id;
$check_symrecord = mysql_query($query_check_symrecord, $iwine) or die(mysql_error());
$totalRows_symrecord = mysql_num_rows($check_symrecord);

if($totalRows_check_symposium != 1 || $totalRows_check_member != 1 || $totalRows_symrecord != 0){
    $code = 199;
    if($totalRows_check_symposium != 1){
        $status = "查詢品酒會錯誤";
    }else if($totalRows_check_member != 1){
        $status = "查詢會員錯誤";
    }else if($totalRows_symrecord != 0){
        $status = "報名紀錄已存在";
    }else{
        $status = "查詢失敗";
    }
    
}else if($totalRows_symrecord == 0){
    $_today = date('Y-m-d H:i:s'); 
    $insertSQL = sprintf("INSERT INTO symposium_apprecorder (symposium_id, member_id, create_time, remitter_code, remitter_name, remitter_time, remitter_fee) VALUES (%s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($symposium_id, "int"),
                       GetSQLValueString($member_id, "int"),
                       GetSQLValueString($_today, "date"),
                       GetSQLValueString($_POST['remitter_code'], "text"),
                       GetSQLValueString($_POST['remitter_name'], "text"),
                       GetSQLValueString($_POST['remitter_time'], "date"),
                       GetSQLValueString($_POST['remitter_fee'], "int"));
    mysql_select_db($database_iwine, $iwine);
    $Result1 = mysql_query($insertSQL, $iwine) or die(mysql_error());
    $code = 100;
    $status = "success";
}
$data['code'] = $code;
// $data['totalRows_symrecord'] = $totalRows_symrecord;
// $data['totalRows_check_member'] = $totalRows_check_member;
// $data['totalRows_check_symposium'] = $totalRows_check_symposium;
// $data['insertSQL'] = $insertSQL;
// $data['symposium_id'] = $symposium_id;
// $data['member_id'] = $member_id;
$data['status'] = $status;

mysql_free_result($Result1);
// print_r($data);
print json_encode($data);
?>
