<?php header('content-type: application/json; charset=utf-8');

require_once('../../Connections/iwine.php'); 
mysql_select_db($database_iwine, $iwine);

$obj_id = ($_GET["id"]);

if (strlen($obj_id) > 0 ){
	$query = "SELECT * FROM wine_supplier WHERE id =".$obj_id;
}else{
	$query = "SELECT * FROM wine_supplier ORDER BY id ASC";
}

$result = mysql_query($query, $iwine) or die(mysql_error());
//$row_symposium = mysql_fetch_assoc($symposium);
$totalRows = mysql_num_rows($result);

$data = array(); 

if ($totalRows > 0){
	while($each_row = mysql_fetch_assoc($result)){
		// if (strlen($each_row['pic1'])>0) $each_row['pic1'] = 'http://admin.iwine.com.tw/webimages/bar/'.$each_row['pic1'];
		// if (strlen($each_row['pic2'])>0) $each_row['pic2'] = 'http://admin.iwine.com.tw/webimages/bar/'.$each_row['pic2'];
		// if (strlen($each_row['pic3'])>0) $each_row['pic3'] = 'http://admin.iwine.com.tw/webimages/bar/'.$each_row['pic3'];
		// if (strlen($each_row['pic4'])>0) $each_row['pic4'] = 'http://admin.iwine.com.tw/webimages/bar/'.$each_row['pic4'];
		// if (strlen($each_row['pic4'])>0) $each_row['pic5'] = 'http://admin.iwine.com.tw/webimages/bar/'.$each_row['pic5'];
		$data[] = $each_row;
		$data['total'] = $totalRows;
	}
}else{
	$data['error'] = "no result";
	$data['total'] = $totalRows;
}
print json_encode($data); 
?>
