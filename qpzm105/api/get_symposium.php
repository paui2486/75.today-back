<?php header('content-type: application/json; charset=utf-8');

require_once('../../Connections/iwine.php');
require_once('function/funcs.php');
mysql_select_db($database_iwine, $iwine);



$obj_id = ($_GET["id"]);
// current month first day
$first_day = date('Y-m-01')." 00:00:00"; 
// get 3 days 
$order_datelimit = Date('Y-m-d', strtotime("+3 days"));
$now = date( "Y-m-d H:i:s", mktime());


if (strlen($obj_id) > 0 ){
    $query_symposium = "SELECT * FROM symposium WHERE id =".$obj_id;
}else{
    $query_symposium = "SELECT * FROM symposium WHERE active = 1 AND start_date >= '".$first_day."' ORDER BY id ASC";
    // $query_symposium = "SELECT * FROM symposium WHERE start_date >= '".$first_day."' AND contain_html is null ORDER BY id ASC";
}

$symposium = mysql_query($query_symposium, $iwine) or die(mysql_error());
$totalRows_symposium = mysql_num_rows($symposium);

$result = array();
$data = array();

if ($totalRows_symposium > 0){
    $datacount = 1;
    while($each_row = mysql_fetch_assoc($symposium)){
        // get 3 days ago paid seats 
        $query_orders = "SELECT * FROM symposium_orders WHERE create_time < '".$order_datelimit." 00:00:00' AND is_paid = '1' AND symposium_id = ".$each_row['id'];
        $orders = mysql_query($query_orders, $iwine) or die(mysql_error());
        $total_orders = mysql_num_rows($orders);
        // get in 3 days register seats
        $query_in3days = "SELECT * FROM symposium_orders WHERE create_time >= '".$order_datelimit." 00:00:00' AND symposium_id = ".$each_row['id'];
        $in3days = mysql_query($query_in3days, $iwine) or die(mysql_error());
        $total_in3days = mysql_num_rows($in3days);
        if ((($each_row['seats'] - $total_in3days - $total_orders) > 0) && (strtotime($now) < strtotime($each_row['order_deadline']) )){
            $each_row['available'] = true;
        }else{
            $each_row['available'] = false;
        }
        $location = get_location($each_row['address']);
        $each_row['latitude'] = $location['latitude'];
        $each_row['longitude'] = $location['longitude'];
        
        mysql_free_result($orders);
        mysql_free_result($in3days);
        
        $each_row['link'] = 'http://www.iwine.com.tw/symposium.php?s_id='.$each_row['id'];
        if (strlen($each_row['pic1'])>0) $each_row['pic1'] = 'http://www.iwine.com.tw/webimages/symposium/'.$each_row['pic1'];
        if (strlen($each_row['pic2'])>0) $each_row['pic2'] = 'http://www.iwine.com.tw/webimages/symposium/'.$each_row['pic2'];
        if (strlen($each_row['pic3'])>0) $each_row['pic3'] = 'http://www.iwine.com.tw/webimages/symposium/'.$each_row['pic3'];
        if (strlen($each_row['pic4'])>0) $each_row['pic4'] = 'http://www.iwine.com.tw/webimages/symposium/'.$each_row['pic4'];
        if (strlen($each_row['pic5'])>0) $each_row['pic5'] = 'http://www.iwine.com.tw/webimages/symposium/'.$each_row['pic5'];
        $data[] = $each_row;
        
        $datacount += 1;
    }
    $result['data']= $data;
    $result['total'] = $totalRows_symposium;
}else{
    $result['error'] = "no result";
    $result['total'] = $totalRows_symposium;
}

mysql_free_result($symposium);
print json_encode($result);
?>
