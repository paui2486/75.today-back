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
  $updateSQL = sprintf("UPDATE short_url SET su_title=%s, su_memo=%s WHERE su_id=%s",
                       GetSQLValueString($_POST['su_title'], "text"),
                       GetSQLValueString($_POST['su_memo'], "text"),
                       GetSQLValueString($_POST['su_id'], "int"));

  mysql_select_db($database_iwine, $iwine);
  $Result1 = mysql_query($updateSQL, $iwine) or die(mysql_error());

  $updateGoTo = "short_url_l.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_su_detail = "-1";
if (isset($_GET['su_id'])) {
  $colname_su_detail = $_GET['su_id'];
}
mysql_select_db($database_iwine, $iwine);
$query_su_detail = sprintf("SELECT * FROM short_url WHERE su_id = %s", GetSQLValueString($colname_su_detail, "int"));
$su_detail = mysql_query($query_su_detail, $iwine) or die(mysql_error());
$row_su_detail = mysql_fetch_assoc($su_detail);
$totalRows_su_detail = mysql_num_rows($su_detail);
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>iWine - 後台管理系統</title>
<link href="css.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="js/jquery-1.7.2.min.js"></script>
<style type="text/css">@import "js/jquery.datepick.package-3.6.1/jquery.datepick.css";</style> 
<script type="text/javascript" src="js/jquery.datepick.package-3.6.1/jquery.datepick.js"></script>
<script type="text/javascript" src="js/jquery.datepick.package-3.6.1/jquery.datepick.pack.js"></script>
<script type="text/javascript" src="js/jquery.datepick.package-3.6.1/jquery.datepick-zh-TW.js"></script>
<script type="text/javascript">
function tmt_confirm(msg){
	document.MM_returnValue=(confirm(unescape(msg)));
}
function MM_goToURL() { //v3.0
  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
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
        <td height="40" align="center" valign="middle"><span class="capw"><font color="#FFFFFF">◎ 編輯短網址資料 ◎</font></span></td>
        </tr>
      <tr>
        <td height="2" bgcolor="#FFFFFF"></td>
        </tr>
      <tr>
        <td align="center" valign="top"><div align="center">
          <form action="<?php echo $editFormAction; ?>" name="form1" method="POST">
            <table width="90%" border="0" cellspacing="0" cellpadding="3">
              <tr>
                <td bgcolor="#494949"><table width="100%" border="0" cellpadding="4" cellspacing="1" class="table">
                  <tr>
                    <td background="images/transp.gif" bgcolor="#999999" class="contnet_w"><div align="right">原始網址:</div></td>
                    <td valign="middle" bgcolor="#FFFFFF" class="sform"><?php echo $row_su_detail['su_url']; ?></td>
                    </tr>
                  <tr>
                    <td background="images/transp.gif" bgcolor="#999999" class="contnet_w"><div align="right">短網址:</div></td>
                    <td valign="middle" bgcolor="#FFFFFF" class="sform"><?php echo $row_su_detail['su_url_short']; ?></td>
                  </tr>
                  <tr>
                    <td background="images/transp.gif" bgcolor="#999999" class="contnet_w"><div align="right">QR-Code:</div></td>
                    <td valign="middle" bgcolor="#FFFFFF" class="sform"><img src="<?php echo $row_su_detail['su_url_short'].".qrcode?s=250"; ?>" width="250" height="250"></td>
                  </tr>
                  <tr>
                    <td width="20%" background="images/transp.gif" bgcolor="#999999" class="contnet_w"><div align="right">網址標題:</div></td>
                    <td valign="middle" bgcolor="#FFFFFF" class="sform">
                      <input name="su_title" type="text" class="sform" id="su_title" value="<?php echo $row_su_detail['su_title']; ?>" size="80"></td>
                    </tr>
                  <tr>
                    <td background="images/transp.gif" bgcolor="#999999" class="contnet_w"><div align="right">網址說明:</div></td>
                    <td valign="middle" bgcolor="#FFFFFF"><textarea name="su_memo" id="su_memo" cols="60" rows="4"><?php echo $row_su_detail['su_memo']; ?></textarea>
                      <input name="su_id" type="hidden" id="su_id" value="<?php echo $row_su_detail['su_id']; ?>"></td>
                    </tr>
                  <tr>
                    <td colspan="2" align="center" background="images/transp.gif" bgcolor="#999999" class="contnet_w">
                      <input name="button3" type="submit" class="sform_b" id="button3" onClick="tmt_confirm('確定修改短網址資料?');return document.MM_returnValue" value="確定修改">                    <input name="button" type="button" class="sform_r" id="button" onClick="MM_goToURL('self','short_url_l.php');return document.MM_returnValue" value="回短網址列表">
                      </td>
                  </tr>
                  </table></td>
                </tr>
              </table>
            <input type="hidden" name="MM_insert" value="form1">
            <input type="hidden" name="MM_update" value="form1">
          </form>
          </div></td>
      </tr>
      <tr>
        <td align="center" valign="top">&nbsp;</td>
        </tr>
    </table></td>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($su_detail);

mysql_free_result($ac_list);

mysql_free_result($ac_detail);
?>
