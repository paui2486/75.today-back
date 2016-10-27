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
  $updateSQL = sprintf("UPDATE order_list SET ord_status=%s, ord_memo2=%s, ord_ship_date=%s, adm_account=%s, adm_datetime=%s WHERE ord_id=%s",
                       GetSQLValueString($_POST['ord_status'], "int"),
                       GetSQLValueString($_POST['ord_memo2'], "text"),
                       GetSQLValueString($_POST['ord_ship_date'], "date"),
                       GetSQLValueString($_POST['adm_account'], "text"),
                       GetSQLValueString($_POST['adm_datetime'], "date"),
                       GetSQLValueString($_POST['ord_id'], "int"));

  mysql_select_db($database_iwine, $iwine);
  $Result1 = mysql_query($updateSQL, $iwine) or die(mysql_error());
  
  go_to($_POST['page']);
}

$colname_Recordset1 = "-1";
if (isset($_GET['ord_id'])) {
  $colname_Recordset1 = $_GET['ord_id'];
}
mysql_select_db($database_iwine, $iwine);
$query_Recordset1 = sprintf("SELECT * FROM order_list LEFT JOIN Product ON order_list.ord_p_id = Product.p_id LEFT JOIN member ON order_list.ord_acc_id = member.m_id WHERE ord_id = %s", GetSQLValueString($colname_Recordset1, "int"));
$Recordset1 = mysql_query($query_Recordset1, $iwine) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
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
        <td height="40" align="center" valign="middle"><span class="capw"><font color="#FFFFFF">◎ 檢視訂單詳細內容 ◎</font></span></td>
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
                    <td width="20%" background="images/transp.gif" bgcolor="#999999" class="contnet_w"><div align="right">訂單編號:</div></td>
                    <td width="30%" valign="middle" bgcolor="#FFFFFF" class="sform"><div align="left"><?php echo $row_Recordset1['ord_code']; ?></div></td>
                    <td width="20%" valign="middle" background="images/transp.gif" bgcolor="#999999" class="contnet_w"><div align="right">訂單日期:</div></td>
                    <td width="30%" valign="middle" bgcolor="#FFFFFF" class="sform"><div align="left"><?php echo $row_Recordset1['ord_date']; ?></div></td>
                  </tr>
                  <tr>
                    <td background="images/transp.gif" bgcolor="#999999" class="contnet_w"><div align="right">訂購人姓名:</div></td>
                    <td valign="middle" bgcolor="#FFFFFF" class="sform"><div align="left"><?php echo $row_Recordset1['m_name']; ?></div></td>
                    <td valign="middle" background="images/transp.gif" bgcolor="#999999" class="contnet_w"><div align="right">訂單狀態:</div></td>
                    <td valign="middle" bgcolor="#FFFFFF" class="sform"><div align="left">
                      <select name="ord_status" class="sform" id="ord_status">
                    <option value="1" <?php if (!(strcmp(1, $row_Recordset1['ord_status']))) {echo "selected=\"selected\"";} ?>>未處理</option>
                    <option value="2" <?php if (!(strcmp(2, $row_Recordset1['ord_status']))) {echo "selected=\"selected\"";} ?>>付款失敗</option>
                    <option value="3" <?php if (!(strcmp(3, $row_Recordset1['ord_status']))) {echo "selected=\"selected\"";} ?>>已付款，準備出貨中</option>
                    <option value="4" <?php if (!(strcmp(4, $row_Recordset1['ord_status']))) {echo "selected=\"selected\"";} ?>>已出貨</option>
                    <option value="5" <?php if (!(strcmp(5, $row_Recordset1['ord_status']))) {echo "selected=\"selected\"";} ?>>尚未匯款</option>
                    <option value="6" <?php if (!(strcmp(6, $row_Recordset1['ord_status']))) {echo "selected=\"selected\"";} ?>>對帳中</option>
                    <option value="7" <?php if (!(strcmp(7, $row_Recordset1['ord_status']))) {echo "selected=\"selected\"";} ?>>對帳失敗，請重填匯款帳號後5碼</option>
                    <option value="8" <?php if (!(strcmp(8, $row_Recordset1['ord_status']))) {echo "selected=\"selected\"";} ?>>已簽收</option>
                    <option value="9" <?php if (!(strcmp(9, $row_Recordset1['ord_status']))) {echo "selected=\"selected\"";} ?>>未簽收退回</option>
                    <option value="10" <?php if (!(strcmp(10, $row_Recordset1['ord_status']))) {echo "selected=\"selected\"";} ?>>缺貨中</option>
                    <option value="11" <?php if (!(strcmp(11, $row_Recordset1['ord_status']))) {echo "selected=\"selected\"";} ?>>信用卡已付款尚未出貨</option>
                    <option value="91" <?php if (!(strcmp(91, $row_Recordset1['ord_status']))) {echo "selected=\"selected\"";} ?>>退貨申請中</option>
                    <option value="92" <?php if (!(strcmp(92, $row_Recordset1['ord_status']))) {echo "selected=\"selected\"";} ?>>退貨處理中</option>
                    <option value="93" <?php if (!(strcmp(93, $row_Recordset1['ord_status']))) {echo "selected=\"selected\"";} ?>>退貨完成</option>
                    <option value="94" <?php if (!(strcmp(94, $row_Recordset1['ord_status']))) {echo "selected=\"selected\"";} ?>>取消退貨</option>
                    <option value="99" <?php if (!(strcmp(99, $row_Recordset1['ord_status']))) {echo "selected=\"selected\"";} ?>>無效訂單</option>
                      </select>
                    </div></td>
                  </tr>
                  <tr>
                    <td background="images/transp.gif" bgcolor="#999999" class="contnet_w"><div align="right">訂購人E-mail:</div></td>
                    <td valign="middle" bgcolor="#FFFFFF" class="sform"><div align="left"><?php echo $row_Recordset1['m_account']; ?></div></td>
                    <td valign="middle" background="images/transp.gif" bgcolor="#999999" class="contnet_w"><div align="right">訂購人手機:</div></td>
                    <td valign="middle" bgcolor="#FFFFFF" class="sform"><div align="left"><?php echo $row_Recordset1['m_mobile']; ?></div></td>
                  </tr>
                  <tr>
                    <td background="images/transp.gif" bgcolor="#999999" class="contnet_w"><div align="right">收貨人姓名:</div></td>
                    <td valign="middle" bgcolor="#FFFFFF" class="sform"><div align="left"><?php echo $row_Recordset1['ord_ship_name']; ?></div></td>
                    <td valign="middle" background="images/transp.gif" bgcolor="#999999" class="contnet_w"><div align="right">收貨人手機:</div></td>
                    <td valign="middle" bgcolor="#FFFFFF" class="sform"><div align="left"><?php echo $row_Recordset1['ord_ship_mobile']; ?></div></td>
                  </tr>
                  <tr>
                    <td background="images/transp.gif" bgcolor="#999999" class="contnet_w"><div align="right">收貨人地址:</div></td>
                    <td colspan="3" valign="middle" bgcolor="#FFFFFF" class="sform"><div align="left"><?php echo $row_Recordset1['ord_ship_zip']; ?><?php echo $row_Recordset1['ord_ship_county']; ?><?php echo $row_Recordset1['ord_ship_city']; ?><?php echo $row_Recordset1['ord_ship_address']; ?></div></td>
                  </tr>
                  <tr>
                    <td background="images/transp.gif" bgcolor="#999999" class="contnet_w"><div align="right">收貨人E-mail:</div></td>
                    <td colspan="3" valign="middle" bgcolor="#FFFFFF" class="sform"><div align="left"><?php echo $row_Recordset1['ord_ship_email']; ?></div></td>
                  </tr>
                  <tr>
                    <td background="images/transp.gif" bgcolor="#999999" class="contnet_w"><div align="right">付款方式:</div></td>
                    <td valign="middle" bgcolor="#FFFFFF" class="sform"><div align="left"><?php 
						switch($row_Recordset1['ord_pay']){
							case 'card':
							echo "信用卡";
							break;
							case 'webatm':
							echo "WEBATM";
							break;
							case 'atm':
							echo "一般匯款";
							break;
						}
						
						?></div></td>
                    <td valign="middle" background="images/transp.gif" bgcolor="#999999" class="contnet_w"><div align="right">一般匯款帳號後5碼:</div></td>
                    <td valign="middle" bgcolor="#FFFFFF" class="sform"><div align="left"><?php echo $row_Recordset1['ord_atm_5code']; ?></div></td>
                  </tr>
                  <tr>
                    <td background="images/transp.gif" bgcolor="#999999" class="contnet_w"><div align="right">信用卡授權碼:</div></td>
                    <td valign="middle" bgcolor="#FFFFFF" class="sform"><div align="left"><?php echo $row_Recordset1['ord_card_code']; ?></div></td>
                    <td valign="middle" background="images/transp.gif" bgcolor="#999999" class="contnet_w"><div align="right">WEBATM:</div></td>
                    <td valign="middle" bgcolor="#FFFFFF" class="sform"><div align="left"></div></td>
                  </tr>
				  
                  <tr>
                    <td colspan="4" align="center" background="images/transp.gif" class="contnet_w">商品資料</td>
                  </tr>
                  <tr>
                    <td background="images/transp.gif" bgcolor="#999999" class="contnet_w"><div align="right">團體商品名稱:</div></td>
                    <td valign="middle" bgcolor="#FFFFFF" class="sform"><div align="left"><?php echo $row_Recordset1['p_name']; ?></div></td>
                    <td valign="middle" background="images/transp.gif" bgcolor="#999999" class="contnet_w"><div align="right">團體價:</div></td>
                    <td valign="middle" bgcolor="#FFFFFF" class="sform"><div align="left"><?php echo $row_Recordset1['p_price2']; ?></div></td>
                  </tr>
                  <tr>
                    <td background="images/transp.gif" bgcolor="#999999" class="contnet_w"><div align="right">各商品訂購數量:</div></td>
                    <td valign="middle" bgcolor="#FFFFFF" class="sform"><div align="left">
                    (1) <?php echo $row_Recordset1['p_product1']; ?>：<?php echo $row_Recordset1['ord_p_num']; ?><br>
                  <?php if($row_Recordset1['p_product2'] <> ""){ ?>
                  (2) <?php echo $row_Recordset1['p_product2']; ?>：<?php echo $row_Recordset1['ord_p_num2']; ?><br>
                  <?php } ?>
                  <?php if($row_Recordset1['p_product3'] <> ""){ ?>
                  (3) <?php echo $row_Recordset1['p_product3']; ?>：<?php echo $row_Recordset1['ord_p_num3']; ?><br>
                  <?php } ?>
                  <?php if($row_Recordset1['p_product4'] <> ""){ ?>
                  (4) <?php echo $row_Recordset1['p_product4']; ?>：<?php echo $row_Recordset1['ord_p_num4']; ?><br>
                  <?php } ?>
                  <?php if($row_Recordset1['p_product5'] <> ""){ ?>
                  (5). <?php echo $row_Recordset1['p_product5']; ?>：<?php echo $row_Recordset1['ord_p_num5']; ?><br>
                  <?php } ?> 
                    </div></td>
                    <td valign="middle" background="images/transp.gif" bgcolor="#999999" class="contnet_w"><div align="right">訂購小計:</div></td>
                    <td valign="middle" bgcolor="#FFFFFF" class="sform"><div align="left"><?php echo $row_Recordset1['ord_buy_price']; ?></div></td>
                  </tr>
                  <tr>
                    <td background="images/transp.gif" bgcolor="#999999" class="contnet_w"><div align="right">運費:</div></td>
                    <td valign="middle" bgcolor="#FFFFFF" class="sform"><div align="left"><?php echo $row_Recordset1['ord_ship_price']; ?></div></td>
                    <td background="images/transp.gif" bgcolor="#999999" class="contnet_w"><div align="right">付款總金額:</div></td>
                    <td valign="middle" bgcolor="#FFFFFF" class="sform"><div align="left"><?php echo $row_Recordset1['ord_total_price']; ?></div></td>
                    </tr>
                  <tr>
                    <td background="images/transp.gif" bgcolor="#999999" class="contnet_w"><div align="right">備註文字:</div></td>
                    <td colspan="3" valign="middle" bgcolor="#FFFFFF" class="sform"><div align="left"><?php echo $row_Recordset1['ord_memo']; ?></div></td>
                    </tr>
<tr>
  <td colspan="4" align="center" background="images/transp.gif" bgcolor="#999999" class="contnet_w">訂單管理資訊</td>
</tr>
                  <tr>
                    <td background="images/transp.gif" bgcolor="#999999" class="contnet_w"><div align="right">出貨日期:</div></td>
                    <td colspan="3" valign="middle" bgcolor="#FFFFFF"><div align="left">
                      <input name="ord_ship_date" type="text" class="sform" id="ord_ship_date" value="<?php echo $row_Recordset1['ord_ship_date']; ?>" size="20">
                    </div>
                    <script type="text/javascript">
// BeginWebWidget jQuery_UI_Calendar: sdate1
jQuery("#ord_ship_date").datepick({dateFormat: 'yy-mm-dd'});
// EndWebWidget jQuery_UI_Calendar: sdate1
                          </script>
                    </td>
                  </tr>
                  <tr>
                    <td background="images/transp.gif" bgcolor="#999999" class="contnet_w"><div align="right">訂單處理備註:</div></td>
                    <td colspan="3" valign="middle" bgcolor="#FFFFFF"><textarea name="ord_memo2" id="ord_memo2" cols="60" rows="4"><?php echo $row_Recordset1['ord_memo2']; ?></textarea>
                      <input name="ord_id" type="hidden" id="ord_id" value="<?php echo $row_Recordset1['ord_id']; ?>">
                      <input name="adm_account" type="hidden" id="adm_account" value="<?php echo $_SESSION['ADMIN_ACCOUNT']; ?>">
                      <input name="adm_datetime" type="hidden" id="adm_datetime" value="<?php echo date('Y-m-d H:i:s'); ?>">
                      <input name="page" type="hidden" id="page" value="<?php echo $_SERVER['HTTP_REFERER']; ?>"></td>
                  </tr>
                  <tr>
                    <td align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">最近處理時間:</td>
                    <td colspan="3" valign="middle" bgcolor="#FFFFFF" class="sform"><div align="left"><?php echo $row_Recordset1['adm_datetime']; ?></div></td>
                  </tr>
                  <tr>
                    <td align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">最近處理人員帳號:</td>
                    <td colspan="3" valign="middle" bgcolor="#FFFFFF" class="sform"><div align="left"><?php echo $row_Recordset1['adm_account']; ?></div></td>
                  </tr>
                  <tr>
                    <td colspan="4" align="center" background="images/transp.gif" bgcolor="#999999" class="contnet_w"><input name="button3" type="submit" class="sform_b" id="button3" onClick="tmt_confirm('確定要更新訂單?');return document.MM_returnValue" value="更新訂單">                      <input name="button" type="button" class="sform_g" id="button" onClick="history.back()" value="回上一頁"></td>
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
