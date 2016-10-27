<?php header('content-type: application/json; charset=utf-8');

require_once('../../Connections/iwine.php');
require_once('function/funcs.php');
mysql_select_db($database_iwine, $iwine);


$query_member = "SELECT m_account, m_email, m_id FROM member";

$member = mysql_query($query_member, $iwine) or die(mysql_error());
$totalRows_article = mysql_num_rows($member);

$result = array();

// $result['sql'] = $query_article;
$_today = date('Y-m-d H:i:s'); 
if ($totalRows_article > 0){
    $data = array();
    while($each_row = mysql_fetch_assoc($member)){
        if($each_row['m_email']<>""){
            $email = $each_row['m_email'];
        }else{
            $email = $each_row['m_account'];
        }
        $check_sql = "SELECT e_email from email_list where e_email = '".$email."'";
        $check = mysql_query($check_sql, $iwine) or die(mysql_error());
        $totalRows_check = mysql_num_rows($check);
        if($totalRows_check==0){
            $insert_sql = "INSERT INTO email_list (e_email, update_time) VALUES ('".$email."', '".$_today."')";
            $each_row['sql'] = $insert_sql;
            $data[] = $each_row;
            // mysql_select_db($database_iwine, $iwine);
            // $Result1 = mysql_query($insert_sql, $iwine) or die(mysql_error());
        }else{
            $each_row['already'] = true;
            $data[] = $each_row;
        }
    }
    $result['data'] = $data;
}
mysql_free_result($article);
print json_encode($result);
?>
