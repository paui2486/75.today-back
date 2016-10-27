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
  $updateSQL = sprintf("UPDATE Wine_section SET n_ws=%s, n_ws_eng=%s, n_type=%s, n_ac=%s, n_capacity=%s, n_winery=%s, n_Variety=%s, n_poo=%s, n_year=%s, n_cuisine=%s, Article=%s, pic1=%s WHERE id=%s",//這裡是後台修改文章的地方記得改變數
                       GetSQLValueString($_POST['n_ws'], "text"),//酒名
					   GetSQLValueString($_POST['n_ws_eng'], "text"),//酒名
					   GetSQLValueString($_POST['n_type'], "text"),//酒名
					   GetSQLValueString($_POST['n_ac'], "text"),//酒名
					   GetSQLValueString($_POST['n_capacity'], "text"),//酒名
					   GetSQLValueString($_POST['n_winery'], "text"),//酒名
                       GetSQLValueString($_POST['n_Variety'], "text"),//價格
					   GetSQLValueString($_POST['n_poo'], "text"),//產地
					   GetSQLValueString($_POST['n_year'], "text"),//年分
					   GetSQLValueString($_POST['n_cuisine'], "text"),//適合料理
					   GetSQLValueString($_POST['Article'], "text"),
                       GetSQLValueString($_POST['pic1'], "text"),//圖
					   //GetSQLValueString($_POST['n_class'], "int"),
                       //GetSQLValueString($_POST['n_name'], "text"),
					   //GetSQLValueString($_POST['n_tag'], "text"),
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
  go_to('wine-section-l.php');
  exit;
}

$colname_news = "-1";
if (isset($_GET['id'])) {// 注意
  $colname_news = $_GET['id'];
}
mysql_select_db($database_iwine, $iwine);// 標題
$query_news = sprintf("SELECT * FROM Wine_section WHERE id = %s", GetSQLValueString($colname_news, "int"));
$news = mysql_query($query_news, $iwine) or die(mysql_error());
$row_news = mysql_fetch_assoc($news);
$totalRows_news = mysql_num_rows($news);

mysql_select_db($database_iwine, $iwine);// 內文
$query_article_class = "SELECT * FROM Wine_section ORDER BY timestamp DESC";
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
        <td height="40" align="center" valign="middle"><span class="capw"><font color="#FFFFFF">◎ 修改酒款內容 ◎</font></span></td>
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
                    <td bgcolor="#FFFFFF"><input name="timestamp" type="text" class="sform" id="n_date" value="<?php echo $row_news['timestamp']; ?>"></td>
                  </tr>
				  <tr bgcolor="#DDDDDD" class="t9">
					<!-- 幹幹幹 沒有ID難怪沒辦法修改 以後修改記得要有ID 沒有ID誰知道改誰啊-->  
					<input name="id" type="hidden" id="id" value="<?php echo $row_news['id']; ?>"></td>
					<!---->  
                  </tr>
            <tr bgcolor="#DDDDDD" class="t9">

                  <tr bgcolor="#DDDDDD" class="t9">
                    <td align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">酒名(中文):</td>
                    <td bgcolor="#FFFFFF"><input name="n_ws" type="text" class="sform" id="n_ws" value="<?php echo $row_news['n_ws']; ?>" size="50"></td>
                  </tr>
				  
				  <tr bgcolor="#DDDDDD" class="t9">
                    <td align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">酒名(英文):</td>
                    <td bgcolor="#FFFFFF"><input name="n_ws_eng" type="text" class="sform" id="n_ws_eng" value="<?php echo $row_news['n_ws_eng']; ?>" size="50"></td>
                  </tr>
				  <tr bgcolor="#DDDDDD" class="t9">
                    <td align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">酒款類型:</td>
                    <td bgcolor="#FFFFFF"><input name="n_type" type="text" class="sform" id="n_type" value="<?php echo $row_news['n_type']; ?>" size="50"></td>
                  </tr>
				  <tr bgcolor="#DDDDDD" class="t9">
                    <td align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">酒精濃度:</td>
                    <td bgcolor="#FFFFFF"><input name="n_ac" type="text" class="sform" id="n_ac" value="<?php echo $row_news['n_ac']; ?>" size="50"></td>
                  </tr>
				  <tr bgcolor="#DDDDDD" class="t9">
                    <td align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">容量:</td>
                    <td bgcolor="#FFFFFF"><input name="n_capacity" type="text" class="sform" id="n_capacity" value="<?php echo $row_news['n_capacity']; ?>" size="50"></td>
                  </tr>
				  <tr bgcolor="#DDDDDD" class="t9">
                    <td align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">酒莊:</td>
                    <td bgcolor="#FFFFFF"><input name="n_winery" type="text" class="sform" id="n_winery" value="<?php echo $row_news['n_winery']; ?>" size="50"></td>
                  </tr>
				  
				  <tr bgcolor="#DDDDDD" class="t9">
                    <td align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">價格:</td>
                    <td bgcolor="#FFFFFF"><input name="n_Variety" type="text" class="sform" id="n_Variety" value="<?php echo $row_news['n_Variety']; ?>" size="50"></td>
                  </tr>
				  <tr bgcolor="#DDDDDD" class="t9">
                    <td align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">原產地:</td>
                    <td bgcolor="#FFFFFF"><input name="n_poo" type="text" class="sform" id="n_poo" value="<?php echo $row_news['n_poo']; ?>" size="50"></td>
                  </tr>
				  <tr bgcolor="#DDDDDD" class="t9">
                    <td align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">年分:</td>
                    <td bgcolor="#FFFFFF"><input name="n_year" type="text" class="sform" id="n_year" value="<?php echo $row_news['n_year']; ?>" size="50"></td>
                  </tr>
				  <tr bgcolor="#DDDDDD" class="t9">
                    <td align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">適合料理:</td>
                    <td bgcolor="#FFFFFF"><input name="n_cuisine" type="text" class="sform" id="n_cuisine" value="<?php echo $row_news['n_cuisine']; ?>" size="50"></td>
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
                    <td bgcolor="#FFFFFF">&nbsp;<img src="<?php if($row_news['pic1']<>""){//重要當前後台的圖處於不同檔案夾且圖名相同時可以用這招

					$url = 'http://www.iwine.com.tw/webimages/symposium/'.$row_news['pic1'].'';//原始圖位置
						if(@fopen($url, 'r')) {
						echo "http://www.iwine.com.tw/webimages/symposium/".$row_news['pic1'];//原始圖位置 前台資料夾
						} else {
						echo "http://admin.iwine.com.tw/webimages/symposium/".$row_news['pic1'];//修改圖位置 後台資料夾
						}

					}else{ echo "icon_prev.gif";} ?>" alt="圖片預覽" name="showImg" id="showImg" onClick='javascript:alert("圖片預覽");'><br>
                      <input name="Submit" type="button" class="sform_g" onClick="window.open('fupload_custom.php?useForm=form1&amp;prevImg=showImg&amp;upUrl=../webimages/symposium&amp;ImgS=&amp;ImgW=&amp;ImgH=&amp;reItem=pic1','fileUpload','width=500,height=300')" value="重新上傳">
                      <?php////
					  
					  ?>
					  <!--<input name="Submit" type="button" class="sform_g" onClick="window.open('fupload_custom.php?useForm=form1&amp;prevImg=showImg&amp;upUrl=../webimages/symposium&amp;ImgS=&amp;ImgW=&amp;ImgH=&amp;reItem=pic1','fileUpload','width=500,height=300')" value="重新上傳">-->
					  <input name="pic1" type="text" class="sform" id="pic1" value="<?php echo $row_news['pic1']; ?>" size="20">
                      (欄位留白可刪除圖片)</td>
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
mysql_free_result($news);

mysql_free_result($article_class);
?>
