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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form5")) {
  $updateSQL = sprintf("UPDATE member SET m_crm_memo=%s WHERE m_id=%s",
                       GetSQLValueString($_POST['m_crm_memo'], "text"),
                       GetSQLValueString($_POST['m_id'], "int"));

  mysql_select_db($database_iwine, $iwine);
  $Result1 = mysql_query($updateSQL, $iwine) or die(mysql_error());
  
  msg_box('修改成功！');
  win_close();
}

$colname_Recordset1 = "-1";
if (isset($_GET['m_id'])) {
  $colname_Recordset1 = $_GET['m_id'];
}
mysql_select_db($database_iwine, $iwine);
$query_Recordset1 = sprintf("SELECT * FROM member WHERE m_id = %s", GetSQLValueString($colname_Recordset1, "int"));
$Recordset1 = mysql_query($query_Recordset1, $iwine) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

include("ckeditor/ckeditor.php") ;
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
<script type="text/javascript" src="ckeditor/ckeditor.js"></script>
<script type="text/javascript">
// BeginWebWidget jQuery_UI_Calendar: sdate1
jQuery("#ord_ship_date").datepick({dateFormat: 'yy-mm-dd'});
// EndWebWidget jQuery_UI_Calendar: sdate1
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
        <td height="40" align="center" valign="middle"><span class="capw"><font color="#FFFFFF">◎ 檢視會員詳細內容 ◎</font></span></td>
        </tr>
      <tr>
        <td height="2" bgcolor="#FFFFFF"></td>
        </tr>
      <tr>
        <td align="center"></td>
        </tr>
      <tr>
        <td align="center" valign="top"><div align="center">
          <form action="<?php echo $editFormAction; ?>" name="form5" method="POST">
            <table width="70%" border="0" cellspacing="0" cellpadding="3">
              <tr>
                <td bgcolor="#494949"><table width="100%" border="0" cellpadding="4" cellspacing="1" class="table">
                  <tr>
                    <td colspan="4" align="center" background="images/transp.gif" bgcolor="#999999" class="contnet_w">訂購人與收貨人資訊</td>
                    </tr>
                  <tr>
                    <td width="20%" background="images/transp.gif" bgcolor="#999999" class="contnet_w"><div align="right">會員ID:</div></td>
                    <td width="30%" valign="middle" bgcolor="#FFFFFF" class="sform"><div align="left"><?php echo $row_Recordset1['m_id']; ?></div></td>
                    <td width="20%" valign="middle" background="images/transp.gif" bgcolor="#999999" class="contnet_w"><div align="right">會員帳號:</div></td>
                    <td width="30%" valign="middle" bgcolor="#FFFFFF" class="sform"><div align="left"><?php echo $row_Recordset1['m_account']; ?></div></td>
                  </tr>
                  <tr>
                    <td background="images/transp.gif" bgcolor="#999999" class="contnet_w"><div align="right">會員姓名:</div></td>
                    <td valign="middle" bgcolor="#FFFFFF" class="sform"><div align="left"><?php echo $row_Recordset1['m_name']; ?></div></td>
                    <td valign="middle" background="images/transp.gif" bgcolor="#999999" class="contnet_w"><div align="right">會員性別:</div></td>
                    <td valign="middle" bgcolor="#FFFFFF" class="sform"><div align="left"><?php echo $row_Recordset1['m_sex']; ?></div></td>
                  </tr>
                  <tr>
                    <td background="images/transp.gif" bgcolor="#999999" class="contnet_w"><div align="right">會員E-mail:</div></td>
                    <td valign="middle" bgcolor="#FFFFFF" class="sform"><div align="left"><?php echo $row_Recordset1['m_email']; ?></div></td>
                    <td valign="middle" background="images/transp.gif" bgcolor="#999999" class="contnet_w"><div align="right">會員手機:</div></td>
                    <td valign="middle" bgcolor="#FFFFFF" class="sform"><div align="left"><?php echo $row_Recordset1['m_mobile']; ?></div></td>
                  </tr>
                  <tr>
                    <td background="images/transp.gif" bgcolor="#999999" class="contnet_w"><div align="right">會員生日:</div></td>
                    <td valign="middle" bgcolor="#FFFFFF" class="sform"><div align="left"><?php echo $row_Recordset1['m_year']; ?>-<?php echo $row_Recordset1['m_month']; ?>-<?php echo $row_Recordset1['m_day']; ?></div></td>
                    <td valign="middle" background="images/transp.gif" bgcolor="#999999" class="contnet_w"><div align="right">註冊時間:</div></td>
                    <td valign="middle" bgcolor="#FFFFFF" class="sform"><div align="left"><?php echo $row_Recordset1['regist_date']; ?></div></td>
                  </tr>
                  <tr>
                    <td background="images/transp.gif" bgcolor="#999999" class="contnet_w"><div align="right">會員地址:</div></td>
                    <td colspan="3" valign="middle" bgcolor="#FFFFFF" class="sform"><div align="left"><?php echo $row_Recordset1['m_zip']; ?><?php echo $row_Recordset1['m_country']; ?><?php echo $row_Recordset1['m_county']; ?><?php echo $row_Recordset1['m_city']; ?><?php echo $row_Recordset1['m_address']; ?></div></td>
                  </tr>
                  <?php if($row_Recordset1['p_package'] == 'Y'){ ?>
                  <?php } ?>
                  <tr>
                    <td background="images/transp.gif" bgcolor="#999999" class="contnet_w"><div align="right">會員備註:</div></td>
                    <td colspan="3" valign="middle" bgcolor="#FFFFFF"><textarea name="m_crm_memo" id="m_crm_memo" cols="60" rows="4" class="ckeditor"><?php echo $row_Recordset1['m_crm_memo']; ?></textarea>
                      <input name="m_id" type="hidden" id="m_id" value="<?php echo $row_Recordset1['m_id']; ?>">
                      <input name="adm_account" type="hidden" id="adm_account" value="<?php echo $_SESSION['ADMIN_ACCOUNT']; ?>">
                      <input name="adm_datetime" type="hidden" id="adm_datetime" value="<?php echo date('Y-m-d H:i:s'); ?>">
                      <input name="page" type="hidden" id="page" value="<?php echo $_SERVER['HTTP_REFERER']; ?>"></td>
                  </tr>
                  <tr>
                    <td colspan="4" align="center" background="images/transp.gif" bgcolor="#999999" class="contnet_w"><input name="button3" type="submit" class="sform_b" id="button3" onClick="tmt_confirm('確定要修改資料?');return document.MM_returnValue" value="確定修改">                      <input name="button" type="button" class="sform_g" id="button" onClick="window.close()" value="關閉本視窗"></td>
                  </tr>
                </table></td>
              </tr>
            </table>
            <input type="hidden" name="MM_update" value="form5">
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
mysql_free_result($Recordset1);
?>
