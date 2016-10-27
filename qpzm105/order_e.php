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
$query_Recordset1 = "SELECT * FROM Product ORDER BY p_code ASC";
$Recordset1 = mysql_query($query_Recordset1, $iwine) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
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
</script>

<link href="css.css" rel="stylesheet" type="text/css">
</head>

<body marginheight="0" marginwidth="0" bgcolor="#666666">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td align="center" valign="top" bgcolor="666666"><table width="100%" height="234" border="0" align="center" cellpadding="0" cellspacing="8">
      <tr>
        <td height="2" bgcolor="#FFFFFF"></td>
        </tr>
      <tr>
        <td height="40" align="center" valign="middle"><span class="capw"><font color="#FFFFFF">◎ 匯出訂單（出貨） ◎</font></span></td>
        </tr>
      <tr>
        <td height="2" bgcolor="#FFFFFF"></td>
        </tr>
      <tr>
        <td height="150" align="center" valign="top">       
        <table width="90%" border="0" cellspacing="0" cellpadding="3">
          <tr>
            <td bgcolor="#494949">
            <form action="order_export.php" method="post" name="form1" target="new">
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
                  <td background="images/transp.gif" bgcolor="#999999" class="contnet_w"><div align="right">匯出格式:</div></td>
                  <td valign="middle" bgcolor="#FFFFFF"><select name="ord_format" class="sform" id="ord_format">
                    <option value="poster" selected="selected">郵局</option>
                    <option value="normal">一般格式</option>
                    <option value="myfresh">買新鮮</option>
                  </select></td>
                </tr>
                <tr>
                  <td background="images/transp.gif" bgcolor="#999999" class="contnet_w"><div align="right">是否開發票:</div></td>
                  <td valign="middle" bgcolor="#FFFFFF"><input type="radio" name="invoce" id="radio" value="Y">
                    是 
                      <input name="invoce" type="radio" id="radio2" value="N" checked="CHECKED">
                      否</td>
                </tr>
                <tr>
                  <td background="images/transp.gif" bgcolor="#999999" class="contnet_w"><div align="right">匯出訂單號次:</div></td>
                  <td valign="middle" bgcolor="#FFFFFF"><select name="ord_no" class="sform" id="ord_no">
                    <option value="1" selected>1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                    <option value="6">6</option>
                    <option value="7">7</option>
                    <option value="8">8</option>
                    <option value="9">9</option>
                  </select></td>
                </tr>
                <tr>
                  <td background="images/transp.gif" bgcolor="#999999" class="contnet_w"><div align="right">廠商編號:</div></td>
                  <td valign="middle" bgcolor="#FFFFFF"><input name="fcode" type="text" class="sform" id="fcode" value="L794"></td>
                </tr>
                <tr>
                  <td background="images/transp.gif" bgcolor="#999999" class="contnet_w"><div align="right">輸送方式編號:</div></td>
                  <td valign="middle" bgcolor="#FFFFFF"><input name="tcode" type="text" class="sform" id="tcode" value="T70"></td>
                </tr>
                <tr>
                  <td background="images/transp.gif" bgcolor="#999999" class="contnet_w"><div align="right">字母:</div></td>
                  <td valign="middle" bgcolor="#FFFFFF"><input name="wcode" type="text" class="sform" id="wcode" value="T"></td>
                </tr>
                <tr>
                  <td background="images/transp.gif" bgcolor="#999999" class="contnet_w"><div align="right">贈品一:</div></td>
                  <td valign="middle" bgcolor="#FFFFFF"><input name="gift1" type="text" class="sform" id="gift1" size="40">
                    (輸入贈品名稱，留白表示無贈品) ，每
                      <input name="gift_num1" type="text" class="sform" id="gift_num1" value="1" size="5">
                      份產品送一個</td>
                </tr>
                <tr>
                  <td background="images/transp.gif" bgcolor="#999999" class="contnet_w"><div align="right">贈品二:</div></td>
                  <td valign="middle" bgcolor="#FFFFFF"><input name="gift2" type="text" class="sform" id="gift2" size="40">
                    (輸入贈品名稱，留白表示無贈品) ，每
                      <input name="gift_num2" type="text" class="sform" id="gift_num2" value="1" size="5">
份產品送一個</td>
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
    </table></td>
  </tr>
</table>
</body>
</html>

<?php
mysql_free_result($Recordset1);

mysql_free_result($order);
?>
