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
	  echo "訂單編號：".$aryData[1]." 匯入成功！<br>";
	  }else{
		  echo "訂單編號：".$aryData[1]." 匯入失敗！<br>";
		  }
}

echo "匯入程序結束，<a href=\"order_change_bitch_2.php\">回前頁</a>";
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
    <td align="center" valign="top" bgcolor="666666"><table width="100%" height="201" border="0" align="center" cellpadding="0" cellspacing="8">
      <tr>
        <td height="2" bgcolor="#FFFFFF"></td>
        </tr>
      <tr>
        <td height="40" align="center" valign="middle" class="contnet_w">◎ 匯入理貨單（會計用） ◎</td>
        </tr>
      <tr>
        <td height="2" bgcolor="#FFFFFF"></td>
        </tr>
      <tr>
        <td height="18" class="contnet_w">◎ 匯入郵局理貨單</td>
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
