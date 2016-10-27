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

if ($_POST['member_id'] <> "" && $_POST['wine_note_id']<> "" ) {
  
    $query_check_member = sprintf("SELECT * FROM member WHERE m_id = %s", GetSQLValueString($_POST['member_id'], "int"));
    $check_member = mysql_query($query_check_member, $iwine) or die(mysql_error());
    $totalRows_check_member = mysql_num_rows($check_member);
    
    $query_check_note = sprintf("SELECT * FROM wine_note WHERE id = %s", GetSQLValueString($_POST['wine_note_id'], "int"));
    $check_note = mysql_query($query_check_note, $iwine) or die(mysql_error());
    $row_note = mysql_fetch_assoc($check_note);
    $totalRows_check_note = mysql_num_rows($check_note);
    
    if($totalRows_check_member == 1 && $totalRows_check_note == 1){
        if($_POST['modify_time'] == $row_note['modify_time']){
            $code = 199;
            $status = "modify time is same with note query";
        }else{
            $alter_sql = sprintf("UPDATE wine_note SET color=%s, rating = %s, member_id = %s, name = %s, region = %s, price = %s, unit = %s , flavor = %s, location = %s, comment = %s, producer = %s, country = %s, varietals = %s, vintage = %s, alcohol_content = %s, sweetness = %s, tannins = %s, acidity = %s, body = %s, create_time = %s, modify_time = %s WHERE id = %s", 
            GetSQLValueString($_POST['color'], "text"), 
            GetSQLValueString($_POST['rating'], "int"), 
            GetSQLValueString($_POST['member_id'], "int"), 
            GetSQLValueString($_POST['name'], "text"), 
            GetSQLValueString($_POST['region'], "text"), 
            GetSQLValueString($_POST['price'], "int"), 
            GetSQLValueString($_POST['unit'], "text"), 
            GetSQLValueString($_POST['flavor'], "text"), 
            GetSQLValueString($_POST['location'], "text"), 
            GetSQLValueString($_POST['comment'], "text"), 
            GetSQLValueString($_POST['producer'], "text"), 
            GetSQLValueString($_POST['country'], "text"), 
            GetSQLValueString($_POST['varietals'], "text"), 
            GetSQLValueString($_POST['vintage'], "text"), 
            GetSQLValueString($_POST['alcohol_content'], "double"), 
            GetSQLValueString($_POST['sweetness'], "text"), 
            GetSQLValueString($_POST['tannins'], "text"), 
            GetSQLValueString($_POST['acidity'], "text"), 
            GetSQLValueString($_POST['body'], "text"), 
            GetSQLValueString($_POST['create_time'], "text"), 
            GetSQLValueString($_POST['modify_time'], "text"), 
            GetSQLValueString($_POST['wine_note_id'], "int"));
            $data['sql'] =  $alter_sql;
            mysql_select_db($database_iwine, $iwine);
            $Result1 = mysql_query($alter_sql, $iwine) or die(mysql_error());
            
            $code = 100;
            $status = "success";
        } 
    }else{
        $code = 199;
        $status = "query error, member return ".$totalRows_check_member." results, note return".$totalRows_check_note." results.";
    }
}else{
    $code = 199;
    $status = "no post data";
}

$data['code'] = $code;
$data['status'] = $status;
print json_encode($data);
  
?>
