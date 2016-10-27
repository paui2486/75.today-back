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

$newSQL = "SELECT * FROM order_list LEFT JOIN Product ON order_list.ord_p_id = Product.p_id LEFT JOIN member ON order_list.ord_acc_id = member.m_id WHERE".$SQL_1 .$SQL_2.$SQL_30.$SQL_31.$SQL_7." ORDER BY ord_date DESC, ord_code ASC";

mysql_select_db($database_iwine, $iwine);
$query_order = $newSQL;
$order = mysql_query($query_order, $iwine) or die(mysql_error());
$row_order = mysql_fetch_assoc($order);
$totalRows_order = mysql_num_rows($order);

require_once("../func/csv.php");

$saveasname=date('YmdHis').'_order.xls';
$fcode = $_POST['fcode'];
$tcode = $_POST['tcode'];
$wcode = $_POST['wcode'];
$ord_today_no = $_POST['ord_no'];
$taiwan_year = date('Y') - 1911 ;
$taiwan_today = $taiwan_year.date('m').date('d');

if($_POST['ord_format'] == "normal"){
	
	if($row_order['p_product1'] == ""){$p_p1 = "商品一";}else{$p_p1 = $row_order['p_product1'];}
	if($row_order['p_product2'] == ""){$p_p2 = "商品二";}else{$p_p2 = $row_order['p_product2'];}
	if($row_order['p_product3'] == ""){$p_p3 = "商品三";}else{$p_p3 = $row_order['p_product3'];}
	if($row_order['p_product4'] == ""){$p_p4 = "商品四";}else{$p_p4 = $row_order['p_product4'];}
	if($row_order['p_product5'] == ""){$p_p5 = "商品五";}else{$p_p5 = $row_order['p_product5'];}
	
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
	
$tmp = excel_start(true).excel_header(array("訂單編號","收貨人姓名","郵遞區號","地址","電話","電子郵件",$p_p1,$p_p2,$p_p3,$p_p4,$p_p5,$p_pb1,$p_pb2,$p_pb3,$p_pb4,$p_pb5,$p_pb6,$p_pb7,$p_pb8,$p_pb9,$p_pb10,$p_pa1,$p_pa2,$p_pa3,$p_pa4,$p_pa5,$p_pa6,$p_pa7,$p_pa8,$p_pa9,$p_pa10,"付款總額","付款方式","統編","備註"),true);

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
							default:
							$_payway = "無";
							break;
						}
						
$_address = "(".$row_order['ord_ship_zip'].")".$row_order['ord_ship_county'].$row_order['ord_ship_city'].$row_order['ord_ship_address'].",";

$tmp .= excel_row(array($row_order['ord_code'],$row_order['ord_ship_name'],$row_order['ord_ship_zip'],$_address,$row_order['ord_ship_mobile'],$row_order['ord_ship_email'],$row_order['ord_p_num'],$row_order['ord_p_num2'],$row_order['ord_p_num3'],$row_order['ord_p_num4'],$row_order['ord_p_num5'],$row_order['ord_pb1_num'],$row_order['ord_pb2_num'],$row_order['ord_pb3_num'],$row_order['ord_pb4_num'],$row_order['ord_pb5_num'],$row_order['ord_pb6_num'],$row_order['ord_pb7_num'],$row_order['ord_pb8_num'],$row_order['ord_pb9_num'],$row_order['ord_pb10_num'],$row_order['ord_pa1_num'],$row_order['ord_pa2_num'],$row_order['ord_pa3_num'],$row_order['ord_pa4_num'],$row_order['ord_pa5_num'],$row_order['ord_pa6_num'],$row_order['ord_pa7_num'],$row_order['ord_pa8_num'],$row_order['ord_pa9_num'],$row_order['ord_pa10_num'],$row_order['ord_total_price'],$_payway,$row_order['ord_ship_fa_id'],$row_order['ord_memo']),true);

} while ($row_order = mysql_fetch_assoc($order)); 
} // Show if recordset not empty 

$tmp .=excel_end(true);
	
}elseif($_POST['ord_format'] == "myfresh"){
	
		
$tmp = excel_start(true).excel_header(array("訂單狀態","訂單日期","訂單編號","商品名稱","愛寵物商品ID","買新鮮商品ID","單價","數量","購買金額","運費","付款總額","收件人","配送地址","電話","出貨日期","物流代號","物流公司名稱","貨運單號"),true);

$_num = 0 ;
if ($totalRows_order > 0) { // Show if recordset not empty
do {

						
$_address = $row_order['ord_ship_zip'].$row_order['ord_ship_county'].$row_order['ord_ship_city'].$row_order['ord_ship_address'];

$tmp .= excel_row(array("",$row_order['ord_date'],$row_order['ord_code'],$row_order['p_product1'],$row_order['p_code'],"",$row_order['p_price2'],$row_order['ord_p_num'],$row_order['ord_buy_price'],$row_order['ord_ship_price'],$row_order['ord_total_price'],$row_order['ord_ship_name'],$_address,$row_order['ord_ship_mobile'],"","","",""),true);

} while ($row_order = mysql_fetch_assoc($order)); 
} // Show if recordset not empty 

$tmp .=excel_end(true);
	
}else{

$tmp = excel_start(true).excel_header(array("付款方式","廠商編號","檔案編號","訂單編號","貨品數序號","姓名","郵遞區號","地址","電話","商品代號","物品名稱","數量","單價","發票日期","買受人統一編號","買受人","銀行名稱","包裝方式","檔案製作日期","業務員代碼","其他費用","發票號碼","檢查號碼","稅額小計","未稅總額","含稅總金額","已審查否","不足數","可扣帳數","原始訂單編號","接單日期","備註","代收金額","隨附發票","事業單位","運輸方式"),true);

$_num = 0 ;
if ($totalRows_order > 0) { // Show if recordset not empty
do {
	
	$_exist1 = "N";$_exist2 = "N";$_exist3 = "N";$_exist4 = "N";$_exist5 = "N";
	$_exist1b = "N";$_exist2b = "N";$_exist3b = "N";$_exist4b = "N";$_exist5b = "N";
	
	$_product_num = $row_order['ord_p_num']+$row_order['ord_p_num2']+$row_order['ord_p_num3']+$row_order['ord_p_num4']+$row_order['ord_p_num5'];
	$_give_gift_num1 = 0;
	$_give_gift_num2 = 0;
	
	if($_POST['invoce'] == "Y"){
	$_single_price = $row_order['p_price2'];
	$_invoce_date = date('Y')."/".date('m')."/".date('d');
	$_with_invoce = "Y";
	}else{
	$_single_price = "";
	$_invoce_date = "";
	$_with_invoce = "";
	}
	
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
							default:
							$_payway = "無";
							break;
						}
	
	if($row_order['ord_p_num'] > 0){
	
	$_exist1 = "Y";
	
	$_num++;
	
	if($_num < 10){$_numx="000".$_num;}
elseif($_num < 100 && $_num >=10){$_numx="00".$_num;}
elseif($_num < 1000 && $_num >=100){$_numx="0".$_num;}
else{$_numx = $_num; }
	
	
	$_ser = $taiwan_today.$wcode.$ord_today_no;
	$_ser_no = $taiwan_today.$wcode.$ord_today_no.$_numx ;
	$_address = "(".$row_order['ord_ship_zip'].")".$row_order['ord_ship_county'].$row_order['ord_ship_city'].$row_order['ord_ship_address'].",";
	
	
	if($_POST['ord_status'] == 11 ){$_nowpay = $row_order['ord_total_price'];}elseif($_POST['ord_status'] != 11){$_nowpay = "";}else{$_nowpay = "0"; }
	
	$tmp .= excel_row(array($_payway,$fcode,$_ser,$_ser_no,"1",$row_order['ord_ship_name'],$row_order['ord_ship_zip'],$_address,$row_order['ord_ship_mobile'],$row_order['p_p1_code'],$row_order['p_product1'],$row_order['ord_p_num'],$_single_price,$_invoce_date,$row_order['ord_ship_fa_id'],"","","","","","","","","","","","","","",$row_order['ord_code'],"","",$_nowpay,$_with_invoce,"",$tcode),true);
	
	}
	
	if($row_order['p_product2'] <> "" && $row_order['ord_p_num2'] > 0){
	
	$_exist2 = "Y";
	
	$_num++;
	
	if($_num < 10){$_numx="000".$_num;}
elseif($_num < 100 && $_num >=10){$_numx="00".$_num;}
elseif($_num < 1000 && $_num >=100){$_numx="0".$_num;}
else{$_numx = $_num; }
	
	
	$_ser = $taiwan_today.$wcode.$ord_today_no;
	$_ser_no = $taiwan_today.$wcode.$ord_today_no.$_numx ;
	$_address = "(".$row_order['ord_ship_zip'].")".$row_order['ord_ship_county'].$row_order['ord_ship_city'].$row_order['ord_ship_address'].",";
	
	if($_POST['ord_status'] == 11 && $_exist1 != "Y"){$_nowpay = $row_order['ord_total_price'];}elseif($_POST['ord_status'] != 11){$_nowpay = "";}else{$_nowpay = "0"; }
	
	$tmp .= excel_row(array($_payway,$fcode,$_ser,$_ser_no,"1",$row_order['ord_ship_name'],$row_order['ord_ship_zip'],$_address,$row_order['ord_ship_mobile'],$row_order['p_p2_code'],$row_order['p_product2'],$row_order['ord_p_num2'],$_single_price,$_invoce_date,$row_order['ord_ship_fa_id'],"","","","","","","","","","","","","","",$row_order['ord_code'],"","",$_nowpay,$_with_invoce,"",$tcode),true);	
		
	}
	
	if($row_order['p_product3'] <> "" && $row_order['ord_p_num3'] > 0){
		
	$_exist3 = "Y";
	
	$_num++;
	
	if($_num < 10){$_numx="000".$_num;}
elseif($_num < 100 && $_num >=10){$_numx="00".$_num;}
elseif($_num < 1000 && $_num >=100){$_numx="0".$_num;}
else{$_numx = $_num; }
	
	
	$_ser = $taiwan_today.$wcode.$ord_today_no;
	$_ser_no = $taiwan_today.$wcode.$ord_today_no.$_numx ;
	$_address = "(".$row_order['ord_ship_zip'].")".$row_order['ord_ship_county'].$row_order['ord_ship_city'].$row_order['ord_ship_address'].",";
	
	if($_POST['ord_status'] == 11 && $_exist1 != "Y" && $_exist2 != "Y"){$_nowpay = $row_order['ord_total_price'];}elseif($_POST['ord_status'] != 11){$_nowpay = "";}else{$_nowpay = "0"; }
	
	$tmp .= excel_row(array($_payway,$fcode,$_ser,$_ser_no,"1",$row_order['ord_ship_name'],$row_order['ord_ship_zip'],$_address,$row_order['ord_ship_mobile'],$row_order['p_p3_code'],$row_order['p_product3'],$row_order['ord_p_num3'],$_single_price,$_invoce_date,$row_order['ord_ship_fa_id'],"","","","","","","","","","","","","","",$row_order['ord_code'],"","",$_nowpay,$_with_invoce,"",$tcode),true);	
	
	if($_POST['product'] == "19"){
	
	$_num++;
	
	if($_num < 10){$_numx="000".$_num;}
elseif($_num < 100 && $_num >=10){$_numx="00".$_num;}
elseif($_num < 1000 && $_num >=100){$_numx="0".$_num;}
else{$_numx = $_num; }
	
	
	$_ser = $taiwan_today.$wcode.$ord_today_no;
	$_ser_no = $taiwan_today.$wcode.$ord_today_no.$_numx ;	
		
	
	$tmp .= excel_row(array($_payway,$fcode,$_ser,$_ser_no,"1",$row_order['ord_ship_name'],$row_order['ord_ship_zip'],$_address,$row_order['ord_ship_mobile'],"輕纖試吃包","輕纖試吃包",$row_order['ord_p_num3']*6,"0",$_invoce_date,$row_order['ord_ship_fa_id'],"","","","","","","","","","","","","","",$row_order['ord_code'],"","",$_nowpay,$_with_invoce,"",$tcode),true);
			
	}
		
	}
	
	if($row_order['p_product4'] <> "" && $row_order['ord_p_num4'] > 0){
		
	$_exist4 = "Y";
	
	$_num++;
	
	if($_num < 10){$_numx="000".$_num;}
elseif($_num < 100 && $_num >=10){$_numx="00".$_num;}
elseif($_num < 1000 && $_num >=100){$_numx="0".$_num;}
else{$_numx = $_num; }
	
	
	$_ser = $taiwan_today.$wcode.$ord_today_no;
	$_ser_no = $taiwan_today.$wcode.$ord_today_no.$_numx ;
	$_address = "(".$row_order['ord_ship_zip'].")".$row_order['ord_ship_county'].$row_order['ord_ship_city'].$row_order['ord_ship_address'].",";
	
	if($_POST['ord_status'] == 11 && $_exist1 != "Y" && $_exist2 != "Y" && $_exist3 != "Y"){$_nowpay = $row_order['ord_total_price'];}elseif($_POST['ord_status'] != 11){$_nowpay = "";}else{$_nowpay = "0"; }
	
	$tmp .= excel_row(array($_payway,$fcode,$_ser,$_ser_no,"1",$row_order['ord_ship_name'],$row_order['ord_ship_zip'],$_address,$row_order['ord_ship_mobile'],$row_order['p_p4_code'],$row_order['p_product4'],$row_order['ord_p_num4'],$_single_price,$_invoce_date,$row_order['ord_ship_fa_id'],"","","","","","","","","","","","","","",$row_order['ord_code'],"","",$_nowpay,$_with_invoce,"",$tcode),true);	
		
	}
	
	if($row_order['p_product5'] <> "" && $row_order['ord_p_num5'] > 0){
		
	$_exist5 = "Y";
	
	$_num++;
	
	if($_num < 10){$_numx="000".$_num;}
elseif($_num < 100 && $_num >=10){$_numx="00".$_num;}
elseif($_num < 1000 && $_num >=100){$_numx="0".$_num;}
else{$_numx = $_num; }
	
	
	$_ser = $taiwan_today.$wcode.$ord_today_no;
	$_ser_no = $taiwan_today.$wcode.$ord_today_no.$_numx ;
	$_address = "(".$row_order['ord_ship_zip'].")".$row_order['ord_ship_county'].$row_order['ord_ship_city'].$row_order['ord_ship_address'].",";
	
	if($_POST['ord_status'] == 11 && $_exist1 != "Y" && $_exist2 != "Y" && $_exist3 != "Y" && $_exist4 != "Y"){$_nowpay = $row_order['ord_total_price'];}elseif($_POST['ord_status'] != 11){$_nowpay = "";}else{$_nowpay = "0"; }
	
	$tmp .= excel_row(array($_payway,$fcode,$_ser,$_ser_no,"1",$row_order['ord_ship_name'],$row_order['ord_ship_zip'],$_address,$row_order['ord_ship_mobile'],$row_order['p_p5_code'],$row_order['p_product5'],$row_order['ord_p_num5'],$_single_price,$_invoce_date,$row_order['ord_ship_fa_id'],"","","","","","","","","","","","","","",$row_order['ord_code'],"","",$_nowpay,$_with_invoce,"",$tcode),true);	
		
	}
	
	if($row_order['p_pb1'] <> "" && $row_order['ord_pb1_num'] > 0){
		
	$_exist1b = "Y";
	
	$_num++;
	
	if($_num < 10){$_numx="000".$_num;}
elseif($_num < 100 && $_num >=10){$_numx="00".$_num;}
elseif($_num < 1000 && $_num >=100){$_numx="0".$_num;}
else{$_numx = $_num; }
	
	
	$_ser = $taiwan_today.$wcode.$ord_today_no;
	$_ser_no = $taiwan_today.$wcode.$ord_today_no.$_numx ;
	$_address = "(".$row_order['ord_ship_zip'].")".$row_order['ord_ship_county'].$row_order['ord_ship_city'].$row_order['ord_ship_address'].",";
	
	if($_POST['ord_status'] == 11 && $_exist1 != "Y" && $_exist2 != "Y" && $_exist3 != "Y" && $_exist4 != "Y" && $_exist5 != "Y"){$_nowpay = $row_order['ord_total_price'];}elseif($_POST['ord_status'] != 11){$_nowpay = "";}else{$_nowpay = "0"; }
	
	$tmp .= excel_row(array($_payway,$fcode,$_ser,$_ser_no,"1",$row_order['ord_ship_name'],$row_order['ord_ship_zip'],$_address,$row_order['ord_ship_mobile'],"",$row_order['p_pb1'],$row_order['ord_pb1_num'],$row_order['p_pb1_price'],$_invoce_date,$row_order['ord_ship_fa_id'],"","","","","","","","","","","","","","",$row_order['ord_code'],"","",$_nowpay,$_with_invoce,"",$tcode),true);	
		
	}
	
	if($row_order['p_pb2'] <> "" && $row_order['ord_pb2_num'] > 0){
		
	$_exist2b = "Y";
	
	$_num++;
	
	if($_num < 10){$_numx="000".$_num;}
elseif($_num < 100 && $_num >=10){$_numx="00".$_num;}
elseif($_num < 1000 && $_num >=100){$_numx="0".$_num;}
else{$_numx = $_num; }
	
	
	$_ser = $taiwan_today.$wcode.$ord_today_no;
	$_ser_no = $taiwan_today.$wcode.$ord_today_no.$_numx ;
	$_address = "(".$row_order['ord_ship_zip'].")".$row_order['ord_ship_county'].$row_order['ord_ship_city'].$row_order['ord_ship_address'].",";
	
	if($_POST['ord_status'] == 11 && $_exist1 != "Y" && $_exist2 != "Y" && $_exist3 != "Y" && $_exist4 != "Y" && $_exist5 != "Y" && $_exist1b != "Y"){$_nowpay = $row_order['ord_total_price'];}elseif($_POST['ord_status'] != 11){$_nowpay = "";}else{$_nowpay = "0"; }
	
	$tmp .= excel_row(array($_payway,$fcode,$_ser,$_ser_no,"1",$row_order['ord_ship_name'],$row_order['ord_ship_zip'],$_address,$row_order['ord_ship_mobile'],"",$row_order['p_pb2'],$row_order['ord_pb2_num'],$row_order['p_pb2_price'],$_invoce_date,$row_order['ord_ship_fa_id'],"","","","","","","","","","","","","","",$row_order['ord_code'],"","",$_nowpay,$_with_invoce,"",$tcode),true);	
		
	}
	
	if($row_order['p_pb3'] <> "" && $row_order['ord_pb3_num'] > 0){
		
	$_exist3b = "Y";
	
	$_num++;
	
	if($_num < 10){$_numx="000".$_num;}
elseif($_num < 100 && $_num >=10){$_numx="00".$_num;}
elseif($_num < 1000 && $_num >=100){$_numx="0".$_num;}
else{$_numx = $_num; }
	
	
	$_ser = $taiwan_today.$wcode.$ord_today_no;
	$_ser_no = $taiwan_today.$wcode.$ord_today_no.$_numx ;
	$_address = "(".$row_order['ord_ship_zip'].")".$row_order['ord_ship_county'].$row_order['ord_ship_city'].$row_order['ord_ship_address'].",";
	
	if($_POST['ord_status'] == 11 && $_exist1 != "Y" && $_exist2 != "Y" && $_exist3 != "Y" && $_exist4 != "Y" && $_exist5 != "Y" && $_exist1b != "Y" && $_exist2b != "Y"){$_nowpay = $row_order['ord_total_price'];}elseif($_POST['ord_status'] != 11){$_nowpay = "";}else{$_nowpay = "0"; }
	
	$tmp .= excel_row(array($_payway,$fcode,$_ser,$_ser_no,"1",$row_order['ord_ship_name'],$row_order['ord_ship_zip'],$_address,$row_order['ord_ship_mobile'],"",$row_order['p_pb3'],$row_order['ord_pb3_num'],$row_order['p_pb3_price'],$_invoce_date,$row_order['ord_ship_fa_id'],"","","","","","","","","","","","","","",$row_order['ord_code'],"","",$_nowpay,$_with_invoce,"",$tcode),true);	
		
	}
	
	if($row_order['p_pb4'] <> "" && $row_order['ord_pb4_num'] > 0){
		
	$_exist4b = "Y";
	
	$_num++;
	
	if($_num < 10){$_numx="000".$_num;}
elseif($_num < 100 && $_num >=10){$_numx="00".$_num;}
elseif($_num < 1000 && $_num >=100){$_numx="0".$_num;}
else{$_numx = $_num; }
	
	
	$_ser = $taiwan_today.$wcode.$ord_today_no;
	$_ser_no = $taiwan_today.$wcode.$ord_today_no.$_numx ;
	$_address = "(".$row_order['ord_ship_zip'].")".$row_order['ord_ship_county'].$row_order['ord_ship_city'].$row_order['ord_ship_address'].",";
	
	if($_POST['ord_status'] == 11 && $_exist1 != "Y" && $_exist2 != "Y" && $_exist3 != "Y" && $_exist4 != "Y" && $_exist5 != "Y" && $_exist1b != "Y" && $_exist2b != "Y" && $_exist3b != "Y"){$_nowpay = $row_order['ord_total_price'];}elseif($_POST['ord_status'] != 11){$_nowpay = "";}else{$_nowpay = "0"; }
	
	$tmp .= excel_row(array($_payway,$fcode,$_ser,$_ser_no,"1",$row_order['ord_ship_name'],$row_order['ord_ship_zip'],$_address,$row_order['ord_ship_mobile'],"",$row_order['p_pb4'],$row_order['ord_pb4_num'],$row_order['p_pb4_price'],$_invoce_date,$row_order['ord_ship_fa_id'],"","","","","","","","","","","","","","",$row_order['ord_code'],"","",$_nowpay,$_with_invoce,"",$tcode),true);	
		
	}
	
	if($row_order['p_pb5'] <> "" && $row_order['ord_pb5_num'] > 0){
		
	$_exist5b = "Y";
	
	$_num++;
	
	if($_num < 10){$_numx="000".$_num;}
elseif($_num < 100 && $_num >=10){$_numx="00".$_num;}
elseif($_num < 1000 && $_num >=100){$_numx="0".$_num;}
else{$_numx = $_num; }
	
	
	$_ser = $taiwan_today.$wcode.$ord_today_no;
	$_ser_no = $taiwan_today.$wcode.$ord_today_no.$_numx ;
	$_address = "(".$row_order['ord_ship_zip'].")".$row_order['ord_ship_county'].$row_order['ord_ship_city'].$row_order['ord_ship_address'].",";
	
	if($_POST['ord_status'] == 11 && $_exist1 != "Y" && $_exist2 != "Y" && $_exist3 != "Y" && $_exist4 != "Y" && $_exist5 != "Y" && $_exist1b != "Y" && $_exist2b != "Y" && $_exist3b != "Y" && $_exist4b != "Y"){$_nowpay = $row_order['ord_total_price'];}elseif($_POST['ord_status'] != 11){$_nowpay = "";}else{$_nowpay = "0"; }
	
	$tmp .= excel_row(array($_payway,$fcode,$_ser,$_ser_no,"1",$row_order['ord_ship_name'],$row_order['ord_ship_zip'],$_address,$row_order['ord_ship_mobile'],"",$row_order['p_pb5'],$row_order['ord_pb5_num'],$row_order['p_pb5_price'],$_invoce_date,$row_order['ord_ship_fa_id'],"","","","","","","","","","","","","","",$row_order['ord_code'],"","",$_nowpay,$_with_invoce,"",$tcode),true);	
		
	}
	
	if($row_order['p_pb6'] <> "" && $row_order['ord_pb6_num'] > 0){
		
	$_exist6b = "Y";
	
	$_num++;
	
	if($_num < 10){$_numx="000".$_num;}
elseif($_num < 100 && $_num >=10){$_numx="00".$_num;}
elseif($_num < 1000 && $_num >=100){$_numx="0".$_num;}
else{$_numx = $_num; }
	
	
	$_ser = $taiwan_today.$wcode.$ord_today_no;
	$_ser_no = $taiwan_today.$wcode.$ord_today_no.$_numx ;
	$_address = "(".$row_order['ord_ship_zip'].")".$row_order['ord_ship_county'].$row_order['ord_ship_city'].$row_order['ord_ship_address'].",";
	
	if($_POST['ord_status'] == 11 && $_exist1 != "Y" && $_exist2 != "Y" && $_exist3 != "Y" && $_exist4 != "Y" && $_exist5 != "Y" && $_exist1b != "Y" && $_exist2b != "Y" && $_exist3b != "Y" && $_exist4b != "Y" && $_exist5b != "Y"){$_nowpay = $row_order['ord_total_price'];}elseif($_POST['ord_status'] != 11){$_nowpay = "";}else{$_nowpay = "0"; }
	
	$tmp .= excel_row(array($_payway,$fcode,$_ser,$_ser_no,"1",$row_order['ord_ship_name'],$row_order['ord_ship_zip'],$_address,$row_order['ord_ship_mobile'],"",$row_order['p_pb6'],$row_order['ord_pb6_num'],$row_order['p_pb6_price'],$_invoce_date,$row_order['ord_ship_fa_id'],"","","","","","","","","","","","","","",$row_order['ord_code'],"","",$_nowpay,$_with_invoce,"",$tcode),true);	
		
	}
	
	if($row_order['p_pb7'] <> "" && $row_order['ord_pb7_num'] > 0){
		
	$_exist7b = "Y";
	
	$_num++;
	
	if($_num < 10){$_numx="000".$_num;}
elseif($_num < 100 && $_num >=10){$_numx="00".$_num;}
elseif($_num < 1000 && $_num >=100){$_numx="0".$_num;}
else{$_numx = $_num; }
	
	
	$_ser = $taiwan_today.$wcode.$ord_today_no;
	$_ser_no = $taiwan_today.$wcode.$ord_today_no.$_numx ;
	$_address = "(".$row_order['ord_ship_zip'].")".$row_order['ord_ship_county'].$row_order['ord_ship_city'].$row_order['ord_ship_address'].",";
	
	if($_POST['ord_status'] == 11 && $_exist1 != "Y" && $_exist2 != "Y" && $_exist3 != "Y" && $_exist4 != "Y" && $_exist5 != "Y" && $_exist1b != "Y" && $_exist2b != "Y" && $_exist3b != "Y" && $_exist4b != "Y" && $_exist5b != "Y" && $_exist6b != "Y"){$_nowpay = $row_order['ord_total_price'];}elseif($_POST['ord_status'] != 11){$_nowpay = "";}else{$_nowpay = "0"; }
	
	$tmp .= excel_row(array($_payway,$fcode,$_ser,$_ser_no,"1",$row_order['ord_ship_name'],$row_order['ord_ship_zip'],$_address,$row_order['ord_ship_mobile'],"",$row_order['p_pb7'],$row_order['ord_pb7_num'],$row_order['p_pb7_price'],$_invoce_date,$row_order['ord_ship_fa_id'],"","","","","","","","","","","","","","",$row_order['ord_code'],"","",$_nowpay,$_with_invoce,"",$tcode),true);	
		
	}
	
	if($row_order['p_pb8'] <> "" && $row_order['ord_pb8_num'] > 0){
		
	$_exist8b = "Y";
	
	$_num++;
	
	if($_num < 10){$_numx="000".$_num;}
elseif($_num < 100 && $_num >=10){$_numx="00".$_num;}
elseif($_num < 1000 && $_num >=100){$_numx="0".$_num;}
else{$_numx = $_num; }
	
	
	$_ser = $taiwan_today.$wcode.$ord_today_no;
	$_ser_no = $taiwan_today.$wcode.$ord_today_no.$_numx ;
	$_address = "(".$row_order['ord_ship_zip'].")".$row_order['ord_ship_county'].$row_order['ord_ship_city'].$row_order['ord_ship_address'].",";
	
	if($_POST['ord_status'] == 11 && $_exist1 != "Y" && $_exist2 != "Y" && $_exist3 != "Y" && $_exist4 != "Y" && $_exist5 != "Y" && $_exist1b != "Y" && $_exist2b != "Y" && $_exist3b != "Y" && $_exist4b != "Y" && $_exist5b != "Y" && $_exist6b != "Y" && $_exist7b != "Y"){$_nowpay = $row_order['ord_total_price'];}elseif($_POST['ord_status'] != 11){$_nowpay = "";}else{$_nowpay = "0"; }
	
	$tmp .= excel_row(array($_payway,$fcode,$_ser,$_ser_no,"1",$row_order['ord_ship_name'],$row_order['ord_ship_zip'],$_address,$row_order['ord_ship_mobile'],"",$row_order['p_pb8'],$row_order['ord_pb8_num'],$row_order['p_pb8_price'],$_invoce_date,$row_order['ord_ship_fa_id'],"","","","","","","","","","","","","","",$row_order['ord_code'],"","",$_nowpay,$_with_invoce,"",$tcode),true);	
		
	}
	
	if($row_order['p_pb9'] <> "" && $row_order['ord_pb9_num'] > 0){
		
	$_exist9b = "Y";
	
	$_num++;
	
	if($_num < 10){$_numx="000".$_num;}
elseif($_num < 100 && $_num >=10){$_numx="00".$_num;}
elseif($_num < 1000 && $_num >=100){$_numx="0".$_num;}
else{$_numx = $_num; }
	
	
	$_ser = $taiwan_today.$wcode.$ord_today_no;
	$_ser_no = $taiwan_today.$wcode.$ord_today_no.$_numx ;
	$_address = "(".$row_order['ord_ship_zip'].")".$row_order['ord_ship_county'].$row_order['ord_ship_city'].$row_order['ord_ship_address'].",";
	
	if($_POST['ord_status'] == 11 && $_exist1 != "Y" && $_exist2 != "Y" && $_exist3 != "Y" && $_exist4 != "Y" && $_exist5 != "Y" && $_exist1b != "Y" && $_exist2b != "Y" && $_exist3b != "Y" && $_exist4b != "Y" && $_exist5b != "Y" && $_exist6b != "Y" && $_exist7b != "Y" && $_exist8b != "Y"){$_nowpay = $row_order['ord_total_price'];}elseif($_POST['ord_status'] != 11){$_nowpay = "";}else{$_nowpay = "0"; }
	
	$tmp .= excel_row(array($_payway,$fcode,$_ser,$_ser_no,"1",$row_order['ord_ship_name'],$row_order['ord_ship_zip'],$_address,$row_order['ord_ship_mobile'],"",$row_order['p_pb9'],$row_order['ord_pb9_num'],$row_order['p_pb9_price'],$_invoce_date,$row_order['ord_ship_fa_id'],"","","","","","","","","","","","","","",$row_order['ord_code'],"","",$_nowpay,$_with_invoce,"",$tcode),true);	
		
	}
	
	if($row_order['p_pb10'] <> "" && $row_order['ord_pb10_num'] > 0){
		
	$_exist10b = "Y";
	
	$_num++;
	
	if($_num < 10){$_numx="000".$_num;}
elseif($_num < 100 && $_num >=10){$_numx="00".$_num;}
elseif($_num < 1000 && $_num >=100){$_numx="0".$_num;}
else{$_numx = $_num; }
	
	
	$_ser = $taiwan_today.$wcode.$ord_today_no;
	$_ser_no = $taiwan_today.$wcode.$ord_today_no.$_numx ;
	$_address = "(".$row_order['ord_ship_zip'].")".$row_order['ord_ship_county'].$row_order['ord_ship_city'].$row_order['ord_ship_address'].",";
	
	if($_POST['ord_status'] == 11 && $_exist1 != "Y" && $_exist2 != "Y" && $_exist3 != "Y" && $_exist4 != "Y" && $_exist5 != "Y" && $_exist1b != "Y" && $_exist2b != "Y" && $_exist3b != "Y" && $_exist4b != "Y" && $_exist5b != "Y" && $_exist6b != "Y" && $_exist7b != "Y" && $_exist8b != "Y" && $_exist9b != "Y"){$_nowpay = $row_order['ord_total_price'];}elseif($_POST['ord_status'] != 11){$_nowpay = "";}else{$_nowpay = "0"; }
	
	$tmp .= excel_row(array($_payway,$fcode,$_ser,$_ser_no,"1",$row_order['ord_ship_name'],$row_order['ord_ship_zip'],$_address,$row_order['ord_ship_mobile'],"",$row_order['p_pb10'],$row_order['ord_pb10_num'],$row_order['p_pb10_price'],$_invoce_date,$row_order['ord_ship_fa_id'],"","","","","","","","","","","","","","",$row_order['ord_code'],"","",$_nowpay,$_with_invoce,"",$tcode),true);	
		
	}
	
	if($row_order['p_pa1'] <> "" && $row_order['ord_pa1_num'] > 0){
		
	$_exist1a = "Y";
	
	$_num++;
	
	if($_num < 10){$_numx="000".$_num;}
elseif($_num < 100 && $_num >=10){$_numx="00".$_num;}
elseif($_num < 1000 && $_num >=100){$_numx="0".$_num;}
else{$_numx = $_num; }
	
	
	$_ser = $taiwan_today.$wcode.$ord_today_no;
	$_ser_no = $taiwan_today.$wcode.$ord_today_no.$_numx ;
	$_address = "(".$row_order['ord_ship_zip'].")".$row_order['ord_ship_county'].$row_order['ord_ship_city'].$row_order['ord_ship_address'].",";
	
	if($_POST['ord_status'] == 11 && $_exist1 != "Y" && $_exist2 != "Y" && $_exist3 != "Y" && $_exist4 != "Y" && $_exist5 != "Y" && $_exist1b != "Y" && $_exist2b != "Y" && $_exist3b != "Y" && $_exist4b != "Y" && $_exist5b != "Y" && $_exist6b != "Y" && $_exist7b != "Y" && $_exist8b != "Y" && $_exist9b != "Y" && $_exist10b != "Y"){$_nowpay = $row_order['ord_total_price'];}elseif($_POST['ord_status'] != 11){$_nowpay = "";}else{$_nowpay = "0"; }
	
	$tmp .= excel_row(array($_payway,$fcode,$_ser,$_ser_no,"1",$row_order['ord_ship_name'],$row_order['ord_ship_zip'],$_address,$row_order['ord_ship_mobile'],"",$row_order['p_pa1'],$row_order['ord_pa1_num'],"0",$_invoce_date,$row_order['ord_ship_fa_id'],"","","","","","","","","","","","","","",$row_order['ord_code'],"","",$_nowpay,$_with_invoce,"",$tcode),true);	
		
	}
	
	if($row_order['p_pa2'] <> "" && $row_order['ord_pa2_num'] > 0){
		
	$_exist2a = "Y";
	
	$_num++;
	
	if($_num < 10){$_numx="000".$_num;}
elseif($_num < 100 && $_num >=10){$_numx="00".$_num;}
elseif($_num < 1000 && $_num >=100){$_numx="0".$_num;}
else{$_numx = $_num; }
	
	
	$_ser = $taiwan_today.$wcode.$ord_today_no;
	$_ser_no = $taiwan_today.$wcode.$ord_today_no.$_numx ;
	$_address = "(".$row_order['ord_ship_zip'].")".$row_order['ord_ship_county'].$row_order['ord_ship_city'].$row_order['ord_ship_address'].",";
	
	if($_POST['ord_status'] == 11 && $_exist1 != "Y" && $_exist2 != "Y" && $_exist3 != "Y" && $_exist4 != "Y" && $_exist5 != "Y" && $_exist1b != "Y" && $_exist2b != "Y" && $_exist3b != "Y" && $_exist4b != "Y" && $_exist5b != "Y" && $_exist6b != "Y" && $_exist7b != "Y" && $_exist8b != "Y" && $_exist9b != "Y" && $_exist10b != "Y" && $_exist1a != "Y"){$_nowpay = $row_order['ord_total_price'];}elseif($_POST['ord_status'] != 11){$_nowpay = "";}else{$_nowpay = "0"; }
	
	$tmp .= excel_row(array($_payway,$fcode,$_ser,$_ser_no,"1",$row_order['ord_ship_name'],$row_order['ord_ship_zip'],$_address,$row_order['ord_ship_mobile'],"",$row_order['p_pa2'],$row_order['ord_pa2_num'],"0",$_invoce_date,$row_order['ord_ship_fa_id'],"","","","","","","","","","","","","","",$row_order['ord_code'],"","",$_nowpay,$_with_invoce,"",$tcode),true);	
		
	}
	
	if($row_order['p_pa3'] <> "" && $row_order['ord_pa3_num'] > 0){
		
	$_exist3a = "Y";
	
	$_num++;
	
	if($_num < 10){$_numx="000".$_num;}
elseif($_num < 100 && $_num >=10){$_numx="00".$_num;}
elseif($_num < 1000 && $_num >=100){$_numx="0".$_num;}
else{$_numx = $_num; }
	
	
	$_ser = $taiwan_today.$wcode.$ord_today_no;
	$_ser_no = $taiwan_today.$wcode.$ord_today_no.$_numx ;
	$_address = "(".$row_order['ord_ship_zip'].")".$row_order['ord_ship_county'].$row_order['ord_ship_city'].$row_order['ord_ship_address'].",";
	
	if($_POST['ord_status'] == 11 && $_exist1 != "Y" && $_exist2 != "Y" && $_exist3 != "Y" && $_exist4 != "Y" && $_exist5 != "Y" && $_exist1b != "Y" && $_exist2b != "Y" && $_exist3b != "Y" && $_exist4b != "Y" && $_exist5b != "Y" && $_exist6b != "Y" && $_exist7b != "Y" && $_exist8b != "Y" && $_exist9b != "Y" && $_exist10b != "Y" && $_exist1a != "Y" && $_exist2a != "Y"){$_nowpay = $row_order['ord_total_price'];}elseif($_POST['ord_status'] != 11){$_nowpay = "";}else{$_nowpay = "0"; }
	
	$tmp .= excel_row(array($_payway,$fcode,$_ser,$_ser_no,"1",$row_order['ord_ship_name'],$row_order['ord_ship_zip'],$_address,$row_order['ord_ship_mobile'],"",$row_order['p_pa3'],$row_order['ord_pa3_num'],"0",$_invoce_date,$row_order['ord_ship_fa_id'],"","","","","","","","","","","","","","",$row_order['ord_code'],"","",$_nowpay,$_with_invoce,"",$tcode),true);	
		
	}
	
	
	if($row_order['p_pa4'] <> "" && $row_order['ord_pa4_num'] > 0){
		
	$_exist4a = "Y";
	
	$_num++;
	
	if($_num < 10){$_numx="000".$_num;}
elseif($_num < 100 && $_num >=10){$_numx="00".$_num;}
elseif($_num < 1000 && $_num >=100){$_numx="0".$_num;}
else{$_numx = $_num; }
	
	
	$_ser = $taiwan_today.$wcode.$ord_today_no;
	$_ser_no = $taiwan_today.$wcode.$ord_today_no.$_numx ;
	$_address = "(".$row_order['ord_ship_zip'].")".$row_order['ord_ship_county'].$row_order['ord_ship_city'].$row_order['ord_ship_address'].",";
	
	if($_POST['ord_status'] == 11 && $_exist1 != "Y" && $_exist2 != "Y" && $_exist3 != "Y" && $_exist4 != "Y" && $_exist5 != "Y" && $_exist1b != "Y" && $_exist2b != "Y" && $_exist3b != "Y" && $_exist4b != "Y" && $_exist5b != "Y" && $_exist6b != "Y" && $_exist7b != "Y" && $_exist8b != "Y" && $_exist9b != "Y" && $_exist10b != "Y" && $_exist1a != "Y" && $_exist2a != "Y" && $_exist3a != "Y"){$_nowpay = $row_order['ord_total_price'];}elseif($_POST['ord_status'] != 11){$_nowpay = "";}else{$_nowpay = "0"; }
	
	$tmp .= excel_row(array($_payway,$fcode,$_ser,$_ser_no,"1",$row_order['ord_ship_name'],$row_order['ord_ship_zip'],$_address,$row_order['ord_ship_mobile'],"",$row_order['p_pa4'],$row_order['ord_pa4_num'],"0",$_invoce_date,$row_order['ord_ship_fa_id'],"","","","","","","","","","","","","","",$row_order['ord_code'],"","",$_nowpay,$_with_invoce,"",$tcode),true);	
		
	}
	
	
	if($row_order['p_pa5'] <> "" && $row_order['ord_pa5_num'] > 0){
		
	$_exist5a = "Y";
	
	$_num++;
	
	if($_num < 10){$_numx="000".$_num;}
elseif($_num < 100 && $_num >=10){$_numx="00".$_num;}
elseif($_num < 1000 && $_num >=100){$_numx="0".$_num;}
else{$_numx = $_num; }
	
	
	$_ser = $taiwan_today.$wcode.$ord_today_no;
	$_ser_no = $taiwan_today.$wcode.$ord_today_no.$_numx ;
	$_address = "(".$row_order['ord_ship_zip'].")".$row_order['ord_ship_county'].$row_order['ord_ship_city'].$row_order['ord_ship_address'].",";
	
	if($_POST['ord_status'] == 11 && $_exist1 != "Y" && $_exist2 != "Y" && $_exist3 != "Y" && $_exist4 != "Y" && $_exist5 != "Y" && $_exist1b != "Y" && $_exist2b != "Y" && $_exist3b != "Y" && $_exist4b != "Y" && $_exist5b != "Y" && $_exist6b != "Y" && $_exist7b != "Y" && $_exist8b != "Y" && $_exist9b != "Y" && $_exist10b != "Y" && $_exist1a != "Y" && $_exist2a != "Y" && $_exist3a != "Y" && $_exist4a != "Y"){$_nowpay = $row_order['ord_total_price'];}elseif($_POST['ord_status'] != 11){$_nowpay = "";}else{$_nowpay = "0"; }
	
	$tmp .= excel_row(array($_payway,$fcode,$_ser,$_ser_no,"1",$row_order['ord_ship_name'],$row_order['ord_ship_zip'],$_address,$row_order['ord_ship_mobile'],"",$row_order['p_pa5'],$row_order['ord_pa5_num'],"0",$_invoce_date,$row_order['ord_ship_fa_id'],"","","","","","","","","","","","","","",$row_order['ord_code'],"","",$_nowpay,$_with_invoce,"",$tcode),true);	
		
	}
	
	if($row_order['p_pa6'] <> "" && $row_order['ord_pa6_num'] > 0){
		
	$_exist6a = "Y";
	
	$_num++;
	
	if($_num < 10){$_numx="000".$_num;}
elseif($_num < 100 && $_num >=10){$_numx="00".$_num;}
elseif($_num < 1000 && $_num >=100){$_numx="0".$_num;}
else{$_numx = $_num; }
	
	
	$_ser = $taiwan_today.$wcode.$ord_today_no;
	$_ser_no = $taiwan_today.$wcode.$ord_today_no.$_numx ;
	$_address = "(".$row_order['ord_ship_zip'].")".$row_order['ord_ship_county'].$row_order['ord_ship_city'].$row_order['ord_ship_address'].",";
	
	if($_POST['ord_status'] == 11 && $_exist1 != "Y" && $_exist2 != "Y" && $_exist3 != "Y" && $_exist4 != "Y" && $_exist5 != "Y" && $_exist1b != "Y" && $_exist2b != "Y" && $_exist3b != "Y" && $_exist4b != "Y" && $_exist5b != "Y" && $_exist6b != "Y" && $_exist7b != "Y" && $_exist8b != "Y" && $_exist9b != "Y" && $_exist10b != "Y" && $_exist1a != "Y" && $_exist2a != "Y" && $_exist3a != "Y" && $_exist4a != "Y" && $_exist5a != "Y"){$_nowpay = $row_order['ord_total_price'];}elseif($_POST['ord_status'] != 11){$_nowpay = "";}else{$_nowpay = "0"; }
	
	$tmp .= excel_row(array($_payway,$fcode,$_ser,$_ser_no,"1",$row_order['ord_ship_name'],$row_order['ord_ship_zip'],$_address,$row_order['ord_ship_mobile'],"",$row_order['p_pa6'],$row_order['ord_pa6_num'],"0",$_invoce_date,$row_order['ord_ship_fa_id'],"","","","","","","","","","","","","","",$row_order['ord_code'],"","",$_nowpay,$_with_invoce,"",$tcode),true);	
		
	}
	
	if($row_order['p_pa7'] <> "" && $row_order['ord_pa7_num'] > 0){
		
	$_exist6a = "Y";
	
	$_num++;
	
	if($_num < 10){$_numx="000".$_num;}
elseif($_num < 100 && $_num >=10){$_numx="00".$_num;}
elseif($_num < 1000 && $_num >=100){$_numx="0".$_num;}
else{$_numx = $_num; }
	
	
	$_ser = $taiwan_today.$wcode.$ord_today_no;
	$_ser_no = $taiwan_today.$wcode.$ord_today_no.$_numx ;
	$_address = "(".$row_order['ord_ship_zip'].")".$row_order['ord_ship_county'].$row_order['ord_ship_city'].$row_order['ord_ship_address'].",";
	
	if($_POST['ord_status'] == 11 && $_exist1 != "Y" && $_exist2 != "Y" && $_exist3 != "Y" && $_exist4 != "Y" && $_exist5 != "Y" && $_exist1b != "Y" && $_exist2b != "Y" && $_exist3b != "Y" && $_exist4b != "Y" && $_exist5b != "Y" && $_exist6b != "Y" && $_exist7b != "Y" && $_exist8b != "Y" && $_exist9b != "Y" && $_exist10b != "Y" && $_exist1a != "Y" && $_exist2a != "Y" && $_exist3a != "Y" && $_exist4a != "Y" && $_exist5a != "Y" && $_exist6a != "Y"){$_nowpay = $row_order['ord_total_price'];}elseif($_POST['ord_status'] != 11){$_nowpay = "";}else{$_nowpay = "0"; }
	
	$tmp .= excel_row(array($_payway,$fcode,$_ser,$_ser_no,"1",$row_order['ord_ship_name'],$row_order['ord_ship_zip'],$_address,$row_order['ord_ship_mobile'],"",$row_order['p_pa7'],$row_order['ord_pa7_num'],"0",$_invoce_date,$row_order['ord_ship_fa_id'],"","","","","","","","","","","","","","",$row_order['ord_code'],"","",$_nowpay,$_with_invoce,"",$tcode),true);	
		
	}
	
	if($row_order['p_pa8'] <> "" && $row_order['ord_pa8_num'] > 0){
		
	$_exist8a = "Y";
	
	$_num++;
	
	if($_num < 10){$_numx="000".$_num;}
elseif($_num < 100 && $_num >=10){$_numx="00".$_num;}
elseif($_num < 1000 && $_num >=100){$_numx="0".$_num;}
else{$_numx = $_num; }
	
	
	$_ser = $taiwan_today.$wcode.$ord_today_no;
	$_ser_no = $taiwan_today.$wcode.$ord_today_no.$_numx ;
	$_address = "(".$row_order['ord_ship_zip'].")".$row_order['ord_ship_county'].$row_order['ord_ship_city'].$row_order['ord_ship_address'].",";
	
	if($_POST['ord_status'] == 11 && $_exist1 != "Y" && $_exist2 != "Y" && $_exist3 != "Y" && $_exist4 != "Y" && $_exist5 != "Y" && $_exist1b != "Y" && $_exist2b != "Y" && $_exist3b != "Y" && $_exist4b != "Y" && $_exist5b != "Y" && $_exist6b != "Y" && $_exist7b != "Y" && $_exist8b != "Y" && $_exist9b != "Y" && $_exist10b != "Y" && $_exist1a != "Y" && $_exist2a != "Y" && $_exist3a != "Y" && $_exist4a != "Y" && $_exist5a != "Y" && $_exist6a != "Y" && $_exist7a != "Y"){$_nowpay = $row_order['ord_total_price'];}elseif($_POST['ord_status'] != 11){$_nowpay = "";}else{$_nowpay = "0"; }
	
	$tmp .= excel_row(array($_payway,$fcode,$_ser,$_ser_no,"1",$row_order['ord_ship_name'],$row_order['ord_ship_zip'],$_address,$row_order['ord_ship_mobile'],"",$row_order['p_pa8'],$row_order['ord_pa8_num'],"0",$_invoce_date,$row_order['ord_ship_fa_id'],"","","","","","","","","","","","","","",$row_order['ord_code'],"","",$_nowpay,$_with_invoce,"",$tcode),true);	
		
	}
	
	if($row_order['p_pa9'] <> "" && $row_order['ord_pa9_num'] > 0){
		
	$_exist9a = "Y";
	
	$_num++;
	
	if($_num < 10){$_numx="000".$_num;}
elseif($_num < 100 && $_num >=10){$_numx="00".$_num;}
elseif($_num < 1000 && $_num >=100){$_numx="0".$_num;}
else{$_numx = $_num; }
	
	
	$_ser = $taiwan_today.$wcode.$ord_today_no;
	$_ser_no = $taiwan_today.$wcode.$ord_today_no.$_numx ;
	$_address = "(".$row_order['ord_ship_zip'].")".$row_order['ord_ship_county'].$row_order['ord_ship_city'].$row_order['ord_ship_address'].",";
	
	if($_POST['ord_status'] == 11 && $_exist1 != "Y" && $_exist2 != "Y" && $_exist3 != "Y" && $_exist4 != "Y" && $_exist5 != "Y" && $_exist1b != "Y" && $_exist2b != "Y" && $_exist3b != "Y" && $_exist4b != "Y" && $_exist5b != "Y" && $_exist6b != "Y" && $_exist7b != "Y" && $_exist8b != "Y" && $_exist9b != "Y" && $_exist10b != "Y" && $_exist1a != "Y" && $_exist2a != "Y" && $_exist3a != "Y" && $_exist4a != "Y" && $_exist5a != "Y" && $_exist6a != "Y" && $_exist7a != "Y" && $_exist8a != "Y"){$_nowpay = $row_order['ord_total_price'];}elseif($_POST['ord_status'] != 11){$_nowpay = "";}else{$_nowpay = "0"; }
	
	$tmp .= excel_row(array($_payway,$fcode,$_ser,$_ser_no,"1",$row_order['ord_ship_name'],$row_order['ord_ship_zip'],$_address,$row_order['ord_ship_mobile'],"",$row_order['p_pa9'],$row_order['ord_pa9_num'],"0",$_invoce_date,$row_order['ord_ship_fa_id'],"","","","","","","","","","","","","","",$row_order['ord_code'],"","",$_nowpay,$_with_invoce,"",$tcode),true);	
		
	}
	
	if($row_order['p_pa10'] <> "" && $row_order['ord_pa10_num'] > 0){
		
	$_exist10a = "Y";
	
	$_num++;
	
	if($_num < 10){$_numx="000".$_num;}
elseif($_num < 100 && $_num >=10){$_numx="00".$_num;}
elseif($_num < 1000 && $_num >=100){$_numx="0".$_num;}
else{$_numx = $_num; }
	
	
	$_ser = $taiwan_today.$wcode.$ord_today_no;
	$_ser_no = $taiwan_today.$wcode.$ord_today_no.$_numx ;
	$_address = "(".$row_order['ord_ship_zip'].")".$row_order['ord_ship_county'].$row_order['ord_ship_city'].$row_order['ord_ship_address'].",";
	
	if($_POST['ord_status'] == 11 && $_exist1 != "Y" && $_exist2 != "Y" && $_exist3 != "Y" && $_exist4 != "Y" && $_exist5 != "Y" && $_exist1b != "Y" && $_exist2b != "Y" && $_exist3b != "Y" && $_exist4b != "Y" && $_exist5b != "Y" && $_exist6b != "Y" && $_exist7b != "Y" && $_exist8b != "Y" && $_exist9b != "Y" && $_exist10b != "Y" && $_exist1a != "Y" && $_exist2a != "Y" && $_exist3a != "Y" && $_exist4a != "Y" && $_exist5a != "Y" && $_exist6a != "Y" && $_exist7a != "Y" && $_exist8a != "Y" && $_exist9a != "Y"){$_nowpay = $row_order['ord_total_price'];}elseif($_POST['ord_status'] != 11){$_nowpay = "";}else{$_nowpay = "0"; }
	
	$tmp .= excel_row(array($_payway,$fcode,$_ser,$_ser_no,"1",$row_order['ord_ship_name'],$row_order['ord_ship_zip'],$_address,$row_order['ord_ship_mobile'],"",$row_order['p_pa10'],$row_order['ord_pa10_num'],"0",$_invoce_date,$row_order['ord_ship_fa_id'],"","","","","","","","","","","","","","",$row_order['ord_code'],"","",$_nowpay,$_with_invoce,"",$tcode),true);	
		
	}
	
	
	if($_POST['ord_status'] == 11){$_nowpay2 = 0;}else{$_nowpay2 = ""; }
	
	if($_POST['gift1'] <> ""){
	
	$n1 = $_product_num/$_POST['gift_num1'];
	$_give_gift_num1 = floor($n1) ;
	
	if($_give_gift_num1 > 0){
	
	$_ser = $taiwan_today.$wcode.$ord_today_no;
	$_ser_no = $taiwan_today.$wcode.$ord_today_no.$_numx."A" ;
	$_address = "(".$row_order['ord_ship_zip'].")".$row_order['ord_ship_county'].$row_order['ord_ship_city'].$row_order['ord_ship_address'].",";
	
	$tmp .= excel_row(array($_payway,$fcode,$_ser,$_ser_no,"1",$row_order['ord_ship_name'],$row_order['ord_ship_zip'],$_address,$row_order['ord_ship_mobile'],$_POST['gift1'],$_POST['gift1'],$_give_gift_num1,"0",$_invoce_date,$row_order['ord_ship_fa_id'],"","","","","","","","","","","","","","",$row_order['ord_code'],"","",$_nowpay2,$_with_invoce,"",$tcode),true);	
		
	}
	
	}
	
	if($_POST['gift2'] <> ""){
	
	$n2 = $_product_num/$_POST['gift_num2'];
	$_give_gift_num2 = floor($n2) ;
	
	if($_give_gift_num2 > 0){
	
	$_ser = $taiwan_today.$wcode.$ord_today_no;
	$_ser_no = $taiwan_today.$wcode.$ord_today_no.$_numx."B" ;
	$_address = "(".$row_order['ord_ship_zip'].")".$row_order['ord_ship_county'].$row_order['ord_ship_city'].$row_order['ord_ship_address'].",";
	
	$tmp .= excel_row(array($_payway,$fcode,$_ser,$_ser_no,"1",$row_order['ord_ship_name'],$row_order['ord_ship_zip'],$_address,$row_order['ord_ship_mobile'],$_POST['gift2'],$_POST['gift2'],$_give_gift_num2,"0",$_invoce_date,$row_order['ord_ship_fa_id'],"","","","","","","","","","","","","","",$row_order['ord_code'],"","",$_nowpay2,$_with_invoce,"",$tcode),true);	
		
	}
	
	}
	

} while ($row_order = mysql_fetch_assoc($order)); 
} // Show if recordset not empty 

$tmp .=excel_end(true);

}
		header('Content-Type: application/octet-stream');
		header('Content-Disposition: attachment; Filename="'.$saveasname.'"');
		header('Pragma: no-cache');
		header('Content-length:'.strlen($tmp));
		
		echo $tmp;

mysql_free_result($order);
?>
