<?php header('content-type: application/json; charset=utf-8');

require_once('../../Connections/iwine.php');
mysql_select_db($database_iwine, $iwine);


$data = array();
if (isset($_POST['member_id'])) {
    $member_id = $_POST['member_id'];
    // $data['member_id'] = $member_id;
    if ($_POST['symposium_id'] <> "") {
        $symposium_id = $_POST['symposium_id'];
        // $data['symposium_id'] = $symposium_id;
        $query_symorders = "SELECT symposium_id, is_paid FROM symposium_orders WHERE symposium_id = '".$symposium_id."' AND member_id = '".$member_id."'";
    }else{
        $query_symorders = "SELECT symposium_id, is_paid FROM symposium_orders WHERE member_id = '".$member_id."'";
    }
    // $data['sql'] = $query_symorders;
    mysql_select_db($database_iwine, $iwine);
    $symorders = mysql_query($query_symorders, $iwine) or die(mysql_error());
    $totalRows_symorders = mysql_num_rows($symorders);
    if($totalRows_symorders == 0){
        $code = 199;
        $status = "recorders not exists";
    }else{
        while($row_symorders = mysql_fetch_assoc($symorders)){
            $data['data'][] = $row_symorders;
        };
        $code = 100;
        $status = "success";
    }
    
}else{
    $code = 199;
    $status = 'no post sumposium id.';
}

$data['code'] = $code;
$data['status'] = $status;

mysql_free_result($row_symorders);
print json_encode($data);
?>
