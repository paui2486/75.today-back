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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE alliance_project SET ap_ratio=%s, ap_post_url=%s, ap_memo=%s, ap_modify_datetime=%s WHERE ap_id=%s",
                       GetSQLValueString($_POST['ap_ratio'], "int"),
					   GetSQLValueString($_POST['ap_post_url'], "text"),
                       GetSQLValueString($_POST['ap_memo'], "text"),
                       GetSQLValueString($_POST['ap_modify_datetime'], "date"),
                       GetSQLValueString($_POST['ap_id'], "int"));

  mysql_select_db($database_iwine, $iwine);
  $Result1 = mysql_query($updateSQL, $iwine) or die(mysql_error());
  
  msg_box('修改成功！');
  $_url = "alliance_member_s.php?am_id=".$_GET['am_id']; 
  go_to($_url);
}

$colname_ap_detail = "-1";
if (isset($_GET['ap_id'])) {
  $colname_ap_detail = $_GET['ap_id'];
}
mysql_select_db($database_iwine, $iwine);
$query_ap_detail = sprintf("SELECT * FROM alliance_project LEFT JOIN alliance_case ON alliance_project.ap_ac_id = alliance_case.ac_id WHERE ap_id = %s", GetSQLValueString($colname_ap_detail, "int"));
$ap_detail = mysql_query($query_ap_detail, $iwine) or die(mysql_error());
$row_ap_detail = mysql_fetch_assoc($ap_detail);
$totalRows_ap_detail = mysql_num_rows($ap_detail);


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
        <td height="40" align="center" valign="middle"><span class="capw"><font color="#FFFFFF">◎ 參與行銷案件之檢視與統計 ◎</font></span></td>
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
                    <td background="images/transp.gif" bgcolor="#999999" class="contnet_w"><div align="right">加入之行銷案件:</div></td>
                    <td valign="middle" bgcolor="#FFFFFF" class="sform"><label for="ap_ac_id"><?php echo $row_ap_detail['ac_title']; ?></label></td>
                    </tr>
                  <tr>
                    <td width="20%" background="images/transp.gif" bgcolor="#999999" class="contnet_w"><div align="right">案件分潤比:</div></td>
                    <td valign="middle" bgcolor="#FFFFFF" class="sform"><label for="ap_ratio"></label>
                      <input name="ap_ratio" type="text" class="sform" id="ap_ratio" value="<?php echo $row_ap_detail['ap_ratio']; ?>" size="10">
                      %</td>
                    </tr>
                  <tr>
                    <td background="images/transp.gif" bgcolor="#999999" class="contnet_w"><div align="right">專屬網址:</div></td>
                    <td valign="middle" bgcolor="#FFFFFF" class="sform"><label for="ap_ratio2"></label>
                      <?php echo $row_ap_detail['ap_url']; ?></td>
                  </tr>
                  <tr>
                    <td background="images/transp.gif" bgcolor="#999999" class="contnet_w"><div align="right">專屬短網址:</div></td>
                    <td valign="middle" bgcolor="#FFFFFF" class="sform"><label for="ap_ratio3"><?php echo $row_ap_detail['ap_url_short']; ?></label></td>
                  </tr>
                  <tr>
                    <td background="images/transp.gif" bgcolor="#999999" class="contnet_w"><div align="right">QR-Code:</div></td>
                    <td valign="middle" bgcolor="#FFFFFF" class="sform"><label for="ap_ratio4"><img src="<?php echo $row_ap_detail['ap_qrcode']; ?>"></label></td>
                  </tr>
  <script type="text/javascript">
// BeginWebWidget jQuery_UI_Calendar: sdate1
jQuery("#ac_start_date").datepick({dateFormat: 'yy-mm-dd'});
jQuery("#ac_end_date").datepick({dateFormat: 'yy-mm-dd'});
// EndWebWidget jQuery_UI_Calendar: sdate1
</script>
                  <tr>
                    <td background="images/transp.gif" bgcolor="#999999" class="contnet_w"><div align="right">盟友文章網址:</div></td>
                    <td valign="middle" bgcolor="#FFFFFF"><label for="ap_post_url"></label>
                      <textarea name="ap_post_url" id="ap_post_url" cols="80" rows="5" class="ckeditor"><?php echo $row_ap_detail['ap_post_url']; ?></textarea></td>
                  </tr>
                  <tr>
                    <td background="images/transp.gif" bgcolor="#999999" class="contnet_w"><div align="right">備註:</div></td>
                    <td valign="middle" bgcolor="#FFFFFF"><textarea name="ap_memo" id="ap_memo" cols="60" rows="4"><?php echo $row_ap_detail['ap_memo']; ?></textarea>
                      <input name="ap_modify_datetime" type="hidden" id="ap_modify_datetime" value="<?php echo date('Y-m-d H:i:s'); ?>">
                      <input name="ap_id" type="hidden" id="ap_id" value="<?php echo $row_ap_detail['ap_id']; ?>"></td>
                    </tr>
                  <tr>
                    <td background="images/transp.gif" bgcolor="#999999" class="contnet_w"><div align="right">總點擊數:</div></td>
                    <td valign="middle" bgcolor="#FFFFFF" class="sform"><?php $_clicks = bitly_v3_clicks($row_ap_detail['ap_url_short']); echo $_clicks[0]['global_clicks']; ?> 次</td>
                  </tr>
                  <tr>
                    <td colspan="2" align="center" background="images/transp.gif" bgcolor="#999999" class="contnet_w">
                      <input name="button3" type="submit" class="sform_b" id="button3" onClick="tmt_confirm('確定修改參與案件?');return document.MM_returnValue" value="確定修改">                    <input name="button" type="button" class="sform_r" id="button" onClick="MM_goToURL('self','alliance_member_s.php?am_id=<?php echo $_GET['am_id']; ?>');return document.MM_returnValue" value="回盟友資料">
                      </td>
                  </tr>
                  </table></td>
                </tr>
              </table>
            <input type="hidden" name="MM_update" value="form1">
            
          </form>
          </div></td>
      </tr>
      <tr>
        <td align="center" valign="top"><?php //$_clicks_by_day = bitly_v3_clicks_by_day($row_ap_detail['ap_url_short']); echo json_encode($_clicks_by_day); ?></td>
        </tr>
    </table></td>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($ap_detail);

mysql_free_result($ac_detail);
?>
