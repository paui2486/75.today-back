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
if (($_POST['member_id'])<> "") {
  
    //$_today = date('Y-m-d H:i:s'); 
    
    //check member
    $query_check_member = sprintf("SELECT * FROM member WHERE m_id = %s", GetSQLValueString($_POST['member_id'], "int"));
    // $data['query_check_member'] =  $query_check_member;
    $check_member = mysql_query($query_check_member, $iwine) or die(mysql_error());
    $totalRows_check_member = mysql_num_rows($check_member);
    if($totalRows_check_member == 1){
        $insertSQL = sprintf("INSERT INTO wine_note ( member_id ) VALUES (%s)", GetSQLValueString($_POST['member_id'], "int"));
        // $data['sql'] =  $insertSQL;
        mysql_select_db($database_iwine, $iwine);
        $Result1 = mysql_query($insertSQL, $iwine) or die(mysql_error());
        $_new_id = mysql_insert_id();
        
        $code = 100;
        $status = "success";
        $data['id'] = $_new_id;
    }else{
        $code = 199;
        $status = "member query error, return ".$totalRows_check_member." results. ";
    }
}else{
    $code = 199;
    $status = "no post data";
}

$data['code'] = $code;
$data['status'] = $status;
print json_encode($data);
?>
