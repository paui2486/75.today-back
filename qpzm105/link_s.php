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
  $updateSQL = sprintf("UPDATE link_fig SET b_file=%s, b_url=%s, b_status=%s, b_order=%s WHERE b_id=%s",
                       GetSQLValueString($_POST['rePic'], "text"),
                       GetSQLValueString($_POST['b_url'], "text"),
                       GetSQLValueString($_POST['b_status'], "text"),
                       GetSQLValueString($_POST['b_order'], "int"),
                       GetSQLValueString($_POST['b_id'], "int"));

  mysql_select_db($database_iwine, $iwine);
  $Result1 = mysql_query($updateSQL, $iwine) or die(mysql_error());

  $updateGoTo = "link_l.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_ad = "-1";
if (isset($_GET['b_id'])) {
  $colname_ad = $_GET['b_id'];
}
mysql_select_db($database_iwine, $iwine);
$query_ad = sprintf("SELECT * FROM link_fig WHERE b_id = %s", GetSQLValueString($colname_ad, "int"));
$ad = mysql_query($query_ad, $iwine) or die(mysql_error());
$row_ad = mysql_fetch_assoc($ad);
$totalRows_ad = mysql_num_rows($ad);
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>iWine - 後台管理系統</title>

<link href="css.css" rel="stylesheet" type="text/css">
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
        <td height="40" align="center" valign="middle"><span class="capw"><font color="#FFFFFF">◎ 檢視或修改相關連結 ◎</font></span></td>
        </tr>
      <tr>
        <td height="2" bgcolor="#FFFFFF"></td>
        </tr>
      <tr>
        <td align="center" valign="top"><table width="90%" border="0" cellpadding="3" cellspacing="0" bgcolor="494949">
          <tr>
            <td><form action="<?php echo $editFormAction; ?>" name="form1" method="POST">
              <div align="center">
                <table width="100%" border="0" cellpadding="5" cellspacing="1" class="table">
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td width="20%" align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">圖檔(180x50):</td>
                    <td bgcolor="#FFFFFF">&nbsp;<img src="<?php if($row_ad['b_file']<>""){ echo "../webimages/link/".$row_ad['b_file'];}else{ echo "icon_prev.gif";} ?>" alt="圖片預覽" name="showImg" id="showImg" onClick='javascript:alert("圖片預覽");'><br>
                      <input name="Submit" type="button" class="sform_g" onClick="window.open('fupload.php?useForm=form1&amp;prevImg=showImg&amp;upUrl=../webimages/link&amp;ImgS=&amp;ImgW=&amp;ImgH=&amp;reItem=rePic','fileUpload','width=500,height=300')" value="重新上傳">
                      <input name="rePic" type="text" class="sform" id="rePic" value="<?php echo $row_ad['b_file']; ?>" size="20">(欄位留白可刪除圖片)</td>
                    </tr>
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">連結:</td>
                    <td bgcolor="#FFFFFF"><input name="b_url" type="text" class="sform" id="b_url" value="<?php echo $row_ad['b_url']; ?>" size="60"></td>
                    </tr>
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">顯示與否:</td>
                    <td bgcolor="#FFFFFF"><input <?php if (!(strcmp($row_ad['b_status'],"Y"))) {echo "checked=\"checked\"";} ?> type="radio" name="b_status" id="radio" value="Y">
                      是 <input <?php if (!(strcmp($row_ad['b_status'],"N"))) {echo "checked=\"checked\"";} ?> type="radio" name="b_status" id="radio2" value="N">
                      否</td>
                    </tr>
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">排序:</td>
                    <td bgcolor="#FFFFFF"><input name="b_order" type="text" class="sform" id="b_order" value="<?php echo $row_ad['b_order']; ?>" size="5">
                      <input name="b_id" type="hidden" id="b_id" value="<?php echo $row_ad['b_id']; ?>"></td>
                    </tr>
                  <tr bgcolor="#F3F3F1" class="t9">
                    <td colspan="2" align="right"><input name="status2" type="submit" class="sform_b" onClick="tmt_confirm('確定要修改?');return document.MM_returnValue" value="確定修改">
                      <input name="Reset" type="reset" class="sform_b" id="Reset2" value="重設">
                      <input name="button" type="button" class="sform_b" id="button" onClick="history.back()" value="回上頁"></td>
                    </tr>
                  </table>
                </div>
              <input type="hidden" name="MM_update" value="form1">
              <input type="hidden" name="MM_update" value="form1">
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
mysql_free_result($ad);

mysql_free_result($ad);
?>
