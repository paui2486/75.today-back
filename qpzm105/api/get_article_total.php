<?php header('content-type: application/json; charset=utf-8');

require_once('../../Connections/iwine.php');
require_once('function/funcs.php');
mysql_select_db($database_iwine, $iwine);


$query_article = "SELECT n_id, n_class, n_title, n_fig1, n_cont FROM article WHERE n_status = 'Y'";

$article = mysql_query($query_article, $iwine) or die(mysql_error());
$totalRows_article = mysql_num_rows($article);

$result = array();

$result['code']= 100;
$result['status']= "success";
$result['total'] = $totalRows_article;

mysql_free_result($article);
print json_encode($result);
?>
