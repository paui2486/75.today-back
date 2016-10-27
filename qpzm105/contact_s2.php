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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE contact SET c_status=%s WHERE c_id=%s",
                       GetSQLValueString($_POST['c_status'], "int"),
					   GetSQLValueString($_POST['c_id'], "int"));

  mysql_select_db($database_iwine, $iwine);
  $Result1 = mysql_query($updateSQL, $iwine) or die(mysql_error());
  
  if($_POST['page']==0){
	  go_to('contact_new_l.php');
	  exit;
  }else{
	  go_to('contact_history_l.php');
	  exit;
  }
}

$colname_newshow = "-1";
if (isset($_GET['c_id'])) {
  $colname_newshow = $_GET['c_id'];
}
mysql_select_db($database_iwine, $iwine);
$query_newshow = sprintf("SELECT * FROM contact WHERE c_id = %s", GetSQLValueString($colname_newshow, "int"));
$newshow = mysql_query($query_newshow, $iwine) or die(mysql_error());
$row_newshow = mysql_fetch_assoc($newshow);
$totalRows_newshow = mysql_num_rows($newshow);
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>iWine - 後台管理系統</title>

<link href="css.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="js/jquery-1.7.2.min.js"></script>
<style type="text/css">@import "../jquery.datepick.package-3.6.1/jquery.datepick.css";</style> 
<script type="text/javascript" src="../jquery.datepick.package-3.6.1/jquery.datepick.js"></script>
<script type="text/javascript" src="../jquery.datepick.package-3.6.1/jquery.datepick.pack.js"></script>
<script type="text/javascript" src="../jquery.datepick.package-3.6.1/jquery.datepick-zh-TW.js"></script>
<script type="text/javascript">
function tmt_confirm(msg){
	document.MM_returnValue=(confirm(unescape(msg)));
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
        <td height="40" align="center" valign="middle"><span class="capw"><font color="#FFFFFF">◎ 檢視完整連絡內容 ◎</font></span></td>
        </tr>
      <tr>
        <td height="2" bgcolor="#FFFFFF"></td>
        </tr>
      <tr>
        <td align="center"></td>
        </tr>
      <tr>
        <td align="center" valign="top"><table width="75%" border="0" cellpadding="3" cellspacing="0" bgcolor="494949">
          <tr>
            <td><form action="<?php echo $editFormAction; ?>" name="form1" method="POST"><table width="100%" border="0" cellpadding="5" cellspacing="1" class="table">
          <tr bgcolor="#DDDDDD" class="t9">
            <td align="left" class="font01">連絡時間:</td>
            <td align="left" bgcolor="#F2F2F2" class="font02"><?php echo $row_newshow['c_datetime']; ?></td>
          </tr>
          <tr bgcolor="#DDDDDD" class="t9">
            <td align="left" class="font01">聯絡人姓名:</td>
            <td align="left" bgcolor="#F2F2F2" class="font02"><?php echo $row_newshow['c_name']; ?></td>
          </tr>
          <tr bgcolor="#DDDDDD" class="t9">
            <td width="20%" align="left" class="font01">聯絡人電話:</td>
            <td width="386" align="left" bgcolor="#F2F2F2" class="font02"><?php echo $row_newshow['c_tel']; ?></td>
          </tr>
          <tr bgcolor="#DDDDDD" class="t9">
            <td align="left" class="font01">連絡人E-mail:</td>
            <td align="left" bgcolor="#F2F2F2" class="font02"><a href="mailto:<?php echo $row_newshow['c_email']; ?>&subject=Re:<?php echo $row_newshow['c_title']; ?>"><?php echo $row_newshow['c_email']; ?></a></td>
          </tr>
          <tr bgcolor="#DDDDDD" class="t9">
            <td align="left" class="font01">聯絡主題分類:</td>
            <td align="left" bgcolor="#F2F2F2" class="font02"><?php echo $row_newshow['c_class']; ?></td>
          </tr>
          <tr bgcolor="#DDDDDD" class="t9">
            <td align="left" class="font01">連絡標題:</td>
            <td align="left" bgcolor="#F2F2F2" class="font02"><?php echo $row_newshow['c_title']; ?></td>
          </tr>
          <tr bgcolor="#DDDDDD" class="t9">
            <td align="left" class="font01">連絡內容:</td>
            <td align="left" bgcolor="#F2F2F2" class="font02"><?php echo $row_newshow['c_cont']; ?></td>
          </tr>
          <tr bgcolor="#DDDDDD" class="t9">
            <td align="left" class="font01">狀態:</td>
            <td align="left" bgcolor="#F2F2F2" class="font02"><select name="c_status" class="font02" id="c_status">
              <option value="0" <?php if (!(strcmp(0, $row_newshow['c_status']))) {echo "selected=\"selected\"";} ?>>付款失敗</option>
              <option value="1" <?php if (!(strcmp(1, $row_newshow['c_status']))) {echo "selected=\"selected\"";} ?>>處理中</option>
<option value="2" <?php if (!(strcmp(2, $row_newshow['c_status']))) {echo "selected=\"selected\"";} ?>>已結案</option>
            </select>
              <input name="page" type="hidden" id="page" value="<?php echo $_GET['page']; ?>" />
              <input name="c_id" type="hidden" id="c_id" value="<?php echo $row_newshow['c_id']; ?>" />
              <input name="status2" type="submit" class="font01" onClick="tmt_confirm('確定要修改?');return document.MM_returnValue" value="確定修改" /></td>
          </tr>
          <tr align="left" bgcolor="#F3F3F1" class="font01">
            <td colspan="2" align="center" bgcolor="#DDDDDD"><input name="Reset" type="reset" class="font01" id="Reset2" value="重設" />
              <input name="button" type="button" class="font07" id="button" onClick="history.back()" value="回上頁" />
              <input name="button2" type="submit" class="font01" id="button2" onClick="MM_goToURL('parent','contact_reply.php');return document.MM_returnValue" value="回覆" /></td>
          </tr>
        </table><input type="hidden" name="MM_update" value="form1">
            </form><form action="contact_reply.php" name="form2" method="POST"><table width="100%" border="0" cellpadding="5" cellspacing="1" class="table">
          <tr bgcolor="#DDDDDD" class="t9">
            <td align="left" class="font01">回覆標題:</td>
            <td align="left" bgcolor="#F2F2F2" class="font02"><input name="c_reply_title" type="text" id="c_reply_title" value="<?php if($row_newshow['c_reply_title'] <> ""){echo $row_newshow['c_reply_title'];}else{echo $row_newshow['c_title'];} ?>" size="40" /></td>
          </tr>
          <tr bgcolor="#DDDDDD" class="t9">
            <td width="20%" align="left" class="font01">回覆內容:</td>
            <td width="386" align="left" bgcolor="#F2F2F2" class="font02"><textarea name="c_cont" id="c_cont" cols="50" rows="10"><?php echo $row_newshow['c_reply']; ?></textarea>
              <input name="c_email" type="hidden" id="c_email" value="<?php echo $row_newshow['c_email']; ?>" />
              <input name="c_id" type="hidden" id="c_id" value="<?php echo $row_newshow['c_id']; ?>" /></td>
          </tr>
          <tr bgcolor="#DDDDDD" class="t9">
            <td align="left" class="font01">回覆時間:</td>
            <td align="left" bgcolor="#F2F2F2" class="font02"><?php echo $row_newshow['c_reply_datetime']; ?></td>
          </tr>
          <tr bgcolor="#DDDDDD" class="t9">
            <td align="left" class="font01">回覆人帳號:</td>
            <td align="left" bgcolor="#F2F2F2" class="font02"><?php echo $row_newshow['c_reply_who']; ?></td>
          </tr>
          <tr align="left" bgcolor="#F3F3F1" class="font01">
            <td colspan="2" align="center" bgcolor="#DDDDDD"><input name="button2" type="submit" class="font07" id="button2" onClick="tmt_confirm('確定要送出回覆嗎?');return document.MM_returnValue" value="確定回覆" />
              <input name="Reset2" type="reset" class="font01" id="Reset" value="重設" /></td>
          </tr>
        </table>
          </form></td>
            </tr>
          </table></td>
        </tr>
    </table></td>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($newshow);
?>
