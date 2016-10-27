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
  // $updateSQL = sprintf("UPDATE symposium SET title=%s, category=%s, start_date=%s, end_date=%s, location=%s, address=%s, area=%s, fee=%s, host=%s, 
                        // speaker=%s, wine_list=%s, description=%s, enrollment=%s, active=%s, pic1=%s, pic2=%s, pic3=%s, pic4=%s, pic5=%s, seats=%s, 
                        // order_deadline=%s, speaker_info=%s, ishot=%s, contain_html=%s WHERE id=%s",
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
                       // GetSQLValueString($_POST['pic1'], "text"),
                       // GetSQLValueString($_POST['pic2'], "text"),
                       // GetSQLValueString($_POST['pic3'], "text"),
                       // GetSQLValueString($_POST['pic4'], "text"),
                       // GetSQLValueString($_POST['pic5'], "text"),
                       // GetSQLValueString($_POST['seats'], "int"),
                       // GetSQLValueString($_POST['order_deadline'], "date"),
                       // GetSQLValueString($_POST['speaker_info'], "text"),
                       // GetSQLValueString($_POST['ishot'], "text"),
                       // GetSQLValueString($_POST['contain_html'], "text"),
                       // GetSQLValueString($_POST['id'], "int"));
  $updateSQL = sprintf("UPDATE symposium SET view_counter=%s, title=%s, start_date=%s, address=%s, area=%s, fee=%s,  
                        description=%s, active=%s, pic1=%s, pic2=%s, pic3=%s, pic4=%s, pic5=%s, available=%s, contacter=%s, contact_email=%s, contact_phone=%s,  
                        contain_html=%s WHERE id=%s",
                       GetSQLValueString($_POST['view_counter'], "int"),
                       GetSQLValueString($_POST['title'], "text"),
                       GetSQLValueString($_POST['start_date'], "date"),
                       GetSQLValueString($_POST['address'], "text"),
                       GetSQLValueString($_POST['county'], "text"),
                       GetSQLValueString($_POST['fee'], "int"),
                       GetSQLValueString($_POST['description'], "text"),
                       GetSQLValueString($_POST['active'], "text"),
                       GetSQLValueString($_POST['pic1'], "text"),
                       GetSQLValueString($_POST['pic2'], "text"),
                       GetSQLValueString($_POST['pic3'], "text"),
                       GetSQLValueString($_POST['pic4'], "text"),
                       GetSQLValueString($_POST['pic5'], "text"),
                       GetSQLValueString($_POST['available'], "int"),
                       GetSQLValueString($_POST['contacter'], "text"),
                       GetSQLValueString($_POST['contact_email'], "text"),
                       GetSQLValueString($_POST['contact_phone'], "text"),
                       GetSQLValueString($_POST['contain_html'], "text"),
                       GetSQLValueString($_POST['id'], "int"));

  mysql_select_db($database_iwine, $iwine);
  $Result1 = mysql_query($updateSQL, $iwine) or die(mysql_error());

  msg_box('修改品酒會內容成功');
  go_to('symposium_l.php');
  exit;
}

$id = "-1";
if (isset($_GET['id'])) {
  $id = $_GET['id'];
}
mysql_select_db($database_iwine, $iwine);
$query_symposium = sprintf("SELECT * FROM symposium WHERE id = %s", GetSQLValueString($id, "int"));
$symposium = mysql_query($query_symposium, $iwine) or die(mysql_error());
$row_symposium = mysql_fetch_assoc($symposium);
$totalRows_symposium = mysql_num_rows($symposium);
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
image{
    max-width: 400px !important;
    height: auto;
}
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
        <td height="40" align="center" valign="middle"><span class="capw"><font color="#FFFFFF">◎ 修改品酒會內容 ◎</font></span></td>
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
                    <td align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">品酒會標題:</td>
                    <td bgcolor="#FFFFFF"><input name="title" type="text" class="sform" id="title" size="100" value="<?php echo $row_symposium['title']; ?>"></td>
                  </tr>
                  <!--tr bgcolor="#DDDDDD" class="t9">
                    <td align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">類型:</td>
                    <td bgcolor="#FFFFFF">
                        <select name="category" class="sform" id="category" >
                          <option value="<?php //echo $row_symposium['category']; ?>"><?php //echo $row_symposium['category']; ?></option>
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
                    <td align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">開始日期:</td>
                     <td bgcolor="#FFFFFF" class="description">
                        <input name="start_date" type="text" class="sform" id="start_date" value="<?php echo $row_symposium['start_date']; ?>" >
                         <!--至
                        <input name="end_date" type="text" class="sform" id="end_date" value="<?php //echo $row_symposium['end_date']; ?>" -->
                     </td>
                  </tr>

                 <!--tr bgcolor="#DDDDDD" class="t9">
                    <td align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">名額:</td>
                    <td bgcolor="#FFFFFF"><input name="seats" type="text" class="sform" id="seats" value="<?php //echo $row_symposium['seats']; ?>"></td>
                  </tr>
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">報名期限:</td>
                     <td bgcolor="#FFFFFF"><input name="order_deadline" type="text" class="sform" id="order_deadline" value="<?php //echo $row_symposium['order_deadline']; ?>"></td>
                  </tr-->
 <script language="JavaScript">
    $(document).ready(function(){
      var opt1={dateFormat: 'yy-mm-dd',
                showSecond: false,
                timeFormat: 'HH:mm:ss',
                addSliderAccess:true,
                sliderAccessArgs:{touchonly:false},
                showButtonPanel: true,
                 defaultValue:"23:59:59"
                };
    $('#start_date').datetimepicker(opt1);
    // $('#end_date').datetimepicker(opt1);
    // $('#order_deadline').datetimepicker(opt1);
      });
  </script>
                    <tr bgcolor="#DDDDDD" class="t9">
                        <td width="15%" align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">審核狀態:</td>
                        <td bgcolor="#FFFFFF" class="description">
                            <input name="active" type="radio" value="1" id="active" <?php if($row_symposium['active']==1) echo "checked=\"checked\""; ?>>通過
                            <input name="active" type="radio" value="0" id="not_active" <?php if($row_symposium['active']==0) echo "checked=\"checked\""; ?>>審核中
                    </td>
                    <tr bgcolor="#DDDDDD" class="t9">
                    <td align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">瀏覽次數:</td>
                    <td bgcolor="#FFFFFF"><input name="view_counter" type="text" class="sform" id="view_counter" size="5" value="<?php echo $row_symposium['view_counter']; ?>"></td>
                  </tr>
                  </tr>
                  <tr bgcolor="#DDDDDD" class="t9">
                        <td width="15%" align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">報名狀態:</td>
                        <td bgcolor="#FFFFFF" class="description">
                            <input name="available" type="radio" value="1" id="available" <?php if($row_symposium['available']==1) echo "checked=\"checked\""; ?>>可報名
                            <input name="available" type="radio" value="0" id="not_available" <?php if($row_symposium['available']==0) echo "checked=\"checked\""; ?>>報名截止
                    </td>
                  </tr>
                  <!--tr bgcolor="#DDDDDD" class="t9">
                        <td width="15%" align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">品酒會列表廣告輪播:</td>
                        <td bgcolor="#FFFFFF" class="description">
                            <input name="ishot" type="radio" value="1" id="ishot" <?php //if($row_symposium['ishot']==1) echo "checked=\"checked\""; ?>>是
                            <input name="ishot" type="radio" value="0" id="ishot_no" <?php //if($row_symposium['ishot']==0) echo "checked=\"checked\""; ?>>否
                    </td>
                  </tr-->
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">區域:</td>
                    <td bgcolor="#FFFFFF" class="description">
                        <input type="text" class="sform" id="conty_input" name="county" value="<?php echo $row_symposium['area']; ?>"> 請填縣市
                         <span id="twzip" display:none; ></span>
<script language="javascript">
    //twzip
    $('#conty_input').click(function(){
        $('#conty_input').hide();
        $('#twzip').show();
            $('#twzip').twzipcode({
            css: ['addr-county', ]  
        });
        $("select[name='district']").hide();
        $("input[name='zipcode']").hide();
    });
    
    </script>
                    </td>
                    </tr>
                  <!--tr bgcolor="#DDDDDD" class="t9">
                    <td width="15%" align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">地點:</td>
                    <td bgcolor="#FFFFFF"><input name="location" type="text" class="sform" id="location" value="<?php //echo $row_symposium['location']; ?>" size="40px"></td>
                  </tr-->
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td width="15%" align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">活動地址:</td>
                    <td bgcolor="#FFFFFF"><input name="address" type="text" class="sform" id="address" value="<?php echo $row_symposium['address']; ?>" size="60px"></td>
                  </tr>
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td width="15%" align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">參加費用:</td>
                    <td bgcolor="#FFFFFF"><input name="fee" type="text" class="sform" id="fee" value="<?php echo $row_symposium['fee']; ?>"></td>
                  </tr>
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td width="15%" align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">聯絡人:</td>
                    <td bgcolor="#FFFFFF"><input name="contacter" type="text" class="sform" id="contacter" value="<?php echo $row_symposium['contacter']; ?>"></td>
                  </tr>
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td width="15%" align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">聯絡信箱:</td>
                    <td bgcolor="#FFFFFF"><input name="contact_email" type="text" class="sform" id="contact_email" value="<?php echo $row_symposium['contact_email']; ?>"></td>
                  </tr>
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td width="15%" align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">連絡電話:</td>
                    <td bgcolor="#FFFFFF"><input name="contact_phone" type="text" class="sform" id="contact_phone" value="<?php echo $row_symposium['contact_phone']; ?>"></td>
                  </tr>
                  <!--tr bgcolor="#DDDDDD" class="t9">
                    <td width="15%" align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">主辦單位:</td>
                    <td bgcolor="#FFFFFF"><input name="host" type="text" class="sform" id="host" value="<?php //echo $row_symposium['host']; ?>"></td>
                  </tr>
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td width="15%" align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">講師:</td>
                    <td bgcolor="#FFFFFF"><input name="speaker" type="text" class="sform" id="speaker" value="<?php //echo $row_symposium['speaker']; ?>"></td>
                  </tr>
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td width="15%" align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">講師介紹:</td>
                    <td bgcolor="#FFFFFF"><textarea name="speaker_info" id="speaker_info" cols="60" rows="5"><?php //echo $row_symposium['speaker_info']; ?></textarea></td>
                  </tr>
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td width="15%" align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">酒單:</td>
                    <td bgcolor="#FFFFFF"><textarea name="wine_list" id="wine_list" cols="60" rows="10"><?php //echo $row_symposium['wine_list']; ?></textarea></td>
                  </tr-->
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td width="15%" align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">純文字活動介紹:</td>
                    <td bgcolor="#FFFFFF"class="html_description">若 html介紹 欄位有值，前台便不顯示<br>
                    <textarea name="description" id="description" cols="60" rows="25"><?php echo $row_symposium['description']; ?></textarea></td>
                  </tr>
                  <!--tr bgcolor="#DDDDDD" class="t9">
                    <td width="15%" align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">報名方式:</td>
                    <td bgcolor="#FFFFFF"><textarea name="enrollment" id="enrollment" cols="60" rows="5"><?php //echo $row_symposium['enrollment']; ?></textarea></td>
                  </tr-->
                  <!--tr bgcolor="#DDDDDD" class="t9">
                        <td width="15%" align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">申請付費banne輪播:</td>
                        <td bgcolor="#FFFFFF" class="description">
                            <input name="wishbeAD" type="radio" value="1" id="wishbeAD_true" <?php //if($row_symposium['wishbeAD']==1) echo "checked=\"checked\""; ?>>通過
                            <input name="wishbeAD" type="radio" value="0" id="wishbeAD_false" <?php //if($row_symposium['wishbeAD']==0) echo "checked=\"checked\""; ?>>審核中
                    </td>
                  </tr>
                  <tr bgcolor="#DDDDDD" class="t9">
                        <td width="15%" align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">付費banne輪播狀態:</td>
                        <td bgcolor="#FFFFFF" class="description">
                            <input name="isAd" type="radio" value="1" id="isAd_true" <?php //if($row_symposium['isAd']==1) echo "checked=\"checked\""; ?>>通過
                            <input name="isAd" type="radio" value="0" id="isAd_false" <?php //if($row_symposium['isAd']==0) echo "checked=\"checked\""; ?>>審核中
                    </td>
                  </tr-->
                  <?php for ($i=1; $i<=5; $i++) { ?>
                    <?php $c_pic = 'pic'.$i; ?>
                   <tr bgcolor="#DDDDDD" class="t9">
                        <td width="15%" align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">圖檔<?php echo $i; ?>:</td>
                        <td bgcolor="#FFFFFF" class="description">
                       
                        <img style="max-width:400px; height:auto;" src="<?php if($row_symposium[$c_pic]<>""){ echo "http://www.iwine.com.tw/webimages/symposium/".$row_symposium[$c_pic];}else{ echo "icon_prev.gif";} ?>" alt="圖片預覽" name="showImg<?php echo $i; ?>" id="showImg<?php echo $i; ?>" onClick='javascript:alert("圖片預覽");'><br>
                      <input name="Submit_pic<?php echo $i; ?>" type="button" class="sform_g" onClick="window.open('fupload_custom.php?useForm=form1&amp;prevImg=showImg<?php echo $i; ?>&amp;upUrl=../../web/webimages/symposium&amp;ImgS=&amp;ImgW=&amp;ImgH=&amp;reItem=<?php echo $c_pic; ?>&amp;pathUrl=http://www.iwine.com.tw/webimages/symposium','fileUpload','width=500,height=300')" value="重新上傳">
                      <input name="<?php echo $c_pic; ?>" type="text" class="sform" id="<?php echo $c_pic; ?>" value="<?php echo $row_symposium[$c_pic]; ?>" size="20">
                    </td>
                  </tr>
                  <?php } ?>

                    
                    
                    <tr bgcolor="#DDDDDD" class="t9">
                    <td width="15%" align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">html介紹:</td>
                    <td bgcolor="#FFFFFF" class="html_description">若此欄位有值，前台便不顯示 活動介紹 的內容
                        <textarea name="contain_html" id="contain_html" cols="60" rows="25" class="ckeditor">
                            <?php echo $row_symposium['contain_html']; ?>
                        </textarea>
                    </td>
                  </tr>
                    
                    
                  <tr bgcolor="#F3F3F1">
                  <td colspan="4" align="center"><input name="id" type="hidden" id="id" value="<?php echo $row_symposium['id']; ?>">
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
mysql_free_result($symposium);
?>
