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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE wine_supplier SET company_name=%s, owner=%s, contact=%s, address=%s, telphone=%s, fax=%s, email=%s, vat_num=%s, active=%s WHERE id=%s",
                       GetSQLValueString($_POST['company_name'], "text"),
                       GetSQLValueString($_POST['owner'], "text"),
                       GetSQLValueString($_POST['contact'], "text"),
                       GetSQLValueString($_POST['address'], "text"),
                       GetSQLValueString($_POST['telphone'], "text"),
                       GetSQLValueString($_POST['fax'], "text"),
                       GetSQLValueString($_POST['email'], "text"),
                       GetSQLValueString($_POST['vat_num'], "text"),
					   GetSQLValueString($_POST['active'], "int"),
                       GetSQLValueString($_POST['id'], "int"));

  mysql_select_db($database_iwine, $iwine);
  $Result1 = mysql_query($updateSQL, $iwine) or die(mysql_error());
  
  msg_box('修改酒商內容成功');
  go_to('winesupplier_l.php');
  exit;
}

$id = "-1";
if (isset($_GET['id'])) {
  $id = $_GET['id'];
}
mysql_select_db($database_iwine, $iwine);
$query_supplier = sprintf("SELECT * FROM wine_supplier WHERE id = %s", GetSQLValueString($id, "int"));
$supplier = mysql_query($query_supplier, $iwine) or die(mysql_error());
$row_supplier = mysql_fetch_assoc($supplier);
$totalRows_supplier = mysql_num_rows($supplier);
  ?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>iWine - 後台管理系統</title>
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
}
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

<body marginheight="0" marginwidth="0" bgcolor="#666666">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td align="center" valign="top" bgcolor="666666"><table width="100%" height="605" border="0" align="center" cellpadding="0" cellspacing="8">
      <tr>
        <td height="2" bgcolor="#FFFFFF"></td>
        </tr>
      <tr>
        <td height="40" align="center" valign="middle"><span class="capw"><font color="#FFFFFF">◎ 修改酒商內容 ◎</font></span></td>
        </tr>
      <tr>
        <td height="2" bgcolor="#FFFFFF"></td>
        </tr>
        <td align="center" valign="top"><table width="90%" border="0" cellpadding="3" cellspacing="0" bgcolor="494949">
          <tr>
            <td><form action="<?php echo $editFormAction; ?>" name="form1" method="POST">
              <div align="center">
                <table width="100%" border="0" cellpadding="5" cellspacing="1" class="table">
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">公司名稱:</td>
                    <td bgcolor="#FFFFFF"><input name="company_name" type="text" class="sform" id="company_name" value="<?php echo $row_supplier['company_name']; ?>"></td>
                  </tr>
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">負責人:</td>
                    <td bgcolor="#FFFFFF"><input name="owner" type="text" class="sform" id="owner" value="<?php echo $row_supplier['owner']; ?>"></td>
                  </tr>
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td width="15%" align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">統一編號:</td>
                    <td bgcolor="#FFFFFF"><input name="vat_num" type="text" class="sform" id="vat_num" value="<?php echo $row_supplier['vat_num']; ?>"></td>
                  </tr>
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td width="15%" align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">聯絡人:</td>
                    <td bgcolor="#FFFFFF"><input name="contact" type="text" class="sform" id="contact" value="<?php echo $row_supplier['contact']; ?>"></td>
                  </tr>
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td width="15%" align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">電話:</td>
                    <td bgcolor="#FFFFFF"><input name="telphone" type="text" class="sform" id="telphone" value="<?php echo $row_supplier['telphone']; ?>"></td>
                  </tr>
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td width="15%" align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">傳真:</td>
                    <td bgcolor="#FFFFFF"><input name="fax" type="text" class="sform" id="fax" value="<?php echo $row_supplier['fax']; ?>"></td>
                  </tr>
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td width="15%" align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">email:</td>
                    <td bgcolor="#FFFFFF"><input name="email" type="text" class="sform" id="email" value="<?php echo $row_supplier['email']; ?>" size="60"></td>
                  </tr>
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td width="15%" align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">地址:</td>
                    <td bgcolor="#FFFFFF"><input name="address" type="text" class="sform" id="address" value="<?php echo $row_supplier['address']; ?>" size="60"></td>
                  </tr>
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td width="15%" align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">審核狀態:</td>
                    <td bgcolor="#FFFFFF" class="description">
                    	<input name="active" type="radio" value="1" id="active" <?php if($row_supplier['active']==1) echo "checked=\"checked\""; ?>>通過 
                        <input name="active" type="radio" value="0" id="not_active" <?php if($row_supplier['active']==0) echo "checked=\"checked\""; ?>>審核中
                    </td>
                  </tr>
                  <tr bgcolor="#F3F3F1">
                  <td colspan="4" align="center"><input name="id" type="hidden" id="id" value="<?php echo $row_supplier['id']; ?>">
                    <input name="status2" type="submit" class="sform_g" onClick="tmt_confirm('確定要修改?');return document.MM_returnValue" value="確定修改">
                    <input name="reset" type="reset" class="sform_b" value="重設">
                    <input name="button" type="button" class="sform_g" id="button" onClick="history.back()" value="回上頁"></td>
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
mysql_free_result($supplier);
?>
