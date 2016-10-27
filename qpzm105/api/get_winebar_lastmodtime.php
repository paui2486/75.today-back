<?php header('content-type: application/json; charset=utf-8');

require_once('../../Connections/iwine.php'); 
require_once('function/funcs.php');
mysql_select_db($database_iwine, $iwine);

$query = 'SELECT mod_time FROM bar order by mod_time desc limit 1'; 
    // $query = 'SELECT * FROM bar order by mod_time desc limit 1'; 
    $query_result = mysql_query($query, $iwine) or die(mysql_error());
    $query_data = mysql_fetch_assoc($query_result);
    $totalRows = mysql_num_rows($query_result);

$data = array(); 
if($totalRows == 1 ){
    $query_data['mod_timestamp'] = strtotime($query_data['mod_time']);
    $data['data'] = $query_data;
    $data['code'] = 100;
    $data['status'] = 'success';
}else{
    $data['code'] = 199;
    $data['status'] = 'error';
}

print json_encode($data);
?>
