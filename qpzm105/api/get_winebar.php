<?php header('content-type: application/json; charset=utf-8');

require_once('../../Connections/iwine.php'); 
require_once('function/funcs.php');
mysql_select_db($database_iwine, $iwine);

$obj_id = ($_GET["id"]);

if (strlen($obj_id) > 0 ){
    $query = "SELECT * FROM bar WHERE id =".$obj_id;
}else{
    $query = "SELECT * FROM bar ORDER BY id ASC";
}

$query_result = mysql_query($query, $iwine) or die(mysql_error());
$totalRows = mysql_num_rows($query_result);

$data = array(); 
$result = array(); 

if ($totalRows > 0){
    while($each_row = mysql_fetch_assoc($query_result)){
        if (strlen($each_row['pic1'])>0) $each_row['pic1'] = 'http://admin.iwine.com.tw/webimages/bar/'.$each_row['pic1'];
        if (strlen($each_row['pic2'])>0) $each_row['pic2'] = 'http://admin.iwine.com.tw/webimages/bar/'.$each_row['pic2'];
        if (strlen($each_row['pic3'])>0) $each_row['pic3'] = 'http://admin.iwine.com.tw/webimages/bar/'.$each_row['pic3'];
        if (strlen($each_row['pic4'])>0) $each_row['pic4'] = 'http://admin.iwine.com.tw/webimages/bar/'.$each_row['pic4'];
        if (strlen($each_row['pic4'])>0) $each_row['pic5'] = 'http://admin.iwine.com.tw/webimages/bar/'.$each_row['pic5'];
        $location = get_location($each_row['address']);
        $each_row['latitude'] = $location['latitude'];
        $each_row['longitude'] = $location['longitude'];
        $data[] = $each_row;
        
    }
    $result['data'] = $data;
    $result['status'] = "success";
    $result['total'] = $totalRows;
}else{
    $result['status'] = "no result";
    $result['total'] = $totalRows;
}
print json_encode($result);
?>
