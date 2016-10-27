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
$_today = date('Y-m-d H:i:s');
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE bar SET company_name=%s, owner=%s, contact=%s, address=%s, telphone=%s, fax=%s, email=%s, vat_num=%s, active=%s, 
                        category=%s, open_time=%s, cons_pattems=%s, products=%s, pic1=%s, pic2=%s, pic3=%s, pic4=%s, pic5=%s, corkage_fee=%s, glass_type=%s, 
                        mod_time=%s  WHERE id=%s",
                       GetSQLValueString($_POST['company_name'], "text"),
                       GetSQLValueString($_POST['owner'], "text"),
                       GetSQLValueString($_POST['contact'], "text"),
                       GetSQLValueString($_POST['address'], "text"),
                       GetSQLValueString($_POST['telphone'], "text"),
                       GetSQLValueString($_POST['fax'], "text"),
                       GetSQLValueString($_POST['email'], "text"),
                       GetSQLValueString($_POST['vat_num'], "text"),
					   GetSQLValueString($_POST['active'], "int"),
					   GetSQLValueString($_POST['category'], "text"),
					   GetSQLValueString($_POST['open_time'], "text"),
					   GetSQLValueString($_POST['cons_pattems'], "text"),
					   GetSQLValueString($_POST['products'], "text"),
					   GetSQLValueString($_POST['pic1'], "text"),
					   GetSQLValueString($_POST['pic2'], "text"),
					   GetSQLValueString($_POST['pic3'], "text"),
					   GetSQLValueString($_POST['pic4'], "text"),
					   GetSQLValueString($_POST['pic5'], "text"),
					   GetSQLValueString($_POST['corkage_fee'], "int"),
					   GetSQLValueString($_POST['glass_type'], "text"),
					   GetSQLValueString($_today, "date"),
                       GetSQLValueString($_POST['id'], "int"));

  mysql_select_db($database_iwine, $iwine);
  $Result1 = mysql_query($updateSQL, $iwine) or die(mysql_error());
  // echo "updateSQL = ".$updateSQL."<br>";
  msg_box('修改酒商內容成功');
  go_to('winebar_l.php');
  exit;
}

$id = "-1";
if (isset($_GET['id'])) {
  $id = $_GET['id'];
}
mysql_select_db($database_iwine, $iwine);
$query_bar = sprintf("SELECT * FROM bar WHERE id = %s", GetSQLValueString($id, "int"));
$bar = mysql_query($query_bar, $iwine) or die(mysql_error());
$row_bar = mysql_fetch_assoc($bar);
$totalRows_bar = mysql_num_rows($bar);
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
<link href="backend.css" rel="stylesheet" type="text/css">
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
        <td height="40" align="center" valign="middle"><span class="capw"><font color="#FFFFFF">◎ 修改酒館內容 ◎</font></span></td>
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
                    <td align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">bar 名稱:</td>
                    <td bgcolor="#FFFFFF"><input size="80" name="company_name" type="text" class="sform" id="company_name" value="<?php echo $row_bar['company_name']; ?>"></td>
                  </tr>
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">酒吧類型:</td>
                    <td bgcolor="#FFFFFF">
	                    <select name="category" class="sform" id="category" >
                          <option value="<?php echo $row_bar['category']; ?>"><?php echo $row_bar['category']; ?></option>
                          <option value="Lounge Bar">1. Lounge Bar</option>
                          <option value="餐廳酒吧">2. 餐廳酒吧</option>
                          <option value="日式酒吧">3. 日式酒吧</option>
                          <option value="夜店酒吧">4. 夜店酒吧</option>
                          <option value="音樂酒吧">5. 音樂酒吧</option>
                          <option value="運動酒吧">6. 運動酒吧</option>                                            
                          <option value="啤酒酒吧">7. 啤酒酒吧</option>                      
                          <option value="其他">8. 其他</option>                                                
                        </select>
                    </td>
                  </tr>
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">葡萄酒杯種類:</td>
                    <td bgcolor="#FFFFFF">
	                    <select name="glass_type" class="sform" id="glass_type" >
                          <option value="<?php echo $row_bar['glass_type']; ?>"><?php echo $row_bar['glass_type']; ?></option>
                          <option value="5種以下">1. 5種以下</option>
                          <option value="6-10種">2. 6-10種</option>
                          <option value="11種以上">3. 11種以上</option>                              
                        </select>
                    </td>
                  </tr>
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">開瓶費:</td>
                    <td bgcolor="#FFFFFF" class="description"><input name="corkage_fee" type="number" class="sform" id="corkage_fee" min="0" value="<?php echo $row_bar['corkage_fee']; ?>" size="30">0表示無開瓶費</td>
                  </tr>
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">負責人:</td>
                    <td bgcolor="#FFFFFF"><input name="owner" type="text" class="sform" id="owner" value="<?php echo $row_bar['owner']; ?>" size="30"></td>
                  </tr>
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td width="15%" align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">統一編號:</td>
                    <td bgcolor="#FFFFFF"><input name="vat_num" type="text" class="sform" id="vat_num" value="<?php echo $row_bar['vat_num']; ?>" size="10"></td>
                  </tr>
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td width="15%" align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">聯絡人:</td>
                    <td bgcolor="#FFFFFF"><input name="contact" type="text" class="sform" id="contact" value="<?php echo $row_bar['contact']; ?>" size="30"></td>
                  </tr>
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td width="15%" align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">電話:</td>
                    <td bgcolor="#FFFFFF"><input name="telphone" type="text" class="sform" id="telphone" value="<?php echo $row_bar['telphone']; ?>" size="20"></td>
                  </tr>
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td width="15%" align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">傳真:</td>
                    <td bgcolor="#FFFFFF"><input name="fax" type="text" class="sform" id="fax" value="<?php echo $row_bar['fax']; ?>" size="20"></td>
                  </tr>
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td width="15%" align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">email:</td>
                    <td bgcolor="#FFFFFF"><input name="email" type="text" class="sform" id="email" value="<?php echo $row_bar['vat_num']; ?>" size="100"></td>
                  </tr>
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td width="15%" align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">地址:</td>
                    <td bgcolor="#FFFFFF"><input name="address" type="text" class="sform" id="address" value="<?php echo $row_bar['address']; ?>" size="100"></td>
                  </tr>
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td width="15%" align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">審核狀態:</td>
                    <td bgcolor="#FFFFFF" class="description">
                    	<input name="active" type="radio" value="1" id="active" <?php if($row_bar['active']==1) echo "checked=\"checked\""; ?>>通過 
                        <input name="active" type="radio" value="0" id="not_active" <?php if($row_bar['active']==0) echo "checked=\"checked\""; ?>>審核中
                    </td>
                  </tr>
                  
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td width="15%" align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">營業時間:</td>
                    <td bgcolor="#FFFFFF"><input name="open_time" type="text" class="sform" id="open_time" value="<?php echo $row_bar['open_time']; ?>" size="100"></td>
                  </tr>
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td width="15%" align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">消費方式:</td>
                    <td bgcolor="#FFFFFF"><input name="cons_pattems" type="text" class="sform" id="cons_pattems" value="<?php echo $row_bar['cons_pattems']; ?>" size="100"></td>
                  </tr>
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td width="15%" align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">主打商品:</td>
                    <td bgcolor="#FFFFFF"><input name="products" type="text" class="sform" id="products" value="<?php echo $row_bar['products']; ?>" size="100"></td>
                  </tr>
                  
                  <?php for ($i=1; $i<=5; $i++) { ?>
                  	<?php $c_pic = 'pic'.$i; ?>
                   <tr bgcolor="#DDDDDD" class="t9">
                        <td width="15%" align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">圖檔<?php echo $i; ?>:</td>
                        <td bgcolor="#FFFFFF"><img src="<?php if($row_bar[$c_pic]<>""){ echo "http://www.iwine.com.tw/webimages/bar/".$row_bar[$c_pic];}else{ echo "icon_prev.gif";} ?>" alt="圖片預覽" name="showImg<?php echo $i; ?>" id="showImg<?php echo $i; ?>" onClick='javascript:alert("圖片預覽");'><br>
                      <input name="Submit_pic<?php echo $i; ?>" type="button" class="sform_g" onClick="window.open('fupload_custom.php?useForm=form1&amp;prevImg=showImg<?php echo $i; ?>&amp;upUrl=../../web/webimages/bar&amp;ImgS=&amp;ImgW=&amp;ImgH=&amp;reItem=<?php echo $c_pic; ?>&amp;pathUrl=http://www.iwine.com.tw/webimages/bar','fileUpload','width=500,height=300')" value="重新上傳">
                      <input name="<?php echo $c_pic; ?>" type="text" class="sform" id="<?php echo $c_pic; ?>" value="<?php echo $row_bar[$c_pic]; ?>" size="20"> 
                    </td>
                  </tr>
                  <? } ?>
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td width="15%" align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">上次修改時間:</td>
                    <td bgcolor="#FFFFFF" class="description"><?php echo $row_bar['mod_time']; ?></td>
                  </tr>
                  <tr bgcolor="#F3F3F1">
                  <td colspan="4" align="center"><input name="id" type="hidden" id="id" value="<?php echo $row_bar['id']; ?>">
                    <input name="status2" type="submit" class="sform_g" onClick="tmt_confirm('確定要修改?');return document.MM_returnValue" value="確定修改">
                    <input name="reset" type="reset" class="sform_b" value="重設">
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
mysql_free_result($bar);
?>
