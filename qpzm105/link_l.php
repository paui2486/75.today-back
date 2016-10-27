<?php include('session_check.php'); ?>
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

$maxRows_flash = 10;
$pageNum_flash = 0;
if (isset($_GET['pageNum_flash'])) {
  $pageNum_flash = $_GET['pageNum_flash'];
}
$startRow_flash = $pageNum_flash * $maxRows_flash;

mysql_select_db($database_iwine, $iwine);
$query_flash = "SELECT * FROM link_fig ORDER BY b_position,b_order ASC";
$query_limit_flash = sprintf("%s LIMIT %d, %d", $query_flash, $startRow_flash, $maxRows_flash);
$flash = mysql_query($query_limit_flash, $iwine) or die(mysql_error());
$row_flash = mysql_fetch_assoc($flash);

if (isset($_GET['totalRows_flash'])) {
  $totalRows_flash = $_GET['totalRows_flash'];
} else {
  $all_flash = mysql_query($query_flash);
  $totalRows_flash = mysql_num_rows($all_flash);
}
$totalPages_flash = ceil($totalRows_flash/$maxRows_flash)-1;

$queryString_flash = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_flash") == false && 
        stristr($param, "totalRows_flash") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_flash = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_flash = sprintf("&totalRows_flash=%d%s", $totalRows_flash, $queryString_flash);
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>iWine - 後台管理系統</title>

<script type="text/javascript">
function dele(ids){
	if(window.confirm('確定要刪除?')){
		window.location='link_d.php?b_id='+ids;
	}
}

function MM_goToURL() { //v3.0
  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
}
</script>

<link href="css.css" rel="stylesheet" type="text/css">

</head>

<body marginheight="0" marginwidth="0" bgcolor="#666666">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td align="center" valign="top" bgcolor="666666"><table width="100%" height="605" border="0" align="center" cellpadding="0" cellspacing="8">
      <tr>
        <td height="2" bgcolor="#FFFFFF"></td>
        </tr>
      <tr>
        <td height="40" align="center" valign="middle"><span class="capw"><font color="#FFFFFF">◎ 檢視相關連結 ◎</font></span></td>
        </tr>
      <tr>
        <td height="2" bgcolor="#FFFFFF"></td>
        </tr>
      <tr>
        <td align="center" valign="top"><table width="90%" border="0" cellpadding="3" cellspacing="0" bgcolor="494949">
          <tr>
            <td><form name="form1" method="POST">
              <div align="center">
                <table width="100%" border="0" cellpadding="5" cellspacing="1" class="table">
                  <tr bgcolor="#DDDDDD" >
                    <td align="center" background="images/transp.gif" bgcolor="#999999" class="contnet_w">圖檔</td>
                    <td align="center" background="images/transp.gif" bgcolor="#999999" class="contnet_w">連結</td>
                    <td align="center" background="images/transp.gif" bgcolor="#999999" class="contnet_w">顯示與否</td>
                    <td align="center" background="images/transp.gif" bgcolor="#999999" class="contnet_w">排序</td>
                    <td align="center" background="images/transp.gif" bgcolor="#999999" class="contnet_w">點擊次數</td>
                    <td width="15%" align="center" background="images/transp.gif" bgcolor="#999999" class="contnet_w">管理</td>
                    </tr>
                  <?php do { ?>
                    <tr >
                      <td align="center" bgcolor="#FFFFFF"><?php /*start inputVar script*/ if (isset($row_flash['b_file'])){ ?>
                        <img src="../webimages/link/<?php echo $row_flash['b_file']; ?>" width="180" height="50">
                        <?php } /*end inputVar script*/ ?></td>
                      <td align="center" bgcolor="#FFFFFF"><?php echo $row_flash['b_url']; ?></td>
                      <td align="center" bgcolor="#FFFFFF"><?php echo $row_flash['b_status']; ?></td>
                      <td align="center" bgcolor="#FFFFFF"><span><?php echo $row_flash['b_order']; ?></span></td>
                      <td align="center" bgcolor="#FFFFFF"><?php echo $row_flash['b_times']; ?></td>
                      <td align="center" bgcolor="#FFFFFF"><input name="button" type="button" class="sform_g" id="button" onClick="MM_goToURL('self','link_s.php?b_id=<?php echo $row_flash['b_id']; ?>');return document.MM_returnValue" value="檢視或修改">
                        <input name="button2" type="button" class="sform_b" id="button2"  onClick="dele('<?php echo $row_flash['b_id']; ?>')" value="刪除"></td>
                      </tr>
                    <?php } while ($row_flash = mysql_fetch_assoc($flash)); ?>
                  <tr bgcolor="#F3F3F1" >
                    <td colspan="6" align="center"><table border="0">
                      <tr>
                        <td><?php if ($pageNum_flash > 0) { // Show if not first page ?>
                          <a href="<?php printf("%s?pageNum_flash=%d%s", $currentPage, 0, $queryString_flash); ?>"><img src="First.gif" border="0"></a>
                          <?php } // Show if not first page ?></td>
                        <td><?php if ($pageNum_flash > 0) { // Show if not first page ?>
                          <a href="<?php printf("%s?pageNum_flash=%d%s", $currentPage, max(0, $pageNum_flash - 1), $queryString_flash); ?>"><img src="Previous.gif" border="0"></a>
                          <?php } // Show if not first page ?></td>
                        <td><?php if ($pageNum_flash < $totalPages_flash) { // Show if not last page ?>
                          <a href="<?php printf("%s?pageNum_flash=%d%s", $currentPage, min($totalPages_flash, $pageNum_flash + 1), $queryString_flash); ?>"><img src="Next.gif" border="0"></a>
                          <?php } // Show if not last page ?></td>
                        <td><?php if ($pageNum_flash < $totalPages_flash) { // Show if not last page ?>
                          <a href="<?php printf("%s?pageNum_flash=%d%s", $currentPage, $totalPages_flash, $queryString_flash); ?>"><img src="Last.gif" border="0"></a>
                          <?php } // Show if not last page ?></td>
                        </tr>
                      </table></td>
                    </tr>
                  </table>
                </div>
              </form></td>
            </tr>
          </table></td>
      </tr>
    </table></td>
  </tr>
</table>
</body>
</html>

<?php
mysql_free_result($flash);
?>
