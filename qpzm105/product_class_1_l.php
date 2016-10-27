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

mysql_select_db($database_iwine, $iwine);
$query_Recordset1 = "SELECT * FROM Product_Class ORDER BY pc_level1 ASC,  pc_level2 ASC, pc_order ASC";
$Recordset1 = mysql_query($query_Recordset1, $iwine) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);


?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>iFit 愛瘦身 - 後台管理系統</title>
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
}
-->
</style>
<script type="text/javascript">
function dele(ids){
	if(window.confirm('確定要刪除?')){
		window.location='product_class_1_d.php?pc_id='+ids;
	}
}
function MM_goToURL() { //v3.0
  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
}
</script>

<link href="css.css" rel="stylesheet" type="text/css">
<script type="text/javascript">
function addBookmarkForBrowser(sTitle, sUrl){

        if (window.sidebar && window.sidebar.addPanel) {
            addBookmarkForBrowser = function(sTitle, sUrl) {
                window.sidebar.addPanel(sTitle, sUrl, "");
            }
        } else if (window.external) {
            addBookmarkForBrowser = function(sTitle, sUrl) {
                window.external.AddFavorite(sUrl, sTitle);
            }
        } else {
            addBookmarkForBrowser = function() {
                alert("do it yourself");
            }
        }

        return addBookmarkForBrowser(sTitle, sUrl);
}
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
        <td height="40" align="center" valign="middle"><span class="capw"><font color="#FFFFFF">◎ 檢視商品分類 ◎</font></span></td>
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
                    <td align="center" background="images/transp.gif" bgcolor="#999999" class="contnet_w">上層分類</td>
                    <td align="center" background="images/transp.gif" bgcolor="#999999" class="contnet_w">分類名稱</td>
                    <td align="center" background="images/transp.gif" bgcolor="#999999" class="contnet_w">分類唯一ID值</td>
                    <td align="center" background="images/transp.gif" bgcolor="#999999" class="contnet_w">排序</td>
                    <td align="center" background="images/transp.gif" bgcolor="#999999" class="contnet_w">是否顯示</td>
                    <td width="30%" align="center" background="images/transp.gif" bgcolor="#999999" class="contnet_w">管理</td>
                    </tr>
                  <?php do { ?>
                  <tr >
                    <td align="center" bgcolor="#FFFFFF" class="text_cap">
                  <?php 
if($row_Recordset1['pc_level1']==0){echo "主分類";}
if($row_Recordset1['pc_level1'] <> 0){
	
$pid = $row_Recordset1['pc_level1'];

mysql_select_db($database_iwine, $iwine);
$query_class1 = "SELECT * FROM Product_Class WHERE pc_id = '$pid'";
$class1 = mysql_query($query_class1, $iwine) or die(mysql_error());
$row_class1 = mysql_fetch_assoc($class1);
$totalRows_class1 = mysql_num_rows($class1);

echo $row_class1['pc_name'];
}
if($row_Recordset1['pc_level2'] <> 0){
	
$pid2 = $row_Recordset1['pc_level2'];

mysql_select_db($database_iwine, $iwine);
$query_class2 = "SELECT * FROM Product_Class WHERE pc_id = '$pid2'";
$class2 = mysql_query($query_class2, $iwine) or die(mysql_error());
$row_class2 = mysql_fetch_assoc($class2);
$totalRows_class2 = mysql_num_rows($class2);

echo  " / ".$row_class2['pc_name'];
}
?>
                    &nbsp;</td>
                    <td align="center" bgcolor="#FFFFFF" class="text_cap"><?php echo $row_Recordset1['pc_name']; ?></td>
                    <td align="center" bgcolor="#FFFFFF" class="text_cap"><?php echo $row_Recordset1['pc_id']; ?></td>
                    <td align="center" bgcolor="#FFFFFF" class="text_cap"><?php echo $row_Recordset1['pc_order']; ?></td>
                    <td align="center" bgcolor="#FFFFFF" class="text_cap"><?php echo $row_Recordset1['pc_online']; ?></td>
                    <td align="center" bgcolor="#FFFFFF"><input name="button" type="button" class="sform_g" id="button" onClick="MM_goToURL('self','product_class_1_s.php?pc_id=<?php echo $row_Recordset1['pc_id']; ?>');return document.MM_returnValue" value="檢視或修改">
                      <input name="button2" type="button" class="sform_b" id="button2" onClick="dele('<?php echo $row_Recordset1['pc_id']; ?>')"  value="刪除"></td>
                    </tr>
                  <?php } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?>
                  <tr bgcolor="#F3F3F1" >
                    <td colspan="6" align="center">&nbsp;</td>
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
mysql_free_result($Recordset1);

mysql_free_result($class1);
?>
