<?php require_once('../Connections/iwine.php'); ?>
<?php include('session_check.php'); ?>
<?php include_once('../bitly/bitly.php'); ?>
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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {

if($_POST['ap_ac_id'] == '0'){
	
	msg_box('請選擇行銷案件！');
	go_to(-1);
	exit;
	
}elseif($_POST['ap_ac_id'] == '1'){
	
	$project_url = "http://ww1.iwine.com.tw/index.php?am_code=".$_POST['ap_am_code'];

}else{
	
$colname_ac_detail = "-1";
if (isset($_POST['ap_ac_id'])) {
  $colname_ac_detail = $_POST['ap_ac_id'];
}
mysql_select_db($database_iwine, $iwine);
$query_ac_detail = sprintf("SELECT * FROM alliance_case WHERE ac_id = %s", GetSQLValueString($colname_ac_detail, "int"));
$ac_detail = mysql_query($query_ac_detail, $iwine) or die(mysql_error());
$row_ac_detail = mysql_fetch_assoc($ac_detail);
$totalRows_ac_detail = mysql_num_rows($ac_detail);	
	
$project_url = "http://ww1.iwine.com.tw/content.php?p_id=".$row_ac_detail['ac_p_id']."&am_code=".$_POST['ap_am_code'];	
}
	
  $results = bitly_v3_shorten($project_url, 'j.mp');
  $project_short_url = $results['url'];
  $project_short_qrcode = $results['url'].".qrcode";
  
  $insertSQL = sprintf("INSERT INTO alliance_project (ap_ac_id, ap_am_id, ap_ratio, ap_url, ap_url_short, ap_qrcode, ap_post_url, ap_memo, ap_regist_datetime) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['ap_ac_id'], "int"),
                       GetSQLValueString($_POST['ap_am_id'], "int"),
                       GetSQLValueString($_POST['ap_ratio'], "int"),
					   GetSQLValueString($project_url, "text"),
					   GetSQLValueString($project_short_url, "text"),
					   GetSQLValueString($project_short_qrcode, "text"),
					   GetSQLValueString($_POST['ap_post_url'], "text"),
                       GetSQLValueString($_POST['ap_memo'], "text"),
                       GetSQLValueString($_POST['ap_regist_datetime'], "date"));

  mysql_select_db($database_iwine, $iwine);
  $Result1 = mysql_query($insertSQL, $iwine) or die(mysql_error());
  
  msg_box('新增案件成功！');
  $_url = "alliance_member_s.php?am_id=".$_GET['am_id']; 
  go_to($_url);
}

mysql_select_db($database_iwine, $iwine);
$query_ac_list = "SELECT * FROM alliance_case WHERE ac_online = 'Y' ORDER BY ac_title ASC";
$ac_list = mysql_query($query_ac_list, $iwine) or die(mysql_error());
$row_ac_list = mysql_fetch_assoc($ac_list);
$totalRows_ac_list = mysql_num_rows($ac_list);


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
<script type="text/javascript" src="ckeditor/ckeditor.js"></script>
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
        <td height="40" align="center" valign="middle"><span class="capw"><font color="#FFFFFF">◎ 新增參與行銷案件 ◎</font></span></td>
        </tr>
      <tr>
        <td height="2" bgcolor="#FFFFFF"></td>
        </tr>
      <tr>
        <td align="center" valign="top"><div align="center">
          <form action="<?php echo $editFormAction; ?>" name="form1" method="POST">
            <table width="90%" border="0" cellspacing="0" cellpadding="3">
              <tr>
                <td bgcolor="#494949"><table width="100%" border="0" cellpadding="4" cellspacing="1" class="table">
                  <tr>
                    <td background="images/transp.gif" bgcolor="#999999" class="contnet_w"><div align="right">請選擇加入之行銷案件:</div></td>
                    <td valign="middle" bgcolor="#FFFFFF" class="sform"><label for="ap_ac_id"></label>
                      <select name="ap_ac_id" class="sform" id="ap_ac_id">
                        <option value="0">請選擇（必選）</option>
                        <?php
do {  
?>
                        <option value="<?php echo $row_ac_list['ac_id']?>"><?php echo $row_ac_list['ac_title']?></option>
                        <?php
} while ($row_ac_list = mysql_fetch_assoc($ac_list));
  $rows = mysql_num_rows($ac_list);
  if($rows > 0) {
      mysql_data_seek($ac_list, 0);
	  $row_ac_list = mysql_fetch_assoc($ac_list);
  }
?>
                      </select></td>
                    </tr>
                  <tr>
                    <td width="20%" background="images/transp.gif" bgcolor="#999999" class="contnet_w"><div align="right">案件分潤比:</div></td>
                    <td valign="middle" bgcolor="#FFFFFF" class="sform"><label for="ap_ratio"></label>
                      <input name="ap_ratio" type="text" class="sform" id="ap_ratio" value="5" size="10">
                      %</td>
                    </tr>
                  <tr>
                    <td background="images/transp.gif" bgcolor="#999999" class="contnet_w"><div align="right">盟友文章網址:</div></td>
                    <td valign="middle" bgcolor="#FFFFFF"><label for="ap_post_url"></label>
                      <textarea name="ap_post_url" id="ap_post_url" cols="80" rows="5" class="ckeditor"></textarea></td>
                  </tr>
  <script type="text/javascript">
// BeginWebWidget jQuery_UI_Calendar: sdate1
jQuery("#ac_start_date").datepick({dateFormat: 'yy-mm-dd'});
jQuery("#ac_end_date").datepick({dateFormat: 'yy-mm-dd'});
// EndWebWidget jQuery_UI_Calendar: sdate1
</script>
                  <tr>
                    <td background="images/transp.gif" bgcolor="#999999" class="contnet_w"><div align="right">備註:</div></td>
                    <td valign="middle" bgcolor="#FFFFFF"><textarea name="ap_memo" id="ap_memo" cols="60" rows="4"></textarea>
                      <input name="ap_regist_datetime" type="hidden" id="ap_regist_datetime" value="<?php echo date('Y-m-d H:i:s'); ?>">
                      <input name="ap_am_id" type="hidden" id="ap_am_id" value="<?php echo $_GET['am_id']; ?>">
                      <input name="ap_am_code" type="hidden" id="ap_am_code" value="<?php echo $_GET['am_code']; ?>"></td>
                    </tr>
                  <tr>
                    <td colspan="2" align="center" background="images/transp.gif" bgcolor="#999999" class="contnet_w">
                      <input name="button3" type="submit" class="sform_b" id="button3" onClick="tmt_confirm('確定新增參與案件?');return document.MM_returnValue" value="確定新增">                    <input name="button" type="button" class="sform_r" id="button" onClick="MM_goToURL('self','alliance_member_s.php?am_id=<?php echo $_GET['am_id']; ?>');return document.MM_returnValue" value="回盟友資料">
                      </td>
                  </tr>
                  </table></td>
                </tr>
              </table>
            <input type="hidden" name="MM_insert" value="form1">
          </form>
          </div></td>
      </tr>
      <tr>
        <td align="center" valign="top">&nbsp;</td>
        </tr>
    </table></td>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($ac_list);

mysql_free_result($ac_detail);
?>
