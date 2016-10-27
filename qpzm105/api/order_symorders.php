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

if ($_POST['member_id'] <> "") {
  $member_id = $_POST['member_id'];
}else{
    $data['code'] = 199;
    $data['status'] = 'no post member_id';
    print json_encode($data);
    exit;
}
if ($_POST['symposium_id'] <> "") {
  $symposium_id = $_POST['symposium_id'];
}else{
    $data['code'] = 199;
    $data['status'] = 'no post symposium_id';
    print json_encode($data);
    exit;
}

//check symorders
$query_check_symposium = "SELECT * FROM symposium WHERE id = ".$symposium_id;
$check_symposium = mysql_query($query_check_symposium, $iwine) or die(mysql_error());
$totalRows_check_symposium = mysql_num_rows($check_symposium);

//check member
$query_check_member = "SELECT * FROM member WHERE m_id = ".$member_id;
$check_member = mysql_query($query_check_member, $iwine) or die(mysql_error());
$totalRows_check_member = mysql_num_rows($check_member);

//check symorders
$query_check_symorders = "SELECT * FROM symposium_orders WHERE symposium_id = ".$symposium_id." AND member_id = ".$member_id;
$check_symorders = mysql_query($query_check_symorders, $iwine) or die(mysql_error());
$totalRows_symorders = mysql_num_rows($check_symorders);

if($totalRows_check_symposium != 1 || $totalRows_check_member != 1 || $totalRows_symorders != 0){
    $code = 199;
    if($totalRows_check_symposium != 1){
        $status = "查詢品酒會錯誤";
    }else if($totalRows_check_member != 1){
        $status = "查詢會員錯誤";
    }else if($totalRows_symorders != 0){
        $status = "報名紀錄已存在";
    }else{
        $status = "查詢失敗";
    }
    
}else if($totalRows_symorders == 0){
    $_today = date('Y-m-d H:i:s'); 
    $insertSQL = sprintf("INSERT INTO symposium_orders (symposium_id, member_id, create_time) VALUES (%s, %s, %s)",
                       GetSQLValueString($symposium_id, "int"),
                       GetSQLValueString($member_id, "int"),
                       GetSQLValueString($_today, "date"));
    mysql_select_db($database_iwine, $iwine);
    $Result1 = mysql_query($insertSQL, $iwine) or die(mysql_error());
    $status = "success";
        $code = 100;
        $status = "success";
}
$data['code'] = $code;
// $data['totalRows_symorders'] = $totalRows_symorders;
// $data['totalRows_check_member'] = $totalRows_check_member;
// $data['totalRows_check_symposium'] = $totalRows_check_symposium;
// $data['insertSQL'] = $insertSQL;
// $data['symposium_id'] = $symposium_id;
// $data['member_id'] = $member_id;
$data['status'] = $status;

mysql_free_result($member);
print json_encode($data);
?>
