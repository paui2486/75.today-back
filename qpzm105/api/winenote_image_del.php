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

if ($_POST['wine_note_id'] == "" || $_POST['position'] == "") {
    $code = 199;
    $status = "post data 不全";
}else{
    $now_timestamp = date_timestamp_get(date_create());
    //取欄位名稱
    $image_field = 'pic'.($_POST['position']+1);
    $query_select = sprintf("SELECT %s FROM wine_note WHERE id = %s", $image_field ,GetSQLValueString($_POST['wine_note_id'], "int"));
    $check_select = mysql_query($query_select, $iwine) or die(mysql_error());
    $row_select = mysql_fetch_assoc($check_select);
    $totalRows_select = mysql_num_rows($check_select);
    
    $impage_path = '../../../web/webimages/winenote/';
   
    if($totalRows_select == 1){
        if($row_select[$image_field]<> ""){
            $del_file = $impage_path.$row_select[$image_field];
            $query_update = sprintf("UPDATE wine_note SET %s = null WHERE id = %s", $image_field , GetSQLValueString($_POST['wine_note_id'], "int"));
            $check_update = mysql_query($query_update, $iwine) or die(mysql_error());
            if($check_update == true){
                $code = 100;
                $status = "success";
            }else{
                $code = 199;
                $status = "update sql fail";
            }
            unlink($del_file);
        }else{
            $code = 199;
            $status = "image is null in database";
        }
    }else{
        $coed = 199;
        $status = "wine note select ". $totalRows_select." datas";
    }
    
}
$data['code'] = $code;
$data['status'] = $status;
print json_encode($data);
?>
