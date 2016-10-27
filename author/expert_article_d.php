<?php require_once('session_check_expert.php'); ?>
<?php require_once('Connections/lovelove.php'); ?>
<?php require_once('Connections/iwine.php'); ?>
<?php require_once('func/func.php'); ?>

<?php
if (!function_exists("GetSQLValueString")) {
    function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") {
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



$p_id = $_GET['p_id'];
$strSQL = sprintf("UPDATE expert_article SET n_status=%s WHERE n_id=%s",
                       GetSQLValueString($_POST['n_status'], "text"),
                       GetSQLValueString($p_id, "int"));
mysql_select_db($database_iwine, $iwine);
$Result1 = mysql_query($strSQL, $iwine) or die(mysql_error());
	
	msg_box('文章隱藏成功!');
	go_to('expert_article_l.php');
	exit;

?>