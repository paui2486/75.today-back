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
  $insertSQL = sprintf("INSERT INTO expert_article (expert, n_title, n_date, n_cont, n_fig1, n_order,view_counter, n_status, n_tag,n_description, n_keyword,n_socialnum, n_hot) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s,%s)",
                       GetSQLValueString($_POST['expert'], "int"),
                       GetSQLValueString($_POST['n_title'], "text"),
                       GetSQLValueString($_POST['n_date'], "date"),
                       GetSQLValueString($_POST['n_cont'], "text"),
                       GetSQLValueString($_POST['rePic'], "text"),
                       GetSQLValueString($_POST['n_order'], "int"),
                       GetSQLValueString($_POST['view_counter'], "int"),
                       GetSQLValueString($_POST['n_status'], "text"),
                       GetSQLValueString($_POST['n_tag'], "text"),
                       GetSQLValueString($_POST['n_description'], "text"),
                       GetSQLValueString($_POST['n_keyword'], "text"),
                       GetSQLValueString($_POST['n_socialnum'], "int"),
                       GetSQLValueString($_POST['n_hot'], "text"));

  mysql_select_db($database_iwine, $iwine);
  $Result1 = mysql_query($insertSQL, $iwine) or die(mysql_error());
  $_new_id = mysql_insert_id();
  
      require_once("../PHPMailer/class.phpmailer.php");
    $mail_body = '<div style="font-family: "微軟正黑體"; font-size: 10px; line-height: 18px; color: #666;">
<p>Hi </p>
<p>iWine 新增了達人文章<a href="http://www.iwine.com.tw/expert_article.php?n_id='.$_new_id.'"><b>'.$_POST['n_title'].'</b></a><br />
點<a href="http://www.iwine.com.tw/expert_article.php?n_id='.$_new_id.'">這邊</a>就可以看到了。</p>
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
    $mail->SetFrom('service@iwine.com.tw',"iWine Service");
    // $mail->AddAddress("draqyang@coevo.com.tw");
    $mail->AddAddress("all@iwine.com.tw");
    $mail->Subject    = "[iWine 達人文章上架通知]".$_POST['n_title']." ".$now_time;
    $mail->AltBody    = "請使用可支援HTML格式的讀信軟體!"; // optional, comment out and test
    $mail->MsgHTML($mail_body);
    $mail->CharSet="utf-8";
    $mail->Encoding = "base64";
    //設置郵件格式為HTML
    $mail->IsHTML(true);
    $mail->Send();

  
  msg_box('新增達人文章內容成功！');
  go_to('expert_article_l.php');
  exit;
}

mysql_select_db($database_iwine, $iwine);
$query_expert = "SELECT * FROM expert ORDER BY e_order ASC";
$expert = mysql_query($query_expert, $iwine) or die(mysql_error());
$row_expert = mysql_fetch_assoc($expert);
$totalRows_expert = mysql_num_rows($expert);

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
        <td height="40" align="center" valign="middle"><span class="capw"><font color="#FFFFFF">◎ 新增達人系列文章內容 ◎</font></span></td>
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
                    <td bgcolor="#FFFFFF"><input name="n_date" type="text" class="sform" id="n_date" value="請輸入日期"></td>
                  </tr>
                  <script type="text/javascript">
// BeginWebWidget jQuery_UI_Calendar: sdate1
jQuery("#n_date").datepick({dateFormat: 'yy-mm-dd'});
// EndWebWidget jQuery_UI_Calendar: sdate1
                          </script>
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">達人:</td>
                    <td bgcolor="#FFFFFF"><select name="expert" class="sform" id="expert">
                      <option value="0">請選擇發表達人</option>
                      <?php
do {
?>
                      <option value="<?php echo $row_expert['id']?>"><?php echo $row_expert['name']?></option>
                      <?php
} while ($row_expert = mysql_fetch_assoc($expert));
  $rows = mysql_num_rows($expert);
  if($rows > 0) {
      mysql_data_seek($expert, 0);
      $row_expert = mysql_fetch_assoc($expert);
  }
?>
                    </select></td>
                  </tr>
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">標題:</td>
                    <td bgcolor="#FFFFFF"><input name="n_title" type="text" class="sform" id="n_title" size="50"></td>
                  </tr>
                    <tr bgcolor="#DDDDDD" class="t9">
                    <td align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">Meta Description:</td>
                    <td bgcolor="#FFFFFF"><input name="n_description" type="text" class="sform" id="n_description" size="80"><span class="text_cap">*中文 75 字</span></td>
                  </tr>
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">Meta KeyWord:</td>
                    <td bgcolor="#FFFFFF"><input name="n_keyword" type="text" class="sform" id="n_keyword" size="80"><span class="text_cap">*請用半形,區隔</span></td>
                  </tr>
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">分享時顯示數字:</td>
                    <td bgcolor="#FFFFFF" class="text_cap"><input name="n_socialnum" type="radio" id="n_socialnum1" value="1" checked>
                      <label for="n_hot">是
                        <input type="radio" name="n_socialnum" id="n_socialnum0" value="0">
                      否</label></td>
                  </tr>
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td width="15%" align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">內容:</td>
                    <td bgcolor="#FFFFFF"><textarea name="n_cont" id="n_cont" cols="60" rows="25" class="ckeditor"></textarea></td>
                  </tr>
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">主圖檔:</td>
                    <td bgcolor="#FFFFFF">&nbsp;<img src="icon_prev.gif" alt="圖片預覽" name="showImg" id="showImg" onClick='javascript:alert("圖片預覽");'>
                      <input name="Submit" type="button" class="sform_g" onClick="window.open('fupload.php?useForm=form1&amp;prevImg=showImg&amp;upUrl=../webimages/article&amp;ImgS=&amp;ImgW=&amp;ImgH=&amp;reItem=rePic','fileUpload','width=500,height=300')" value="準備上傳">
                      <input name="rePic" type="hidden" id="rePic" size="4"></td>
                  </tr>
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">標記:</td>
                    <td bgcolor="#FFFFFF"><input name="n_tag" type="text" class="sform" id="n_tag" size="40">
                      <span class="text_cap">（請以半型逗點區分每個標記文字）</span></td>
                  </tr>
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">排序:</td>
                    <td bgcolor="#FFFFFF" class="text_cap"><input name="n_order" type="text" class="sform" id="n_order" size="5">
                      (數字越小排序愈前)</td>
                  </tr>
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td width="20%" align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">瀏覽數:</td>
                    <td width="386" bgcolor="#FFFFFF"><input name="view_counter" type="number" class="sform" min="0" id="view_counter" value="" size="80"></td>
                    </tr>
                    
                  </tr>
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">顯示:</td>
                    <td bgcolor="#FFFFFF" class="text_cap"><input name="n_status" type="radio" id="n_status" value="Y" checked>
                      <label for="n_hot">是
                        <input type="radio" name="n_status" id="n_status2" value="N">
                      否</label></td>
                  </tr>
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">熱門文章:</td>
                    <td bgcolor="#FFFFFF" class="text_cap"><input name="n_hot" type="radio" id="n_status3" value="Y" checked>
                      <label for="n_status3">是
                        <input type="radio" name="n_hot" id="n_status4" value="N">
                        否</label></td>
                  </tr>
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
mysql_free_result($expert);
?>
