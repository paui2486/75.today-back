<?php include('session_check.php'); ?>
<?php require_once('../Connections/iwine.php'); ?>
<?php require_once('../Connections/iwine_shop.php'); ?>
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
  $updateSQL = sprintf("UPDATE vedio SET title=%s, Article=%s, pic1=%s, pic2=%s, tag=%s, meta=%s, vedio_src=%s WHERE id=%s",
                       GetSQLValueString($_POST['title'], "text"),//標頭
                       //GetSQLValueString($_POST['creat_time'], "date"),//時間
                       GetSQLValueString($_POST['Article'], "text"),//內文
                       GetSQLValueString($_POST['pic1'], "text"),//圖
					   GetSQLValueString($_POST['pic2'], "text"),//圖2
					   GetSQLValueString($_POST['tag'], "text"),//標籤
					   GetSQLValueString($_POST['meta'], "text"),//
					   GetSQLValueString($_POST['vedio_src'], "text"),//連結真網址
                       //GetSQLValueString($_POST['n_order'], "int"),
                       //GetSQLValueString($_POST['n_status'], "text"),
					   //GetSQLValueString($_POST['n_hot'], "text"),
					   //GetSQLValueString($_POST['n_description'], "text"),
					   //GetSQLValueString($_POST['n_keyword'], "text"),
					   //GetSQLValueString($_POST['view_counter'], "int"),
					   //GetSQLValueString($_POST['n_socialnum'], "int"),
                       GetSQLValueString($_POST['id'], "int"));

  mysql_select_db($database_iwine, $iwine);
  $Result1 = mysql_query($updateSQL, $iwine) or die(mysql_error());
  
  msg_box('修改文章內容成功');
  go_to('Vedio-l.php');
  exit;
}

$colname_news = "-1";
if (isset($_GET['id'])) {// 注意
  $colname_news = $_GET['id'];
}
mysql_select_db($database_iwine, $iwine);// 標題
$query_news = sprintf("SELECT * FROM vedio WHERE id = %s", GetSQLValueString($colname_news, "int"));
$news = mysql_query($query_news, $iwine) or die(mysql_error());
$row_news = mysql_fetch_assoc($news);
$totalRows_news = mysql_num_rows($news);

mysql_select_db($database_iwine, $iwine);// 內文
$query_article_class = "SELECT * FROM vedio ORDER BY creat_time DESC";
$article_class = mysql_query($query_article_class, $iwine) or die(mysql_error());
$row_article_class = mysql_fetch_assoc($article_class);
$totalRows_article_class = mysql_num_rows($article_class);
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
<script src="ckfinder/ckfinder.js"></script>
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
        <td height="40" align="center" valign="middle"><span class="capw"><font color="#FFFFFF">◎ 修改影片文章內容 ◎</font></span></td>
        </tr>
      <tr>
        <td height="2" bgcolor="#FFFFFF"></td>
        </tr>
      <tr>
        <td align="center"></td>
        </tr>
      <tr>
        <td align="center" valign="top"><table width="98%" border="0" cellpadding="3" cellspacing="0" bgcolor="494949">
          <tr>
            <td><form action="<?php echo $editFormAction; ?>" name="form1" method="POST">
              <div align="center">
                <table width="100%" border="0" cellpadding="5" cellspacing="1" class="table">
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td width="80" align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">日期:</td>
                    <td bgcolor="#FFFFFF"><input name="creat_time" type="text" class="sform" id="n_date" value="<?php echo $row_news['creat_time']; ?>"></td>
                  </tr>
                  <tr bgcolor="#DDDDDD" class="t9">
					<!-- 幹幹幹 沒有ID難怪沒辦法修改 以後修改記得要有ID 沒有ID誰知道改誰啊-->  
					<input name="id" type="hidden" id="id" value="<?php echo $row_news['id']; ?>"></td>
					<!---->  
                  </tr>
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">標題:</td>
                    <td bgcolor="#FFFFFF"><input name="title" type="text" class="sform" id="title" value="<?php echo $row_news['title']; ?>" size="50"></td>
                  </tr>
					
				  
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td width="15%" align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">內容:</td>
                    <td bgcolor="#FFFFFF"><textarea name="Article" id="Article" cols="60" rows="10" class="ckeditor"><?php echo $row_news['Article']; ?></textarea>
					
						<script>
						CKEDITOR.replace( 'Article', {
filebrowserBrowseUrl : 'ckfinder/ckfinder.html',
filebrowserImageBrowseUrl : 'ckfinder/ckfinder.html?Type=Images',
filebrowserFlashBrowseUrl : 'ckfinder/ckfinder.html?Type=Flash',
filebrowserUploadUrl : 'ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
filebrowserImageUploadUrl : 'ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
filebrowserFlashUploadUrl : 'ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash'
						});
						</script>
					
					</td>
                  </tr>
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">主圖檔:</td>
                    <td bgcolor="#FFFFFF">
										  &nbsp;<img src="<?php if($row_news['pic1']<>""){ echo "http://admin.iwine.com.tw/webimages/symposium/".$row_news['pic1'];}else{echo "icon_prev.gif";} ?>" alt="圖片預覽" name="showImg" id="showImg" onClick='javascript:alert("圖片預覽");'><br>	
					<input name="Submit" type="button" class="sform_g" onClick="window.open('fupload_custom.php?useForm=form1&amp;prevImg=showImg&amp;upUrl=../webimages/symposium&amp;ImgS=&amp;ImgW=&amp;ImgH=&amp;reItem=pic1','fileUpload','width=500,height=300')" value="重新上傳">
                      <input name="pic1" type="text" class="sform" id="pic1" value="<?php echo $row_news['pic1']; ?>" size="20">
                      (欄位留白可刪除圖片)</td>
                  </tr>
				  <!--<tr bgcolor="#DDDDDD" class="t9">
                    <td align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">主圖檔2:</td>
                    <td bgcolor="#FFFFFF">&nbsp;<img src="<?php //if($row_news['pic2']<>""){ echo "http://www.iwine.com.tw/webimages/symposium/".$row_news['pic2'];}else{ echo "icon_prev.gif";} ?>" alt="圖片預覽" name="showImg" id="showImg" onClick='javascript:alert("圖片預覽");'><br>
                      <input name="Submit" type="button" class="sform_g" onClick="window.open('fupload.php?useForm=form1&amp;prevImg=showImg&amp;upUrl=../webimages/article&amp;ImgS=&amp;ImgW=&amp;ImgH=&amp;reItem=rePic','fileUpload','width=500,height=300')" value="重新上傳">
                      <input name="pic2" type="text" class="sform" id="rePic" value="<?php// echo $row_news['pic2']; ?>" size="20">
                      (欄位留白可刪除圖片)</td>
                  </tr>-->
                  <!--<tr bgcolor="#DDDDDD" class="t9">
                    <td align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">標籤:</td>
                    <td bgcolor="#FFFFFF"><input name="tag" type="text" class="sform" id="n_title" value="<?php// echo $row_news['tag']; ?>" size="50"></td>
                  </tr>-->
				  <!--<tr bgcolor="#DDDDDD" class="t9">
                    <td align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">meta:</td>
                    <td bgcolor="#FFFFFF"><input name="meta" type="text" class="sform" id="n_title" value="<?php// echo $row_news['meta']; ?>" size="50"></td>
                  </tr>-->
				
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
mysql_free_result($news);

mysql_free_result($article_class);
?>
