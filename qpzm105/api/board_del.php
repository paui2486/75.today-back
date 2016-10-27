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
if ($_POST['member_id']<> "" && $_POST['board_id']<> "") {
 
    //check board? 
    $query_check_board = sprintf("SELECT * FROM iwinestand_board WHERE id = %s", GetSQLValueString($_POST['board_id'], "int"));
    $check_board = mysql_query($query_check_board, $iwine) or die(mysql_error());
    $totalRows_check_board = mysql_num_rows($check_board);
    $now_timestamp = date_timestamp_get(date_create());
    if( $totalRows_check_board == 1 ){
        $row_board = mysql_fetch_assoc($check_board);
        if($row_board['m_id'] == $_POST['member_id']){
            $del_sql = "delete from iwinestand_board where id='".$_POST['board_id']."'";
            mysql_select_db($database_iwine, $iwine);
            if(mysql_query($del_sql, $iwine) or die(mysql_error())){ 
                $code = 100;
                $status = "success";
            }else{
                $code = 199;
                $status = "query delete failed";
            }
        }else{
            $code = 152;
            $status = "current member id is not the owner of board id = ".$_POST['board_id'];
        }
        
    }else{
        $code = 151;
        $status = sprintf("query board id = %s is not exist.", $_POST['board_id']);
    }
        
}else{
    $code = 199;
    if($_POST['board_id'] == ""){
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
