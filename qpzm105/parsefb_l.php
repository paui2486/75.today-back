<?php //include('session_check.php'); ?>
<?php require_once('../Connections/iwine.php'); ?>
<?php require_once('../Connections/iwine_shop.php'); ?>
<?php
if(!function_exists("GetSQLValueString")){
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

$editFormAction = $_SERVER['PHP_SELF'];
// if (isset($_SERVER['QUERY_STRING'])) {
  // $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
// }

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE article SET n_title=%s, n_class=%s, n_name=%s, n_date=%s, n_cont=%s, n_fig1=%s, n_tag=%s, n_order=%s, n_status=%s, n_hot=%s, view_counter=%s WHERE n_id=%s",
                       GetSQLValueString($_POST['n_title'], "text"),
					   GetSQLValueString($_POST['n_class'], "int"),
                       GetSQLValueString($_POST['n_name'], "text"),
                       GetSQLValueString($_POST['n_date'], "date"),
                       GetSQLValueString($_POST['n_cont'], "text"),
                       GetSQLValueString($_POST['rePic'], "text"),
					   GetSQLValueString($_POST['n_tag'], "text"),
                       GetSQLValueString($_POST['n_order'], "int"),
                       GetSQLValueString($_POST['n_status'], "text"),
					   GetSQLValueString($_POST['n_hot'], "text"),
					   GetSQLValueString($_POST['view_counter'], "int"),
                       GetSQLValueString($_POST['n_id'], "int"));

  mysql_select_db($database_iwine, $iwine);
  $Result1 = mysql_query($updateSQL, $iwine) or die(mysql_error());
  
  // msg_box('修改文章內容成功');
  // go_to('article_l.php');
  // exit;
}

$colname_news = "-1";
if (isset($_GET['n_id'])) {
  $colname_news = $_GET['n_id'];
}
mysql_select_db($database_iwine, $iwine);
$query_news = sprintf("SELECT * FROM article WHERE n_id = %s", GetSQLValueString($colname_news, "int"));
$news = mysql_query($query_news, $iwine) or die(mysql_error());
$row_news = mysql_fetch_assoc($news);
$totalRows_news = mysql_num_rows($news);

mysql_select_db($database_iwine, $iwine);
$query_article_class = "SELECT * FROM article_class ORDER BY pc_order ASC";
$article_class = mysql_query($query_article_class, $iwine) or die(mysql_error());
$row_article_class = mysql_fetch_assoc($article_class);
$totalRows_article_class = mysql_num_rows($article_class);

mysql_select_db($database_iwine, $iwine);
$query_product = sprintf("SELECT * FROM product_article WHERE a_type='article' AND a_id = %s ORDER BY id ASC", GetSQLValueString($colname_news, "int"));
$product = mysql_query($query_product, $iwine) or die(mysql_error());
// $row_product = mysql_fetch_assoc($product);
$totalRows_product = mysql_num_rows($product);
  ?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>iWine - 後台管理系統</title>
<style type="text/css">
<--
-->
</style>
<link href="css.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="js/jquery-1.7.2.min.js"></script>
<style type="text/css">@import "js/jquery.datepick.package-3.6.1/jquery.datepick.css";</style> 
<script type="text/javascript" src="js/jquery.datepick.package-3.6.1/jquery.datepick.js"></script>
<script type="text/javascript" src="js/jquery.datepick.package-3.6.1/jquery.datepick.pack.js"></script>
<script type="text/javascript" src="js/jquery.datepick.package-3.6.1/jquery.datepick-zh-TW.js"></script>
<script type="text/javascript" src="ckeditor/ckeditor.js"></script>
<script type="text/javascript">
function tmt_confirm(msg){
	document.MM_returnValue=(confirm(unescape(msg)));
}
</script>

</head>

<body >
<?
$homepage = file_get_contents('https://graph.facebook.com/?ids=http://www.your-website.com/the-url-or-so');
$html_obj = (array)json_decode($homepage);
echo $html_obj->('http://www.your-website.com/the-url-or-so');


?>
</body>
</html>
<?php
mysql_free_result($news);

mysql_free_result($article_class);
?>
