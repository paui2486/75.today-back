<?php header('content-type: application/json; charset=utf-8');

require_once('../../Connections/iwine.php');
require_once('function/funcs.php');
mysql_select_db($database_iwine, $iwine);

if (!function_exists("GetSQLValueString")) {
    function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") {
        if (PHP_VERSION < 6) { $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue; }
        $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

        switch ($theType) {
            case "text":
              $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
              break;    
            case "long":
            case "int":
              $theValue = ($theValue != "") ? intval($theValue) : "NULL";
              break;
            case "double":
              $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
              break;
            case "date":
              $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
              break;
            case "defined":
              $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
              break;
      }
        return $theValue;
    }
}


$data = array();
if (isset($_POST['member_id']) && isset($_POST['old_passwd']) && isset($_POST['new_passwd'])) {
    $m_id = $_POST['member_id'];
    $old_passwd = md5($_POST['old_passwd']);
    $new_passwd = $_POST['new_passwd'];
    
    $query_member = sprintf("SELECT * FROM member WHERE m_id = %s", GetSQLValueString($m_id, "text"));
    // $data['sql'] = $query_member;
    mysql_select_db($database_iwine, $iwine);
    $member = mysql_query($query_member, $iwine) or die(mysql_error());
    $totalRows_member = mysql_num_rows($member);
    
    if($totalRows_member == 1){
            $row_member = mysql_fetch_assoc($member);
            $_passwd_md5 = md5($new_passwd);
            if($old_passwd == $row_member['m_passwd_md5']){
                $_passwd_id = $row_member['m_id'];
                $insertSQL = sprintf("UPDATE member SET m_passwd_md5 = %s WHERE m_id = %s", GetSQLValueString($_passwd_md5, "text"), GetSQLValueString($_passwd_id, "int"));
                // $data['insertSQL'] = $insertSQL;
                // $data['new_passwd'] = $new_passwd;
                mysql_select_db($database_iwine, $iwine);
                $Result1 = mysql_query($insertSQL, $iwine) or die(mysql_error());
                $code = 100;
                $status = "success";
            }else{
                $code = 102;
                $status = "password incorrect.";
            }
        
        mysql_free_result($row_member);
    }else{
        $code = 199;
        $status = "member query result = ".$totalRows_member;
    }
    
}else{
    $code = 199;
    $status = 'post data error, no account or old_passwd or new_passwd.';
}

$data['code'] = $code;
$data['status'] = $status;


print json_encode($data);
?>
