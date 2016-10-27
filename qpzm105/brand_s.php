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
  $updateSQL = sprintf("UPDATE brand SET b_title=%s,b_ctitle=%s,b_etitle=%s, b_image=%s,b_logo=%s, b_info=%s, b_description=%s, b_keyword=%s, b_order=%s, b_online=%s, b_key_tag=%s WHERE b_id=%s",
                       GetSQLValueString($_POST['b_title'], "text"),
                       GetSQLValueString($_POST['b_ctitle'], "text"),
                       GetSQLValueString($_POST['b_etitle'], "text"),
                       GetSQLValueString($_POST['b_image'], "text"),
                       GetSQLValueString($_POST['b_logo'], "text"),
                       GetSQLValueString($_POST['b_info'], "text"),
                       GetSQLValueString($_POST['b_description'], "text"),
                       GetSQLValueString($_POST['b_keyword'], "text"),
                       GetSQLValueString($_POST['b_order'], "int"),
                       GetSQLValueString($_POST['b_online'], "int"),
                       GetSQLValueString($_POST['b_key_tag'], "text"),
                       GetSQLValueString($_POST['b_id'], "int"));

  mysql_select_db($database_iwine, $iwine);
  $Result1 = mysql_query($updateSQL, $iwine) or die(mysql_error());
  
  msg_box('修改品牌專區成功！');
  go_to('brand_l.php');
  exit;
}

$colname_Recordset1 = "-1";
if (isset($_GET['b_id'])) {
  $colname_Recordset1 = $_GET['b_id'];
}
mysql_select_db($database_iwine, $iwine);
$query_Recordset1 = sprintf("SELECT * FROM brand WHERE b_id = %s", GetSQLValueString($colname_Recordset1, "int"));
$Recordset1 = mysql_query($query_Recordset1, $iwine) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>iWine - 後台管理系統</title>
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
}
-->
</style>
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
        <td height="40" align="center" valign="middle"><span class="capw"><font color="#FFFFFF">◎ 檢視或品牌專區 ◎</font></span></td>
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
                    <td width="20%" align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">品牌名稱:</td>
                    <td width="386" bgcolor="#FFFFFF"><input name="b_title" type="text" class="sform" id="b_title" size="80" value="<?php echo $row_Recordset1['b_title']; ?>"></td>
                    </tr>
                <table width="100%" border="0" cellpadding="5" cellspacing="1" class="table">
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td width="20%" align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">品牌中文標題:</td>
                    <td width="386" bgcolor="#FFFFFF"><input name="b_ctitle" type="text" class="sform" id="b_ctitle" size="80" value="<?php echo $row_Recordset1['b_title']; ?>"></td>
                    </tr>
                <table width="100%" border="0" cellpadding="5" cellspacing="1" class="table">
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td width="20%" align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">品牌英文標題:</td>
                    <td width="386" bgcolor="#FFFFFF"><input name="b_etitle" type="text" class="sform" id="b_etitle" size="80" value="<?php echo $row_Recordset1['b_title']; ?>"></td>
                    </tr>
                <tr bgcolor="#DDDDDD" class="t9">
                    <td align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">品牌 logo:</td>
                    <td bgcolor="#FFFFFF">&nbsp;<img src="<?php if($row_Recordset1['b_logo']<>""){ echo "../webimages/brand/".$row_Recordset1['b_logo'];}else{ echo "icon_prev.gif";} ?>" alt="圖片預覽" name="showImg" id="showImg" onClick='javascript:alert("圖片預覽");'>
                      <input name="Submit" type="button" class="sform_g" onClick="window.open('fupload.php?useForm=form1&amp;prevImg=showImg&amp;upUrl=../webimages/brand&amp;ImgS=&amp;ImgW=&amp;ImgH=&amp;reItem=b_logo','fileUpload','width=500,height=300')" value="準備上傳"><span class="text_cap">＊145px * 145px</span>
                      <input name="b_logo" type="text" class="sform" id="b_logo" value="<?php echo $row_Recordset1['b_logo']; ?>" size="20"> 
                      (欄位留白可刪除圖片)
                    </td>
                  </tr>
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">品牌 形象圖片:</td>
                    <td bgcolor="#FFFFFF">&nbsp;<img src="<?php if($row_Recordset1['b_image']<>""){ echo "../webimages/brand/".$row_Recordset1['b_image'];}else{ echo "icon_prev.gif";} ?>" alt="圖片預覽" name="showImg2" id="showImg2" onClick='javascript:alert("圖片預覽");'>
                      <input name="Submit2" type="button2" class="sform_g" onClick="window.open('fupload.php?useForm=form1&amp;prevImg=showImg2&amp;upUrl=../webimages/brand&amp;ImgS=&amp;ImgW=&amp;ImgH=&amp;reItem=b_image','fileUpload','width=500,height=300')" value="準備上傳"><span class="text_cap">＊910px * 418px</span>
                      <input name="b_image" type="text" class="sform" id="b_image" value="<?php echo $row_Recordset1['b_image']; ?>" size="20"> 
                      (欄位留白可刪除圖片)
                    </td>
                  </tr>
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td width="20%" align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">說明文字:</td>
                    <td width="386" bgcolor="#FFFFFF"><input name="b_info" type="text" class="sform" id="b_info" size="150" value="<?php echo $row_Recordset1['b_info']; ?>"></td>
                    </tr>
                    <tr bgcolor="#DDDDDD" class="t9">
                    <td align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">Meta Description:</td>
                    <td bgcolor="#FFFFFF"><input name="b_description" type="text" class="sform" id="b_description" size="80"><span class="text_cap" value="<?php echo $row_Recordset1['b_description']; ?>">*中文 75 字</span></td>
                  </tr>
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">Meta KeyWord:</td>
                    <td bgcolor="#FFFFFF"><input name="b_keyword" type="text" class="sform" id="b_keyword" size="80"><span class="text_cap" value="<?php echo $row_Recordset1['b_keyword']; ?>">*請用半形,區隔</span></td>
                  </tr>
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">排序:</td>
                    <td bgcolor="#FFFFFF"><input name="b_order" type="text" class="sform" id="b_order" size="5" value="<?php echo $row_Recordset1['b_order']; ?>"></td>
                  </tr>
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">顯示與否：</td>
                    <td bgcolor="#FFFFFF" class="text_cap">
                    <?php 
                        if($row_Recordset1['b_online']==1 ) { 
                        ?>
                            <input name="b_online" type="radio" id="radio" value="1" checked="CHECKED" >是 <input type="radio" name="b_online" id="radio2" value="0">否
                        <?php
                        }else if($row_Recordset1['b_online']==0 ) { ?>
                            <input name="b_online" type="radio" id="radio" value="1">是 <input type="radio" name="b_online" id="radio2" value="0"  checked="CHECKED" >否
                        <?php
                        } ?>
                    
                    
                    </td>
                  </tr>
                  <tr bgcolor="#F3F3F1" class="t9">
                    <td colspan="2" align="right"><input name="status2" type="submit" class="sform_b" onClick="tmt_confirm('確定要修改?');return document.MM_returnValue" value="確定修改">
                      <input name="Reset" type="reset" class="sform_b" id="Reset2" value="重設">
                      <input name="button" type="button" class="sform_b" id="button" onClick="history.back()" value="回上頁"></td>
                  </tr>
                  </table>
                </div>
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
mysql_free_result($Recordset1);
?>
