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

if(!empty($_POST['account'])){
  $account = $_POST['account'];
}else{
    $account = '-1';
}
$data = array();

$query_check_member = sprintf("SELECT * FROM member WHERE m_account = %s ", htmlspecialchars(GetSQLValueString($account, "text")));
$check_member = mysql_query($query_check_member, $iwine) or die(mysql_error());
$row_check_member = mysql_fetch_assoc($check_member);
$totalRows_check_member = mysql_num_rows($check_member);

if($totalRows_check_member==1){
    $status = "account exists";
    $code = 101;
}elseif($totalRows_check_member == 0){
    $_today = date('Y-m-d H:i:s'); 
    
    $insertSQL = sprintf("INSERT INTO member (m_account, m_passwd_md5, m_name, m_year, m_month, m_day, m_mobile, m_zip, m_county, m_city, m_address, m_email, m_edm, regist_date, last_login, last_modify) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString(trim($account), "text"),
                       GetSQLValueString(md5($_POST['passwd']), "text"),
                       GetSQLValueString($_POST['name'], "text"),
                       GetSQLValueString($_POST['bir_year'], "int"),
                       GetSQLValueString($_POST['bir_month'], "int"),
                       GetSQLValueString($_POST['bir_date'], "int"),
                       GetSQLValueString($_POST['mobile'], "text"),
                       GetSQLValueString($_POST['zipcode'], "text"),
                       GetSQLValueString($_POST['county'], "text"),
                       GetSQLValueString($_POST['district'], "text"),
                       GetSQLValueString($_POST['address'], "text"),
                       GetSQLValueString($_POST['account'], "text"),
                       GetSQLValueString("Y" ,"defined","'Y'","'N'"),
                       GetSQLValueString($_today, "date"),
                       GetSQLValueString($_today, "date"),
                       GetSQLValueString($_today, "date"));

    mysql_select_db($database_iwine, $iwine);
    $Result1 = mysql_query($insertSQL, $iwine) or die(mysql_error());
    $status = "success";
    $code = 100;
}else{
    $status = "account error";
    $code = 102;

}
$data['status'] = $status;
$data['code'] = $code;

print json_encode($data);
?>
