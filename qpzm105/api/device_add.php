 <?php 
//header('content-type: application/json; charset=utf-8');

// require_once('../../Connections/iwine.php');
// mysql_select_db($database_iwine, $iwine);

// if (!function_exists("GetSQLValueString")) {
    // function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = ""){
      // if (PHP_VERSION < 6) { $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue; }
      // $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);
      // switch ($theType) {
        // case "text": $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL"; break;    
        // case "long":
        // case "int": $theValue = ($theValue != "") ? intval($theValue) : "NULL"; break;
        // case "double": $theValue = ($theValue != "") ? doubleval($theValue) : "NULL"; break;
        // case "date": $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL"; break;
        // case "defined": $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue; break;
      // }
      // return $theValue;
    // }
// }
// $data = array();
// if ($_POST['device_id'] == "" || $_POST['member_id'] == "" ) {
    // $code = 199;
    // $status = "post data 不全";
// }else{
    // $now_timestamp = date_timestamp_get(date_create());
    // $device_id = $_POST['device_id'];
    // $member_id = $_POST['member_id'];
    // $_today = date('Y-m-d H:i:s'); 
    // #check recorde exist or not
    // mysql_select_db($database_iwine, $iwine);
   
    // $check_sql = sprintf("SELECT * FROM member_device WHERE m_id = %s AND device_id = %s",GetSQLValueString($member_id,"int"), GetSQLValueString($device_id,'text'));
    
    // $check_query = mysql_query($check_sql, $iwine) or die(mysql_error());
    // $total_check = mysql_num_rows($check_query);
    // if($total_check == 0 ){
        // $add_sql = sprintf("INSERT INTO member_device(m_id, device_id, create_time) VALUES (%s, %s, %s)",GetSQLValueString($member_id,"int"), GetSQLValueString($device_id,'text'), GetSQLValueString($_today,'date'));
        // if( mysql_query($add_sql, $iwine) or die(mysql_error())){
            // $code = 100;
            // $status = 'success';
        // }else{
            // $code = 199;
            // $status = 'insert query failed';
        // }
        
    // }else{
        // $code = 199;
        // $status = sprintf('recorder exist: member id = %s, device id = %s', $member_id, $device_id);
    // }
// }
// $data['code'] = $code;
// $data['status'] = $status;
// print json_encode($data);
?>
