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
  $insertSQL = sprintf("INSERT INTO ad_fig (b_position, b_file, b_url, b_status, b_order) VALUES (%s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['b_position'], "text"),
                       GetSQLValueString($_POST['rePic'], "text"),
                       GetSQLValueString($_POST['b_url'], "text"),
                       GetSQLValueString($_POST['b_status'], "text"),
                       GetSQLValueString($_POST['b_order'], "int"));

  mysql_select_db($database_iwine, $iwine);
  $Result1 = mysql_query($insertSQL, $iwine) or die(mysql_error());

  $insertGoTo = "ads_l.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>iWine - 後台管理系統</title>

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
        <td height="40" align="center" valign="middle"><span class="capw"><font color="#FFFFFF">◎ 新增AD Banner ◎</font></span></td>
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
                    <td align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">位置:</td>
                    <td bgcolor="#FFFFFF"><span class="contnet_w">
                      <label for="b_position">圖檔尺寸建議上傳附註大小</label>
                      <select name="b_position" class="sform" id="b_position">
                        <option value="1">B2-右上方站內AD(250x250)</option>
                        <option value="2">B3-首頁底</option>
                        <option value="3">B4-首頁右下方(250x250)</option>
                        <option value="6">B5-內容頁底</option>
                        <option value="4">B6-內容頁右下方1(250x250)</option>
                        <option value="5">B7-內容頁右下方2(250x250)</option>
                        <option value="7">B8-右側邊欄固定底端(250x250)</option>
                        <option value="index_ad1">新版-首頁內廣告一(453x257)</option>
                        <option value="index_ad2">新版-首頁內廣告二左邊453x257)</option>
                        <option value="index_ad3">新版-首頁內廣告三右邊(453x257)</option>
                        <option value="index_bottom">新版-內容下端廣告(910x179)</option>
                        <option value="index_sider_bottom">新版-邊欄下方廣告(235x200)</option>
                        <option value="prodA_list_banner">新版-產品列表Banner(1150x336)</option>
                      </select>
                      </span></td>
                    </tr>
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td width="20%" align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">圖檔:</td>
                    <td width="386" bgcolor="#FFFFFF">&nbsp;<img src="icon_prev.gif" alt="圖片預覽" name="showImg" id="showImg" onClick='javascript:alert("圖片預覽");'>
                      <input name="Submit" type="button" class="sform_g" onClick="window.open('fupload.php?useForm=form1&amp;prevImg=showImg&amp;upUrl=../webimages/ad&amp;ImgS=&amp;ImgW=&amp;ImgH=&amp;reItem=rePic','fileUpload','width=500,height=300')" value="準備上傳">
                      <input name="rePic" type="hidden" id="rePic" size="4"></td>
                    </tr>
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">連結:</td>
                    <td bgcolor="#FFFFFF"><input name="b_url" type="text" class="sform" id="b_url" size="60"></td>
                    </tr>
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">顯示與否:</td>
                    <td bgcolor="#FFFFFF"><input type="radio" name="b_status" id="radio" value="Y">
                      是 <input name="b_status" type="radio" id="radio2" value="N" checked="CHECKED">
                      否</td>
                    </tr>
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">排序:</td>
                    <td bgcolor="#FFFFFF"><input name="b_order" type="text" class="sform" id="b_order" size="5"></td>
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
