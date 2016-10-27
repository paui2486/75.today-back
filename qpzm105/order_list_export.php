<?php include('session_check.php'); ?>
<?php require_once('../Connections/iwine.php'); ?>
<?php
$f = 0;

if (isset($_POST['product']) && $_POST['product'] <> "0") {

   $SQL_1 = " ord_p_id = '".$_POST['product']."' AND";
   $f = 1;

}

if (isset($_POST['ord_status']) && $_POST['ord_status'] <> "0") {
	  
   $SQL_2 = " ord_status = '".$_POST['ord_status']."' AND";
   $f = 1;
   
}

if ($_POST['date1']<>"") {

   $date01 = $_POST['date1'];
   
   $SQL_30 = " ord_date >= '".$date01."' AND";
   $f = 1;
  
}

if ($_POST['date2']<>"") {

   $date02 = $_POST['date2'];
   $SQL_31 = " ord_date <= '".$date02."' AND";
   $f = 1;
  
}

if($_POST['search'] <> "Y" && $f == 0){
   
   $SQL_7 = " ord_id = '-1'";

}else{
	
   $SQL_7 = " ord_id > 0";

}

$newSQL = "SELECT * FROM order_list LEFT JOIN Product ON order_list.ord_p_id = Product.p_id LEFT JOIN member ON order_list.ord_acc_id = member.m_id WHERE".$SQL_1 .$SQL_2.$SQL_30.$SQL_31.$SQL_7." ORDER BY ord_code ASC";

mysql_select_db($database_iwine, $iwine);
$query_order = $newSQL;
$order = mysql_query($query_order, $iwine) or die(mysql_error());
$row_order = mysql_fetch_assoc($order);
$totalRows_order = mysql_num_rows($order);

require_once("../func/csv.php");

$saveasname=date('YmdHis').'_order_list.xls';
$fcode = $_POST['fcode'];
$tcode = $_POST['tcode'];
$wcode = $_POST['wcode'];
$ord_today_no = $_POST['ord_no'];
$taiwan_year = date('Y') - 1911 ;
$taiwan_today = $taiwan_year.date('m').date('d');

	
	if($row_order['p_product1'] == "" || $_POST['product'] == 0 || !isset($_POST['product'])){$p_p1 = "商品一";}else{$p_p1 = $row_order['p_product1'];}
	if($row_order['p_product2'] == "" || $_POST['product'] == 0 || !isset($_POST['product'])){$p_p2 = "商品二";}else{$p_p2 = $row_order['p_product2'];}
	if($row_order['p_product3'] == "" || $_POST['product'] == 0 || !isset($_POST['product'])){$p_p3 = "商品三";}else{$p_p3 = $row_order['p_product3'];}
	if($row_order['p_product4'] == "" || $_POST['product'] == 0 || !isset($_POST['product'])){$p_p4 = "商品四";}else{$p_p4 = $row_order['p_product4'];}
	if($row_order['p_product5'] == "" || $_POST['product'] == 0 || !isset($_POST['product'])){$p_p5 = "商品五";}else{$p_p5 = $row_order['p_product5'];}
	
	if($row_order['p_pb1'] == ""){$p_pb1 = "加購商品一";}else{$p_pb1 = $row_order['p_pb1'];}
	if($row_order['p_pb2'] == ""){$p_pb2 = "加購商品二";}else{$p_pb2 = $row_order['p_pb2'];}
	if($row_order['p_pb3'] == ""){$p_pb3 = "加購商品三";}else{$p_pb3 = $row_order['p_pb3'];}
	if($row_order['p_pb4'] == ""){$p_pb4 = "加購商品四";}else{$p_pb4 = $row_order['p_pb4'];}
	if($row_order['p_pb5'] == ""){$p_pb5 = "加購商品五";}else{$p_pb5 = $row_order['p_pb5'];}
	if($row_order['p_pb6'] == ""){$p_pb6 = "加購商品六";}else{$p_pb6 = $row_order['p_pb6'];}
	if($row_order['p_pb7'] == ""){$p_pb7 = "加購商品七";}else{$p_pb7 = $row_order['p_pb7'];}
	if($row_order['p_pb8'] == ""){$p_pb8 = "加購商品八";}else{$p_pb8 = $row_order['p_pb8'];}
	if($row_order['p_pb9'] == ""){$p_pb9 = "加購商品九";}else{$p_pb9 = $row_order['p_pb9'];}
	if($row_order['p_pb10'] == ""){$p_pb10 = "加購商品十";}else{$p_pb10 = $row_order['p_pb10'];}
	
	if($row_order['p_pa1'] == ""){$p_pa1 = "搭配商品一";}else{$p_pa1 = $row_order['p_pa1'];}
	if($row_order['p_pa2'] == ""){$p_pa2 = "搭配商品二";}else{$p_pa2 = $row_order['p_pa2'];}
	if($row_order['p_pa3'] == ""){$p_pa3 = "搭配商品三";}else{$p_pa3 = $row_order['p_pa3'];}
	if($row_order['p_pa4'] == ""){$p_pa4 = "搭配商品四";}else{$p_pa4 = $row_order['p_pa4'];}
	if($row_order['p_pa5'] == ""){$p_pa5 = "搭配商品五";}else{$p_pa5 = $row_order['p_pa5'];}
	if($row_order['p_pa6'] == ""){$p_pa6 = "搭配商品六";}else{$p_pa6 = $row_order['p_pa6'];}
	if($row_order['p_pa7'] == ""){$p_pa7 = "搭配商品七";}else{$p_pa7 = $row_order['p_pa7'];}
	if($row_order['p_pa8'] == ""){$p_pa8 = "搭配商品八";}else{$p_pa8 = $row_order['p_pa8'];}
	if($row_order['p_pa9'] == ""){$p_pa9 = "搭配商品九";}else{$p_pa9 = $row_order['p_pa9'];}
	if($row_order['p_pa10'] == ""){$p_pa10 = "搭配商品十";}else{$p_pa10 = $row_order['p_pa10'];}
	
$tmp = excel_start(true).excel_header(array("訂單編號","收貨人姓名",$p_p1,$p_p2,$p_p3,$p_p4,$p_p5,$p_pb1,$p_pb2,$p_pb3,$p_pb4,$p_pb5,$p_pb6,$p_pb7,$p_pb8,$p_pb9,$p_pb10,$p_pa1,$p_pa2,$p_pa3,$p_pa4,$p_pa5,$p_pa6,$p_pa7,$p_pa8,$p_pa9,$p_pa10,"商品總價","運費","手續費","付款總額","付款方式","訂單狀態","掛號編號","發票日期","發票號碼","備註"),true);

$_num = 0 ;
if ($totalRows_order > 0) { // Show if recordset not empty
do {

	switch($row_order['ord_pay']){
							case 'card':
							$_payway = "信用卡";
							break;
							case 'webatm':
							$_payway = "WEBATM";
							break;
							case 'atm':
							$_payway = "超商付款";
							break;
							case 'atm_cathy':
							$_payway = "一般匯款";
							break;
							case 'paynow':
							$_payway = "貨到付款";
							break;
						}
	switch($row_order['ord_status']){
							case '1':
							$_status = "未處理";
							break;
							case '2':
							$_status = "付款失敗";
							break;
							case '3':
							$_status = "已付款，準備出貨中";
							break;
							case '4':
							$_status = "已出貨";
							break;
							case '5':
							$_status = "尚未匯款";
							break;
							case '6':
							$_status = "對帳中";
							break;
							case '7':
							$_status = "對帳失敗，請重填匯款帳號後5碼";
							break;
							case '8':
							$_status = "已簽收";
							break;
							case '9':
							$_status = "未簽收退回";
							break;
							case '10':
							$_status = "缺貨中";
							break;
							case '11':
							$_status = "貨到付款尚未出貨";
							break;
							case '21':
							$_status = "查無帳款，請與我們聯繫";
							break;
							case '22':
							$_status = "金額不符，請與我們聯繫";
							break;
							case '91':
							$_status = "退貨申請中";
							break;
							case '92':
							$_status = "退貨中";
							break;
							case '93':
							$_status = "退貨完成";
							break;
							case '94':
							$_status = "取消訂單中";
							break;
							case '95':
							$_status = "未轉帳，已取消訂單";
							break;
							case '99':
							$_status = "無效訂單";
							break;
						}

$_total_num = $row_order['ord_p_num']+$row_order['ord_p_num2']+$row_order['ord_p_num3']+$row_order['ord_p_num4']+$row_order['ord_p_num5'];					
$_main_total_price = $_total_num*$row_order['p_price2'];
$_addition_total_price = $row_order['ord_pb1_num']*$row_order['p_pb1_price']+$row_order['ord_pb2_num']*$row_order['p_pb2_price']+$row_order['ord_pb3_num']*$row_order['p_pb3_price']+$row_order['ord_pb4_num']*$row_order['p_pb4_price']+$row_order['ord_pb5_num']*$row_order['p_pb5_price']+$row_order['ord_pb6_num']*$row_order['p_pb6_price']+$row_order['ord_pb7_num']*$row_order['p_pb7_price']+$row_order['ord_pb8_num']*$row_order['p_pb8_price']+$row_order['ord_pb9_num']*$row_order['p_pb9_price']+$row_order['ord_pb10_num']*$row_order['p_pb10_price'];
$_total_buy = $_main_total_price + $_addition_total_price ; 


$tmp .= excel_row(array($row_order['ord_code'],$row_order['ord_ship_name'],$row_order['ord_p_num'],$row_order['ord_p_num2'],$row_order['ord_p_num3'],$row_order['ord_p_num4'],$row_order['ord_p_num5'],$row_order['ord_pb1_num'],$row_order['ord_pb2_num'],$row_order['ord_pb3_num'],$row_order['ord_pb4_num'],$row_order['ord_pb5_num'],$row_order['ord_pb6_num'],$row_order['ord_pb7_num'],$row_order['ord_pb8_num'],$row_order['ord_pb9_num'],$row_order['ord_pb10_num'],$row_order['ord_pa1_num'],$row_order['ord_pa2_num'],$row_order['ord_pa3_num'],$row_order['ord_pa4_num'],$row_order['ord_pa5_num'],$row_order['ord_pa6_num'],$row_order['ord_pa7_num'],$row_order['ord_pa8_num'],$row_order['ord_pa9_num'],$row_order['ord_pa10_num'],$_total_buy,$row_order['ord_ship_price'],$row_order['ord_hand_price'],$row_order['ord_total_price'],$_payway,$_status,$row_order['ord_ship_code'],$row_order['ord_ship_fa_date'],$row_order['ord_ship_fa_code'],$row_order['ord_memo']),true);

} while ($row_order = mysql_fetch_assoc($order)); 
} // Show if recordset not empty 

$tmp .=excel_end(true);
	

		header('Content-Type: application/octet-stream');
		header('Content-Disposition: attachment; Filename="'.$saveasname.'"');
		header('Pragma: no-cache');
		header('Content-length:'.strlen($tmp));
		
		echo $tmp;

mysql_free_result($order);
?>
