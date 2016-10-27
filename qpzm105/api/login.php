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

if($_POST['mem_type'] <> "" && $_POST['mem_id'] <> "" && $_POST['mem_passwd'] <> ""){
    $mem_type = $_POST['mem_type'];
    if($_POST['mem_type']=='member'){
        $query_login = sprintf("SELECT * FROM member WHERE m_account = %s", GetSQLValueString($_POST['mem_id'], "text"));
    }if($_POST['mem_type']=='bar'){
        $query_login = sprintf("SELECT * FROM bar WHERE account = %s", GetSQLValueString($_POST['mem_id'], "text"));
    }if($_POST['mem_type']=='wine_supplier'){
        $query_login = sprintf("SELECT * FROM wine_supplier WHERE account = %s", GetSQLValueString($_POST['mem_id'], "text"));
    }else{
        $code = 199;
        $status = "member type error";
    }
    // $data['query_login'] = $query_login;
    $login = mysql_query($query_login, $iwine) or die(mysql_error());
    $login_result_num = mysql_num_rows($login);
    // $data['login_result_num'] = $login_result_num;

    if($login_result_num == 1){
        $now_date = date('Y-m-d H:i:s');
        $login_row = mysql_fetch_assoc($login);
        $post_md5_pwd = md5(htmlspecialchars($_POST['mem_passwd']));
        if($login_row['m_passwd_md5'] == $post_md5_pwd || $login_row['password_md5'] == $post_md5_pwd){
            $code = 100;
            $status = "success";
            unset($login_row['m_passwd_md5']);
            unset($login_row['password_md5']);
            $data['data'] = $login_row;
            if($_POST['mem_type']=='member'){
                $query_update = sprintf("UPDATE member SET last_login = %s WHERE m_id =%s", GetSQLValueString($now_date, "date"), GetSQLValueString($login_row['m_id'], "int"));
            }if($_POST['mem_type']=='bar'){
                $query_update = sprintf("UPDATE bar SET last_login = %s WHERE id =%s", GetSQLValueString($now_date, "date"), GetSQLValueString($login_row['id'], "int"));
            }if($_POST['mem_type']=='wine_supplier'){
                $query_update = sprintf("UPDATE wine_supplier SET last_login = %s WHERE id =%s", GetSQLValueString($now_date, "date"), GetSQLValueString($login_row['id'], "int"));
            }
            mysql_select_db($database_iwine, $iwine);
            $update_result = mysql_query($query_update, $iwine) or die(mysql_error());
        }else{
            $code = 102;
            $status = "password incorrect";
        }
    }else if($login_result_num == 0){
        $code = 101;
        $status = "account not exists";
    }else{
        $code = 199;
        $status = "login query error.";
    }
}else{
    $code = 199;
    if($_POST['mem_type'] == ""){
        $status = "no member type.";
    }else if($_POST['mem_id'] == ""){
        $status = "no member account.";
    }else if($_POST['mem_passwd'] == ""){
        $status = "no member password.";
    }
}

$data['code'] = $code;
$data['status'] = $status;
$data['member_type'] = $_POST['mem_type'];
mysql_free_result($login);
mysql_free_result($update_result);
print json_encode($data);
?>
