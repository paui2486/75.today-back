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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO vedio (title, n_name, Article, pic1, tag,meta,vedio_src) VALUES (%s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['title'], "text"),
                       GetSQLValueString($_POST['n_name'], "text"),
                       GetSQLValueString($_POST['n_cont'], "text"),
                       GetSQLValueString($_POST['rePic'], "text"),
                       GetSQLValueString($_POST['tag'], "text"),
                       GetSQLValueString($_POST['meta'], "text"),
                       GetSQLValueString($_POST['vedio_src'], "text"));//電話
  mysql_select_db($database_iwine, $iwine);
  $Result1 = mysql_query($insertSQL, $iwine) or die(mysql_error());
  $_new_id = mysql_insert_id();

  if($_POST['product_num'] > 0){
    // echo "POST['product_num'] = ".$_POST['product_num']."<br>";
    for($i=1 ; $i<=$_POST['product_num']; $i++){
        if($_POST['p_code'.$i]<>"" || $_POST['p_name'.$i]<>"" ){
            $insert_product = sprintf("INSERT INTO product_article (a_type, a_id, p_code, notinshop) values (%s, %s, %s, %s)", 
                                      GetSQLValueString('article', "text"),
                                      GetSQLValueString($_new_id, "int"),
                                      GetSQLValueString($_POST['p_code'.$i], "text"),
                                      GetSQLValueString($_POST['p_name'.$i], "text"));
            // echo "$i, sql = ".$insert_product."<br>";
            $Result1 = mysql_query($insert_product, $iwine) or die(mysql_error());
        }
    }
  }
  
    require_once("../PHPMailer/class.phpmailer.php");
    $mail_body = '<div style="font-family: "微軟正黑體"; font-size: 10px; line-height: 18px; color: #666;">
<p>Hi </p>
<p>iWine 新增了 影片<a href="http://www.iwine.com.tw/video_view.php?n_id='.$_new_id.'"><b>'.$_POST['n_title'].'</b></a><br />
點<a href="http://www.iwine.com.tw/video_view.php?n_id='.$_new_id.'">這邊</a>就可以看到了。</p>
</div>';
    
    $now_time = date('Y-m-d H:i');
    $mail = new PHPMailer(); // defaults to using php "mail()"
    $mail->IsSMTP(); // telling the class to use SMTP
    // $mail->Host       = "iwine.com.tw"; // SMTP server
    $mail->SMTPDebug  = 1;                     // enables SMTP debug information (for testing)
                                           // 1 = errors and messages
                                           // 2 = messages only
    $mail->SMTPAuth   = true;                  // enable SMTP authentication
    $mail->SMTPSecure = "ssl";
    $mail->Host       = "smtp.gmail.com"; // sets the SMTP server
    $mail->Port       = 465;                    // set the SMTP port for the GMAIL server
    $mail->Username   = "service@iwine.com.tw"; // SMTP account username
    $mail->Password   = "service53118909";        // SMTP account passw

    // $mail->AddReplyTo("service@iwine.com.tw","iWine");
    $mail->SetFrom('admin@iwine.com.tw',"Admin");
    // $mail->AddAddress("draqyang@coevo.com.tw");
    $mail->AddAddress("all@iwine.com.tw");
    $mail->Subject    = "[iWine 文章上架通知]".$_POST['n_title']." ".$now_time;
    $mail->AltBody    = "請使用可支援HTML格式的讀信軟體!"; // optional, comment out and test
    $mail->MsgHTML($mail_body);
    $mail->CharSet="utf-8";
    $mail->Encoding = "base64";
    //設置郵件格式為HTML
    $mail->IsHTML(true);
    $mail->Send();

    msg_box('新增文章內容成功！');
  go_to('Vedio-l.php');
  exit;
}
/*
mysql_select_db($database_iwine, $iwine);
$query_article_class = "SELECT * FROM article_class ORDER BY pc_order ASC";
$article_class = mysql_query($query_article_class, $iwine) or die(mysql_error());
$row_article_class = mysql_fetch_assoc($article_class);
$totalRows_article_class = mysql_num_rows($article_class);
*/
include("ckeditor/ckeditor.php") ;
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
$(document).ready(function(){
    var i = 1;
    $("#add_product" ).click(function() {
        i++;
        var append_html = "<br>商城商品編號<input type=\"text\" name=\"p_code"+i+"\" placeholder=\"w0000001\"> 不在商城的酒名<input type=\"text\" name=\"p_name"+i+"\">";
        // alert(append_html);
        $('#product_select').append(append_html);
        $('#input_times').html("<input type=hidden name=product_num value=\""+i+"\">");
    });
});
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
        <td height="40" align="center" valign="middle"><span class="capw"><font color="#FFFFFF">◎ 新增影片內容 ◎</font></span></td>
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
                    <td align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">標題:</td>
                    <td bgcolor="#FFFFFF"><input name="title" type="text" class="sform" id="title" size="50"></td>
                  </tr>
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">發表者:</td>
                    <td bgcolor="#FFFFFF"><input name="n_name" type="text" class="sform" id="n_name"></td>
                  </tr>
                  <!--<tr bgcolor="#DDDDDD" class="t9">
                    <td align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">meta:</td>
                    <td bgcolor="#FFFFFF"><input name="meta" type="text" class="sform" id="meta" size="80"><span class="text_cap">*中文 75 字</span></td>
                  </tr>
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">tag:</td>
                    <td bgcolor="#FFFFFF"><input name="tag" type="text" class="sform" id="tag" size="80"><span class="text_cap">*請用半形,區隔</span></td>
                  </tr>-->

				  <tr bgcolor="#DDDDDD" class="t9"><!--如要新增項目name id記得改-->
                    <td align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">影片URL:</td>
                    <td bgcolor="#FFFFFF"><input name="vedio_src" type="text" class="sform" id="vedio_src"><span class="text_cap">之後會改成有影片連結自動嵌入</span></td>
                  </tr>
				  
				  
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td width="15%" align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">內容:</td>
                    <td bgcolor="#FFFFFF"><textarea name="n_cont" id="n_cont" cols="60" rows="25" class="ckeditor"></textarea>
					
					<script>
					CKEDITOR.replace( 'n_cont', {
						
filebrowserBrowseUrl : 'ckfinder/ckfinder.html',
filebrowserImageBrowseUrl : 'ckfinder/ckfinder.html?Type=Images',
filebrowserFlashBrowseUrl : 'ckfinder/ckfinder.html?Type=Flash',
filebrowserUploadUrl : 'ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
filebrowserImageUploadUrl : 'ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
filebrowserFlashUploadUrl : 'ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash',
allowedContent : true
					
					//filebrowserBrowseUrl: '/ckfinder/ckfinder.html',
					//filebrowserUploadUrl: '/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files'
					});
					</script>
					
					</td>
                  </tr>
				  
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">主圖檔:</td>
                    <td bgcolor="#FFFFFF">&nbsp;<img src="icon_prev.gif" alt="圖片預覽" name="showImg" id="showImg" onClick='javascript:alert("圖片預覽");'>
                      <input name="Submit" type="button" class="sform_g" onClick="window.open('fupload_custom_FD.php?useForm=form1&amp;prevImg=showImg&amp;upUrl=../webimages/symposium&amp;ImgS=&amp;ImgW=&amp;ImgH=&amp;reItem=rePic','fileUpload','width=500,height=300')" value="準備上傳">
                      <input name="rePic" type="hidden" id="rePic" size="4"></td>
                  </tr>

				  <!--<tr bgcolor="#DDDDDD" class="t9">
                    <td align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">主圖檔2:</td>
                    <td bgcolor="#FFFFFF">&nbsp;<img src="icon_prev.gif" alt="圖片預覽" name="showImg" id="showImg" onClick='javascript:alert("圖片預覽");'>
                      <input name="Submit" type="button" class="sform_g" onClick="window.open('fupload.php?useForm=form1&amp;prevImg=showImg&amp;upUrl=../webimages/article&amp;ImgS=&amp;ImgW=&amp;ImgH=&amp;reItem=rePic2','fileUpload','width=500,height=300')" value="準備上傳">
                      <input name="rePic2" type="hidden" id="rePic2" size="4"></td>
                  </tr>-->

                  
                  
                  <tr bgcolor="#F3F3F1" class="t9">
                    <td colspan="2" align="right"><input name="status2" type="submit" class="sform_b" onClick="tmt_confirm('確定要新增?');return document.MM_returnValue" value="新增">
                      <input name="Reset" type="reset" class="sform_b" id="Reset2" onClick="form1.reset()" value="重設">
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
<?php
mysql_free_result($article_class);
mysql_free_result($product);
?>
