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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO alliance_member (am_account, am_passwd, am_code, am_name, am_company, am_company_code, am_tel, am_fax, am_mobile, am_email, am_address, am_weburl, am_payway, am_fa, am_bank_name, am_bank_brench, am_bank_code, am_bank_account, am_regist_datetime, am_memo, am_ratio) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['am_account'], "text"),
                       GetSQLValueString(md5($_POST['am_passwd']), "text"),
					   GetSQLValueString(md5($_POST['am_account']), "text"),
                       GetSQLValueString($_POST['am_name'], "text"),
                       GetSQLValueString($_POST['am_company'], "text"),
                       GetSQLValueString($_POST['am_company_code'], "text"),
                       GetSQLValueString($_POST['am_tel'], "text"),
                       GetSQLValueString($_POST['am_fax'], "text"),
                       GetSQLValueString($_POST['am_mobile'], "text"),
                       GetSQLValueString($_POST['am_email'], "text"),
                       GetSQLValueString($_POST['am_address'], "text"),
                       GetSQLValueString($_POST['am_weburl'], "text"),
                       GetSQLValueString($_POST['am_payway'], "text"),
                       GetSQLValueString($_POST['am_fa'], "text"),
                       GetSQLValueString($_POST['am_bank_name'], "text"),
                       GetSQLValueString($_POST['am_bank_brench'], "text"),
                       GetSQLValueString($_POST['am_bank_code'], "text"),
                       GetSQLValueString($_POST['am_bank_account'], "text"),
                       GetSQLValueString($_POST['am_regist_datetime'], "date"),
                       GetSQLValueString($_POST['am_memo'], "text"),
                       GetSQLValueString($_POST['am_ratio'], "int"));

  mysql_select_db($database_iwine, $iwine);
  $Result1 = mysql_query($insertSQL, $iwine) or die(mysql_error());

  $insertGoTo = "alliance_member_l.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}


?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>iWine - 後台管理系統</title>
<link href="css.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="js/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="ckeditor/ckeditor.js"></script>
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
        <td height="40" align="center" valign="middle"><span class="capw"><font color="#FFFFFF">◎ 新增盟友資料 ◎</font></span></td>
        </tr>
      <tr>
        <td height="2" bgcolor="#FFFFFF"></td>
        </tr>
      <tr>
        <td align="center"></td>
        </tr>
      <tr>
        <td align="center" valign="top"><div align="center">
          <form action="<?php echo $editFormAction; ?>" name="form1" method="POST">
            <table width="90%" border="0" cellspacing="0" cellpadding="3">
              <tr>
                <td bgcolor="#494949"><table width="100%" border="0" cellpadding="4" cellspacing="1" class="table">
                  <tr>
                    <td colspan="4" align="center" background="images/transp.gif" bgcolor="#999999" class="contnet_w">盟友基本資料</td>
                    </tr>
                  <tr>
                    <td background="images/transp.gif" bgcolor="#999999" class="contnet_w"><div align="right">帳號:</div></td>
                    <td valign="middle" bgcolor="#FFFFFF" class="sform"><label for="am_account"></label>
                      <input name="am_account" type="text" class="sform" id="am_account" size="40"></td>
                    <td valign="middle" background="images/transp.gif" bgcolor="#999999" class="contnet_w"><div align="right">預設密碼:</div></td>
                    <td valign="middle" bgcolor="#FFFFFF" class="sform"><label for="am_passwd"></label>
                      <input name="am_passwd" type="text" class="sform" id="am_passwd"></td>
                  </tr>
                  <tr>
                    <td width="20%" background="images/transp.gif" bgcolor="#999999" class="contnet_w"><div align="right">姓名:</div></td>
                    <td width="30%" valign="middle" bgcolor="#FFFFFF" class="sform"><input name="am_name" type="text" class="sform" id="am_name"></td>
                    <td width="20%" valign="middle" background="images/transp.gif" bgcolor="#999999" class="contnet_w"><div align="right">公司名稱:</div></td>
                    <td width="30%" valign="middle" bgcolor="#FFFFFF" class="sform"><label for="am_company"></label>
                      <input name="am_company" type="text" class="sform" id="am_company" size="25">
/
<label for="am_company_code"></label>
<input name="am_company_code" type="text" class="sform" id="am_company_code" size="15"></td>
                  </tr>
                  <tr>
                    <td background="images/transp.gif" bgcolor="#999999" class="contnet_w"><div align="right">電話:</div></td>
                    <td valign="middle" bgcolor="#FFFFFF" class="sform"><label for="am_tel"></label>
                      <input name="am_tel" type="text" class="sform" id="am_tel"></td>
                    <td valign="middle" background="images/transp.gif" bgcolor="#999999" class="contnet_w"><div align="right">手機:</div></td>
                    <td valign="middle" bgcolor="#FFFFFF" class="sform"><label for="am_mobile"></label>
                      <input name="am_mobile" type="text" class="sform" id="am_mobile"></td>
                  </tr>
                  <tr>
                    <td background="images/transp.gif" bgcolor="#999999" class="contnet_w"><div align="right">傳真:</div></td>
                    <td valign="middle" bgcolor="#FFFFFF" class="sform"><label for="am_fax"></label>
                      <input name="am_fax" type="text" class="sform" id="am_fax"></td>
                    <td valign="middle" background="images/transp.gif" bgcolor="#999999" class="contnet_w"><div align="right">E-mail:</div></td>
                    <td valign="middle" bgcolor="#FFFFFF" class="sform"><label for="am_email"></label>
                      <input name="am_email" type="text" class="sform" id="am_email" size="40"></td>
                  </tr>
                  <tr>
                    <td background="images/transp.gif" bgcolor="#999999" class="contnet_w"><div align="right">地址:</div></td>
                    <td colspan="3" valign="middle" bgcolor="#FFFFFF" class="sform"><label for="am_address"></label>
                      <input name="am_address" type="text" class="sform" id="am_address" size="80"></td>
                  </tr>
                  <tr>
                    <td background="images/transp.gif" bgcolor="#999999" class="contnet_w"><div align="right">網站:</div></td>
                    <td colspan="3" valign="middle" bgcolor="#FFFFFF" class="sform"><label for="am_weburl"></label>
                      <textarea name="am_weburl" id="am_weburl" cols="80" rows="5" class="ckeditor"></textarea></td>
                  </tr>
                  <tr>
                    <td background="images/transp.gif" bgcolor="#999999" class="contnet_w"><div align="right">付款方式:</div></td>
                    <td valign="middle" bgcolor="#FFFFFF" class="sform"><label for="am_payway"></label>
                      <select name="am_payway" id="am_payway">
                        <option value="現金匯款">現金匯款</option>
                        <option value="支票支付" selected>支票支付</option>
                        <option value="PayPal">PayPal</option>
                      </select></td>
                    <td valign="middle" background="images/transp.gif" bgcolor="#999999" class="contnet_w"><div align="right">請款應檢附單據類別:</div></td>
                    <td valign="middle" bgcolor="#FFFFFF" class="sform"><input type="radio" name="am_fa" id="am_fa" value="Y">統一發票 <input name="am_fa" type="radio" value="N" checked>
                      個人身分證（執行業務所得）</td>
                  </tr>
                  <tr>
                    <td background="images/transp.gif" bgcolor="#999999" class="contnet_w"><div align="right">匯款銀行名:</div></td>
                    <td valign="middle" bgcolor="#FFFFFF" class="sform"><label for="am_bank_name"></label>
                      <input name="am_bank_name" type="text" class="sform" id="am_bank_name"></td>
                    <td valign="middle" background="images/transp.gif" bgcolor="#999999" class="contnet_w"><div align="right">匯款銀行分行名稱:</div></td>
                    <td valign="middle" bgcolor="#FFFFFF" class="sform"><label for="am_bank_brench"></label>
                      <input name="am_bank_brench" type="text" class="sform" id="am_bank_brench"></td>
                  </tr>
                  <tr>
                    <td background="images/transp.gif" bgcolor="#999999" class="contnet_w"><div align="right">匯款銀行代號:</div></td>
                    <td valign="middle" bgcolor="#FFFFFF" class="sform"><label for="am_bank_code"></label>
                      <input name="am_bank_code" type="text" class="sform" id="am_bank_code" size="10"></td>
                    <td valign="middle" background="images/transp.gif" bgcolor="#999999" class="contnet_w"><div align="right">匯款銀行帳號或PayPal帳號:</div></td>
                    <td valign="middle" bgcolor="#FFFFFF" class="sform"><label for="am_bank_account"></label>
                      <input name="am_bank_account" type="text" class="sform" id="am_bank_account" size="30"></td>
                  </tr>
                  <?php if($row_Recordset1['p_package'] == 'Y'){ ?>
                  <?php } ?>
                  <tr>
                    <td background="images/transp.gif" bgcolor="#999999" class="contnet_w"><div align="right">備註:</div></td>
                    <td colspan="3" valign="middle" bgcolor="#FFFFFF"><textarea name="am_memo" id="am_memo" cols="60" rows="4"></textarea>
                      <input name="am_regist_datetime" type="hidden" id="am_regist_datetime" value="<?php echo date('Y-m-d H:i:s'); ?>"></td>
                  </tr>
                  <tr>
                    <td background="images/transp.gif" bgcolor="#999999" class="contnet_w"><div align="right">分潤比:</div></td>
                    <td colspan="3" valign="middle" bgcolor="#FFFFFF" class="sform"><label for="am_ratio"></label>
                      <input name="am_ratio" type="text" class="sform" id="am_ratio" size="5">
                      %</td>
                  </tr>
                  <tr>
                    <td colspan="4" align="center" background="images/transp.gif" bgcolor="#999999" class="contnet_w">
                      <input name="button3" type="submit" class="sform_b" id="button3" onClick="tmt_confirm('確定新增盟友資料?');return document.MM_returnValue" value="確定新增">                    <input name="button" type="button" class="sform_r" id="button" onClick="MM_goToURL('self','alliance_member_l.php');return document.MM_returnValue" value="回盟友列表">
                      </td>
                  </tr>
                </table></td>
              </tr>
            </table>
            <input type="hidden" name="MM_insert" value="form1">
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