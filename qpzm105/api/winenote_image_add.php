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
if ($_POST['wine_note_id'] == "" || $_POST['position'] == "" || $_POST['name'] == "" || $_POST['data'] == "") {
    $code = 199;
    $status = "post data 不全";
}else{
    $now_timestamp = date_timestamp_get(date_create());
    $filetype = end(explode('.', $_POST['name']));
    $image_field = 'pic'.($_POST['position']+1);
    $impage_path = '../../../web/webimages/winenote/';
    $filename = "pic".$now_timestamp.".".$filetype;
    $target = $impage_path.$filename;
    $post_data = base64_decode($_POST['data']);
    $success = file_put_contents($target, $post_data); 
    
    $query_update = sprintf("UPDATE wine_note SET %s = %s WHERE id = %s", $image_field , GetSQLValueString($filename, "text"), GetSQLValueString($_POST['wine_note_id'], "int"));
    
    $check_update = mysql_query($query_update, $iwine) or die(mysql_error());
    
    if($check_update == true){
        $code = 100;
        $status = "success";
    }else{
        $code = 199;
        $status = "update fail";
    }
    
}
$data['code'] = $code;
$data['status'] = $status;
print json_encode($data);
?>
