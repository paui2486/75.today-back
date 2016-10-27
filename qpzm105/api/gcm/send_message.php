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
// $file = fopen("log_send.txt", "a+")or die("can't open file");

// fwrite($file, "==========================\n");
// fwrite($file, 'time: '.$_today."\n");
// $data['now'] = $_today;

// $data['code'] = $code;
// $data['status'] = $status;
// fwrite($file, 'code: '.$code."\n");
// fwrite($file, 'status: '.$status."\n");

$gcm = new GCM();
 
    // $registatoin_ids = array('APA91bFmq-8CHcIatAv0VTjjs4Q-EPaB7GkwYK1ToipRgsIqv95W06MnJycNCcmAQirMXrG8-8tUSKdpcAq0fNR1Y6x04V5J_xq93zJZC1f_9A3sf2e5_dNLE_LGwaf-pQBjnreZWmHEABU3C8a_vWTqKvgUmTYnfA',);
    $registatoin_ids = array('APA91bEHytEQrXN1CvSTVbv7orLKf-kcJFD4rRHysdJm3f8sVf8TSS3hKFbaKiHYo7BD0ZKRXPZoKJBiCdl2m4pDhvskXi95nOcCKDIetECjKtwTjwKV3qgTUn3zwywtUoMJ-7F431JqPNfTh12pgLIQ_GBPUMF0Kw', 'APA91bEtiixE278PwO6q2FLpjYOkSHg_bPQxQ-Sn8Xz3E6WvNS0f_64Lk1yCHt7ddC0n9kxSTHe8qjHogzDVAXq-ID7BiVfWRHf7O5C_X-r6rCFUVivPkmsoAA6dh3AqDBNbv76Du_LvEZT293DPXMTzsF59a3enTA');
    $_data = array(
        "title"         =>      "New Article",
        "description"   =>      "test123"
    );
    $message = array(
        "data" => $_data
    );
 
    $result = $gcm->send_notification($registatoin_ids, $message);
 
    // echo $result;


// fclose($file);
print json_encode($result);
?>