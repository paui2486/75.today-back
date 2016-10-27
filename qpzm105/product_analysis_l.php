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
$query_Recordset1 = "SELECT * FROM Product WHERE p_outside = 'N' ORDER BY p_code ASC";
$Recordset1 = mysql_query($query_Recordset1, $iwine) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);


if (isset($_POST['search']) && $_POST['search'] == "Y") {

$f = 0;

if (isset($_POST['product']) && $_POST['product'] <> "0") {

   $SQL_1 = " ord_p_id = '".$_POST['product']."' AND";
   $f = 1;

}else{
msg_box('請選擇團體專案！');
go_to(-1);
exit;	
	
}

if (isset($_POST['status']) && $_POST['status'] == "1") {
	  
   $SQL_2 = "(ord_status = '3' OR ord_status = '4')";
   $f = 1;
   
}else{
   $SQL_2 = "(ord_status = '3' OR ord_status = '4' OR ord_status = '5' OR ord_status = '11')";
   $f = 1;
	
}

if ($_POST['date1']<>"") {

   $date01 = $_POST['date1'];
   
   $SQL_30 = " ord_date >= '".$date01."' AND";
   $f = 1;
  
}else{
	
	$date01 = date('Y')."-".date('m')."-01";
   
   $SQL_30 = " ord_date >= '".$date01."' AND";
   $f = 1;
  
}

if ($_POST['date2']<>"") {

   $date02 = $_POST['date2'];
   $SQL_31 = " ord_date <= '".$date02."' AND";
   $f = 1;
  
}else{

   $date02 = date('Y-m-d');
   $SQL_31 = " ord_date <= '".$date02."' AND";
   $f = 1;
  
}

mysql_select_db($database_iwine, $iwine);
$query_order = "SELECT *, SUM(ord_buy_price) AS t_price, COUNT(*) AS t_num, SUM(ord_p_num) AS t_p_num1, SUM(ord_p_num2) AS t_p_num2, SUM(ord_p_num3) AS t_p_num3, SUM(ord_p_num4) AS t_p_num4, SUM(ord_p_num5) AS t_p_num5, SUM(ord_pb1_num) AS t_pb1_num, SUM(ord_pb2_num) AS t_pb2_num, SUM(ord_pb3_num) AS t_pb3_num, SUM(ord_pb4_num) AS t_pb4_num, SUM(ord_pb5_num) AS t_pb5_num, SUM(ord_pb6_num) AS t_pb6_num, SUM(ord_pb7_num) AS t_pb7_num, SUM(ord_pb8_num) AS t_pb8_num, SUM(ord_pb9_num) AS t_pb9_num, SUM(ord_pb10_num) AS t_pb10_num, SUM(ord_pa1_num) AS t_pa1_num, SUM(ord_pa2_num) AS t_pa2_num, SUM(ord_pa3_num) AS t_pa3_num, SUM(ord_pa4_num) AS t_pa4_num, SUM(ord_pa5_num) AS t_pa5_num, SUM(ord_pa6_num) AS t_pa6_num, SUM(ord_pa7_num) AS t_pa7_num, SUM(ord_pa8_num) AS t_pa8_num, SUM(ord_pa9_num) AS t_pa9_num, SUM(ord_pa10_num) AS t_pa10_num FROM order_list LEFT JOIN Product ON order_list.ord_p_id = Product.p_id LEFT JOIN member ON order_list.ord_acc_id = member.m_id WHERE ".$SQL_2." AND".$SQL_1.$SQL_30.$SQL_31." ord_id > 0 GROUP BY ord_date ORDER BY ord_code ASC";
$order = mysql_query($query_order, $iwine) or die(mysql_error());
$row_order = mysql_fetch_assoc($order);
$totalRows_order = mysql_num_rows($order);

	
	if($row_order['p_product1'] == "" || $_POST['product'] == 0 || !isset($_POST['product'])){$p_p1 = "無";}else{$p_p1 = $row_order['p_product1'];}
	if($row_order['p_product2'] == "" || $_POST['product'] == 0 || !isset($_POST['product'])){$p_p2 = "無";}else{$p_p2 = $row_order['p_product2'];}
	if($row_order['p_product3'] == "" || $_POST['product'] == 0 || !isset($_POST['product'])){$p_p3 = "無";}else{$p_p3 = $row_order['p_product3'];}
	if($row_order['p_product4'] == "" || $_POST['product'] == 0 || !isset($_POST['product'])){$p_p4 = "無";}else{$p_p4 = $row_order['p_product4'];}
	if($row_order['p_product5'] == "" || $_POST['product'] == 0 || !isset($_POST['product'])){$p_p5 = "無";}else{$p_p5 = $row_order['p_product5'];}
	
	if($row_order['p_pb1'] == ""){$p_pb1 = "無";}else{$p_pb1 = $row_order['p_pb1'];}
	if($row_order['p_pb2'] == ""){$p_pb2 = "無";}else{$p_pb2 = $row_order['p_pb2'];}
	if($row_order['p_pb3'] == ""){$p_pb3 = "無";}else{$p_pb3 = $row_order['p_pb3'];}
	if($row_order['p_pb4'] == ""){$p_pb4 = "無";}else{$p_pb4 = $row_order['p_pb4'];}
	if($row_order['p_pb5'] == ""){$p_pb5 = "無";}else{$p_pb5 = $row_order['p_pb5'];}
	if($row_order['p_pb6'] == ""){$p_pb6 = "無";}else{$p_pb6 = $row_order['p_pb6'];}
	if($row_order['p_pb7'] == ""){$p_pb7 = "無";}else{$p_pb7 = $row_order['p_pb7'];}
	if($row_order['p_pb8'] == ""){$p_pb8 = "無";}else{$p_pb8 = $row_order['p_pb8'];}
	if($row_order['p_pb9'] == ""){$p_pb9 = "無";}else{$p_pb9 = $row_order['p_pb9'];}
	if($row_order['p_pb10'] == ""){$p_pb10 = "無";}else{$p_pb10 = $row_order['p_pb10'];}
	
	if($row_order['p_pa1'] == ""){$p_pa1 = "無";}else{$p_pa1 = $row_order['p_pa1'];}
	if($row_order['p_pa2'] == ""){$p_pa2 = "無";}else{$p_pa2 = $row_order['p_pa2'];}
	if($row_order['p_pa3'] == ""){$p_pa3 = "無";}else{$p_pa3 = $row_order['p_pa3'];}
	if($row_order['p_pa4'] == ""){$p_pa4 = "無";}else{$p_pa4 = $row_order['p_pa4'];}
	if($row_order['p_pa5'] == ""){$p_pa5 = "無";}else{$p_pa5 = $row_order['p_pa5'];}
	if($row_order['p_pa6'] == ""){$p_pa6 = "無";}else{$p_pa6 = $row_order['p_pa6'];}
	if($row_order['p_pa7'] == ""){$p_pa7 = "無";}else{$p_pa7 = $row_order['p_pa7'];}
	if($row_order['p_pa8'] == ""){$p_pa8 = "無";}else{$p_pa8 = $row_order['p_pa8'];}
	if($row_order['p_pa9'] == ""){$p_pa9 = "無";}else{$p_pa9 = $row_order['p_pa9'];}
	if($row_order['p_pa10'] == ""){$p_pa10 = "無";}else{$p_pa10 = $row_order['p_pa10'];}
	
}
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>iWine - 後台管理系統</title>
<script type="text/javascript" src="js/jquery-1.7.2.min.js"></script>
<style type="text/css">@import "js/jquery.datepick.package-3.6.1/jquery.datepick.css";</style> 
<script type="text/javascript" src="js/jquery.datepick.package-3.6.1/jquery.datepick.js"></script>
<script type="text/javascript" src="js/jquery.datepick.package-3.6.1/jquery.datepick.pack.js"></script>
<script type="text/javascript" src="js/jquery.datepick.package-3.6.1/jquery.datepick-zh-TW.js"></script>
<link href="css.css" rel="stylesheet" type="text/css">
</head>

<body marginheight="0" marginwidth="0" bgcolor="#666666">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td align="center" valign="top" bgcolor="666666"><table width="100%" height="392" border="0" align="center" cellpadding="0" cellspacing="8">
      <tr>
        <td height="2" bgcolor="#FFFFFF"></td>
        </tr>
      <tr>
        <td height="40" align="center" valign="middle"><span class="capw"><font color="#FFFFFF">◎ 團體商品銷售統計 ◎</font></span></td>
        </tr>
      <tr>
        <td height="2" bgcolor="#FFFFFF"></td>
        </tr>
      <tr>
        <td height="150" align="center" valign="top">       
        <table width="90%" border="0" cellspacing="0" cellpadding="3">
          <tr>
            <td bgcolor="#494949">
            <form action="" method="post" name="form1">
            <table width="100%" border="0" cellpadding="5" cellspacing="1" class="table">
              <tr>
                <td width="20%" background="images/transp.gif" bgcolor="#999999" class="contnet_w"><div align="right">選擇團體專案:</div></td>
                <td valign="middle" bgcolor="#FFFFFF"><select name="product" class="sform" id="product">
                  <option value="0" <?php if (!(strcmp(0, $_POST['product']))) {echo "selected=\"selected\"";} ?>>請選擇（必選）</option>
                  <?php
do {  
?>
                  <option value="<?php echo $row_Recordset1['p_id']?>"<?php if (!(strcmp($row_Recordset1['p_id'], $_POST['product']))) {echo "selected=\"selected\"";} ?>><?php echo $row_Recordset1['p_code']?> - <?php echo $row_Recordset1['p_name']?></option>
<?php
} while ($row_Recordset1 = mysql_fetch_assoc($Recordset1));
  $rows = mysql_num_rows($Recordset1);
  if($rows > 0) {
      mysql_data_seek($Recordset1, 0);
	  $row_Recordset1 = mysql_fetch_assoc($Recordset1);
  }
?>
                </select></td>
              </tr>
              <tr>
                <td background="images/transp.gif" bgcolor="#999999" class="contnet_w"><div align="right">訂單狀態:</div></td>
                <td valign="middle" bgcolor="#FFFFFF"><label for="status"></label>
                  <select name="status" class="sform" id="status">
                    <option value="0" <?php if (!(strcmp(0, $_POST['status']))) {echo "selected=\"selected\"";} ?>>已付款＋未付款訂單</option>
                    <option value="1" <?php if (!(strcmp(1, $_POST['status']))) {echo "selected=\"selected\"";} ?>>已付款訂單</option>
                  </select></td>
              </tr>
                <tr>
                  <td background="images/transp.gif" bgcolor="#999999" class="contnet_w"><div align="right">訂單日期區間:</div></td>
                  <td valign="middle" bgcolor="#FFFFFF">
                    <input name="date1" type="text" class="sform" id="date1" value="<?php if($_POST['date1'] <> ""){echo $_POST['date1'];}else{ echo date('Y')."-".date('m')."-01"; } ?>" size="15">
                    至
  <input name="date2" type="text" class="sform" id="date2" value="<?php if($_POST['date2'] <> ""){echo $_POST['date2'];}else{ echo date('Y-m-d'); } ?>" size="15">
                    <input name="ord_date_if" type="hidden" value="Y">
                    <script type="text/javascript">
// BeginWebWidget jQuery_UI_Calendar: sdate1
jQuery("#date1").datepick({dateFormat: 'yy-mm-dd'});
jQuery("#date2").datepick({dateFormat: 'yy-mm-dd'});
// EndWebWidget jQuery_UI_Calendar: sdate1
                          </script>
                    </td>
                </tr>
              <tr>
                <td colspan="2" align="center" bgcolor="#FFFFFF" class="contnet_w"><input name="search" type="hidden" id="search" value="Y">                  <input name="button5" type="submit" class="sform_r" id="button6" value="送出"></td>
              </tr>               
            </table>
            </form>
            </td>
          </tr>
        </table></td>
        </tr>
      <tr>
        <td align="center" valign="top">
        <table width="98%" border="0" cellpadding="3" cellspacing="0" bgcolor="494949">  
          <tr>
            <td><div align="center">
              <table width="100%" border="0" cellpadding="5" cellspacing="1" class="table">
                <tr bgcolor="#DDDDDD" >
                  <td align="center" background="images/transp.gif" bgcolor="#999999" class="contnet_w">日期</td>
                  <td align="center" background="images/transp.gif" bgcolor="#999999" class="contnet_w">總訂單數</td>
                  <td align="center" background="images/transp.gif" bgcolor="#999999" class="contnet_w">銷售金額</td>
                  <td align="center" bgcolor="#0000FF" class="contnet_w"><?php echo $p_p1; ?></td>
                  <td align="center" bgcolor="#0000FF" class="contnet_w"><?php echo $p_p2; ?></td>
                  <td align="center" bgcolor="#0000FF" class="contnet_w"><?php echo $p_p3; ?></td>
                  <td align="center" bgcolor="#0000FF" class="contnet_w"><?php echo $p_p4; ?></td>
                  <td align="center" bgcolor="#0000FF" class="contnet_w"><?php echo $p_p5; ?></td>
                  <td align="center" bgcolor="#993300" class="contnet_w"><?php echo $p_pb1; ?></td>
                  <td align="center" bgcolor="#993300" class="contnet_w"><?php echo $p_pb2; ?></td>
                  <td align="center" bgcolor="#993300" class="contnet_w"><?php echo $p_pb3; ?></td>
                  <td align="center" bgcolor="#993300" class="contnet_w"><?php echo $p_pb4; ?></td>
                  <td align="center" bgcolor="#993300" class="contnet_w"><?php echo $p_pb5; ?></td>
                  <td align="center" bgcolor="#993300" class="contnet_w"><?php echo $p_pb6; ?></td>
                  <td align="center" bgcolor="#993300" class="contnet_w"><?php echo $p_pb7; ?></td>
                  <td align="center" bgcolor="#993300" class="contnet_w"><?php echo $p_pb8; ?></td>
                  <td align="center" bgcolor="#993300" class="contnet_w"><?php echo $p_pb9; ?></td>
                  <td align="center" bgcolor="#993300" class="contnet_w"><?php echo $p_pb10; ?></td>
                  <td align="center" bgcolor="#6600CC" class="contnet_w"><?php echo $p_pa1; ?></td>
                  <td align="center" bgcolor="#6600CC" class="contnet_w"><?php echo $p_pa2; ?></td>
                  <td align="center" bgcolor="#6600CC" class="contnet_w"><?php echo $p_pa3; ?></td>
                  <td align="center" bgcolor="#6600CC" class="contnet_w"><?php echo $p_pa4; ?></td>
                  <td align="center" bgcolor="#6600CC" class="contnet_w"><?php echo $p_pa5; ?></td>
                  <td align="center" bgcolor="#6600CC" class="contnet_w"><?php echo $p_pa6; ?></td>
                  <td align="center" bgcolor="#6600CC" class="contnet_w"><?php echo $p_pa7; ?></td>
                  <td align="center" bgcolor="#6600CC" class="contnet_w"><?php echo $p_pa8; ?></td>
                  <td align="center" bgcolor="#6600CC" class="contnet_w"><?php echo $p_pa9; ?></td>
                  <td align="center" bgcolor="#6600CC" class="contnet_w"><?php echo $p_pa10; ?></td>
                  </tr>
				  <?php if ($totalRows_order > 0) { // Show if recordset not empty ?>
                  <?php do { ?>
                    <tr bgcolor="#DDDDDD" class="bg_cap" >
                      <td align="center" bgcolor="#FFFFFF"><?php echo $row_order['ord_date']; ?></td>
                      <td align="center" bgcolor="#FFFFFF"><?php echo $row_order['t_num']; $t_final_num = $t_final_num + $row_order['t_num']; ?></td>
                      <td align="center" bgcolor="#FFFFFF"><?php echo $row_order['t_price']; $t_final_price = $t_final_price + $row_order['t_price']; ?></td>
                      <td align="center" bgcolor="#FFFFFF"><?php echo $row_order['t_p_num1']; $t_final_p1 = $t_final_p1 + $row_order['t_p_num1']; ?></td>
                      <td align="center" bgcolor="#FFFFFF"><?php echo $row_order['t_p_num2']; $t_final_p2 = $t_final_p2 + $row_order['t_p_num2'];?></td>
                      <td align="center" bgcolor="#FFFFFF"><?php echo $row_order['t_p_num3']; $t_final_p3 = $t_final_p3 + $row_order['t_p_num3'];?></td>
                      <td align="center" bgcolor="#FFFFFF"><?php echo $row_order['t_p_num4']; $t_final_p4 = $t_final_p4 + $row_order['t_p_num4'];?></td>
                      <td align="center" bgcolor="#FFFFFF"><?php echo $row_order['t_p_num5']; $t_final_p5 = $t_final_p5 + $row_order['t_p_num5'];?></td>
                      <td align="center" bgcolor="#FFFFFF"><?php echo $row_order['t_pb1_num']; $t_final_pb1 = $t_final_pb1 + $row_order['t_pb1_num'];?></td>
                      <td align="center" bgcolor="#FFFFFF"><?php echo $row_order['t_pb2_num']; $t_final_pb2 = $t_final_pb2 + $row_order['t_pb2_num'];?></td>
                      <td align="center" bgcolor="#FFFFFF"><?php echo $row_order['t_pb3_num']; $t_final_pb3 = $t_final_pb3 + $row_order['t_pb3_num'];?></td>
                      <td align="center" bgcolor="#FFFFFF"><?php echo $row_order['t_pb4_num']; $t_final_pb4 = $t_final_pb4 + $row_order['t_pb4_num'];?></td>
                      <td align="center" bgcolor="#FFFFFF"><?php echo $row_order['t_pb5_num']; $t_final_pb5 = $t_final_pb5 + $row_order['t_pb5_num'];?></td>
                      <td align="center" bgcolor="#FFFFFF"><?php echo $row_order['t_pb6_num']; $t_final_pb6 = $t_final_pb6 + $row_order['t_pb6_num'];?></td>
                      <td align="center" bgcolor="#FFFFFF"><?php echo $row_order['t_pb7_num']; $t_final_pb7 = $t_final_pb7 + $row_order['t_pb7_num'];?></td>
                      <td align="center" bgcolor="#FFFFFF"><?php echo $row_order['t_pb8_num']; $t_final_pb8 = $t_final_pb8 + $row_order['t_pb8_num'];?></td>
                      <td align="center" bgcolor="#FFFFFF"><?php echo $row_order['t_pb9_num']; $t_final_pb9 = $t_final_pb9 + $row_order['t_pb9_num'];?></td>
                      <td align="center" bgcolor="#FFFFFF"><?php echo $row_order['t_pb10_num']; $t_final_pb10 = $t_final_pb10 + $row_order['t_pb10_num'];?></td>
                      <td align="center" bgcolor="#FFFFFF"><?php echo $row_order['t_pa1_num']; $t_final_pa1 = $t_final_pa1 + $row_order['t_pa1_num'];?></td>
                      <td align="center" bgcolor="#FFFFFF"><?php echo $row_order['t_pa2_num']; $t_final_pa2 = $t_final_pa2 + $row_order['t_pa2_num'];?></td>
                      <td align="center" bgcolor="#FFFFFF"><?php echo $row_order['t_pa3_num']; $t_final_pa3 = $t_final_pa3 + $row_order['t_pa3_num'];?></td>
                      <td align="center" bgcolor="#FFFFFF"><?php echo $row_order['t_pa4_num']; $t_final_pa4 = $t_final_pa4 + $row_order['t_pa4_num'];?></td>
                      <td align="center" bgcolor="#FFFFFF"><?php echo $row_order['t_pa5_num']; $t_final_pa5 = $t_final_pa5 + $row_order['t_pa5_num'];?></td>
                      <td align="center" bgcolor="#FFFFFF"><?php echo $row_order['t_pa6_num']; $t_final_pa6 = $t_final_pa6 + $row_order['t_pa6_num'];?></td>
                      <td align="center" bgcolor="#FFFFFF"><?php echo $row_order['t_pa7_num']; $t_final_pa7 = $t_final_pa7 + $row_order['t_pa7_num'];?></td>
                      <td align="center" bgcolor="#FFFFFF"><?php echo $row_order['t_pa8_num']; $t_final_pa8 = $t_final_pa8 + $row_order['t_pa8_num'];?></td>
                      <td align="center" bgcolor="#FFFFFF"><?php echo $row_order['t_pa9_num']; $t_final_pa9 = $t_final_pa9 + $row_order['t_pa9_num'];?></td>
                      <td align="center" bgcolor="#FFFFFF"><?php echo $row_order['t_pa10_num']; $t_final_pa10 = $t_final_pa10 + $row_order['t_pa10_num'];?></td>
                    </tr>
                    <?php } while ($row_order = mysql_fetch_assoc($order)); ?>
<?php } while ($row_order = mysql_fetch_assoc($order)); ?> 
                <tr bgcolor="#DDDDDD" >
                      <td align="center" bgcolor="#CCCCCC"><span class="text_cap2"><strong>合計</strong></span></td>
                      <td align="center" bgcolor="#CCCCCC"><?php echo $t_final_num; ?></td>
                      <td align="center" bgcolor="#CCCCCC"><?php echo $t_final_price; ?></td>
                      <td align="center" bgcolor="#CCCCCC"><?php echo $t_final_p1; ?></td>
                      <td align="center" bgcolor="#CCCCCC"><?php echo $t_final_p2; ?></td>
                      <td align="center" bgcolor="#CCCCCC"><?php echo $t_final_p3; ?></td>
                      <td align="center" bgcolor="#CCCCCC"><?php echo $t_final_p4; ?></td>
                      <td align="center" bgcolor="#CCCCCC"><?php echo $t_final_p5; ?></td>
                      <td align="center" bgcolor="#CCCCCC"><?php echo $t_final_pb1; ?></td>
                      <td align="center" bgcolor="#CCCCCC"><?php echo $t_final_pb2; ?></td>
                      <td align="center" bgcolor="#CCCCCC"><?php echo $t_final_pb3; ?></td>
                      <td align="center" bgcolor="#CCCCCC"><?php echo $t_final_pb4; ?></td>
                      <td align="center" bgcolor="#CCCCCC"><?php echo $t_final_pb5; ?></td>
                      <td align="center" bgcolor="#CCCCCC"><?php echo $t_final_pb6; ?></td>
                      <td align="center" bgcolor="#CCCCCC"><?php echo $t_final_pb7; ?></td>
                      <td align="center" bgcolor="#CCCCCC"><?php echo $t_final_pb8; ?></td>
                      <td align="center" bgcolor="#CCCCCC"><?php echo $t_final_pb9; ?></td>
                      <td align="center" bgcolor="#CCCCCC"><?php echo $t_final_pb10; ?></td>
                      <td align="center" bgcolor="#CCCCCC"><?php echo $t_final_pa1; ?></td>
                      <td align="center" bgcolor="#CCCCCC"><?php echo $t_final_pa2; ?></td>
                      <td align="center" bgcolor="#CCCCCC"><?php echo $t_final_pa3; ?></td>
                      <td align="center" bgcolor="#CCCCCC"><?php echo $t_final_pa4; ?></td>
                      <td align="center" bgcolor="#CCCCCC"><?php echo $t_final_pa5; ?></td>
                      <td align="center" bgcolor="#CCCCCC"><?php echo $t_final_pa6; ?></td>
                      <td align="center" bgcolor="#CCCCCC"><?php echo $t_final_pa7; ?></td>
                      <td align="center" bgcolor="#CCCCCC"><?php echo $t_final_pa8; ?></td>
                      <td align="center" bgcolor="#CCCCCC"><?php echo $t_final_pa9; ?></td>
                      <td align="center" bgcolor="#CCCCCC"><?php echo $t_final_pa10; ?></td>
                    </tr>
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
mysql_free_result($Recordset1);

mysql_free_result($order);
?>
