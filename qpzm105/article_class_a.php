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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO article_class (pc_name, pc_order, pc_online, pc_description, pc_keyword,pc_banner1,pc_banner1_url,pc_banner2,pc_banner2_url,pc_banner3,pc_banner3_url,pc_banner4,pc_banner4_url,pc_banner5,pc_banner5_url ) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['pc_name'], "text"),
                       GetSQLValueString($_POST['pc_order'], "int"),
                       GetSQLValueString($_POST['pc_online'], "text"),
                       GetSQLValueString($_POST['pc_description'], "text"),
                       GetSQLValueString($_POST['pc_keyword'], "text"),
                       GetSQLValueString($_POST['pc_banner1'], "text"),
                       GetSQLValueString($_POST['pc_banner1_url'], "text"),
                       GetSQLValueString($_POST['pc_banner2'], "text"),
                       GetSQLValueString($_POST['pc_banner2_url'], "text"),
                       GetSQLValueString($_POST['pc_banner3'], "text"),
                       GetSQLValueString($_POST['pc_banner3_url'], "text"),
                       GetSQLValueString($_POST['pc_banner4'], "text"),
                       GetSQLValueString($_POST['pc_banner4_url'], "text"),
                       GetSQLValueString($_POST['pc_banner5'], "text"),
                       GetSQLValueString($_POST['pc_banner5_url'], "text"));

  mysql_select_db($database_iwine, $iwine);
  $Result1 = mysql_query($insertSQL, $iwine) or die(mysql_error());
  
  msg_box('新增文章分類成功！');
  go_to('article_class_l.php');
  exit;
}
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
        <td height="40" align="center" valign="middle"><span class="capw"><font color="#FFFFFF">◎ 新增文章分類 ◎</font></span></td>
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
                    <td width="20%" align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">分類名稱:</td>
                    <td width="386" bgcolor="#FFFFFF"><input name="pc_name" type="text" class="sform" id="pc_name" size="80"></td>
                    </tr>
                    <tr bgcolor="#DDDDDD" class="t9">
                    <td align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">Meta Description:</td>
                    <td bgcolor="#FFFFFF"><input name="pc_description" type="text" class="sform" id="pc_description" size="80"><span class="text_cap">*中文 75 字</span></td>
                  </tr>
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">Meta KeyWord:</td>
                    <td bgcolor="#FFFFFF"><input name="pc_keyword" type="text" class="sform" id="pc_keyword" size="80"><span class="text_cap">*請用半形,區隔</span></td>
                  </tr>
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">排序:</td>
                    <td bgcolor="#FFFFFF"><input name="pc_order" type="text" class="sform" id="pc_order" size="5"></td>
                  </tr>
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">顯示與否：</td>
                    <td bgcolor="#FFFFFF" class="text_cap"><input name="pc_online" type="radio" id="radio" value="Y" checked="CHECKED">
                      是 
                      <input type="radio" name="pc_online" id="radio2" value="N">
                      否</td>
                  </tr>
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">文章分類主視覺:</td>
                    <td bgcolor="#FFFFFF">&nbsp;<img src="icon_prev.gif" alt="圖片預覽" name="showImg1" id="showImg1" onClick='javascript:alert("圖片預覽");'>
                      <input name="Submit" type="button" class="sform_g" onClick="window.open('fupload.php?useForm=form1&amp;prevImg=showImg1&amp;upUrl=../webimages/article&amp;ImgS=&amp;ImgW=&amp;ImgH=&amp;reItem=pc_banner1','fileUpload','width=500,height=300')" value="準備上傳">
                      <input name="pc_banner1" type="hidden" id="pc_banner1" size="4"></td>
                  </tr>
                  <!--tr bgcolor="#DDDDDD" class="t9">
                    <td width="20%" align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">banner 1 連結:</td>
                    <td width="386" bgcolor="#FFFFFF"><input name="pc_banner1_url" type="text" class="sform" id="pc_banner1_url" size="80"></td>
                    </tr>
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">文章分類 banner 2:</td>
                    <td bgcolor="#FFFFFF">&nbsp;<img src="icon_prev.gif" alt="圖片預覽" name="showImg2" id="showImg2" onClick='javascript:alert("圖片預覽");'>
                      <input name="Submit" type="button" class="sform_g" onClick="window.open('fupload.php?useForm=form1&amp;prevImg=showImg2&amp;upUrl=../webimages/article&amp;ImgS=&amp;ImgW=&amp;ImgH=&amp;reItem=pc_banner2','fileUpload','width=500,height=300')" value="準備上傳">
                      <input name="pc_banner2" type="hidden" id="pc_banner2" size="4"></td>
                  </tr>
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td width="20%" align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">banner 2 連結:</td>
                    <td width="386" bgcolor="#FFFFFF"><input name="pc_banner2_url" type="text" class="sform" id="pc_banner2_url" size="80"></td>
                    </tr>
                 <tr bgcolor="#DDDDDD" class="t9">
                    <td align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">文章分類 banner 3:</td>
                    <td bgcolor="#FFFFFF">&nbsp;<img src="icon_prev.gif" alt="圖片預覽" name="showImg3" id="showImg3" onClick='javascript:alert("圖片預覽");'>
                      <input name="Submit" type="button" class="sform_g" onClick="window.open('fupload.php?useForm=form1&amp;prevImg=showImg3&amp;upUrl=../webimages/article&amp;ImgS=&amp;ImgW=&amp;ImgH=&amp;reItem=pc_banner3','fileUpload','width=500,height=300')" value="準備上傳">
                      <input name="pc_banner3" type="hidden" id="pc_banner3" size="4"></td>
                  </tr>
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td width="20%" align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">banner 3 連結:</td>
                    <td width="386" bgcolor="#FFFFFF"><input name="pc_banner3_url" type="text" class="sform" id="pc_banner3_url" size="80"></td>
                    </tr>
                   <tr bgcolor="#DDDDDD" class="t9">
                    <td align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">文章分類 banner 4:</td>
                    <td bgcolor="#FFFFFF">&nbsp;<img src="icon_prev.gif" alt="圖片預覽" name="showImg4" id="showImg4" onClick='javascript:alert("圖片預覽");'>
                      <input name="Submit" type="button" class="sform_g" onClick="window.open('fupload.php?useForm=form1&amp;prevImg=showImg4&amp;upUrl=../webimages/article&amp;ImgS=&amp;ImgW=&amp;ImgH=&amp;reItem=pc_banner4','fileUpload','width=500,height=300')" value="準備上傳">
                      <input name="pc_banner4" type="hidden" id="pc_banner4" size="4"></td>
                  </tr>
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td width="20%" align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">banner 4 連結:</td>
                    <td width="386" bgcolor="#FFFFFF"><input name="pc_banner4_url" type="text" class="sform" id="pc_banner4_url" size="80"></td>
                    </tr>
                 <tr bgcolor="#DDDDDD" class="t9">
                    <td align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">文章分類 banner 5:</td>
                    <td bgcolor="#FFFFFF">&nbsp;<img src="icon_prev.gif" alt="圖片預覽" name="showImg5" id="showImg5" onClick='javascript:alert("圖片預覽");'>
                      <input name="Submit" type="button" class="sform_g" onClick="window.open('fupload.php?useForm=form1&amp;prevImg=showImg5&amp;upUrl=../webimages/article&amp;ImgS=&amp;ImgW=&amp;ImgH=&amp;reItem=pc_banner5','fileUpload','width=500,height=300')" value="準備上傳">
                      <input name="pc_banner5" type="hidden" id="pc_banner5" size="4"></td>
                  </tr>
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td width="20%" align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">banner 5 連結:</td>
                    <td width="386" bgcolor="#FFFFFF"><input name="pc_banner5_url" type="text" class="sform" id="pc_banner5_url" size="80"></td>
                    </tr-->
                  <tr bgcolor="#F3F3F1" class="t9">
                    <td colspan="2" align="right"><input name="status2" type="submit" class="sform_b" onClick="tmt_confirm('確定要新增?');return document.MM_returnValue" value="新增">
                      <input name="Reset" type="reset" class="sform_b" id="Reset2" value="重設">
                      <input name="button" type="button" class="sform_b" id="button" onClick="history.back()" value="回上頁"></td>
                  </tr>
                  </table>
                </div>
              <input type="hidden" name="MM_insert" value="form1">
            </form></td>
            </tr>
          </table></td>
      </tr>
    </table></td>
  </tr>
</table>
</body>
</html>
