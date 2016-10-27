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

if ($_POST['member_id']<> "" && $_POST['bar_id']<> "") {
  
    //$_today = date('Y-m-d H:i:s'); 
    
    //check member
    $query_check_member = sprintf("SELECT * FROM member WHERE m_id = %s", GetSQLValueString($_POST['member_id'], "int"));
    // $data['query_check_member'] =  $query_check_member;
    $check_member = mysql_query($query_check_member, $iwine) or die(mysql_error());
    $totalRows_check_member = mysql_num_rows($check_member);
    
    //check bar
    $query_check_bar = sprintf("SELECT * FROM bar WHERE id = %s", GetSQLValueString($_POST['bar_id'], "int"));
    // $data['query_check_bar'] =  $query_check_bar;
    $check_bar = mysql_query($query_check_bar, $iwine) or die(mysql_error());
    $totalRows_check_bar = mysql_num_rows($check_bar);
    
    //check board? 
    // $query_check_board = sprintf("SELECT * FROM iwinestand_board WHERE m_id = %s AND bar_id = %s", GetSQLValueString($_POST['member_id'], "int"),GetSQLValueString($_POST['bar_id'], "int"));
    // $data['query_check_board'] =  $query_check_board;
    // $check_board = mysql_query($query_check_board, $iwine) or die(mysql_error());
    // $totalRows_check_board = mysql_num_rows($check_board);
    $now_timestamp = date_timestamp_get(date_create());
    if($totalRows_check_member == 1 && $totalRows_check_bar == 1){
        $insertSQL = sprintf("INSERT INTO iwinestand_board ( m_id, bar_id, message, match_method, quota, line_id, telphone, dating_time)
                              VALUES (%s, %s, %s ,%s, %s,%s,%s,%s)", 
                              GetSQLValueString($_POST['member_id'], "int"),
                              GetSQLValueString($_POST['bar_id'], "int"),
                              GetSQLValueString($_POST['message'], "text"),
                              GetSQLValueString($_POST['match_method'], "text"),
                              GetSQLValueString($_POST['quota'], "int"),
                              GetSQLValueString($_POST['line_id'], "text"),
                              GetSQLValueString($_POST['telphone'], "text"),
                              GetSQLValueString(date('Y-m-d H:i',$_POST['dating_time']), "date"));
        // $data['sql'] =  $insertSQL;
        mysql_select_db($database_iwine, $iwine);
        $Result1 = mysql_query($insertSQL, $iwine) or die(mysql_error());
        $_new_id = mysql_insert_id();
        
        $code = 100;
        $status = "success";
        $data['id'] = $_new_id;
    }else{
        $code = 199;
        if($totalRows_check_member == 0 && $totalRows_check_bar ==0){
            $status = sprintf("member id = %s  and bar id = %s not exist.",$_POST['member_id'], $_POST['bar_id']);
        }else if($totalRows_check_member == 0){
            $status = sprintf("member id = %s not exist.",$_POST['member_id']);
        }else if($totalRows_check_member == 0){
            $status = sprintf("bar id = %s not exist.", $_POST['bar_id']);
        }else{
            $status = " member or bar query error.";
        }
        
    }
}else{
    $code = 199;
    if($_POST['bar_id'] == ""){
        $status = "no post bar data";
    }else if($_POST['member_id'] == ""){
        $status = "no post member data";
    }else{
        $status = "no post member and bar data";
    }
    
}

$data['code'] = $code;
$data['status'] = $status;
print json_encode($data);
?>
