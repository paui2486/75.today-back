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

$currentPage = $_SERVER["PHP_SELF"];

if (isset($_GET['ord_status'])) {
  if ($_GET['ord_status'] == 0){$newsql = "SELECT * FROM order_list LEFT JOIN Product ON order_list.ord_p_id = Product.p_id WHERE (ord_status >= '3' AND ord_status <= '7') OR ord_status = '11' OR ord_status = '21' OR ord_status = '22' ORDER BY ord_status ASC, ord_id DESC";} 
  else { $status = $_GET['ord_status']; $newsql = "SELECT * FROM order_list LEFT JOIN Product ON order_list.ord_p_id = Product.p_id WHERE ord_status = '".$status."' ORDER BY ord_status ASC, ord_id DESC";}
  }
else{
  $newsql = "SELECT * FROM order_list LEFT JOIN Product ON order_list.ord_p_id = Product.p_id WHERE (ord_status >= '3' AND ord_status <= '7') OR ord_status = '11' OR ord_status = '21' OR ord_status = '22' ORDER BY ord_status ASC, ord_id DESC";	
}

mysql_select_db($database_iwine, $iwine);
$query_order = $newsql;
$order = mysql_query($query_order, $iwine) or die(mysql_error());
$row_order = mysql_fetch_assoc($order);
$totalRows_order = mysql_num_rows($order);
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>iWine - 後台管理系統</title>

<style type="text/css" title="currentStyle">
			@import "demo_page.css";
			@import "demo_table.css";
		</style>
<script type="text/javascript" src="js/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="js/jquery.dataTables.js"></script>
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
        <td height="40" align="center" valign="middle"><span class="capw"><font color="#FFFFFF">◎ 檢視新進訂單(出貨完成前) ◎</font></span></td>
        </tr>
      <tr>
        <td height="2" bgcolor="#FFFFFF"></td>
        </tr>
      <tr>
        <td height="30" align="center"><form action="" method="get" name="form3">
          <span class="contnet_w">選擇訂單狀態
          <select name="ord_status" class="sform" id="ord_status" onChange="form3.submit()">
            <option value="0" <?php if (!(strcmp(0, $_GET['ord_status']))) {echo "selected=\"selected\"";} ?>>全部新進訂單</option>
            <option value="3" <?php if (!(strcmp(3, $_GET['ord_status']))) {echo "selected=\"selected\"";} ?>>已付款，未出貨</option>
            <option value="4" <?php if (!(strcmp(4, $_GET['ord_status']))) {echo "selected=\"selected\"";} ?>>已出貨</option>
            <option value="5" <?php if (!(strcmp(5, $_GET['ord_status']))) {echo "selected=\"selected\"";} ?>>尚未匯款</option>
            <option value="6" <?php if (!(strcmp(6, $_GET['ord_status']))) {echo "selected=\"selected\"";} ?>>對帳中</option>
            <option value="7" <?php if (!(strcmp(7, $_GET['ord_status']))) {echo "selected=\"selected\"";} ?>>對帳失敗，請重填匯款帳號後5碼</option>
<option value="11" <?php if (!(strcmp(11, $_GET['ord_status']))) {echo "selected=\"selected\"";} ?>>貨到付款未出貨</option>
<option value="21" <?php if (!(strcmp(21, $_GET['ord_status']))) {echo "selected=\"selected\"";} ?>>查無帳款，請與我們聯繫</option>
<option value="22" <?php if (!(strcmp(22, $_GET['ord_status']))) {echo "selected=\"selected\"";} ?>>金額不符，請與我們聯繫</option>
          </select>
          </span>
        </form></td>
        </tr>
      <tr>
        <td align="center" valign="top"><table width="98%" border="0" cellpadding="3" cellspacing="0">
          <tr bgcolor="#FFFFFF">
            <td>
                <table width="100%" border="0" cellpadding="5" cellspacing="1" id="product_list" class="display">
                  <thead>
                	<tr bgcolor="#DDDDDD" >
                    <th align="center" background="images/transp.gif" bgcolor="#999999" class="contnet_w">訂單時間</th>
                    <th align="center" background="images/transp.gif" bgcolor="#999999" class="contnet_w">訂單編號</th>
                    <th align="center" background="images/transp.gif" bgcolor="#999999" class="contnet_w">團體商品名稱</th>
                    <th align="center" background="images/transp.gif" bgcolor="#999999" class="contnet_w">各商品訂購數量</th>
  					<th align="center" background="images/transp.gif" bgcolor="#999999" class="contnet_w">訂購人姓名</th>
  					<th align="center" background="images/transp.gif" bgcolor="#999999" class="contnet_w">e-mail</th>
                    <th align="center" background="images/transp.gif" bgcolor="#999999" class="contnet_w">手機</th>
                    <th align="center" background="images/transp.gif" bgcolor="#999999" class="contnet_w">送貨地址</th>
                    <th align="center" background="images/transp.gif" bgcolor="#999999" class="contnet_w">訂購總金額</th>
                    <th align="center" background="images/transp.gif" bgcolor="#999999" class="contnet_w">付款方式</th>
                    <th align="center" background="images/transp.gif" bgcolor="#999999" class="contnet_w">訂單狀態</th>
                    <th align="center" background="images/transp.gif" bgcolor="#999999" class="contnet_w">管理</th>
                    </tr>
                    </thead>
                    <tbody>
                  <?php if ($totalRows_order > 0) { // Show if recordset not empty ?>
                    <?php do { ?>
                      <tr >
                        <td align="center" bgcolor="#FFFFFF"><?php echo $row_order['ord_date']; ?></td>
                        <td align="center" bgcolor="#FFFFFF"><?php echo $row_order['ord_code']; ?></td>
                        <td align="center" bgcolor="#FFFFFF"><?php echo $row_order['p_name']; ?></td>
                        <td align="center" bgcolor="#FFFFFF">
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
                  <?php } ?></td>
                        <td align="center" bgcolor="#FFFFFF"><?php echo $row_order['ord_ship_name']; ?></td>
                        <td align="center" bgcolor="#FFFFFF"><?php echo $row_order['ord_ship_email']; ?></td>
                        <td align="center" bgcolor="#FFFFFF"><?php echo $row_order['ord_ship_mobile']; ?></td>
                        <td align="center" bgcolor="#FFFFFF"><?php echo $row_order['ord_ship_zip']; ?><?php echo $row_order['ord_ship_county']; ?><?php echo $row_order['ord_ship_city']; ?><?php echo $row_order['ord_ship_address']; ?></td>
                        <td align="center" bgcolor="#FFFFFF"><?php echo $row_order['ord_total_price']; ?></td>
                        <td align="center" bgcolor="#FFFFFF"><?php 
						switch($row_order['ord_pay']){
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
						
						?></td>
                        <td align="center" bgcolor="#FFFFFF"><select name="ord_status2" class="sform" id="ord_status2" onChange="chstatus('<?php echo $row_order['ord_id']; ?>',this.value);">
                          <option value="1" <?php if (!(strcmp(1, $row_order['ord_status']))) {echo "selected=\"selected\"";} ?>>未處理</option>
                          <option value="2" <?php if (!(strcmp(2, $row_order['ord_status']))) {echo "selected=\"selected\"";} ?>>付款失敗</option>
                          <option value="3" <?php if (!(strcmp(3, $row_order['ord_status']))) {echo "selected=\"selected\"";} ?>>已付款，準備出貨中</option>
                          <option value="4" <?php if (!(strcmp(4, $row_order['ord_status']))) {echo "selected=\"selected\"";} ?>>已出貨</option>
                          <option value="5" <?php if (!(strcmp(5, $row_order['ord_status']))) {echo "selected=\"selected\"";} ?>>尚未匯款</option>
                          <option value="6" <?php if (!(strcmp(6, $row_order['ord_status']))) {echo "selected=\"selected\"";} ?>>對帳中</option>
                          <option value="7" <?php if (!(strcmp(7, $row_order['ord_status']))) {echo "selected=\"selected\"";} ?>>對帳失敗，請重填匯款帳號後5碼</option>
                          <option value="8" <?php if (!(strcmp(8, $row_order['ord_status']))) {echo "selected=\"selected\"";} ?>>已簽收</option>
                          <option value="9" <?php if (!(strcmp(9, $row_order['ord_status']))) {echo "selected=\"selected\"";} ?>>未簽收退回</option>
                          <option value="10" <?php if (!(strcmp(10, $row_order['ord_status']))) {echo "selected=\"selected\"";} ?>>缺貨中</option>
                          <option value="21" <?php if (!(strcmp(21, $row_order['ord_status']))) {echo "selected=\"selected\"";} ?>>查無帳款，請與我們聯繫</option>
                          <option value="22" <?php if (!(strcmp(22, $row_order['ord_status']))) {echo "selected=\"selected\"";} ?>>金額不符，請與我們聯繫</option>
                          <option value="91" <?php if (!(strcmp(91, $row_order['ord_status']))) {echo "selected=\"selected\"";} ?>>退貨申請中</option>
                          <option value="92" <?php if (!(strcmp(92, $row_order['ord_status']))) {echo "selected=\"selected\"";} ?>>退貨處理中</option>
                          <option value="93" <?php if (!(strcmp(93, $row_order['ord_status']))) {echo "selected=\"selected\"";} ?>>退貨完成</option>
                          <option value="94" <?php if (!(strcmp(94, $row_order['ord_status']))) {echo "selected=\"selected\"";} ?>>取消退貨</option>
                          <option value="99" <?php if (!(strcmp(99, $row_order['ord_status']))) {echo "selected=\"selected\"";} ?>>無效訂單</option>
                        </select></td>
                        <td align="center" bgcolor="#FFFFFF"><input name="button" type="button" class="sform_g" id="button" onClick="MM_goToURL('self','order_s.php?ord_id=<?php echo $row_order['ord_id']; ?>&page=0');return document.MM_returnValue" value="檢視完整內容"></td>
                      </tr>
                      <?php } while ($row_order = mysql_fetch_assoc($order)); ?>
                    <?php } // Show if recordset not empty ?>
                    </tbody>
                    <tfoot>
					<tr bgcolor="#F3F3F1" >
  						<th colspan="16" align="center">
						</th>
                	</tr>
                  </tfoot>
                  </table>
                </td>
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
//	}
</script>
<?php
mysql_free_result($order);
?>
