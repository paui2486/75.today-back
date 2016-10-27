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

if($_POST['date1'] <> ""){$_date1 = $_POST['date1'];}else{ $_date1 = date('Y')."-".date('m')."-01";}
if($_POST['date2'] <> ""){$_date2 = $_POST['date2'];}else{ $_date2 = date('Y-m-d');}

 
mysql_select_db($database_iwine, $iwine);
$query_order_total = "SELECT *, SUM(ord_total_price) AS t_price, COUNT(*) AS t_num FROM order_list WHERE ord_date >= '".$_date1."' AND ord_date <= '".$_date2."' GROUP BY ord_date ORDER BY ord_id ASC";
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
</head>

<body marginheight="0" marginwidth="0" bgcolor="#666666">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td align="center" valign="top" bgcolor="666666"><table width="100%" height="605" border="0" align="center" cellpadding="0" cellspacing="8">
      <tr>
        <td height="2" bgcolor="#FFFFFF"></td>
        </tr>
      <tr>
        <td height="40" align="center" valign="middle"><span class="capw"><font color="#FFFFFF">◎ 訂單金額分析 ◎</font></span></td>
        </tr>
      <tr>
        <td height="2" bgcolor="#FFFFFF"></td>
        </tr>
      <tr>
        <td height="50" align="center"><form action="" method="post" name="form2">
          <span class="contnet_w">日期區間:</span>
          <input name="date1" type="text" class="sform" id="date1" value="<?php if($_POST['date1'] <> ""){echo $_POST['date1'];}else{ echo date('Y')."-".date('m')."-01"; } ?>" size="15">
          <span class="contnet_w">至
            <input name="date2" type="text" class="sform" id="date2" value="<?php if($_POST['date2'] <> ""){echo $_POST['date2'];}else{ echo date('Y-m-d'); } ?>" size="15">
            <input name="button4" type="submit" class="sform_b" id="button4" value="送出">
            <input name="button4" type="reset" class="sform_g" id="button5" value="重設">
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
                  <td align="center" background="images/transp.gif" bgcolor="#999999" class="contnet_w">總訂單數</td>
                  <td align="center" background="images/transp.gif" bgcolor="#999999" class="contnet_w">訂單總金額</td>
                  <td align="center" background="images/transp.gif" bgcolor="#999999" class="contnet_w">已付款訂單數</td>
                  <td align="center" background="images/transp.gif" bgcolor="#999999" class="contnet_w">百分比</td>
                  <td align="center" background="images/transp.gif" bgcolor="#999999" class="contnet_w">已付金額</td>
                  <td align="center" background="images/transp.gif" bgcolor="#999999" class="contnet_w">百分比</td>
                  <td align="center" background="images/transp.gif" bgcolor="#999999" class="contnet_w">已付款客單價</td>
                  <td align="center" background="images/transp.gif" bgcolor="#999999" class="contnet_w">未付款訂單數</td>
                  <td align="center" background="images/transp.gif" bgcolor="#999999" class="contnet_w">未付款金額</td>
                  <td align="center" background="images/transp.gif" bgcolor="#999999" class="contnet_w">未付款客單價</td>
                  </tr>
                <?php if ($totalRows_order_total > 0) { // Show if recordset not empty ?>
                <?php $j = 1 ; ?>
                  <?php do { ?>
                  <?php
mysql_select_db($database_iwine, $iwine);
$query_order_total2 = "SELECT *, SUM(ord_total_price) AS t_price2, COUNT(*) AS t_num2 FROM order_list WHERE ord_date = '".$row_order_total['ord_date']."' AND ord_status >= '3' AND ord_status <= '8' AND ord_status <> '7' AND ord_status <> '5' GROUP BY ord_date ORDER BY ord_id ASC";
$order_total2 = mysql_query($query_order_total2, $iwine) or die(mysql_error());
$row_order_total2 = mysql_fetch_assoc($order_total2);
$totalRows_order_total2 = mysql_num_rows($order_total2);

if($row_order_total2['t_num2']==""){$row_order_total2['t_num2'] = 0; }
if($row_order_total2['t_price2']==""){$row_order_total2['t_price2'] = 0;}
				  ?>
                    <tr bgcolor="#DDDDDD" >
                      <td align="center" bgcolor="#FFFFFF"><span class="text_cap2"><?php echo $row_order_total['ord_date']; ?></span></td>
                      <td align="center" bgcolor="#FFFFFF"><span class="text_cap2"><?php echo $row_order_total['t_num']; $tt_num = $tt_num + $row_order_total['t_num']; ?></span></td>
                      <td align="center" bgcolor="#FFFFFF"><span class="text_cap2"><?php echo $row_order_total['t_price']; $tt_price = $tt_price + $row_order_total['t_price']; ?></span></td>
                      <td align="center" bgcolor="#FFC"><span class="text_cap2"><?php echo $row_order_total2['t_num2']; $tt_num2 = $tt_num2 + $row_order_total2['t_num2'];?></span></td>
                      <td align="center" bgcolor="#FFC"><span class="text_cap2">
                        <?php $pay_ratio = round(($row_order_total2['t_num2']/$row_order_total['t_num']),2)*100; echo $pay_ratio."%"; ?>
                      </span></td>
                      <td align="center" bgcolor="#FCF"><span class="text_cap2"><?php echo $row_order_total2['t_price2']; $tt_price2 = $tt_price2 + $row_order_total2['t_price2'];?></span></td>
                      <td align="center" bgcolor="#FCF"><span class="text_cap2">
                        <?php $pay_price_ratio = round(($row_order_total2['t_price2']/$row_order_total['t_price']),2)*100; echo $pay_price_ratio."%"; ?>
                      </span></td>
                      <td align="center" bgcolor="#FFFFFF"><span class="text_cap2"><?php echo round($row_order_total2['t_price2']/$row_order_total2['t_num2'],0); ?></span></td>
                      <td align="center" bgcolor="#FFFFFF"><span class="text_cap2"><?php echo $row_order_total['t_num']-$row_order_total2['t_num2']; ?></span></td>
                      <td align="center" bgcolor="#FFFFFF"><span class="text_cap2"><?php echo $row_order_total['t_price']-$row_order_total2['t_price2']; ?></span></td>
                      <td align="center" bgcolor="#FFFFFF"><span class="text_cap2"><?php echo round(($row_order_total['t_price']-$row_order_total2['t_price2'])/($row_order_total['t_num']-$row_order_total2['t_num2']),0); ?></span></td>
                    </tr>
                    <?php $j++; ?>
                    <?php } while ($row_order_total = mysql_fetch_assoc($order_total)); ?>
                 
                  <tr bgcolor="#DDDDDD" >
                      <td align="center" bgcolor="#CCCCCC"><span class="text_cap2"><strong>合計</strong></span></td>
                      <td align="center" bgcolor="#CCCCCC"><span class="text_cap2"><strong><?php echo $tt_num; ?></strong></span></td>
                      <td align="center" bgcolor="#CCCCCC"><span class="text_cap2"><strong><?php echo $tt_price; ?></strong></span></td>
                      <td align="center" bgcolor="#FFC"><span class="text_cap2"><strong><?php echo $tt_num2; ?></strong></span></td>
                      <td align="center" bgcolor="#FFC"><span class="text_cap2"><strong><?php echo round(($tt_num2/$tt_num),2)*100 ; ?>%</strong></span></td>
                      <td align="center" bgcolor="#FCF"><span class="text_cap2"><strong><?php echo $tt_price2; ?></strong></span></td>
                      <td align="center" bgcolor="#FCF"><span class="text_cap2"><strong><?php echo round(($tt_price2/$tt_price),2)*100 ; ?>%</strong></span></td>
                      <td align="center" bgcolor="#CCCCCC"><span class="text_cap2"><strong><?php echo round($tt_price2/$tt_num2,0); ?></strong></span></td>
                      <td align="center" bgcolor="#CCCCCC"><span class="text_cap2"><strong><?php echo $tt_num - $tt_num2; ?></strong></span></td>
                      <td align="center" bgcolor="#CCCCCC"><span class="text_cap2"><strong><?php echo $tt_price - $tt_price2; ?></strong></span></td>
                      <td align="center" bgcolor="#CCCCCC"><span class="text_cap2"><strong><?php echo round(($tt_price - $tt_price2)/($tt_num - $tt_num2),0); ?></strong></span></td>
                    </tr>
					<?php } // Show if recordset not empty ?>
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
