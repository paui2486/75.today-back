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
if (isset($_POST["title"])) {
  // $insertSQL = sprintf("INSERT INTO symposium (title, category, start_date, end_date, location, address, area, fee, host, speaker, wine_list, description, enrollment, active, ishot, creator, pic1, pic2, pic3, pic4, pic5, create_time, seats, order_deadline, speaker_info, contain_html)
                                               // VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       // GetSQLValueString($_POST['title'], "text"),
                       // GetSQLValueString($_POST['category'], "text"),
                       // GetSQLValueString($_POST['start_date'], "date"),
                       // GetSQLValueString($_POST['end_date'], "date"),
                       // GetSQLValueString($_POST['location'], "text"),
                       // GetSQLValueString($_POST['address'], "text"),
                       // GetSQLValueString($_POST['county'], "text"),
                       // GetSQLValueString($_POST['fee'], "int"),
                       // GetSQLValueString($_POST['host'], "text"),
                       // GetSQLValueString($_POST['speaker'], "text"),
                       // GetSQLValueString($_POST['wine_list'], "text"),
                       // GetSQLValueString($_POST['description'], "text"),
                       // GetSQLValueString($_POST['enrollment'], "text"),
                       // GetSQLValueString($_POST['active'], "text"),
                       // GetSQLValueString($_POST['ishot'], "text"),
                       // GetSQLValueString($_SESSION['ADMIN_NAME'], "text"),
                       // GetSQLValueString($_POST['pic1'], "text"),
                       // GetSQLValueString($_POST['pic2'], "text"),
                       // GetSQLValueString($_POST['pic3'], "text"),
                       // GetSQLValueString($_POST['pic4'], "text"),
                       // GetSQLValueString($_POST['pic5'], "text"),
                       // GetSQLValueString($_today, "date"),
                       // GetSQLValueString($_POST['seats'], "int"),
                       // GetSQLValueString($_POST['order_deadline']." 23:59:59", "date"),
                       // GetSQLValueString($_POST['speaker_info'], "text"),
                       // GetSQLValueString($_POST['contain_html'], "text"));
  $insertSQL = sprintf("INSERT INTO symposium (view_counter ,title, start_date, address, area, fee, description, active, creator, pic1, pic2, pic3, pic4, pic5, create_time, contain_html,contacter, contact_email,contact_phone)
                                               VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['view_counter'], "int"),
                       GetSQLValueString($_POST['title'], "text"),
                       GetSQLValueString($_POST['start_date'], "date"),
                       GetSQLValueString($_POST['address'], "text"),
                       GetSQLValueString($_POST['county'], "text"),
                       GetSQLValueString($_POST['fee'], "int"),
                       GetSQLValueString($_POST['description'], "text"),
                       GetSQLValueString($_POST['active'], "text"),
                       GetSQLValueString($_SESSION['ADMIN_NAME'], "text"),
                       GetSQLValueString($_POST['pic1'], "text"),
                       GetSQLValueString($_POST['pic2'], "text"),
                       GetSQLValueString($_POST['pic3'], "text"),
                       GetSQLValueString($_POST['pic4'], "text"),
                       GetSQLValueString($_POST['pic5'], "text"),
                       GetSQLValueString($_today, "date"),
                       GetSQLValueString($_POST['contain_html'], "text"),
                       GetSQLValueString($_POST['contacter'], "text"),
                       GetSQLValueString($_POST['contact_email'], "text"),
                       GetSQLValueString($_POST['contact_phone'], "text"));
  // echo "<font color=red>".$insertSQL."</font>";
  mysql_select_db($database_iwine, $iwine);
  $Result1 = mysql_query($insertSQL, $iwine) or die(mysql_error());

  msg_box('新增品酒會內容成功！');
  go_to('symposium_l.php');
  exit;
}

mysql_select_db($database_iwine, $iwine);

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
<!--script type="text/javascript" src="js/jquery-1.7.2.min.js"></script>
<style type="text/css">@import "js/jquery.datepick.package-3.6.1/jquery.datepick.css";</style>
<script type="text/javascript" src="js/jquery.datepick.package-3.6.1/jquery.datepick.js"></script>
<script type="text/javascript" src="js/jquery.datepick.package-3.6.1/jquery.datepick.pack.js"></script>
<script type="text/javascript" src="js/jquery.datepick.package-3.6.1/jquery.datepick-zh-TW.js"></script-->

<link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.2/themes/hot-sneaks/jquery-ui.css" rel="stylesheet">
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.2/jquery-ui.min.js"></script>
<link href='js/datetimepick/lib/jquery-ui-timepicker-addon.css' rel='stylesheet'>
<script type='text/javascript' src='js/datetimepick/lib/jquery-ui-timepicker-addon.js'></script>
<script type='text/javascript' src='js/datetimepick/lib/jquery-ui-sliderAccess.js'></script>
<script type='text/javascript' src='js/datetimepick/jquery-ui-timepicker-zh-TW.js'></script>
<script src="../js/twzipcode-1.4.1.js"></script>
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
        <td height="40" align="center" valign="middle"><span class="capw"><font color="#FFFFFF">◎ 新增品酒會內容 ◎</font></span></td>
        </tr>
      <tr>
        <td height="2" bgcolor="#FFFFFF"></td>
        </tr>
      <tr>
        <td align="center" valign="top"><table width="90%" border="0" cellpadding="3" cellspacing="0" bgcolor="494949">
          <tr>
            <td><form action="<?php echo $editFormAction; ?>" name="form1" method="POST" id="backend_form">
              <div align="center">
                <table width="100%" border="0" cellpadding="5" cellspacing="1" class="table">
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">品酒會標題:</td>
                    <td bgcolor="#FFFFFF"><input name="title" type="text" class="sform" id="title" size="100"></td>
                  </tr>
                  <!--tr bgcolor="#DDDDDD" class="t9">
                    <td align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">類型:</td>
                    <td bgcolor="#FFFFFF">
                        <select name="category" class="sform" id="category" >
                          <option value="">請選擇</option>
                          <option value="品酒會">1. 品酒會</option>
                          <option value="餐酒會">2. 餐酒會</option>
                          <option value="品酒課程">3. 品酒課程</option>
                          <option value="酒展">4. 酒展</option>
                          <option value="派對">5. 派對</option>
                          <option value="發表會">6. 發表會</option>
                          <option value="其他">7. 其他</option>

                        </select>
                    </td>
                  </tr-->
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">時間:</td>
                     <td bgcolor="#FFFFFF" class="description">
                        <input name="start_date" type="text" class="sform" id="start_date" placeholder="選擇開始時間"> <!--至
                        <input name="end_date" type="text" class="sform" id="end_date" placeholder="選擇結束時間"-->
                     </td>
                  </tr>
                <!--tr bgcolor="#DDDDDD" class="t9">
                    <td align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">名額:</td>
                    <td bgcolor="#FFFFFF" class="description"><input name="seats" type="text" class="sform" id="seats" size="10" placeholder="ex:50"> 人</td>
                  </tr>
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">報名期限:</td>
                     <td bgcolor="#FFFFFF"><input name="order_deadline" type="text" class="sform" id="order_deadline" placeholder="點此選日期"></td>
                  </tr-->
<script language="JavaScript">
    $(document).ready(function(){
      var opt1={dateFormat: 'yy-mm-dd',
                showSecond: false,
                timeFormat: 'HH:mm',
                addSliderAccess:true,
                sliderAccessArgs:{touchonly:false},
                showButtonPanel: true,
                 defaultValue:"23:59"
                };
    $('#start_date').datetimepicker(opt1);
    // $('#end_date').datetimepicker(opt1);
    // $('#order_deadline').datetimepicker(opt1);
      });
  </script>
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">審核狀態:</td>
                    <td bgcolor="#FFFFFF" class="description">
                        <input name="active" type="radio" value="1" id="active">通過
                        <input name="active" type="radio" value="0" id="not_active" checked="checked">審核中
                    </td>
                  </tr>
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">瀏覽次數:</td>
                    <td bgcolor="#FFFFFF"><input name="view_counter" type="text" class="sform" id="view_counter" size="5"></td>
                  </tr>
                  <!--tr bgcolor="#DDDDDD" class="t9">
                    <td align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">品酒會列表廣告輪播:</td>
                    <td bgcolor="#FFFFFF" class="description">
                        <input name="ishot" type="radio" value="1" id="ishot">是
                        <input name="ishot" type="radio" value="0" id="ishot" checked="checked">否
                    </td>
                  </tr-->
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">區域:</td>
                    <td bgcolor="#FFFFFF">
                        <span id="twzip"></span>
<script language="javascript">
    //twzip
    $('#twzip').twzipcode({
        css: ['addr-county', ]  
    });
    $("select[name='district']").hide();
        $("input[name='zipcode']").hide();
    </script>

                    </td>
                  </tr>
                  <!--tr bgcolor="#DDDDDD" class="t9">
                    <td align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">地點:</td>
                    <td bgcolor="#FFFFFF"><input name="location" type="text" class="sform" id="location" size="50" placeholder="ex: 某某飯店"></td>
                  </tr-->
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">活動地址:</td>
                    <td bgcolor="#FFFFFF"><input name="address" type="text" class="sform" id="address" size="100"></td>
                  </tr>
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">參加費用:</td>
                    <td bgcolor="#FFFFFF"><input name="fee" type="text" class="sform" id="fee" size="10"></td>
                  </tr>
                  <!--tr bgcolor="#DDDDDD" class="t9">
                    <td align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">主辦單位:</td>
                    <td bgcolor="#FFFFFF"><input name="host" type="text" class="sform" id="host" size="10"></td>
                  </tr>
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">講師:</td>
                    <td bgcolor="#FFFFFF"><input name="speaker" type="text" class="sform" id="speaker" size="10"></td>
                  </tr>
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">講師介紹:</td>
                    <td bgcolor="#FFFFFF"><textarea name="speaker_info" id="speaker_info" cols="60" rows="5" class="ckeditor"></textarea></td>
                  </tr>
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td width="15%" align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">酒單:</td>
                    <td bgcolor="#FFFFFF"><textarea name="wine_list" id="wine_list" cols="60" rows="10" class="ckeditor"></textarea></td>
                  </tr--><tr bgcolor="#DDDDDD" class="t9">
                    <td align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">聯絡人:</td>
                    <td bgcolor="#FFFFFF"><input name="contacter" type="text" class="sform" id="contacter" size="100"></td>
                  </tr>
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">聯絡信箱:</td>
                    <td bgcolor="#FFFFFF"><input name="contact_email" type="text" class="sform" id="contact_email" size="100"></td>
                  </tr>
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">連絡電話:</td>
                    <td bgcolor="#FFFFFF"><input name="contact_phone" type="text" class="sform" id="contact_phone" size="100"></td>
                  </tr>
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td width="15%" align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">純文字活動介紹:</td>
                    <td bgcolor="#FFFFFF"class="html_description">若 html介紹 欄位有值，前台便不顯示<br>
                    <textarea name="description" id="description" cols="60" rows="10"></textarea></td>
                  </tr>
                  
                  <!--tr bgcolor="#DDDDDD" class="t9">
                    <td width="15%" align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">報名方式:</td>
                    <td bgcolor="#FFFFFF"><textarea name="enrollment" id="enrollment" cols="60" rows="5" class="ckeditor"></textarea></td>
                  </tr>
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">申請付費banner輪播:</td>
                    <td bgcolor="#FFFFFF" class="description"><input name="wishbeAD" type="radio" value="1" id="wish_ad">是 <input name="wishbeAD" type="radio" value="0" id="wish_not" checked="checked">否</td>
                  </tr>
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">付費banner輪播狀態:</td>
                    <td bgcolor="#FFFFFF" class="description"><input name="isAd" type="radio" value="1" id="is_ad">是 <input name="isAd" type="radio" value="0" id="not_ad" checked="checked">否</td>
                  </tr-->
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">資料建立者:</td>
                    <td bgcolor="#FFFFFF" class="description"> <?php echo $_SESSION['ADMIN_NAME']; ?> </td>
                  </tr>

                  <tr bgcolor="#DDDDDD" class="t9">
                    <td align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">主圖檔:</td>
                    <td bgcolor="#FFFFFF">&nbsp;<img src="icon_prev.gif" alt="圖片預覽" name="showImg1" id="showImg1" onClick='javascript:alert("圖片預覽");'>
                      <input name="Submit_pic1" type="button" class="sform_g" onClick="window.open('fupload_custom.php?useForm=form1&amp;prevImg=showImg1&amp;upUrl=../../web/webimages/symposium&amp;ImgS=&amp;ImgW=&amp;ImgH=&amp;reItem=pic1&amp;pathUrl=http://www.iwine.com.tw/webimages/symposium','fileUpload','width=500,height=300')" value="準備上傳">
                      <input name="pic1" type="hidden" id="pic1" size="4"></td>
                  </tr>
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">圖檔2:</td>
                    <td bgcolor="#FFFFFF">&nbsp;<img src="icon_prev.gif" alt="圖片預覽" name="showImg2" id="showImg2" onClick='javascript:alert("圖片預覽");'>
                      <input name="Submit_pic2" type="button" class="sform_g" onClick="window.open('fupload_custom.php?useForm=form1&amp;prevImg=showImg2&amp;upUrl=../../web/webimages/symposium&amp;ImgS=&amp;ImgW=&amp;ImgH=&amp;reItem=pic2&amp;pathUrl=http://www.iwine.com.tw/webimages/symposium','fileUpload','width=500,height=300')" value="準備上傳">
                      <input name="pic2" type="hidden" id="pic2" size="4"></td>
                  </tr>
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">圖檔3:</td>
                    <td bgcolor="#FFFFFF">&nbsp;<img src="icon_prev.gif" alt="圖片預覽" name="showImg3" id="showImg3" onClick='javascript:alert("圖片預覽");'>
                      <input name="Submit_pic3" type="button" class="sform_g" onClick="window.open('fupload_custom.php?useForm=form1&amp;prevImg=showImg3&amp;upUrl=../../web/webimages/symposium&amp;ImgS=&amp;ImgW=&amp;ImgH=&amp;reItem=pic3&amp;pathUrl=http://www.iwine.com.tw/webimages/symposium','fileUpload','width=500,height=300')" value="準備上傳">
                      <input name="pic3" type="hidden" id="pic3" size="4"></td>
                  </tr>
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">圖檔4:</td>
                    <td bgcolor="#FFFFFF">&nbsp;<img src="icon_prev.gif" alt="圖片預覽" name="showImg4" id="showImg4" onClick='javascript:alert("圖片預覽");'>
                      <input name="Submit_pic4" type="button" class="sform_g" onClick="window.open('fupload_custom.php?useForm=form1&amp;prevImg=showImg4&amp;upUrl=../../web/webimages/symposium&amp;ImgS=&amp;ImgW=&amp;ImgH=&amp;reItem=pic4&amp;pathUrl=http://www.iwine.com.tw/webimages/symposium','fileUpload','width=500,height=300')" value="準備上傳">
                      <input name="pic4" type="hidden" id="pic4" size="4"></td>
                  </tr>
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">圖檔5:</td>
                    <td bgcolor="#FFFFFF">&nbsp;<img src="icon_prev.gif" alt="圖片預覽" name="showImg5" id="showImg5" onClick='javascript:alert("圖片預覽");'>
                      <input name="Submit_pic5" type="button" class="sform_g" onClick="window.open('fupload_custom.php?useForm=form1&amp;prevImg=showImg5&amp;upUrl=../../web/webimages/symposium&amp;ImgS=&amp;ImgW=&amp;ImgH=&amp;reItem=pic5&amp;pathUrl=http://www.iwine.com.tw/webimages/symposium','fileUpload','width=500,height=300')" value="準備上傳">
                      <input name="pic5" type="hidden" id="pic5" size="4"></td>
                  </tr>
                  
                 <tr bgcolor="#DDDDDD" class="t9">
                    <td width="15%" align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">html 介紹:</td>
                    <td bgcolor="#FFFFFF" class="html_description">若此欄位有值，前台便不顯示 活動介紹 的內容<br>
                    <textarea name="contain_html" id="contain_html" cols="60" rows="10" class="ckeditor"></textarea></td>
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

