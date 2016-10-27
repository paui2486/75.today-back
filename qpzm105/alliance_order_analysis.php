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

$_date1 = $_GET['date1'];
$_date2 = $_GET['date2'];
$_am_code = $_GET['am_code'];
$_am_ratio = $_GET['am_ratio']/100;
 
mysql_select_db($database_iwine, $iwine);
$query_order_total = "SELECT *, SUM(ord_buy_price) AS t_price, COUNT(*) AS t_num FROM order_list WHERE ord_date >= '".$_date1."' AND ord_date <= '".$_date2."' AND am_code = '$_am_code' GROUP BY ord_date ORDER BY ord_id ASC";
$order_total = mysql_query($query_order_total, $iwine) or die(mysql_error());
$row_order_total = mysql_fetch_assoc($order_total);
$totalRows_order_total = mysql_num_rows($order_total);

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
        <td height="40" align="center" valign="middle"><span class="capw"><font color="#FFFFFF">◎ 行銷成果分析 ◎</font></span></td>
        </tr>
      <tr>
        <td height="2" bgcolor="#FFFFFF"></td>
        </tr>
      <tr>
        <td height="50" align="center"><form action="alliance_order_analysis.php" method="GET" name="form2">
          <span class="contnet_w">
          <input name="am_id" type="hidden" id="am_id" value="<?php echo $_GET['am_id']; ?>">
          <input name="am_code" type="hidden" id="am_code" value="<?php echo $_GET['am_code']; ?>">
          <input name="am_ratio" type="hidden" id="am_ratio" value="<?php echo $_GET['am_ratio']; ?>">
          日期區間:</span>
          <input name="date1" type="text" class="sform" id="date1" value="<?php echo $_GET['date1']; ?>" size="15">
          <span class="contnet_w">至
            <input name="date2" type="text" class="sform" id="date2" value="<?php echo $_GET['date2']; ?>" size="15">
            <input name="button4" type="submit" class="sform_b" id="button4" value="送出">
            <input name="button4" type="reset" class="sform_g" id="button5" value="重設">
            <input name="button" type="button" class="sform_r" id="button" onClick="MM_goToURL('self','alliance_member_s.php?am_id=<?php echo $_GET['am_id']; ?>');return document.MM_returnValue" value="回盟友資料">
            </span>
          </form></td>
      </tr>
      <script type="text/javascript">
// BeginWebWidget jQuery_UI_Calendar: sdate1
jQuery("#date1").datepick({dateFormat: 'yy-mm-dd'});
jQuery("#date2").datepick({dateFormat: 'yy-mm-dd'});
// EndWebWidget jQuery_UI_Calendar: sdate1
                          </script>
      <tr>
        <td align="center" valign="top"><table width="95%" border="0" cellpadding="3" cellspacing="0" bgcolor="494949">
          
          <tr>
            <td><div align="center">
              <table width="100%" border="0" cellpadding="5" cellspacing="1" class="table">
                <tr bgcolor="#DDDDDD" >
                  <td align="center" background="images/transp.gif" bgcolor="#999999" class="contnet_w">日期</td>
                  <td align="center" background="images/transp.gif" bgcolor="#999999" class="contnet_w">已付款交易訂單數</td>
                  <td align="center" background="images/transp.gif" bgcolor="#999999" class="contnet_w">已付款交易訂單總金額</td>
                  <td align="center" background="images/transp.gif" bgcolor="#999999" class="contnet_w">分潤金額</td>
                  <td align="center" background="images/transp.gif" bgcolor="#999999" class="contnet_w">未付款交易訂單數</td>
                  <td align="center" background="images/transp.gif" bgcolor="#999999" class="contnet_w">未付款交易訂單總金額</td>
                  </tr>
                <?php if ($totalRows_order_total > 0) { // Show if recordset not empty ?>
                <?php $j = 1 ; ?>
                <?php do { ?>
                <?php
mysql_select_db($database_iwine, $iwine);
$query_order_total2 = "SELECT *, SUM(ord_buy_price) AS t_price2, COUNT(*) AS t_num2 FROM order_list WHERE (ord_date = '".$row_order_total['ord_date']."' AND am_code = '".$row_order_total['am_code']."' AND ord_status = '4') OR (ord_date = '".$row_order_total['ord_date']."' AND am_code = '".$row_order_total['am_code']."' AND ord_status = '3') GROUP BY ord_date ORDER BY ord_id ASC";
$order_total2 = mysql_query($query_order_total2, $iwine) or die(mysql_error());
$row_order_total2 = mysql_fetch_assoc($order_total2);
$totalRows_order_total2 = mysql_num_rows($order_total2);

if($row_order_total2['t_num2']==""){$row_order_total2['t_num2'] = 0; }
if($row_order_total2['t_price2']==""){$row_order_total2['t_price2'] = 0;}
				  ?>
                <tr bgcolor="#DDDDDD" >
                      <td align="center" bgcolor="#FFFFFF"><span class="text_cap2"><?php echo $row_order_total['ord_date']; ?></span></td>
                      <td align="center" bgcolor="#FFFFFF"><span class="text_cap2"><?php echo $row_order_total2['t_num2']; $tt_num = $tt_num + $row_order_total2['t_num2']; ?></span></td>
                      <td align="center" bgcolor="#FFFFFF"><span class="text_cap2"><?php echo $row_order_total2['t_price2']; $tt_price = $tt_price + $row_order_total2['t_price2']; ?></span></td>
                      <td align="center" bgcolor="#FFC"><span class="text_cap2"><?php echo $_pay = round($row_order_total2['t_price2']*$_am_ratio,0); $tt_num2 = $tt_num2 + $_pay;?></span></td>
                      <td align="center" bgcolor="#FFFFFF"><?php echo $no_pay_num = $row_order_total['t_num']-$row_order_total2['t_num2']; $tt_num3 = $tt_num3 + $no_pay_num; ?></td>
                      <td align="center" bgcolor="#FFFFFF"><?php echo $no_pay_price = $row_order_total['t_price']-$row_order_total2['t_price2']; $tt_price3 = $tt_price3 + $no_pay_price; ?></td>
                      </tr>
                      <?php $j++; ?>
                    <?php } while ($row_order_total = mysql_fetch_assoc($order_total)); ?>
                 
                      <tr bgcolor="#DDDDDD" >
                      <td align="center" bgcolor="#CCCCCC"><span class="text_cap2"><strong>合計</strong></span></td>
                      <td align="center" bgcolor="#CCCCCC"><span class="text_cap2"><strong><?php echo $tt_num; ?></strong></span></td>
                      <td align="center" bgcolor="#CCCCCC"><span class="text_cap2"><strong><?php echo $tt_price; ?></strong></span></td>
                      <td align="center" bgcolor="#FFC"><span class="text_cap2"><strong><?php echo $tt_num2; ?></strong></span></td>
                      <td align="center" bgcolor="#CCCCCC"><?php echo $tt_num3; ?></td>
                      <td align="center" bgcolor="#CCCCCC"><?php echo $tt_price3; ?></td>
                      </tr>
					  <?php }else{ // Show if recordset not empty ?>                  
                  		<tr bgcolor="#DDDDDD" >
                  		<td colspan="6" align="center" bgcolor="#FFFFFF">無成交記錄</td>
                  		</tr>
				<?php } ?>	
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
mysql_free_result($order_total);
?>
