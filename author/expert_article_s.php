<?php require_once('session_check_expert.php'); ?>
<?php require_once('Connections/lovelove.php'); ?>
<?php require_once('Connections/iwine.php'); ?>
<?php require_once('func/func.php'); 

if (!function_exists("GetSQLValueString")) {
    function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") {
        if (PHP_VERSION < 6) { $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue; }
        $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);
        switch ($theType) {
            case "text": $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL"; break;    
            case "long":
            case "int": $theValue = ($theValue != "") ? intval($theValue) : "NULL"; break;
            case "double": $theValue = ($theValue != "") ? doubleval($theValue) : "NULL"; break;
            case "date": $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL"; break;
            case "defined": $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue; break;
        }
    return $theValue;
    }
}


$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}
$colname_news = "-1";
if (isset($_GET['n_id'])) {
  $colname_news = $_GET['n_id'];
}
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE expert_article SET n_title=%s, expert=%s, n_date=%s, n_cont=%s, n_fig1=%s, n_status=%s, n_socialnum=%s WHERE n_id=%s",
                       GetSQLValueString($_POST['n_title'], "text"),
					   GetSQLValueString($_SESSION['EXPERT_ID'], "int"),
                       GetSQLValueString($_POST['n_date'], "date"),
                       GetSQLValueString($_POST['n_cont'], "text"),
                       GetSQLValueString($_POST['rePic'], "text"),
                       GetSQLValueString($_POST['n_status'], "text"),
					   GetSQLValueString($_POST['n_socialnum'], "int"),
                       GetSQLValueString($colname_news, "int"));
    // echo $updateSQL;
  mysql_select_db($database_iwine, $iwine);
  $Result1 = mysql_query($updateSQL, $iwine) or die(mysql_error());
  
  msg_box('修改成功');
  go_to('expert_article_l.php');
  exit;
}


mysql_select_db($database_iwine, $iwine);
$query_news = sprintf("SELECT * FROM expert_article WHERE n_id = %s", GetSQLValueString($colname_news, "int"));
$news = mysql_query($query_news, $iwine) or die(mysql_error());
$row_news = mysql_fetch_assoc($news);
$totalRows_news = mysql_num_rows($news);

mysql_select_db($database_iwine, $iwine);
$query_expert = "SELECT * FROM expert ORDER BY e_order ASC";
$expert = mysql_query($query_expert, $iwine) or die(mysql_error());
$row_expert = mysql_fetch_assoc($expert);
$totalRows_expert = mysql_num_rows($expert);
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
<script type="text/javascript">
function tmt_confirm(msg){
	document.MM_returnValue=(confirm(unescape(msg)));
}
</script>

</head>

<body marginheight="0" marginwidth="0" bgcolor="#666666">
<?php include('menu.php'); ?>
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td align="center" valign="top" bgcolor="666666"><table width="100%" height="605" border="0" align="center" cellpadding="0" cellspacing="8">
      <tr>
        <td height="2" bgcolor="#FFFFFF"></td>
        </tr>
      <tr>
        <td height="40" align="center" valign="middle"><span class="capw"><font color="#FFFFFF">◎ 修改達人文章內容 ◎</font></span></td>
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
            <td><form action="<?php echo $editFormAction; ?>" name="form1" method="POST" enctype="multipart/form-data">
              <div align="center">
                <table width="100%" border="0" cellpadding="5" cellspacing="1" class="table">
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td width="80" align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">日期:</td>
                    <td bgcolor="#FFFFFF"><input name="n_date" type="text" class="sform" id="n_date" value="<?php echo $row_news['n_date']; ?>"></td>
                  </tr>
                  
                  <script type="text/javascript">
// BeginWebWidget jQuery_UI_Calendar: sdate1
jQuery("#n_date").datepick({dateFormat: 'yy-mm-dd'});
// EndWebWidget jQuery_UI_Calendar: sdate1
                          </script>
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">標題:</td>
                    <td bgcolor="#FFFFFF"><input name="n_title" type="text" class="sform" id="n_title" value="<?php echo $row_news['n_title']; ?>" size="50"></td>
                  </tr>
                  <!--tr bgcolor="#DDDDDD" class="t9">
                    <td align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">Meta Description:</td>
                    <td bgcolor="#FFFFFF"><input name="n_description" type="text" class="sform" id="n_description" size="80" value="<?php echo $row_news['n_description']; ?>"><span class="text_cap">*中文 75 字</span></td>
                  </tr>
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">Meta KeyWord:</td>
                    <td bgcolor="#FFFFFF"><input name="n_keyword" type="text" class="sform" id="n_keyword" size="80" value="<?php echo $row_news['n_keyword']; ?>"><span class="text_cap">*請用半形,區隔</span></td>
                  </tr-->     
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">FB 與G plus 分享時顯示數字:</td>
                    <td bgcolor="#FFFFFF" class="text_cap"><input <?php if (!(strcmp($row_news['n_socialnum'],"1"))) {echo "checked=\"checked\"";} ?> name="n_socialnum" type="radio" id="n_socialnum1" value="1">
                      <label for="n_socialnum">是，顯示分享數
                        <input <?php if (!(strcmp($row_news['n_socialnum'],"0"))) {echo "checked=\"checked\"";} ?> type="radio" name="n_socialnum" id="n_socialnum2" value="0">
                        否，單純分享功能</label></td>
                  </tr>
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td width="15%" align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">內容:</td>
                    <td bgcolor="#FFFFFF"><textarea name="n_cont" id="n_cont" cols="60" rows="10" class="ckeditor"><?php echo $row_news['n_cont']; ?></textarea></td>
                  </tr>
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">主圖檔:</td>
                    <td bgcolor="#FFFFFF">&nbsp;<img src="<?php if($row_news['n_fig1']<>""){ echo "../webimages/article/".$row_news['n_fig1'];}else{ echo "icon_prev.gif";} ?>" alt="圖片預覽" name="showImg" id="showImg" onClick='javascript:alert("圖片預覽");'><br>
                      <input name="Submit" type="button" class="sform_g" onClick="window.open('fupload.php?useForm=form1&amp;prevImg=showImg&amp;upUrl=../webimages/article&amp;ImgS=&amp;ImgW=&amp;ImgH=&amp;reItem=rePic','fileUpload','width=500,height=300')" value="重新上傳">
                      <input name="rePic" type="text" class="sform" id="rePic" value="<?php echo $row_news['n_fig1']; ?>" size="20">
                      (欄位留白可刪除圖片)</td>
                  </tr>
                  <!--tr bgcolor="#DDDDDD" class="t9">
                    <td align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">標記:</td>
                    <td bgcolor="#FFFFFF"><input name="n_tag" type="text" class="sform" id="n_tag" value="<?php echo $row_news['n_tag']; ?>" size="40">
                      <span class="text_cap">（請以半型逗點區分每個標記文字）</span></td>
                  </tr-->
                  <!--tr bgcolor="#DDDDDD" class="t9">
                    <td align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">排序:</td>
                    <td bgcolor="#FFFFFF"><label for="n_order"></label>
                      <input name="n_order" type="text" class="sform" id="n_order" value="<?php echo $row_news['n_order']; ?>" size="5">
(數字越小排序愈前)
<input name="n_id" type="hidden" id="n_id" value="<?php echo $row_news['n_id']; ?>"></td>
                  </tr-->
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td width="20%" align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">瀏覽數:</td>
                    <td width="386" bgcolor="#FFFFFF">
                        <!--input name="view_counter" type="number" class="sform" min="0" id="view_counter" value="<?php echo $row_news['view_counter']; ?>" size="80"-->
                        <?php echo $row_news['view_counter']; ?>
                    </td>
                  </tr>
                            
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">顯示:</td>
                    <td bgcolor="#FFFFFF" class="text_cap"><input <?php if (!(strcmp($row_news['n_status'],"Y"))) {echo "checked=\"checked\"";} ?> name="n_status" type="radio" id="n_status" value="Y">
                      <label for="n_status">正式發布
                        <input <?php if (!(strcmp($row_news['n_status'],"N"))) {echo "checked=\"checked\"";} ?> type="radio" name="n_status" id="n_status2" value="N">
                        暫存草稿</label></td>
                  </tr>
                  <!--tr bgcolor="#DDDDDD" class="t9">
                    <td width="80" align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">熱門文章:</td>
                    <td width="80" bgcolor="#FFFFFF" class="text_cap"><input <?php if (!(strcmp($row_news['n_hot'],"Y"))) {echo "checked=\"checked\"";} ?> name="n_hot" type="radio" id="n_status3" value="Y">
                      <label for="n_status3">是
                        <input <?php if (!(strcmp($row_news['n_hot'],"N"))) {echo "checked=\"checked\"";} ?> type="radio" name="n_hot" id="n_status4" value="N">
                        否</label></td>
                  </tr-->
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

mysql_free_result($expert);
?>
