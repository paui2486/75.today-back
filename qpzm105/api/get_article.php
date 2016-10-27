<?php header('content-type: application/json; charset=utf-8');

require_once('../../Connections/iwine.php');
require_once('function/funcs.php');
mysql_select_db($database_iwine, $iwine);

if($_GET["current_page"] > 0){
    $current_page = $_GET["current_page"];
}else{
    $current_page = 0;
}

if($_GET["per_page"] > 0 ){
    $per_page = $_GET["per_page"];
}else{
    $per_page = 0; 
}
if ($current_page > 0 && $per_page > 0 ){
    if($current_page == 1 ){
        $start = $current_page;
    }else{
        $start = ($current_page-1)*$per_page;
    }
    
    $query_article = "SELECT n_id, n_class, n_title, n_fig1, n_cont FROM article WHERE n_status = 'Y' ORDER BY n_id DESC limit ".$start." ,".$per_page;
}else{
    $query_article = "SELECT n_id, n_class, n_title, n_fig1, n_cont FROM article WHERE n_status = 'Y' ORDER BY n_id DESC";
    // $query_article = "SELECT n_id, n_class, n_title, n_fig1, n_cont FROM article ORDER BY n_id DESC";
}

$article = mysql_query($query_article, $iwine) or die(mysql_error());
$totalRows_article = mysql_num_rows($article);

$result = array();
$data = array();
// $result['sql'] = $query_article;

if ($totalRows_article > 0){
    $datacount = 1;
    while($each_row = mysql_fetch_assoc($article)){
        if (strlen($each_row['n_fig1'])>0){
            
            $path_image = '../../webimages/article/'.$each_row['n_fig1'];
            $each_row['n_fig1'] = 'http://admin.iwine.com.tw/webimages/article/'.$each_row['n_fig1'];
            list($n_fig1_width, $n_fig1_height) = getimagesize($path_image);
            $each_row['link'] = 'http://www.iwine.com.tw/article.php?n_id='.$each_row['n_id'];
            $each_row['path'] = $path_image;
            $each_row['n_fig1_width'] = $n_fig1_width;
            $each_row['n_fig1_height'] = $n_fig1_height;
        }
        $data[] = $each_row;
        $datacount += 1;
    }
    $result['code']= 100;
    $result['status']= "success";
    $result['data']= $data;
    $result['total'] = $totalRows_article;
}else{
    $result['code']= 199;
    $result['status']= "no result";
    $result['total'] = $totalRows_article;
}

mysql_free_result($article);
print json_encode($result);
?>
