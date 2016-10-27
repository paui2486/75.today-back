<?php include('session_check.php'); ?>
<?php require_once('../Connections/iwine.php'); ?>
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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE alliance_case SET ac_p_id=%s, ac_title=%s, ac_start_date=%s, ac_end_date=%s, ac_memo=%s, ac_online=%s, ac_modify_datetime=%s WHERE ac_id=%s",
                       GetSQLValueString($_POST['ac_p_id'], "int"),
                       GetSQLValueString($_POST['ac_title'], "text"),
                       GetSQLValueString($_POST['ac_start_date'], "date"),
                       GetSQLValueString($_POST['ac_end_date'], "date"),
                       GetSQLValueString($_POST['ac_memo'], "text"),
                       GetSQLValueString($_POST['ac_online'], "text"),
                       GetSQLValueString($_POST['ac_modify_datetime'], "date"),
                       GetSQLValueString($_POST['ac_id'], "int"));

  mysql_select_db($database_iwine, $iwine);
  $Result1 = mysql_query($updateSQL, $iwine) or die(mysql_error());

  $updateGoTo = "alliance_case_l.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

mysql_select_db($database_iwine, $iwine);
$query_gb_list = "SELECT * FROM Product WHERE p_online = 'Y' ORDER BY p_code ASC";
$gb_list = mysql_query($query_gb_list, $iwine) or die(mysql_error());
$row_gb_list = mysql_fetch_assoc($gb_list);
$totalRows_gb_list = mysql_num_rows($gb_list);

$colname_ac_detail = "-1";
if (isset($_GET['ac_id'])) {
  $colname_ac_detail = $_GET['ac_id'];
}
mysql_select_db($database_iwine, $iwine);
$query_ac_detail = sprintf("SELECT * FROM alliance_case WHERE ac_id = %s", GetSQLValueString($colname_ac_detail, "int"));
$ac_detail = mysql_query($query_ac_detail, $iwine) or die(mysql_error());
$row_ac_detail = mysql_fetch_assoc($ac_detail);
$totalRows_ac_detail = mysql_num_rows($ac_detail);
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
        <td height="40" align="center" valign="middle"><span class="capw"><font color="#FFFFFF">◎ 檢視行銷案件 ◎</font></span></td>
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
                    <td background="images/transp.gif" bgcolor="#999999" class="contnet_w"><div align="right">請選擇加入行銷案件之團體專案:</div></td>
                    <td valign="middle" bgcolor="#FFFFFF" class="sform"><label for="ac_p_id"></label>
                      <select name="ac_p_id" class="sform" id="ac_p_id">
                        <option value="0" <?php if (!(strcmp(0, $row_ac_detail['ac_p_id']))) {echo "selected=\"selected\"";} ?>>請選擇（必選）</option>
                        <?php
do {  
?>
                        <option value="<?php echo $row_gb_list['p_id']?>"<?php if (!(strcmp($row_gb_list['p_id'], $row_ac_detail['ac_p_id']))) {echo "selected=\"selected\"";} ?>><?php echo $row_gb_list['p_code']?> - <?php echo $row_gb_list['p_name']; ?></option>
                        <?php
} while ($row_gb_list = mysql_fetch_assoc($gb_list));
  $rows = mysql_num_rows($gb_list);
  if($rows > 0) {
      mysql_data_seek($gb_list, 0);
	  $row_gb_list = mysql_fetch_assoc($gb_list);
  }
?>
                        </select></td>
                    </tr>
                  <tr>
                    <td width="20%" background="images/transp.gif" bgcolor="#999999" class="contnet_w"><div align="right">行銷案件名稱:</div></td>
                    <td valign="middle" bgcolor="#FFFFFF" class="sform"><label for="ac_title"></label>
                      <input name="ac_title" type="text" class="sform" id="ac_title" value="<?php echo $row_ac_detail['ac_title']; ?>" size="80"></td>
                    </tr>
                  <tr>
                    <td background="images/transp.gif" bgcolor="#999999" class="contnet_w"><div align="right">專案期限:</div></td>
                    <td valign="middle" bgcolor="#FFFFFF" class="sform"><label for="ac_start_date"></label>
                      <input name="ac_start_date" type="text" class="sform" id="ac_start_date" value="<?php echo $row_ac_detail['ac_start_date']; ?>">
                      至
                      <input name="ac_end_date" type="text" class="sform" id="ac_end_date" value="<?php echo $row_ac_detail['ac_end_date']; ?>">                      <label for="ac_end_date"></label></td>
                    </tr>
  <script type="text/javascript">
// BeginWebWidget jQuery_UI_Calendar: sdate1
jQuery("#ac_start_date").datepick({dateFormat: 'yy-mm-dd'});
jQuery("#ac_end_date").datepick({dateFormat: 'yy-mm-dd'});
// EndWebWidget jQuery_UI_Calendar: sdate1
</script>
                  <tr>
                    <td background="images/transp.gif" bgcolor="#999999" class="contnet_w"><div align="right">備註:</div></td>
                    <td valign="middle" bgcolor="#FFFFFF"><textarea name="ac_memo" id="ac_memo" cols="60" rows="4"><?php echo $row_ac_detail['ac_memo']; ?></textarea>
                      <input name="ac_modify_datetime" type="hidden" id="ac_modify_datetime" value="<?php echo date('Y-m-d H:i:s'); ?>">
                      <input name="ac_id" type="hidden" id="ac_id" value="<?php echo $row_ac_detail['ac_id']; ?>"></td>
                    </tr>
                  <tr>
                    <td background="images/transp.gif" bgcolor="#999999" class="contnet_w"><div align="right">是否開放:</div></td>
                    <td valign="middle" bgcolor="#FFFFFF" class="sform"><label for="am_ratio"></label>
                      <input <?php if (!(strcmp($row_ac_detail['ac_online'],"Y"))) {echo "checked=\"checked\"";} ?> name="ac_online" type="radio" id="am_online_Y" value="Y">
                      是
                      <input <?php if (!(strcmp($row_ac_detail['ac_online'],"N"))) {echo "checked=\"checked\"";} ?> name="ac_online" type="radio" id="am_online_N" value="N">
                      否</td>
                    </tr>
                  <tr>
                    <td background="images/transp.gif" bgcolor="#999999" class="contnet_w"><div align="right">建立時間:</div></td>
                    <td valign="middle" bgcolor="#FFFFFF" class="sform"><?php echo $row_ac_detail['ac_regist_datetime']; ?></td>
                  </tr>
                  <tr>
                    <td background="images/transp.gif" bgcolor="#999999" class="contnet_w"><div align="right">最近修改時間:</div></td>
                    <td valign="middle" bgcolor="#FFFFFF" class="sform"><?php echo $row_ac_detail['ac_modify_datetime']; ?></td>
                  </tr>
                  <tr>
                    <td colspan="2" align="center" background="images/transp.gif" bgcolor="#999999" class="contnet_w">
                      <input name="button3" type="submit" class="sform_b" id="button3" onClick="tmt_confirm('確定修改行銷案件?');return document.MM_returnValue" value="確定修改">
                      <input name="button2" type="reset" class="sform_g" id="button2" value="恢復預設值"><input name="button" type="button" class="sform_r" id="button" onClick="MM_goToURL('self','alliance_case_l.php');return document.MM_returnValue" value="回案件列表">
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
        <td align="center" valign="top">&nbsp;</td>
        </tr>
    </table></td>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($gb_list);

mysql_free_result($ac_detail);
?>
