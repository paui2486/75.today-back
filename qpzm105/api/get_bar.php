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
    $query_bar = "SELECT * FROM bar WHERE id =".$obj_id;
}else{
    $query_bar = "SELECT * FROM bar ORDER BY id ASC";
}

$bar = mysql_query($query_bar, $iwine) or die(mysql_error());
$totalRows_bar = mysql_num_rows($bar);

$result = array();
$data = array();

if ($totalRows_bar > 0){
    $datacount = 1;
    while($each_row = mysql_fetch_assoc($bar)){
        // get 3 days ago paid seats 
        // $query_orders = "SELECT * FROM bar_orders WHERE create_time < '".$order_datelimit." 00:00:00' AND is_paid = '1' AND bar_id = ".$each_row['id'];
        // $orders = mysql_query($query_orders, $iwine) or die(mysql_error());
        // $total_orders = mysql_num_rows($orders);
        // get in 3 days register seats
        // $query_in3days = "SELECT * FROM bar_orders WHERE create_time >= '".$order_datelimit." 00:00:00' AND bar_id = ".$each_row['id'];
        // $in3days = mysql_query($query_in3days, $iwine) or die(mysql_error());
        // $total_in3days = mysql_num_rows($in3days);
        // if ((($each_row['seats'] - $total_in3days - $total_orders) > 0) && (strtotime($now) < strtotime($each_row['order_deadline']) )){
            // $each_row['available'] = true;
        // }else{
            // $each_row['available'] = false;
        // }
        if($each_row['company_name']!="" && $each_row['address']!="" && $each_row['telphone'] != ""){
            $location = get_location($each_row['address']);
            $each_row['latitude'] = $location['latitude'];
            $each_row['longitude'] = $location['longitude'];
            $each_row['password_md5'] = null;
            unset($each_row['password_md5']);
            unset($each_row['last_login']);
            unset($each_row['regist_date']);
            unset($each_row['account']);
            // mysql_free_result($orders);
            // mysql_free_result($in3days);
            
            // $each_row['link'] = 'http://www.iwine.com.tw/bar.php?s_id='.$each_row['id'];
            if (strlen($each_row['pic1'])>0) $each_row['pic1'] = 'http://www.iwine.com.tw/webimages/bar/'.$each_row['pic1'];
            if (strlen($each_row['pic2'])>0) $each_row['pic2'] = 'http://www.iwine.com.tw/webimages/bar/'.$each_row['pic2'];
            if (strlen($each_row['pic3'])>0) $each_row['pic3'] = 'http://www.iwine.com.tw/webimages/bar/'.$each_row['pic3'];
            if (strlen($each_row['pic4'])>0) $each_row['pic4'] = 'http://www.iwine.com.tw/webimages/bar/'.$each_row['pic4'];
            if (strlen($each_row['pic5'])>0) $each_row['pic5'] = 'http://www.iwine.com.tw/webimages/bar/'.$each_row['pic5'];
            $data[] = $each_row;
            
            $datacount += 1;
        }else{
            // $return_data = array();
            // $return_data['id'] = $each_row['id'];
            // $return_data['status'] = "no company_name or address or telphone";
            // $data[] = $return_data;
        }
    }
    $result['code']= 100;
    $result['status']= 'success';
    $result['data']= $data;
    $result['total'] = $datacount-1;
}else{
    $result['code']= 199;
    $result['status']= 'no result';
    $result['total'] = $totalRows_bar;
}

mysql_free_result($bar);
print json_encode($result);
?>
