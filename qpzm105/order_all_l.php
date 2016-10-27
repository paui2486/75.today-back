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

if (isset($_POST['ord_pay']) && $_POST['ord_pay'] <> "0") {
	  
   $SQL_21 = " ord_pay = '".$_POST['ord_pay']."' AND";
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

if ($_POST['date3']<>"") {

   $date03 = $_POST['date3'];
   
   $SQL_32 = " ord_ship_date >= '".$date03."' AND";
   $f = 1;
  
}

if ($_POST['date4']<>"") {

   $date04 = $_POST['date4'];
   $SQL_33 = " ord_ship_date <= '".$date04."' AND";
   $f = 1;
  
}


if ($_POST['ord_code']<>"") {
   
   $ord_code = $_POST['ord_code'];
   $SQL_4 = " ord_code = '".$ord_code."' AND";
   $f = 1;
  
}

if ($_POST['ord_acc']<>"") {
   
   $ord_acc = $_POST['ord_acc'];
   $SQL_5 = " ord_acc = '".$ord_acc."' OR ord_ship_name = '".$ord_acc."' OR ord_ship_mobile = '".$ord_acc."' OR m_mobile = '".$ord_acc."' AND";
   $f = 1;

}

if ($_POST['atm_code']<>"") {

   $atm_code = $_POST['atm_code'];
   $SQL_6 = " ord_atm_5code = '".$atm_code."' AND";
   $f = 1;
}

if($_POST['search'] <> "Y" && $f == 0){
   
   $SQL_7 = " ord_id = '-1'";

}else{
	
   $SQL_7 = " ord_id > 0";

}

$newSQL = "SELECT * FROM order_list LEFT JOIN Product ON order_list.ord_p_id = Product.p_id LEFT JOIN member ON order_list.ord_acc_id = member.m_id WHERE".$SQL_1 .$SQL_2.$SQL_21.$SQL_30.$SQL_31.$SQL_32.$SQL_33.$SQL_4.$SQL_5.$SQL_6.$SQL_7." ORDER BY ord_date DESC, ord_code DESC";

?>
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
$query_Recordset1 = "SELECT * FROM Product ORDER BY p_code ASC";
$Recordset1 = mysql_query($query_Recordset1, $iwine) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

mysql_select_db($database_iwine, $iwine);
$query_order = $newSQL;
$order = mysql_query($query_order, $iwine) or die(mysql_error());
$row_order = mysql_fetch_assoc($order);
$totalRows_order = mysql_num_rows($order);
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
<script type="text/javascript" src="js/jquery.dataTables.js"></script>

<style type="text/css" title="currentStyle">
			@import "demo_page.css";
			@import "demo_table.css";
		</style>

<script type="text/javascript">
$(document).ready(function(){
	$('#product_list').dataTable({
	"bFilter": true,
	"aaSorting": [[ 1, "desc" ]],
	"oLanguage": {
      "sLengthMenu": "每頁顯示 _MENU_ 筆訂單資料",
      "sZeroRecords": "無訂單資料",
      "sInfo": "目前顯示 _START_ 到 _END_ 筆，共 _TOTAL_ 筆訂單資料",
      "sInfoEmtpy": "無訂單商品資料",
      "sInfoFiltered": "共有 _MAX_ 筆訂單資料)",
      "sProcessing": "正在載入中...",
      "sSearch": "搜尋",
      "sUrl": "", //多语言配置文件，可将oLanguage的设置放在一个txt文件中，例：Javascript/datatable/dtCH.txt
      "oPaginate": {
          "sFirst":    "第一頁",
          "sPrevious": " 上一頁 ",
          "sNext":     " 下一頁 ",
          "sLast":     " 最後一頁 "
      }
  }, 
      "aLengthMenu": [[10, 25, 50, 75, 100, -1], ["10", "25", "50", "75", "100", "全部"]]  //设置每页显示记录的下拉菜单
   });
});	
</script>
<script type="text/javascript">
function dele(ids){
	if(window.confirm('確定要刪除?')){
		window.location='contact_d.php?s_id='+ids;
	}
}

function MM_goToURL() { //v3.0
  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
}
</script>

<link href="css.css" rel="stylesheet" type="text/css">
</head>

<body marginheight="0" marginwidth="0" bgcolor="#666666">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td align="center" valign="top" bgcolor="666666"><table width="100%" height="605" border="0" align="center" cellpadding="0" cellspacing="8">
      <tr>
        <td height="2" bgcolor="#FFFFFF"></td>
        </tr>
      <tr>
        <td height="40" align="center" valign="middle"><span class="capw"><font color="#FFFFFF">◎ 檢視所有訂單 ◎</font></span></td>
        </tr>
      <tr>
        <td height="2" bgcolor="#FFFFFF"></td>
        </tr>
      <tr>
        <td height="150" align="center" valign="top">       
        <table width="90%" border="0" cellspacing="0" cellpadding="3">
          <tr>
            <td bgcolor="#494949">
            <form name="form1" method="post" action="order_all_l.php">
            <table width="100%" border="0" cellpadding="5" cellspacing="1" class="table">
              <tr>
                <td background="images/transp.gif" bgcolor="#999999" class="contnet_w"><div align="right">選擇團購專案:</div></td>
                <td valign="middle" bgcolor="#FFFFFF"><select name="product" class="sform" id="product">
                  <option value="0" <?php if (!(strcmp(0, $_POST['product']))) {echo "selected=\"selected\"";} ?>>不限</option>
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
                  <td width="20%" background="images/transp.gif" bgcolor="#999999" class="contnet_w"><div align="right">訂單狀態:</div></td>
                  <td valign="middle" bgcolor="#FFFFFF"><select name="ord_status" class="sform" id="ord_status">
                    <option value="0" <?php if (!(strcmp(0, $_POST['ord_status']))) {echo "selected=\"selected\"";} ?>>不限</option>
                    <option value="1" <?php if (!(strcmp(1, $_POST['ord_status']))) {echo "selected=\"selected\"";} ?>>未處理</option>
                    <option value="2" <?php if (!(strcmp(2, $_POST['ord_status']))) {echo "selected=\"selected\"";} ?>>付款失敗</option>
                    <option value="3" <?php if (!(strcmp(3, $_POST['ord_status']))) {echo "selected=\"selected\"";} ?>>已付款，準備出貨中</option>
                    <option value="4" <?php if (!(strcmp(4, $_POST['ord_status']))) {echo "selected=\"selected\"";} ?>>已出貨</option>
                    <option value="5" <?php if (!(strcmp(5, $_POST['ord_status']))) {echo "selected=\"selected\"";} ?>>尚未匯款</option>
                    <option value="6" <?php if (!(strcmp(6, $_POST['ord_status']))) {echo "selected=\"selected\"";} ?>>對帳中</option>
                    <option value="7" <?php if (!(strcmp(7, $_POST['ord_status']))) {echo "selected=\"selected\"";} ?>>對帳失敗，請重填匯款帳號後5碼</option>
                    <option value="8" <?php if (!(strcmp(8, $_POST['ord_status']))) {echo "selected=\"selected\"";} ?>>已簽收</option>
                    <option value="9" <?php if (!(strcmp(9, $_POST['ord_status']))) {echo "selected=\"selected\"";} ?>>未簽收退回</option>
                    <option value="10" <?php if (!(strcmp(10, $_POST['ord_status']))) {echo "selected=\"selected\"";} ?>>缺貨中</option>
                    <option value="11" <?php if (!(strcmp(11, $_POST['ord_status']))) {echo "selected=\"selected\"";} ?>>貨到付款未出貨</option>
                    <option value="21" <?php if (!(strcmp(21, $_POST['ord_status']))) {echo "selected=\"selected\"";} ?>>查無帳款，請與我們聯繫</option>
                    <option value="22" <?php if (!(strcmp(22, $_POST['ord_status']))) {echo "selected=\"selected\"";} ?>>金額不符，請與我們聯繫</option>
                    <option value="91" <?php if (!(strcmp(91, $_POST['ord_status']))) {echo "selected=\"selected\"";} ?>>退貨申請中</option>
                    <option value="92" <?php if (!(strcmp(92, $_POST['ord_status']))) {echo "selected=\"selected\"";} ?>>退貨處理中</option>
                    <option value="93" <?php if (!(strcmp(93, $_POST['ord_status']))) {echo "selected=\"selected\"";} ?>>退貨完成</option>
                    <option value="94" <?php if (!(strcmp(94, $_POST['ord_status']))) {echo "selected=\"selected\"";} ?>>取消退貨</option>
                    <option value="99" <?php if (!(strcmp(99, $_POST['ord_status']))) {echo "selected=\"selected\"";} ?>>無效訂單</option>
                    </select></td>
                </tr>
                <tr>
                  <td background="images/transp.gif" bgcolor="#999999" class="contnet_w"><div align="right">付款方式:</div></td>
                  <td valign="middle" bgcolor="#FFFFFF"><select name="ord_pay" class="sform" id="ord_pay">
                    <option value="0" <?php if (!(strcmp(0, $_POST['ord_pay']))) {echo "selected=\"selected\"";} ?>>不限</option>
                    <option value="card" <?php if (!(strcmp("card", $_POST['ord_pay']))) {echo "selected=\"selected\"";} ?>>信用卡</option>
                    <option value="webatm" <?php if (!(strcmp("webatm", $_POST['ord_pay']))) {echo "selected=\"selected\"";} ?>>WebATM</option>
                    <option value="atm" <?php if (!(strcmp("atm", $_POST['ord_pay']))) {echo "selected=\"selected\"";} ?>>超商付款</option>
                    <option value="paynow" <?php if (!(strcmp("paynow", $_POST['ord_pay']))) {echo "selected=\"selected\"";} ?>>貨到付款</option>
<option value="atm_cathy" <?php if (!(strcmp("atm_cathy", $_POST['ord_pay']))) {echo "selected=\"selected\"";} ?>>一般匯款</option>
</select></td>
                </tr>
                <tr>
                  <td background="images/transp.gif" bgcolor="#999999" class="contnet_w"><div align="right">訂單日期區間:</div></td>
                  <td valign="middle" bgcolor="#FFFFFF">
                    <input name="date1" type="text" class="sform" id="date1" value="<?php echo $_POST['date1']; ?>" size="15">
                    至
<input name="date2" type="text" class="sform" id="date2" value="<?php echo $_POST['date2']; ?>" size="15">
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
                  <td background="images/transp.gif" bgcolor="#999999" class="contnet_w"><div align="right">出貨日期區間:</div></td>
                  <td valign="middle" bgcolor="#FFFFFF"><input name="date3" type="text" class="sform" id="date3" value="<?php echo $_POST['date3']; ?>" size="15">
至
  <input name="date4" type="text" class="sform" id="date4" value="<?php echo $_POST['date4']; ?>" size="15">
  <input name="ord_date_if2" type="hidden" value="Y">
  <script type="text/javascript">
// BeginWebWidget jQuery_UI_Calendar: sdate1
jQuery("#date3").datepick({dateFormat: 'yy-mm-dd'});
jQuery("#date4").datepick({dateFormat: 'yy-mm-dd'});
// EndWebWidget jQuery_UI_Calendar: sdate1
                          </script></td>
                </tr>
                <tr>
                  <td background="images/transp.gif" bgcolor="#999999" class="contnet_w"><div align="right">訂單編號:</div></td>
                  <td valign="middle" bgcolor="#FFFFFF"><input name="ord_code" type="text" class="sform" id="ord_code" value="<?php echo $_POST['ord_code']; ?>"></td>
                </tr>
                <tr>
                  <td background="images/transp.gif" bgcolor="#999999" class="contnet_w"><div align="right">訂購者帳號或收貨人姓名或手機號碼:</div></td>
                  <td valign="middle" bgcolor="#FFFFFF"><input name="ord_acc" type="text" class="sform" id="ord_acc" value="<?php echo $_POST['ord_acc']; ?>"></td>
                </tr>
                <tr>
                  <td background="images/transp.gif" bgcolor="#999999" class="contnet_w"><div align="right">匯款虛擬帳號:</div></td>
                  <td valign="middle" bgcolor="#FFFFFF"><input name="atm_code" type="text" class="sform" id="atm_code" value="<?php echo $_POST['atm_code']; ?>"></td>
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
        <td align="center" valign="top"><table width="99%" border="0" cellpadding="3" cellspacing="0">
          <tr bgcolor="#FFFFFF">
            <td><table width="100%" border="1" cellpadding="5" cellspacing="0" id="product_list" class="display">
              <thead>
                <tr bgcolor="#DDDDDD" >
                  <th align="center" background="images/transp.gif" bgcolor="#999999" class="contnet_w">訂單時間</th>
                  <th align="center" background="images/transp.gif" bgcolor="#999999" class="contnet_w">訂單編號</th>
                  <th align="center" background="images/transp.gif" bgcolor="#999999" class="contnet_w">團購專案名稱</th>
                  <th align="center" background="images/transp.gif" bgcolor="#999999" class="contnet_w">各商品訂購數量</th>
                  <th align="center" background="images/transp.gif" bgcolor="#999999" class="contnet_w">訂購人姓名</th>
                  <th align="center" background="images/transp.gif" bgcolor="#999999" class="contnet_w">e-mail</th>
                  <th align="center" background="images/transp.gif" bgcolor="#999999" class="contnet_w">手機</th>
                  <th align="center" background="images/transp.gif" bgcolor="#999999" class="contnet_w">送貨地址</th>
                  <th align="center" background="images/transp.gif" bgcolor="#999999" class="contnet_w">訂購總金額</th>
                  <th align="center" background="images/transp.gif" bgcolor="#999999" class="contnet_w">付款方式</th>
                  <th align="center" background="images/transp.gif" bgcolor="#999999" class="contnet_w">訂單狀態</th>
                  </tr>
              </thead>
              <tbody>
                <?php if ($totalRows_order > 0) { // Show if recordset not empty ?>
                <?php do { ?>
                <tr >
                  <td align="center" bgcolor="#FFFFFF" class="text_cap2"><?php echo $row_order['ord_date']; ?></td>
                  <td align="center" bgcolor="#FFFFFF" class="text_cap2"><a href="javascript:window.open('order_s.php?ord_id=<?php echo $row_order['ord_id']; ?>&page=0');"><?php echo $row_order['ord_code']; ?></a></td>
                  <td align="center" bgcolor="#FFFFFF" class="text_cap2"><?php echo $row_order['p_name']; ?></td>
                  <td align="left" bgcolor="#FFFFFF" class="text_cap2"><strong><em>團購主商品：</em></strong><br>
                  (1) <?php echo $row_order['p_product1']; ?>：<?php echo $row_order['ord_p_num']; ?><br>
                  <?php if($row_order['p_product2'] <> ""){ ?>
                  (2) <?php echo $row_order['p_product2']; ?>：<?php echo $row_order['ord_p_num2']; ?><br>
                  <?php } ?>
                  <?php if($row_order['p_product3'] <> ""){ ?>
                  (3) <?php echo $row_order['p_product3']; ?>：<?php echo $row_order['ord_p_num3']; ?><br>
                  <?php } ?>
                  <?php if($row_order['p_product4'] <> ""){ ?>
                  (4) <?php echo $row_order['p_product4']; ?>：<?php echo $row_order['ord_p_num4']; ?><br>
                  <?php } ?>
                  <?php if($row_order['p_product5'] <> ""){ ?>
                  (5). <?php echo $row_order['p_product5']; ?>：<?php echo $row_order['ord_p_num5']; ?><br>
                  <?php } ?>
                  <?php if($row_order['p_pb1'] <> ""){ ?>
                  <em><strong>加購商品：</strong></em><strong></strong><br>
                  (1) <?php echo $row_order['p_pb1']; ?>：<?php echo $row_order['ord_pb1_num']; ?><br>
                  <?php } ?>
				  <?php if($row_order['p_pb2'] <> ""){ ?>
                  (2) <?php echo $row_order['p_pb2']; ?>：<?php echo $row_order['ord_pb2_num']; ?><br>
                  <?php } ?>
                  <?php if($row_order['p_pb3'] <> ""){ ?>
                  (3) <?php echo $row_order['p_pb3']; ?>：<?php echo $row_order['ord_pb3_num']; ?><br>
                  <?php } ?>
                  <?php if($row_order['p_pb4'] <> ""){ ?>
                  (4) <?php echo $row_order['p_pb4']; ?>：<?php echo $row_order['ord_pb4_num']; ?><br>
                  <?php } ?>
                  <?php if($row_order['p_pb5'] <> ""){ ?>
                  (5). <?php echo $row_order['p_pb5']; ?>：<?php echo $row_order['ord_pb5_num']; ?><br>
                  <?php } ?>
                  <?php if($row_order['p_pb6'] <> ""){ ?>
                  (1) <?php echo $row_order['p_pb6']; ?>：<?php echo $row_order['ord_pb6_num']; ?><br>
                  <?php } ?>
				  <?php if($row_order['p_pb7'] <> ""){ ?>
                  (2) <?php echo $row_order['p_pb7']; ?>：<?php echo $row_order['ord_pb7_num']; ?><br>
                  <?php } ?>
                  <?php if($row_order['p_pb8'] <> ""){ ?>
                  (3) <?php echo $row_order['p_pb8']; ?>：<?php echo $row_order['ord_pb8_num']; ?><br>
                  <?php } ?>
                  <?php if($row_order['p_pb9'] <> ""){ ?>
                  (4) <?php echo $row_order['p_pb9']; ?>：<?php echo $row_order['ord_pb9_num']; ?><br>
                  <?php } ?>
                  <?php if($row_order['p_pb10'] <> ""){ ?>
                  (5). <?php echo $row_order['p_pb10']; ?>：<?php echo $row_order['ord_pb10_num']; ?><br>
                  <?php } ?>
                  <?php if($row_order['p_pa1'] <> ""){ ?>
                  <em><strong>贈品或組合商品</strong></em>：<br>
                  (1) <?php echo $row_order['p_pa1']; ?>：<?php echo $row_order['ord_pa1_num']; ?><br>
                  <?php } ?>
				  <?php if($row_order['p_pa2'] <> ""){ ?>
                  (2) <?php echo $row_order['p_pa2']; ?>：<?php echo $row_order['ord_pa2_num']; ?><br>
                  <?php } ?>
                  <?php if($row_order['p_pa3'] <> ""){ ?>
                  (3) <?php echo $row_order['p_pa3']; ?>：<?php echo $row_order['ord_pa3_num']; ?><br>
                  <?php } ?>
                  <?php if($row_order['p_pa4'] <> ""){ ?>
                  (4) <?php echo $row_order['p_pa4']; ?>：<?php echo $row_order['ord_pa4_num']; ?><br>
                  <?php } ?>
                  <?php if($row_order['p_pa5'] <> ""){ ?>
                  (5). <?php echo $row_order['p_pa5']; ?>：<?php echo $row_order['ord_pa5_num']; ?><br>
                  <?php } ?>
                  <?php if($row_order['p_pa6'] <> ""){ ?>
                  (1) <?php echo $row_order['p_pa6']; ?>：<?php echo $row_order['ord_pa6_num']; ?><br>
                  <?php } ?>
				  <?php if($row_order['p_pa7'] <> ""){ ?>
                  (2) <?php echo $row_order['p_pa7']; ?>：<?php echo $row_order['ord_pa7_num']; ?><br>
                  <?php } ?>
                  <?php if($row_order['p_pa8'] <> ""){ ?>
                  (3) <?php echo $row_order['p_pa8']; ?>：<?php echo $row_order['ord_pa8_num']; ?><br>
                  <?php } ?>
                  <?php if($row_order['p_pa9'] <> ""){ ?>
                  (4) <?php echo $row_order['p_pa9']; ?>：<?php echo $row_order['ord_pa9_num']; ?><br>
                  <?php } ?>
                  <?php if($row_order['p_pa10'] <> ""){ ?>
                  (5). <?php echo $row_order['p_pa10']; ?>：<?php echo $row_order['ord_pa10_num']; ?><br>
                  <?php } ?>
                  </td>
                  <td align="center" bgcolor="#FFFFFF" class="text_cap2"><?php echo $row_order['ord_ship_name']; ?></td>
                  <td align="center" bgcolor="#FFFFFF" class="text_cap2"><?php echo $row_order['ord_ship_email']; ?></td>
                  <td align="center" bgcolor="#FFFFFF" class="text_cap2"><?php echo $row_order['ord_ship_mobile']; ?></td>
                  <td align="center" bgcolor="#FFFFFF" class="text_cap2"><?php echo $row_order['ord_ship_zip']; ?><?php echo $row_order['ord_ship_county']; ?><?php echo $row_order['ord_ship_city']; ?><?php echo $row_order['ord_ship_address']; ?></td>
                  <td align="center" bgcolor="#FFFFFF" class="text_cap2"><?php echo $row_order['ord_total_price']; $_total_order_price = $_total_order_price + $row_order['ord_total_price']; ?></td>
                  <td align="center" bgcolor="#FFFFFF" class="text_cap2">
                    <?php 
						switch($row_order['ord_pay']){
							case 'card':
							echo "信用卡";
							break;
							case 'webatm':
							echo "WEBATM";
							break;
							case 'atm':
							echo "超商付款";
							break;
							case 'atm_cathy':
							echo "一般匯款";
							break;
							case 'paynow':
							echo "貨到付款";
							break;
						}
						
						?>
                  </td>
                  <td align="center" bgcolor="#FFFFFF" class="text_cap2">
                    <select name="ord_status2" class="sform" id="ord_status2" onChange="chstatus('<?php echo $row_order['ord_id']; ?>',this.value);">
                      <option value="1" <?php if (!(strcmp(1, $row_order['ord_status']))) {echo "selected=\"selected\"";} ?>>未處理</option>
                      <option value="2" <?php if (!(strcmp(2, $row_order['ord_status']))) {echo "selected=\"selected\"";} ?>>付款失敗</option>
                      <option value="3" <?php if (!(strcmp(3, $row_order['ord_status']))) {echo "selected=\"selected\"";} ?>>已付款，準備出貨中</option>
                      <option value="4" <?php if (!(strcmp(4, $row_order['ord_status']))) {echo "selected=\"selected\"";} ?>>已出貨</option>
                      <option value="5" <?php if (!(strcmp(5, $row_order['ord_status']))) {echo "selected=\"selected\"";} ?>>尚未匯款</option>
                      <option value="6" <?php if (!(strcmp(6, $row_order['ord_status']))) {echo "selected=\"selected\"";} ?>>對帳中</option>
                      <option value="8" <?php if (!(strcmp(8, $row_order['ord_status']))) {echo "selected=\"selected\"";} ?>>已簽收</option>
                      <option value="9" <?php if (!(strcmp(9, $row_order['ord_status']))) {echo "selected=\"selected\"";} ?>>未簽收退回</option>
                      <option value="10" <?php if (!(strcmp(10, $row_order['ord_status']))) {echo "selected=\"selected\"";} ?>>缺貨中</option>
                      <option value="11" <?php if (!(strcmp(11, $row_order['ord_status']))) {echo "selected=\"selected\"";} ?>>貨到付款未出貨</option>
                      <option value="91" <?php if (!(strcmp(91, $row_order['ord_status']))) {echo "selected=\"selected\"";} ?>>退貨申請中</option>
                      <option value="92" <?php if (!(strcmp(92, $row_order['ord_status']))) {echo "selected=\"selected\"";} ?>>退貨處理中</option>
                      <option value="93" <?php if (!(strcmp(93, $row_order['ord_status']))) {echo "selected=\"selected\"";} ?>>退貨完成</option>
                      <option value="94" <?php if (!(strcmp(94, $row_order['ord_status']))) {echo "selected=\"selected\"";} ?>>取消退貨</option>
                      <option value="99" <?php if (!(strcmp(99, $row_order['ord_status']))) {echo "selected=\"selected\"";} ?>>無效訂單</option>
                      </select>
                    <br>
                    <?php if($row_order['ord_pay'] == "atm_cathy"){ echo $row_order['ord_atm_5code']; } ?>
                  </td>
                  </tr>
                <?php } while ($row_order = mysql_fetch_assoc($order)); ?>
                <?php } // Show if recordset not empty ?>
              </tbody>
              <tfoot>
                <tr bgcolor="#F3F3F1" >
                  <th colspan="15" align="right" class="text_w">區間訂單總金額：<b> $<?php echo number_format($_total_order_price); ?></b></th>
                </tr>
                <tr bgcolor="#F3F3F1" >
                  <th colspan="15" align="center"></th>
                </tr>
              </tfoot>
            </table></td>
          </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
</table>
</body>
</html>
<script language="javascript">
	function chstatus(oid, ostatus){
	
		//if(window.confirm('確定要更新訂單狀態？')){
		
		//alert(oid+ostatus);
		$.ajax({
    		type: 'POST',
			url: 'status_change.php',
    		data: {ord_id: oid, ord_status: ostatus},
    		error: function(xhr) {  },
    		success: function(response) { 
			if(response == 'success'){
			alert('更新成功!');
			}else{
			alert('更新失敗!');
			}
			}
				});
				
}
	//}
</script>

<?php
mysql_free_result($Recordset1);

mysql_free_result($order);
?>
