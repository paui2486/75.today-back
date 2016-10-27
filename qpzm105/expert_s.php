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
  $updateSQL = sprintf("UPDATE expert SET member_id=%s, account=%s,title=%s, name=%s, active=%s, icon=%s, introduction=%s, e_order=%s, view_count=%s, agree_ad=%s,description=%s,keyword=%s  WHERE id=%s",
                       GetSQLValueString($_POST['member_id'], "text"),
                       GetSQLValueString($_POST['account'], "text"),
                       GetSQLValueString($_POST['title'], "text"),
                       GetSQLValueString($_POST['name'], "text"),
                       GetSQLValueString($_POST['active'], "int"),
                       GetSQLValueString($_POST['icon'], "text"),
                       GetSQLValueString($_POST['introduction'], "text"),
                       GetSQLValueString($_POST['e_order'], "int"),
                       GetSQLValueString($_POST['view_count'], "int"),
                       GetSQLValueString($_POST['agree_ad'], "int"),
                       GetSQLValueString($_POST['description'], "text"),
                       GetSQLValueString($_POST['keyword'], "text"),
                       GetSQLValueString($_POST['id'], "int"));

  mysql_select_db($database_iwine, $iwine);
  $Result1 = mysql_query($updateSQL, $iwine) or die(mysql_error());
  
  msg_box('修改達人成功！');
  go_to('expert_l.php');
  exit;
}

$colname_Recordset1 = "-1";
if (isset($_GET['id'])) {
  $colname_Recordset1 = $_GET['id'];
}
mysql_select_db($database_iwine, $iwine);
$query_Recordset1 = sprintf("SELECT * FROM expert WHERE id = %s", GetSQLValueString($colname_Recordset1, "int"));
$Recordset1 = mysql_query($query_Recordset1, $iwine) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
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
        <td height="40" align="center" valign="middle"><span class="capw"><font color="#FFFFFF">◎ 檢視或修改文章分類 ◎</font></span></td>
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
                    <td width="386" bgcolor="#FFFFFF"><input name="name" type="text" class="sform" id="name" value="<?php echo $row_Recordset1['name']; ?>" size="80"></td>
                    </tr>
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td width="20%" align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">抬頭:</td>
                    <td width="386" bgcolor="#FFFFFF"><input name="title" type="text" class="sform" id="title" value="<?php echo $row_Recordset1['title']; ?>" size="80"></td>
                    </tr>
                    
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td width="20%" align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">顯示與否：</td>
                    <td width="386" bgcolor="#FFFFFF">
                        <input name="active" type="radio" value="1" id="active" <?php if($row_Recordset1['active']==1) echo "checked=\"checked\""; ?>>是
                        <input name="active" type="radio" value="0" id="not_active" <?php if($row_Recordset1['active']==0) echo "checked=\"checked\""; ?>>否
                    </td>
                  </tr>
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td width="20%" align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">瀏覽數:</td>
                    <td width="386" bgcolor="#FFFFFF"><input name="view_count" type="number" class="sform" min="0" id="view_count" value="<?php echo $row_Recordset1['view_count']; ?>" size="80"></td>
                    </tr>
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">Meta Description:</td>
                    <td bgcolor="#FFFFFF"><input name="description" type="text" class="sform" id="description" size="80" value="<?php echo $row_Recordset1['description']; ?>"><span class="text_cap">*中文 75 字</span></td>
                  </tr>
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">Meta KeyWord:</td>
                    <td bgcolor="#FFFFFF"><input name="keyword" type="text" class="sform" id="keyword" size="80" value="<?php echo $row_Recordset1['keyword']; ?>"><span class="text_cap">*請用半形,區隔</span></td>
                  </tr>
                    <tr bgcolor="#DDDDDD" class="t9">
                    <td width="20%" align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">排序:</td>
                    <td width="386" bgcolor="#FFFFFF"><input name="e_order" type="text" class="sform" id="e_order" value="<?php echo $row_Recordset1['e_order']; ?>" size="80"></td>
                    </tr>
                    <!--tr bgcolor="#DDDDDD" class="t9">
                    <td width="20%" align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">達人登入帳號:</td>
                    <td width="386" bgcolor="#FFFFFF"><input name="account" type="text" class="sform" id="account" value="<?php echo $row_Recordset1['account']; ?>" size="10"></td>
                    </tr-->
                    <tr bgcolor="#DDDDDD" class="t9">
                    <td width="20%" align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">是否同意文章搜尋廣告：</td>
                    <td width="386" bgcolor="#FFFFFF">
                        <input name="agree_ad" type="radio" value="1" id="agree_ad1" <?php if($row_Recordset1['agree_ad']==1) echo "checked=\"checked\""; ?>>是
                        <input name="agree_ad" type="radio" value="0" id="agree_ad2" <?php if($row_Recordset1['agree_ad']==0) echo "checked=\"checked\""; ?>>否
                    </td>
                  </tr>
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td width="20%" align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">封面照片:</td>
                    <td width="386" bgcolor="#FFFFFF">
                        <img src="<?php if($row_Recordset1['icon']<>""){ echo "../webimages/expert/".$row_Recordset1['icon'];}else{ echo "icon_prev.gif";} ?>" alt="圖片預覽" name="showImg1" id="showImg1" onClick='javascript:alert("圖片預覽");'><br>
                      <input name="Submit_pic<?php echo $i; ?>" type="button" class="sform_g" onClick="window.open('fupload_custom.php?useForm=form1&amp;prevImg=showImg1&amp;upUrl=../webimages/expert&amp;ImgS=&amp;ImgW=&amp;ImgH=&amp;reItem=icon','fileUpload','width=500,height=300')" value="重新上傳">
                      <input name="icon" type="text" class="sform" id="icon" value="<?php echo $row_Recordset1['icon']; ?>" size="20">
                    
                    </td>
                    <tr bgcolor="#DDDDDD" class="t9">
                    <td width="20%" align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">達人簡介:</td>
                    <td width="386" bgcolor="#FFFFFF">
                        <textarea name="introduction" id="introduction" cols="60" rows="25" class="ckeditor"><?php echo $row_Recordset1['introduction']; ?></textarea>
                        
                        </td>
                  </tr>
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">達人上稿帳號人:</td>
                    <td bgcolor="#FFFFFF" class="text_cap">
                    <!--select name="member" class="text_cap"-->
                    <?php
                        
                        $link = mysql_select_db($database_iwine, $iwine);
                        $query_member = "SELECT * FROM member GROUP BY  m_account";
                        $member = mysql_query($query_member, $iwine) or die(mysql_error());
                        $row_member = mysql_fetch_assoc($member);
                        $totalRows_member = mysql_num_rows($member);
                    ?>
                    
                    <input type="radio" name="member_id" value=""> 不指定，工作人員上稿<br>
                    <?php do { ?>
                        <!--option vlaue="<?php //echo $row_member['m_id']; ?>"> <?php //echo $row_member['m_name']." - ".$row_member['m_account']; ?> </option-->
                        <input type="radio" name="member_id" id="member<?php echo $i; ?>" value="<?php echo $row_member['m_id']; ?>" <?php if($totalRows_smember>0){if($row_Recordset1['member_id']==$row_member['m_id']){echo "checked=\"checked\""; }} ?> ><?php echo $row_member['m_name']." - ".$row_member['m_account']; ?><br >
                    <?php } while ($row_member = mysql_fetch_assoc($member)); ?>
                    <?php mysql_close($link); ?>
                            
                    
                    <!--/select-->

                    </td>
                  </tr>
                  <tr bgcolor="#F3F3F1" class="t9">
                    <td colspan="2" align="right">
                    <input name="id" type="hidden" id="id" value="<?php echo $row_Recordset1['id']; ?>">
                    <input name="status2" type="submit" class="sform_b" onClick="tmt_confirm('確定要修改?');return document.MM_returnValue" value="確定修改">
                      <input name="Reset" type="reset" class="sform_b" id="Reset2" value="重設">
                      <input name="button" type="button" class="sform_b" id="button" onClick="history.back()" value="回上頁"></td>
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
mysql_free_result($Recordset1);
?>
