<?php header('content-type: application/json; charset=utf-8');

require_once('../../Connections/iwine.php');
mysql_select_db($database_iwine, $iwine);

$data = array();
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

if($_POST['member_id'] != "") {
    $member_id = $_POST['member_id'];
    $query_member = sprintf("SELECT * FROM member WHERE m_id = %s", GetSQLValueString($member_id, "int"));
    mysql_select_db($database_iwine, $iwine);
    $member = mysql_query($query_member, $iwine) or die(mysql_error());
    $totalRows_member = mysql_num_rows($member);
    
    if($totalRows_member == 1){
        
        $id = $_POST['wine_note_id'];
        $query_select = sprintf("SELECT id, modify_time FROM wine_note WHERE member_id = %s", GetSQLValueString($_POST['member_id'], "int"));
        $select_query = mysql_query($query_select, $iwine) or die(mysql_error());
        $totalRows_select = mysql_num_rows($select_query);
         if ($totalRows_select > 0){
            $data['data'] = array();
            while($each_row = mysql_fetch_assoc($select_query)){
                array_push($data['data'], $each_row);
            };
            $code = 100;
            $status = 'success';
        }else{
            $coed = 199;
            $status = 'member no note.';
        }
  
    }else{
        $code = 104;
        $status = 'member not exists.';
    }
   
}else{
    $code = 199;
    $status = 'no post member id';
}

$data['code'] = $code;
$data['status'] = $status;

mysql_free_result($each_row);
print json_encode($data);
?>
