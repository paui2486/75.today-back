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
$each_data = array();

if($_POST['member_id']){
    if($_POST['wine_note_id'] <> ""){
        $query_select = sprintf("SELECT * FROM wine_note WHERE id = %s AND member_id = %s", GetSQLValueString($_POST['wine_note_id'], "int"), GetSQLValueString($_POST['member_id'], "int"));
    }else{
        $query_select = sprintf("SELECT * FROM wine_note WHERE member_id = %s", GetSQLValueString($_POST['member_id'], "int"));
    }
    $data['sql_select'] = $query_select;
    $select_query = mysql_query($query_select, $iwine) or die(mysql_error());
    $totalRows_select = mysql_num_rows($select_query);
    if ($totalRows_select > 0){
        $data['data'] = array();
        while($each_row = mysql_fetch_assoc($select_query)){
            if (strlen($each_row['pic1'])>0) $each_row['pic1'] = 'http://www.iwine.com.tw/webimages/winenote/'.$each_row['pic1'];
            if (strlen($each_row['pic2'])>0) $each_row['pic2'] = 'http://www.iwine.com.tw/webimages/winenote/'.$each_row['pic2'];
            if (strlen($each_row['pic3'])>0) $each_row['pic3'] = 'http://www.iwine.com.tw/webimages/winenote/'.$each_row['pic3'];
            array_push($data['data'], $each_row);
        };
        $code = 100;
        $status = 'success';
    }else{
        $code = 131;
        $status = "wine_note_id not exists.";
    }

}else{
    $code = 199;
    $status = "no member id";
}

$data['code'] = $code;
$data['status'] = $status;
print json_encode($data);
?>
