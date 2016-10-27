<?php
//include('public_include.php');
include('session_check.php');
require_once('config.inc.php');
?>
<?php require_once('../Connections/iwine.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

$currentPage = $_SERVER["PHP_SELF"];

$maxRows_syslog = 30;
$pageNum_syslog = 0;
if (isset($_GET['pageNum_syslog'])) {
  $pageNum_syslog = $_GET['pageNum_syslog'];
}
$startRow_syslog = $pageNum_syslog * $maxRows_syslog;

mysql_select_db($database_iwine, $iwine);
$query_syslog = "SELECT * FROM login_log ORDER BY id DESC";
$query_limit_syslog = sprintf("%s LIMIT %d, %d", $query_syslog, $startRow_syslog, $maxRows_syslog);
$syslog = mysql_query($query_limit_syslog, $iwine) or die(mysql_error());
$row_syslog = mysql_fetch_assoc($syslog);

if (isset($_GET['totalRows_syslog'])) {
  $totalRows_syslog = $_GET['totalRows_syslog'];
} else {
  $all_syslog = mysql_query($query_syslog);
  $totalRows_syslog = mysql_num_rows($all_syslog);
}
$totalPages_syslog = ceil($totalRows_syslog/$maxRows_syslog)-1;

$queryString_syslog = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_syslog") == false && 
        stristr($param, "totalRows_syslog") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_syslog = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_syslog = sprintf("&totalRows_syslog=%d%s", $totalRows_syslog, $queryString_syslog);
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>iWine - 後台管理系統</title>

<link href="css.css" rel="stylesheet" type="text/css">
<script type="text/javascript">
<!--
function dele(ids){
	if(window.confirm('確定要刪除?')){
		window.location='account_d.php?n_id='+ids;
	}
}
//-->
</script>

</head>

<body marginheight="0" marginwidth="0" bgcolor="#666666">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td align="center" valign="top" bgcolor="666666"><table width="100%" height="605" border="0" align="center" cellpadding="0" cellspacing="8">
      <tr>
        <td height="2" bgcolor="#FFFFFF"></td>
        </tr>
      <tr>
        <td height="40" align="center" valign="middle" class="contnet_w">◎ 系統紀錄 ◎</td>
        </tr>
      <tr>
        <td height="2" bgcolor="#FFFFFF"></td>
        </tr>
      <tr>
        <td align="center" valign="top"><table width="80%" border="0" cellpadding="3" cellspacing="0" bgcolor="#494949">
          
          <tr>
            <td><div align="center">
              <table width="100%" border="0" cellpadding="5" cellspacing="1" class="table">
                <tr bgcolor="#DDDDDD" >
                  <td align="center" background="images/transp.gif" bgcolor="#999999" class="contnet_w">嘗試登入時間</td>
                  <td align="center" background="images/transp.gif" bgcolor="#999999" class="contnet_w">來源ip</td>
                  <td align="center" background="images/transp.gif" bgcolor="#999999" class="contnet_w">使用帳號</td>
                  <td align="center" background="images/transp.gif" bgcolor="#999999" class="contnet_w">成功與否</td>
                  </tr>
                <?php do { ?>
                  <tr >
                    <td align="center" bgcolor="#FFFFFF"><?php echo $row_syslog['login_time']; ?></td>
                    <td align="center" bgcolor="#FFFFFF"><?php echo $row_syslog['login_ip']; ?></td>
                    <td align="center" bgcolor="#FFFFFF"><?php echo $row_syslog['account_pid']; ?></td>
                    <td align="center" bgcolor="#FFFFFF"><?php
				switch($row_syslog['status']){
					case 'T':
					echo "成功";
					break;
					case 'F':
					echo "失敗";
					break;
					}
				?></td>
                  </tr>
                  <?php } while ($row_syslog = mysql_fetch_assoc($syslog)); ?>
  <tr bgcolor="#F3F3F1" >
    <td colspan="4" align="center"><table border="0">
      <tr>
          <td><?php if ($pageNum_syslog > 0) { // Show if not first page ?>
              <a href="<?php printf("%s?pageNum_syslog=%d%s", $currentPage, 0, $queryString_syslog); ?>"><img src="First.gif"></a>
              <?php } // Show if not first page ?></td>
          <td><?php if ($pageNum_syslog > 0) { // Show if not first page ?>
              <a href="<?php printf("%s?pageNum_syslog=%d%s", $currentPage, max(0, $pageNum_syslog - 1), $queryString_syslog); ?>"><img src="Previous.gif"></a>
              <?php } // Show if not first page ?></td>
          <td><?php if ($pageNum_syslog < $totalPages_syslog) { // Show if not last page ?>
              <a href="<?php printf("%s?pageNum_syslog=%d%s", $currentPage, min($totalPages_syslog, $pageNum_syslog + 1), $queryString_syslog); ?>"><img src="Next.gif"></a>
              <?php } // Show if not last page ?></td>
          <td><?php if ($pageNum_syslog < $totalPages_syslog) { // Show if not last page ?>
              <a href="<?php printf("%s?pageNum_syslog=%d%s", $currentPage, $totalPages_syslog, $queryString_syslog); ?>"><img src="Last.gif"></a>
              <?php } // Show if not last page ?></td>
        </tr>
    </table></td>
  </tr>
                </table>
              </div></td>
            </tr>
          </table></td>
      </tr>
    </table></td>
  </tr>
</table>
</body>
</html>

<?php
mysql_free_result($syslog);
?>
