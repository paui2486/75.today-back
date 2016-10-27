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


$query_expert = "SELECT * FROM expert Where active = 1 order by name"; 
$experts = mysql_query($query_expert, $iwine) or die(mysql_errno());
$total_experts = mysql_num_rows($experts);
$data['total'] = $total_experts;


if($total_experts == 0){
    $code = 151;
    $status = "no expert in database";
}else{
    while($each_expert=mysql_fetch_assoc($experts)){
        
        unset($each_expert['password_md5']);
        unset($each_expert['account']);
        unset($each_expert['last_login']);
        $each_expert['icon'] = "http://admin.iwine.com.tw/webimages/expert/".$each_expert['icon'];
        $data['data'][] = $each_expert;
        $code = 100;
        $status = 'success';

    };
}

$data['code'] = $code;
$data['status'] = $status;
mysql_free_result($experts);
// mysql_free_result($joiner);

print json_encode($data);
?>
