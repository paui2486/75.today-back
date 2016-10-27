<?php include('session_check.php'); ?>
<?php require_once('../Connections/iwine.php'); ?>
<?php
$f = 0;

$sql_select = "SELECT * FROM email_list ORDER BY e_email ASC";

mysql_select_db($database_iwine, $iwine);
$query_email = $sql_select;
$email = mysql_query($query_email, $iwine) or die(mysql_error());
// $row_email = mysql_fetch_assoc($email);
$totalRows_email = mysql_num_rows($email);

require_once("../func/csv.php");

$saveasname=date('YmdHis').'_mail.xls';
$taiwan_year = date('Y') - 1911 ;
$taiwan_today = $taiwan_year.date('m').date('d');
    
$tmp = excel_start(true).excel_header(array("電子郵件"),true);

$_num = 0 ;
if ($totalRows_email > 0) { // Show if recordset not empty
    while ($row_email = mysql_fetch_assoc($email)) {
        $tmp .= excel_row(array($row_email['e_email']),true);
        
    }; 
} // Show if recordset not empty 


        $tmp .=excel_end(true);
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; Filename="'.$saveasname.'"');
        header('Pragma: no-cache');
        header('Content-length:'.strlen($tmp));
        
        echo $tmp;

mysql_free_result($email);
?>
