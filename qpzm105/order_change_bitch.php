<?php 
include('session_check.php'); 
set_time_limit(0);
?>
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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form2")) {
  $_ord_date = $_POST['date1'];	
  $updateSQL = "UPDATE order_list SET ord_status = '99' WHERE (ord_status = '5' OR ord_status = '6' OR ord_status = '7') AND ord_date <= '$_ord_date'";

  mysql_select_db($database_iwine, $iwine);
  $Result1 = mysql_query($updateSQL, $iwine) or die(mysql_error());
  
  msg_box('訂單狀態更新完成！');
}

if ((isset($_POST["MM_update2"])) && ($_POST["MM_update2"] == "form1")) {

$today = date('Y-m-d H:i:s');
$uploadcsv = $_FILES['csvfile']['tmp_name'];

if( $uploadcsv != ""){

$fp = fopen($uploadcsv,'r');
$con = fread($fp,filesize($uploadcsv));
fclose($fp);
$tmp1 = explode("\r",$con);
foreach($tmp1 as $d){
	$aryData=explode(",",$d);
	if($d=='') continue;
$aryData[0] = iconv('BIG5','UTF-8',$aryData[0]);
$aryData[1] = iconv('BIG5','UTF-8',$aryData[1]);
$aryData[2] = iconv('BIG5','UTF-8',$aryData[2]);
$aryData[3] = iconv('BIG5','UTF-8',$aryData[3]);
$aryData[4] = iconv('BIG5','UTF-8',$aryData[4]);
//$aryData[5] = iconv('BIG5','UTF-8',$aryData[5]);
//$aryData[6] = iconv('BIG5','UTF-8',$aryData[6]);

  $strSQL = "UPDATE order_list SET ord_ship_date = '$aryData[0]', ord_ship_code = '$aryData[2]', ord_status = '4', ord_ship_fa_date = '$aryData[3]', ord_ship_fa_code = '$aryData[4]' WHERE ord_code = '$aryData[1]'";
  mysql_select_db($database_iwine, $iwine);
  mysql_query($strSQL, $iwine) or die(mysql_error());
  
  if(mysql_affected_rows()){
	  echo "訂單編號：".$aryData[1]." 更新出貨狀態成功！<br>";
	  }else{
		  echo "訂單編號：".$aryData[1]." 更新出貨狀態失敗！<br>";
		  }

mysql_select_db($database_iwine, $iwine);
$query_ord_list = "SELECT * FROM order_list LEFT JOIN Product ON order_list.ord_p_id = Product.p_id LEFT JOIN member ON order_list.ord_acc_id = member.m_id WHERE ord_code = '$aryData[1]'";
$ord_list = mysql_query($query_ord_list, $iwine) or die(mysql_error());
$row_ord_list = mysql_fetch_assoc($ord_list);
$totalRows_ord_list = mysql_num_rows($ord_list);


$message01 = "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">
<html xmlns=\"http://www.w3.org/1999/xhtml\">
<head>
<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />
<title></title>
</head>

<body>
<table width=\"780\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
  <tr>
    <td height=\"150\" align=\"center\" valign=\"middle\">
	親愛的會員朋友您好，您在iWine團購網所訂購的商品已經出貨了：<br>
	<table width=\"95%\" border=\"0\" cellpadding=\"4\" cellspacing=\"1\">
            <tr>
              <td width=\"20%\" bgcolor=\"#999999\"><div align=\"right\"><strong>訂單編號:</strong></div></td>
              <td width=\"30%\" valign=\"middle\" bgcolor=\"#CCCCCC\"><div align=\"left\">".$row_ord_list['ord_code']."</div></td>
              <td width=\"20%\" valign=\"middle\" bgcolor=\"#999999\"><div align=\"right\"><strong>出貨日期:</strong></div></td>
              <td width=\"30%\" valign=\"middle\" bgcolor=\"#CCCCCC\"><div align=\"left\">".$row_ord_list['ord_ship_date']."</div></td>
            </tr>
            <tr>
              <td bgcolor=\"#999999\"><div align=\"right\"><strong>訂購人姓名:</strong></div></td>
              <td valign=\"middle\"><div align=\"left\">".$row_ord_list['m_name']."</div></td>
              <td valign=\"middle\" bgcolor=\"#999999\"><div align=\"right\" ><strong>郵件編號:</strong></div></td>
              <td valign=\"middle\"><div align=\"left\" color=\"red\">".$row_ord_list['ord_ship_code']."</div></td>
            </tr>
            <tr>
              <td bgcolor=\"#999999\"><div align=\"right\"><strong>訂購人E-mail:</strong></div></td>
              <td valign=\"middle\" bgcolor=\"#CCCCCC\"><div align=\"left\">".$row_ord_list['m_email']."</div></td>
              <td valign=\"middle\" bgcolor=\"#999999\"><div align=\"right\"><strong>訂購人手機:</strong></div></td>
              <td valign=\"middle\" bgcolor=\"#CCCCCC\"><div align=\"left\">".$row_ord_list['m_mobile']."</div></td>
            </tr>
			<tr>
              <td bgcolor=\"#999999\"><div align=\"right\"><strong>收貨人姓名:</strong></div></td>
              <td valign=\"middle\" bgcolor=\"#CCCCCC\"><div align=\"left\">".$row_ord_list['ord_ship_name']."</div></td>
              <td valign=\"middle\" bgcolor=\"#999999\"><div align=\"right\"><strong>收貨人手機:</strong></div></td>
              <td valign=\"middle\" bgcolor=\"#CCCCCC\"><div align=\"left\">".$row_ord_list['ord_ship_mobile']."</div></td>
            </tr>
            <tr>
              <td bgcolor=\"#999999\"><div align=\"right\"><strong>收貨人地址:</strong></div></td>
              <td colspan=\"3\" valign=\"middle\"><div align=\"left\">".$row_ord_list['ord_ship_zip'].$row_ord_list['ord_ship_county'].$row_ord_list['ord_ship_city'].$row_ord_list['ord_ship_address']."</div></td>
            </tr>
			<tr>
              <td bgcolor=\"#999999\"><div align=\"right\"><strong>公司統編:</strong></div></td>
              <td colspan=\"3\" valign=\"middle\"><div align=\"left\">".$row_ord_list['ord_ship_fa_id']."</div></td>
            </tr>
 
            </table>
			<br>
			<table width=\"95%\" border=\"1\" cellpadding=\"4\" cellspacing=\"0\" bordercolor=\"#000000\">
        <tr bgcolor=\"#999999\">
          <td width=\"30%\"><div align=\"center\"><strong>團購代號</strong></div></td>
          <td width=\"70%\"><div align=\"center\"><strong>團購專案名稱</strong></div></td>
        </tr>
		<tr>
            <td><div align=\"center\">".$row_ord_list['p_code']."</div></td>
            <td><div align=\"center\">".$row_ord_list['p_name']."</div></td>
          </tr>		  
				<tr>
				  <td colspan=\"2\" bgcolor=\"#cccccc\" ><div align=\"center\">注意事項</div></td>
				</tr>
				<tr>
				  <td colspan=\"2\" bgcolor=\"#ffffff\" ><div align=\"left\">
				  <p>1.商品出貨後1~3個工作天左右送達。歡迎隨時到<a href=\"http://postserv.post.gov.tw/webpost/CSController?cmd=POS4001_1&_MENU_ID=189&_SYS_ID=D&_ACTIVE_ID=190\">郵局「國內快捷/掛號/包裹查詢」網頁輸入郵件代碼14碼</a>查看您目前訂單最新送貨進度。</p>
                  <p>2.若3個工作天後仍未收到商品，請mail至web@i-fit.com.tw客服信箱洽詢，謝謝！</p>
				  <p>4.此郵件是系統自動傳送，請勿直接回覆！</p>
				  <p>祝 您有個美好的一天 ^_^</p>
				  <p>----------------------------------------------------------</p>
				  <p>iWine團購網 http://ww1.iwine.com.tw</p>
				</div></td>
				</tr>
    </table>
	</td>
  </tr>
</table>
</html>
";

require_once('../PHPMailer/class.phpmailer.php');
$mail             = new PHPMailer(); // defaults to using php "mail()"

$body             = $message01;

$mail->AddReplyTo("service@iwine.com.tw","iWine團購網");
$mail->SetFrom('service@iwine.com.tw',"iWine團購網");

$address = $row_ord_list['m_email'];
$mail->AddAddress($address, $row_ord_list['m_name']);

$mail->Subject    = "iWine團購網出貨通知信";

$mail->AltBody    = "請使用可支援HTML格式的讀信軟體!"; // optional, comment out and test

$mail->MsgHTML($body);

$mail->CharSet="utf-8";

$mail->Encoding = "base64";
//設置郵件格式為HTML
$mail->IsHTML(true);

//$mail->AddAttachment("images/phpmailer.gif");      // attachment
//$mail->AddAttachment("images/phpmailer_mini.gif"); // attachment

if(!$mail->Send()) {
    echo "訂單編號：".$row_ord_list['ord_code']." 出貨通知寄出失敗！<br>";
} else {
	echo "訂單編號：".$row_ord_list['ord_code']." 出貨通知寄出成功！<br>";
	$mail->ClearAddresses();  //清除使用者欄位，為下一封信做準備
}  
  
}
//msg_box('匯入成功!');
echo "匯入程序結束，<a href=\"order_change_bitch.php\">回前頁</a>";
exit;
}else{
msg_box('匯入失敗，請重新操作!');	
}	
}

if ((isset($_POST["MM_update3"])) && ($_POST["MM_update3"] == "form3")) {

$today = date('Y-m-d H:i:s');
$uploadcsv = $_FILES['csvfile2']['tmp_name'];

if( $uploadcsv != ""){

$fp = fopen($uploadcsv,'r');
$con = fread($fp,filesize($uploadcsv));
fclose($fp);
$tmp1 = explode("\r",$con);
foreach($tmp1 as $d){
	$aryData=explode(",",$d);
	if($d=='') continue;
$aryData[0] = iconv('BIG5','UTF-8',$aryData[0]);
$aryData[1] = iconv('BIG5','UTF-8',$aryData[1]);
//$aryData[2] = iconv('BIG5','UTF-8',$aryData[2]);
//$aryData[3] = iconv('BIG5','UTF-8',$aryData[3]);
//$aryData[4] = iconv('BIG5','UTF-8',$aryData[4]);
//$aryData[5] = iconv('BIG5','UTF-8',$aryData[5]);
//$aryData[6] = iconv('BIG5','UTF-8',$aryData[6]);

if($aryData[0] != "" && $aryData[1] != ''){

  $strSQL = "UPDATE order_list SET ord_status = '3' WHERE ord_atm_5code = '$aryData[1]' AND ord_status = '5'";
  mysql_select_db($database_iwine, $iwine);
  mysql_query($strSQL, $iwine) or die(mysql_error());
  
  if(mysql_affected_rows()){
	  echo "匯款帳號：".$aryData[1]." 更新已付款狀態成功！<br>";
	  }else{
		  echo "匯款帳號：".$aryData[1]." 更新已付款狀態失敗！<br>";
		  }
}
}
//msg_box('匯入成功!');
echo "匯入程序結束，<a href=\"order_change_bitch.php\">回前頁</a>";
exit;
}else{
msg_box('匯入失敗，請重新操作!');	
}	
}
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
<!--
function ord_change(){
	if(window.confirm('確定要修改訂單狀態?')){
		document.form2.submit();
	}
}

function ord_import(){
	if(window.confirm('匯入理貨單會同時寄出出貨通知，若訂單數目多，則需要花費一些時間（畫面空白），請不要點選回上一頁或重新整理，以免發生錯誤！\n確定要匯入理貨單?')){
		document.form1.submit();
	}
}

function ord_import2(){
	if(window.confirm('匯入需要花費一些時間（畫面空白），請不要點選回上一頁或重新整理，以免發生錯誤！\n確定要匯入對帳單?')){
		document.form3.submit();
	}
}
//-->
</script>
</head>
<body marginheight="0" marginwidth="0" bgcolor="#666666">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td align="center" valign="top" bgcolor="666666"><table width="100%" height="504" border="0" align="center" cellpadding="0" cellspacing="8">
      <tr>
        <td height="2" bgcolor="#FFFFFF"></td>
        </tr>
      <tr>
        <td height="40" align="center" valign="middle" class="contnet_w">◎ 批次修改訂單狀態 ◎</td>
        </tr>
      <tr>
        <td height="2" bgcolor="#FFFFFF"></td>
        </tr>
      <tr>
        <td class="contnet_w">◎ 匯入郵局理貨單</td>
        </tr>
      <tr>
        <td height="91" align="center"><form action="<?php echo $editFormAction; ?>" method="POST" enctype="multipart/form-data" name="form1">
          <table width="75%" border="0" cellspacing="0" cellpadding="3">
            <tr>
              <td bgcolor="#494949"><table width="100%" border="0" cellpadding="5" cellspacing="1">
                <tr bgcolor="#DDDDDD">
                  <td align="center" background="images/transp.gif" bgcolor="#999999" class="contnet_w">選擇匯入檔案（csv）</td>
                  <td align="left" bgcolor="#FFFFFF"><input type="file" name="csvfile" id="csvfile"></td>
                </tr>
                <tr bgcolor="#F3F3F1">
                  <td colspan="2" align="center">
                    <input name="status2" type="button" class="sform_g" value="確定匯入" onClick="ord_import();">
                    <input name="reset" type="reset" class="sform_b" value="重設"></td>
                  </tr>
                </table></td>
              </tr>
            </table>
          <input type="hidden" name="MM_update2" value="form1">
        </form></td>
        </tr>
      <tr>
        <td class="contnet_w">◎ 匯入匯款對帳單</td>
      </tr>
      <tr>
        <td height="91" align="center"><form action="<?php echo $editFormAction; ?>" method="POST" enctype="multipart/form-data" name="form3">
          <table width="75%" border="0" cellspacing="0" cellpadding="3">
            <tr>
              <td bgcolor="#494949"><table width="100%" border="0" cellpadding="5" cellspacing="1">
                <tr bgcolor="#DDDDDD">
                  <td align="center" background="images/transp.gif" bgcolor="#999999" class="contnet_w">選擇匯入檔案（csv）</td>
                  <td align="left" bgcolor="#FFFFFF"><input type="file" name="csvfile2" id="csvfile2"></td>
                </tr>
                <tr bgcolor="#F3F3F1">
                  <td colspan="2" align="center"><input name="status" type="button" class="sform_g" value="確定匯入" onClick="ord_import2();">
                    <input name="reset2" type="reset" class="sform_b" value="重設"></td>
                </tr>
              </table></td>
            </tr>
          </table>
          <input type="hidden" name="MM_update3" value="form3">
        </form></td>
      </tr>
      <tr>
        <td class="contnet_w">◎ 批次修改未付款訂單為無效訂單</td>
      </tr>
      <tr>
        <td align="center" valign="top">
        <form name="form2" method="POST" action="<?php echo $editFormAction; ?>">
        <?php
		$d = strtotime('-6 day'); 
		$_start = date('Y-m-d',$d);
		?>
          <table width="75%" border="0" cellpadding="3" cellspacing="0" bgcolor="#494949">
            <tr>
              <td><div align="center">
                <table width="100%" border="0" cellpadding="5" cellspacing="1" class="table">
                  <tr>
                    <td align="center" background="images/transp.gif" bgcolor="#999999" class="contnet_w">選擇期限</td>
                    <td bgcolor="#FFFFFF" class="text_cap2">將
                      <input name="date1" type="text" class="sform" id="date1" value="<?php echo $_start; ?>" size="15">
                      前（含）所有未付款訂單更改為無效訂單</td>
                  </tr>
                  <tr bgcolor="#F3F3F1" >
                    <td colspan="2" align="center"><input name="id" type="hidden" id="id" value="1">
                      <input name="Button" type="button" class="sform_g" id="button" value="確認修改" onClick="ord_change();">
                      <input name="button2" type="reset" class="sform_b" id="button2" value="重設"></td>
                  </tr>
                </table>
              </div></td>
            </tr>
          </table>
          <input type="hidden" name="MM_update" value="form2">
        </form></td>
        </tr>
    </table></td>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($ord_list);
?>
<script type="text/javascript">
// BeginWebWidget jQuery_UI_Calendar: sdate1
jQuery("#date1").datepick({dateFormat: 'yy-mm-dd'});
//jQuery("#date2").datepick({dateFormat: 'yy-mm-dd'});
// EndWebWidget jQuery_UI_Calendar: sdate1
                          </script>
<?php
mysql_free_result($admin);
?>
