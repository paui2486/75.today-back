<?php header('content-type: application/json; charset=utf-8');

require_once('../../../Connections/iwine.php');
require_once('config.php');
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
$_today = date('Y-m-d H:i:s');
$file = fopen("log.txt", "a+")or die("can't open file");

fwrite($file, "==========================\n");
fwrite($file, 'time: '.$_today."\n");
$data['now'] = $_today;
if($_POST['member_id'] != "") {
    $member_id = $_POST['member_id']; 
    // $member_id =170; 
    fwrite($file, 'member_id: '.$member_id."\n");
    // $data['member_id'] = $member_id;
    if ($_POST['reg_id'] <> "" && $_POST['device_id']<> ""){
        $registatoin_ids = array();
        array_push($registatoin_ids, $_POST['reg_id']);
        $query_check = sprintf("SELECT * FROM device_android WHERE device_id = %s", GetSQLValueString($_POST['device_id'], "text"));
        fwrite($file, 'query_check: '.$query_check."\n");
        // $data['query_check'] =  $query_check;
        $check = mysql_query($query_check, $iwine) or die(mysql_error());
        $row_check = mysql_fetch_assoc($check);
        $totalRows_check = mysql_num_rows($check);
        if($totalRows_check == 0){
            $query_insert = sprintf("INSERT INTO device_android ( m_id, device_id, reg_id,device_name, app_name, create_time) VALUES (%s, %s, %s ,%s, %s ,%s)", 
                                  GetSQLValueString($member_id, "int"),
                                  GetSQLValueString($_POST['device_id'], "text"),
                                  GetSQLValueString($_POST['reg_id'], "text"),
                                  GetSQLValueString($_POST['device_name'], "text"),
                                  GetSQLValueString($_POST['app_name'], "text"),
                                  GetSQLValueString($_today, "date"));
            $insert = mysql_query($query_insert, $iwine) or die(mysql_error());
            fwrite($file, 'query_insert: '.$query_insert."\n");
            // $data['query_insert'] = $query_insert;
            $gcm = new GCM();
            // $message = "draq test";
            $message = array();
            $result = $gcm->send_notification($registatoin_ids, $message);
            // $data['gcm_result'] = $result;
            fwrite($file, 'gcm_result: '.$result."\n");
            $code = 100;
            $status = 'success';
            
        }else{
            $code = 199;
            $status = sprintf("device id %s is already exist.", GetSQLValueString($_POST['device_id'], "text"));
            // $query_del = sprintf("DELETE FROM device_android where id = %s", GetSQLValueString($row_check['id'], "int"));
            // fwrite($file, 'query_del: '.$query_del."\n");
            // $data['query_del'] = $query_del;
            // mysql_select_db($database_iwine, $iwine);
            // $Result1 = mysql_query($query_del, $iwine) or die(mysql_error());
            // mysql_free_result($Result1);
        }
    }else{
        $code = 199;
        $status = "no reg id or no device id.";
    }

} else {
    $code = 199;
    $status = "no member id.";
}
$data['code'] = $code;
$data['status'] = $status;
fwrite($file, 'code: '.$code."\n");
fwrite($file, 'status: '.$status."\n");
mysql_free_result($insert);
mysql_free_result($check);


fclose($file);
print json_encode($data);
?>