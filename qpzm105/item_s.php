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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE item SET p_code=%s, p_name=%s, p_price1=%s, p_price2=%s, p_description=%s WHERE p_id=%s",
                       GetSQLValueString($_POST['p_code'], "text"),
                       GetSQLValueString($_POST['p_name'], "text"),
                       GetSQLValueString($_POST['p_price1'], "int"),
                       GetSQLValueString($_POST['p_price2'], "int"),
                       GetSQLValueString($_POST['p_description'], "text"),
                       GetSQLValueString($_POST['p_id'], "int"));

  mysql_select_db($database_iwine, $iwine);
  $Result1 = mysql_query($updateSQL, $iwine) or die(mysql_error());

  $updateGoTo = "item_l.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_item = "-1";
if (isset($_GET['p_id'])) {
  $colname_item = $_GET['p_id'];
}
mysql_select_db($database_iwine, $iwine);
$query_item = sprintf("SELECT * FROM item WHERE p_id = %s", GetSQLValueString($colname_item, "int"));
$item = mysql_query($query_item, $iwine) or die(mysql_error());
$row_item = mysql_fetch_assoc($item);
$totalRows_item = mysql_num_rows($item);
?>
<?php include('session_check.php'); ?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>iWine - 後台管理系統</title>

<link href="css.css" rel="stylesheet" type="text/css">
<script type="text/javascript">
function tmt_confirm(msg){
	document.MM_returnValue=(confirm(unescape(msg)));
}
</script>
<script type="text/javascript" src="js/jquery-1.7.2.min.js"></script>
<style type="text/css">@import "js/jquery.datepick.package-3.6.1/jquery.datepick.css";</style> 
<script type="text/javascript" src="js/jquery.datepick.package-3.6.1/jquery.datepick.js"></script>
<script type="text/javascript" src="js/jquery.datepick.package-3.6.1/jquery.datepick.pack.js"></script>
<script type="text/javascript" src="js/jquery.datepick.package-3.6.1/jquery.datepick-zh-TW.js"></script>
<script type="text/javascript" src="ckeditor/ckeditor.js"></script><script type="text/javascript">
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

function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
</script>
</head>

<body marginheight="0" marginwidth="0" bgcolor="#666666">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td align="center" valign="top" bgcolor="666666"><table width="100%" height="1277" border="0" align="center" cellpadding="0" cellspacing="8">
      <tr>
        <td height="2" bgcolor="#FFFFFF"></td>
        </tr>
      <tr>
        <td height="40" align="center" valign="middle"><span class="capw"><font color="#FFFFFF">◎ 檢視加購商品內容 ◎</font></span></td>
        </tr>
      <tr>
        <td height="2" bgcolor="#FFFFFF"></td>
        </tr>
      <tr>
        <td align="center" valign="top"><table width="90%" border="0" cellpadding="3" cellspacing="0" bgcolor="494949">
          <tr>
            <td><form action="<?php echo $editFormAction; ?>" name="form1" method="POST">
              <div align="center">
                <table width="100%" border="0" cellpadding="5" cellspacing="1" class="table">
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">商品連結:</td>
                    <td bgcolor="#FFFFFF" class="text_cap"><a href="javascript:MM_openBrWindow('../item.php?p_id=<?php echo $row_item['p_id']; ?>','item','scrollbars=yes,width=800,height=600')">item.php?p_id=<?php echo $row_item['p_id']; ?></a></td>
                  </tr>
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">商品編號:</td>
                    <td bgcolor="#FFFFFF" class="text_cap"><input name="p_code" type="text" class="sform" id="p_code" value="<?php echo $row_item['p_code']; ?>"></td>
                  </tr>
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td width="15%" align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">商品名稱（必填）:</td>
                    <td bgcolor="#FFFFFF" class="text_cap"><input name="p_name" type="text" class="sform" id="p_name" value="<?php echo $row_item['p_name']; ?>" size="80"></td>
                  </tr>
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">定價:</td>
                    <td bgcolor="#FFFFFF" class="text_cap"><input name="p_price1" type="text" class="sform" id="p_price1" value="<?php echo $row_item['p_price1']; ?>" size="20">元</td>
                  </tr>
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">加購價:</td>
                    <td bgcolor="#FFFFFF" class="text_cap"><input name="p_price2" type="text" class="sform" id="p_price2" value="<?php echo $row_item['p_price2']; ?>" size="20">元</td>
                    </tr>
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">商品介紹（必填）:</td>
                    <td bgcolor="#FFFFFF" class="text_cap"><textarea name="p_description" id="p_description" cols="45" rows="5" class="ckeditor"><?php echo $row_item['p_description']; ?></textarea>
                      <input name="p_id" type="hidden" id="p_id" value="<?php echo $row_item['p_id']; ?>"></td>
                  </tr>
                  <tr bgcolor="#F3F3F1" class="t9">
                    <td colspan="2" align="right"><input name="status2" type="submit" class="sform_b" onClick="tmt_confirm('確定要修改?');return document.MM_returnValue" value="確定修改">
                      <input name="Reset" type="reset" class="sform_b" id="Reset2" value="重設">
                      <input name="button" type="button" class="sform_b" id="button" onClick="history.back()" value="回上頁"></td>
                  </tr>
                  </table>
                </div>
              <input type="hidden" name="MM_update" value="form1">
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
mysql_free_result($item);
?>

<script type="text/javascript">
// BeginWebWidget jQuery_UI_Calendar: sdate1
jQuery("#p_start_time").datepick({dateFormat: 'yy-mm-dd'});
// EndWebWidget jQuery_UI_Calendar: sdate1
</script>
<script type="text/javascript">
// BeginWebWidget jQuery_UI_Calendar: sdate1
jQuery("#p_end_time").datepick({dateFormat: 'yy-mm-dd'});
// EndWebWidget jQuery_UI_Calendar: sdate1
                          </script>
