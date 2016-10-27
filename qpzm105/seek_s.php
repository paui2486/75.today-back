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
  $updateSQL = sprintf("UPDATE seek_detail SET ap_code=%s, ap_show=%s, ap_class=%s, ap_name=%s, ap_county=%s, ap_city=%s, ap_breed=%s, ap_sex=%s, ap_age=%s, ap_chip=%s, ap_weight=%s, ap_close=%s, ap_health=%s, ap_m_name=%s, ap_m_tel=%s, ap_m_email=%s, ap_memo=%s, ap_status=%s, ap_date=%s, ap_date2=%s, ap_photo=%s WHERE ap_id=%s",
                       GetSQLValueString($_POST['ap_code'], "text"),
                       GetSQLValueString($_POST['ap_show'], "text"),
                       GetSQLValueString($_POST['ap_class'], "int"),
                       GetSQLValueString($_POST['ap_name'], "text"),
                       GetSQLValueString($_POST['ap_county'], "text"),
                       GetSQLValueString($_POST['ap_city'], "text"),
                       GetSQLValueString($_POST['ap_breed'], "text"),
                       GetSQLValueString($_POST['ap_sex'], "text"),
                       GetSQLValueString($_POST['ap_age'], "text"),
                       GetSQLValueString($_POST['ap_chip'], "text"),
                       GetSQLValueString($_POST['ap_weight'], "text"),
                       GetSQLValueString($_POST['ap_close'], "text"),
                       GetSQLValueString($_POST['ap_health'], "text"),
                       GetSQLValueString($_POST['ap_m_name'], "text"),
                       GetSQLValueString($_POST['ap_m_tel'], "text"),
                       GetSQLValueString($_POST['ap_m_email'], "text"),
                       GetSQLValueString($_POST['ap_memo'], "text"),
                       GetSQLValueString($_POST['ap_status'], "int"),
                       GetSQLValueString($_POST['ap_date'], "date"),
                       GetSQLValueString($_POST['ap_date2'], "date"),
                       GetSQLValueString($_POST['rePic'], "text"),
                       GetSQLValueString($_POST['ap_id'], "int"));

  mysql_select_db($database_iwine, $iwine);
  $Result1 = mysql_query($updateSQL, $iwine) or die(mysql_error());
  
  msg_box('修改成功！');
  go_to('seek_l.php');
  exit;
}

$colname_adopt = "-1";
if (isset($_GET['ap_id'])) {
  $colname_adopt = $_GET['ap_id'];
}
mysql_select_db($database_iwine, $iwine);
$query_adopt = sprintf("SELECT * FROM seek_detail WHERE ap_id = %s", GetSQLValueString($colname_adopt, "int"));
$adopt = mysql_query($query_adopt, $iwine) or die(mysql_error());
$row_adopt = mysql_fetch_assoc($adopt);
$totalRows_adopt = mysql_num_rows($adopt);
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
<script type="text/javascript" src="js/jquery-1.7.2.min.js"></script>
<style type="text/css">@import "js/jquery.datepick.package-3.6.1/jquery.datepick.css";</style> 
<script type="text/javascript" src="js/jquery.datepick.package-3.6.1/jquery.datepick.js"></script>
<script type="text/javascript" src="js/jquery.datepick.package-3.6.1/jquery.datepick.pack.js"></script>
<script type="text/javascript" src="js/jquery.datepick.package-3.6.1/jquery.datepick-zh-TW.js"></script>
<script type="text/javascript" src="ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="../js/jquery.twzipcode-1.6.0.min.js"></script>
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
        <td height="40" align="center" valign="middle"><span class="capw"><font color="#FFFFFF">◎ 修改協尋資訊 ◎</font></span></td>
        </tr>
      <tr>
        <td height="2" bgcolor="#FFFFFF"></td>
        </tr>
      <tr>
        <td align="center"></td>
        </tr>
      <tr>
        <td align="center" valign="top"><table width="90%" border="0" cellpadding="3" cellspacing="0" bgcolor="494949">
          <tr>
            <td><form action="<?php echo $editFormAction; ?>" name="form1" method="POST">
              <div align="center">
                <table width="100%" border="0" cellpadding="5" cellspacing="1" class="table">
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td width="15%" align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">公告日期:</td>
                    <td bgcolor="#FFFFFF"><input name="ap_date" type="text" class="sform" id="ap_date" value="<?php echo $row_adopt['ap_date']; ?>"></td>
                  </tr>
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">走失或尋獲日期:</td>
                    <td bgcolor="#FFFFFF"><input name="ap_date2" type="text" class="sform" id="ap_date2" value="<?php echo $row_adopt['ap_date2']; ?>"></td>
                  </tr>
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">編號:</td>
                    <td bgcolor="#FFFFFF"><input name="ap_code" type="text" class="sform" id="ap_code" value="<?php echo $row_adopt['ap_code']; ?>"></td>
                  </tr>
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">名字:</td>
                    <td bgcolor="#FFFFFF"><input name="ap_name" type="text" class="sform" id="ap_name" value="<?php echo $row_adopt['ap_name']; ?>"></td>
                  </tr>
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">分類:</td>
                    <td bgcolor="#FFFFFF"><select name="ap_class" class="sform" id="ap_class">
                      <option value="1" <?php if (!(strcmp(1, $row_adopt['ap_class']))) {echo "selected=\"selected\"";} ?>>找主人</option>
                      <option value="2" <?php if (!(strcmp(2, $row_adopt['ap_class']))) {echo "selected=\"selected\"";} ?>>找毛寶貝</option>
                    </select></td>
                  </tr>
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">所在地:</td>
                    <td bgcolor="#FFFFFF"><div id="twzipcode"></div>
                      <script>
					$(function () {
   						 $('#twzipcode').twzipcode({
						   countySel: '<?php echo $row_adopt['ap_county']; ?>', //縣市預設值
        				   districtSel: '<?php echo $row_adopt['ap_city']; ?>', //鄉鎮市區預設值	 
     					   countyName: 'ap_county',
      					   districtName: 'ap_city',
        				   zipcodeName: 'ap_zip',
						   css: ['sform', 'sform', 'sform']
    					});
					});
					</script></td>
                  </tr>
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">品種:</td>
                    <td bgcolor="#FFFFFF"><input name="ap_breed" type="text" class="sform" id="ap_breed" value="<?php echo $row_adopt['ap_breed']; ?>" size="50"></td>
                  </tr>
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">性別:</td>
                    <td bgcolor="#FFFFFF"><input <?php if (!(strcmp($row_adopt['ap_sex'],"公"))) {echo "checked=\"checked\"";} ?> name="ap_sex" type="radio" id="ap_sex" value="公">
                      <label for="n_status3">公
                        <input <?php if (!(strcmp($row_adopt['ap_sex'],"母"))) {echo "checked=\"checked\"";} ?> type="radio" name="ap_sex" id="ap_sex" value="母">
                        母 </label></td>
                  </tr>
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">年紀:</td>
                    <td bgcolor="#FFFFFF"><input name="ap_age" type="text" class="sform" id="ap_age" value="<?php echo $row_adopt['ap_age']; ?>"></td>
                  </tr>
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">體重:</td>
                    <td bgcolor="#FFFFFF"><input name="ap_weight" type="text" class="sform" id="ap_weight" value="<?php echo $row_adopt['ap_weight']; ?>"></td>
                  </tr>
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">健康:</td>
                    <td bgcolor="#FFFFFF"><input name="ap_health" type="text" class="sform" id="ap_health" value="<?php echo $row_adopt['ap_health']; ?>" size="40"></td>
                  </tr>
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">植入晶片:</td>
                    <td bgcolor="#FFFFFF"><input  <?php if (!(strcmp($row_adopt['ap_chip'],"是"))) {echo "checked=\"checked\"";} ?> name="ap_chip" type="radio" id="ap_chip" value="是">
                      <label for="ap_sex2">是
                        <input <?php if (!(strcmp($row_adopt['ap_chip'],"否"))) {echo "checked=\"checked\"";} ?> name="ap_chip" type="radio" id="ap_chip" value="否">
                        否</label></td>
                  </tr>
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">是否節紮:</td>
                    <td bgcolor="#FFFFFF"><input <?php if (!(strcmp($row_adopt['ap_close'],"是"))) {echo "checked=\"checked\"";} ?> name="ap_close" type="radio" id="ap_chip2" value="是">
                      <label for="ap_sex3">是
                        <input <?php if (!(strcmp($row_adopt['ap_close'],"否"))) {echo "checked=\"checked\"";} ?> name="ap_close" type="radio" id="ap_chip2" value="否">
                        否</label></td>
                  </tr>
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">聯絡人:</td>
                    <td bgcolor="#FFFFFF"><input name="ap_m_name" type="text" class="sform" id="ap_m_name" value="<?php echo $row_adopt['ap_m_name']; ?>"></td>
                  </tr>
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">聯絡電話:</td>
                    <td bgcolor="#FFFFFF"><input name="ap_m_tel" type="text" class="sform" id="ap_m_tel" value="<?php echo $row_adopt['ap_m_tel']; ?>"></td>
                  </tr>
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">聯絡E-mail:</td>
                    <td bgcolor="#FFFFFF"><input name="ap_m_email" type="text" class="sform" id="ap_m_email" value="<?php echo $row_adopt['ap_m_email']; ?>"></td>
                  </tr>
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">說明與注意事項:</td>
                    <td bgcolor="#FFFFFF"><textarea name="ap_memo" id="ap_memo" cols="60" rows="25" class="ckeditor"><?php echo $row_adopt['ap_memo']; ?></textarea></td>
                  </tr>
                  <script type="text/javascript">
// BeginWebWidget jQuery_UI_Calendar: sdate1
jQuery("#ap_date").datepick({dateFormat: 'yy-mm-dd'});
// EndWebWidget jQuery_UI_Calendar: sdate1
                          </script>
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">主圖檔:</td>
                    <td bgcolor="#FFFFFF">&nbsp;<img src="<?php if($row_adopt['ap_photo']<>""){ echo "../webimages/seek/".$row_adopt['ap_photo'];}else{ echo "icon_prev.gif";} ?>" alt="圖片預覽" name="showImg" id="showImg" onClick='javascript:alert("圖片預覽");'><br>
                      <input name="Submit" type="button" class="sform_g" onClick="window.open('fupload.php?useForm=form1&amp;prevImg=showImg&amp;upUrl=../webimages/seek&amp;ImgS=&amp;ImgW=&amp;ImgH=&amp;reItem=rePic','fileUpload','width=500,height=300')" value="重新上傳">
                      <input name="rePic" type="text" class="sform" id="rePic" value="<?php echo $row_adopt['ap_photo']; ?>" size="20">
                      (欄位留白可刪除圖片)</td>
                  </tr>
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">標記:</td>
                    <td bgcolor="#FFFFFF"><select name="ap_status" class="sform" id="ap_status">
                      <option value="1" <?php if (!(strcmp(1, $row_adopt['ap_status']))) {echo "selected=\"selected\"";} ?>>等待主人中</option>
                      <option value="2" <?php if (!(strcmp(2, $row_adopt['ap_status']))) {echo "selected=\"selected\"";} ?>>等待毛寶貝中</option>
                      <option value="3" <?php if (!(strcmp(3, $row_adopt['ap_status']))) {echo "selected=\"selected\"";} ?>>已回到溫暖的家</option>
                    </select></td>
                  </tr>
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">顯示:</td>
                    <td bgcolor="#FFFFFF" class="text_cap"><input <?php if (!(strcmp($row_adopt['ap_show'],"Y"))) {echo "checked=\"checked\"";} ?> name="ap_show" type="radio" id="n_status3" value="Y">
                      <label for="ap_sex">是
                        <input <?php if (!(strcmp($row_adopt['ap_show'],"N"))) {echo "checked=\"checked\"";} ?> type="radio" name="ap_show" id="n_status4" value="N">
                        否
                        <input name="ap_id" type="hidden" id="ap_id" value="<?php echo $row_adopt['ap_id']; ?>">
                        </label></td>
                  </tr>
                  <tr bgcolor="#F3F3F1" class="t9">
                    <td colspan="2" align="right"><input name="status2" type="submit" class="sform_b" onClick="tmt_confirm('確定要修改?');return document.MM_returnValue" value="修改">
                      <input name="button" type="button" class="sform_g" id="button" onClick="history.back()" value="回上頁"></td>
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
mysql_free_result($adopt);

mysql_free_result($news);

mysql_free_result($seek_class);
?>
