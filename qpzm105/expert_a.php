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
$_now = date('Y-m-d H:i:s');
// $temp_pwd = "iwine_expert";
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO  expert (member_id, account, title, name, active, icon, introduction, agree_ad, view_count, create_time,description ,keyword, e_order) 
                        VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['member_id'], "int"),
                       GetSQLValueString($_POST['account'], "text"),
                       GetSQLValueString($_POST['title'], "text"),
                       GetSQLValueString($_POST['name'], "text"),
                       GetSQLValueString($_POST['active'], "int"),
                       GetSQLValueString($_POST['icon'], "text"),
                       GetSQLValueString($_POST['introduction'], "text"),
                       GetSQLValueString($_POST['agree_ad'], "int"),
                       GetSQLValueString($_POST['view_count'], "int"),
                       GetSQLValueString($_now, "date"),
                       GetSQLValueString($_POST['description'], "text"),
                       GetSQLValueString($_POST['keyword'], "text"),
                       GetSQLValueString($_POST['order'], "int"));
//echo $insertSQL."<br>" ;
  mysql_select_db($database_iwine, $iwine);
  $Result1 = mysql_query($insertSQL, $iwine) or die(mysql_error());
  
  msg_box('新增達人成功！');
  go_to('expert_l.php');
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
        <td height="40" align="center" valign="middle"><span class="capw"><font color="#FFFFFF">◎ 新增達人 ◎</font></span></td>
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
                    <td width="20%" align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">姓名:</td>
                    <td width="386" bgcolor="#FFFFFF"><input name="name" type="text" class="sform" id="name" size="20"></td>
                  </tr>
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td width="20%" align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">抬頭:</td>
                    <td width="386" bgcolor="#FFFFFF"><input name="title" type="text" class="sform" id="title" size="20"></td>
                  </tr>
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">顯示與否：</td>
                    <td bgcolor="#FFFFFF" class="text_cap"><input name="active" type="radio" id="active1" value="1" checked="CHECKED">
                      是 
                      <input type="radio" name="active" id="active2" value="0">
                      否</td>
                  </tr>
                   <tr bgcolor="#DDDDDD" class="t9">
                    <td width="20%" align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">瀏覽數:</td>
                    <td width="386" bgcolor="#FFFFFF"><input name="view_count" type="number" class="sform" min="0" id="view_count" value="0" size="80"></td>
                    </tr>
                    <tr bgcolor="#DDDDDD" class="t9">
                    <td align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">Meta Description:</td>
                    <td bgcolor="#FFFFFF"><input name="description" type="text" class="sform" id="description" size="80"><span class="text_cap">*中文 75 字</span></td>
                  </tr>
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">Meta KeyWord:</td>
                    <td bgcolor="#FFFFFF"><input name="keyword" type="text" class="sform" id="keyword" size="80"><span class="text_cap">*請用半形,區隔</span></td>
                  </tr>
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">排序:</td>
                    <td bgcolor="#FFFFFF"><input name="order" type="text" class="sform" id="order" size="5"></td>
                  </tr>
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">是否同意文章搜尋廣告：</td>
                    <td bgcolor="#FFFFFF" class="text_cap"><input name="agree_ad" type="radio" id="agree_ad1" value="1" >
                      是 
                      <input type="radio" name="agree_ad" id="agree_ad2" value="0" checked="CHECKED">
                      否</td>
                  </tr>
                  <!--tr bgcolor="#DDDDDD" class="t9">
                    <td width="20%" align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">達人登入帳號:</td>
                    <td width="386" bgcolor="#FFFFFF"><input name="account" type="text" class="sform" id="account" size="80"></td>
                  </tr-->
                  <!--tr bgcolor="#DDDDDD" class="t9">
                    <td width="20%" align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">達人登入密碼:</td>
                    <td width="386" bgcolor="#FFFFFF"><input name="password" type="text" class="sform" id="password" size="10"></td>
                  </tr-->
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td width="20%" align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">封面照片:</td>
                    <td width="386" bgcolor="#FFFFFF">
                    
                    &nbsp;<img src="icon_prev.gif" alt="圖片預覽" name="showImg1" id="showImg1" onClick='javascript:alert("圖片預覽");'>
                      <input name="Submit_pic1" type="button" class="sform_g" onClick="window.open('fupload_custom.php?useForm=form1&amp;prevImg=showImg1&amp;upUrl=../webimages/expert&amp;ImgS=&amp;ImgW=&amp;ImgH=&amp;reItem=icon','fileUpload','width=500,height=300')" value="準備上傳">
                      <input name="icon" type="hidden" id="icon" size="4">
                    
                    </td>
                  </tr>
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td width="20%" align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">簡介:</td>
                    <td width="386" bgcolor="#FFFFFF"><textarea name="introduction" id="introduction" cols="60" rows="10" class="ckeditor"></textarea></td>
                  </tr>
                  
                  
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w" style="vertical-align: text-top;">達人文章上稿人:</td>
                    <td bgcolor="#FFFFFF" class="text_cap">
                    <!--select name="member" class="text_cap"-->
                    <?php
                        $link = mysql_select_db($database_iwine, $iwine);
                        $query_member = "SELECT * FROM member GROUP BY  m_account";
                        $member = mysql_query($query_member, $iwine) or die(mysql_error());
                        $row_member = mysql_fetch_assoc($member);
                        $totalRows_member = mysql_num_rows($member);
                    ?>
                    <?php do { ?>
                        <!--option vlaue="<?php //echo $row_member['m_id']; ?>"> <?php //echo $row_member['m_name']." - ".$row_member['m_account']; ?> </option-->
                        <input type="radio" name="member_id" id="member<?php echo $i; ?>" value="<?php echo $row_member['m_id']; ?>"><?php echo $row_member['m_name']." - ".$row_member['m_account']; ?><br >
                    <?php } while ($row_member = mysql_fetch_assoc($member)); ?>
                    <?php mysql_close($link); ?>
                            
                    
                    <!--/select-->

                    </td>
                  </tr>
                  
                  
                  
                  
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
