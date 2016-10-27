<?php include('session_check.php'); ?>
<?php require_once('../Connections/iwine.php'); ?>
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
  $insertSQL = sprintf("INSERT INTO Product_Class (pc_name, pc_order, pc_fig, pc_fig2, pc_fig3, pc_top, pc_top1, pc_top2, pc_top3, pc_online, pc_banner, pc_url, pc_url2, pc_url3, pc_level1, pc_level2) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['pc_name'], "text"),
                       GetSQLValueString($_POST['pc_order'], "text"),
                       GetSQLValueString($_POST['rePic'], "text"),
                       GetSQLValueString($_POST['rePic2'], "text"),
					   GetSQLValueString($_POST['rePic3'], "text"),
                       GetSQLValueString($_POST['pc_top'], "text"),
                       GetSQLValueString($_POST['pc_top1'], "text"),
                       GetSQLValueString($_POST['pc_top2'], "text"),
                       GetSQLValueString($_POST['pc_top3'], "text"),
                       GetSQLValueString($_POST['pc_online'], "text"),
                       GetSQLValueString($_POST['pc_banner'], "text"),
                       GetSQLValueString($_POST['pc_url'], "text"),
                       GetSQLValueString($_POST['pc_url2'], "text"),
					   GetSQLValueString($_POST['pc_url3'], "text"),
                       GetSQLValueString($_POST['pc_level1'], "int"),
                       GetSQLValueString($_POST['pc_level2'], "int"));

  mysql_select_db($database_iwine, $iwine);
  $Result1 = mysql_query($insertSQL, $iwine) or die(mysql_error());

  $insertGoTo = "product_class_1_l.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

mysql_select_db($database_iwine, $iwine);
$query_main_class = "SELECT * FROM Product_Class WHERE pc_level1 = 0 ORDER BY pc_order ASC";
$main_class = mysql_query($query_main_class, $iwine) or die(mysql_error());
$row_main_class = mysql_fetch_assoc($main_class);
$totalRows_main_class = mysql_num_rows($main_class);
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>iFit 愛瘦身 - 後台管理系統</title>
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
}
-->
</style>
<script type="text/javascript" src="js/jquery-1.7.2.min.js"></script>
<link href="css.css" rel="stylesheet" type="text/css">
<script type="text/javascript">
function tmt_confirm(msg){
	document.MM_returnValue=(confirm(unescape(msg)));
}
</script>
<script type="text/javascript">
function addBookmarkForBrowser(sTitle, sUrl){

        if (window.sidebar && window.sidebar.addPanel) {
            addBookmarkForBrowser = function(sTitle, sUrl) {
                window.sidebar.addPanel(sTitle, sUrl, "");
            }
        } else if (window.external) {
            addBookmarkForBrowser = function(sTitle, sUrl) {
                window.external.AddFavorite(sUrl, sTitle);
            }
        } else {
            addBookmarkForBrowser = function() {
                alert("do it yourself");
            }
        }

        return addBookmarkForBrowser(sTitle, sUrl);
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
        <td height="40" align="center" valign="middle"><span class="capw"><font color="#FFFFFF">◎ 新增商品分類 ◎</font></span></td>
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
                    <td align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">上層分類:</td>
                    <td bgcolor="#FFFFFF"><select name="pc_level1" class="sform" id="pc_level1" onChange="getClass('1',this.value)">
                      <option value="0">無</option>
                      <?php
do {  
?>
                      <option value="<?php echo $row_main_class['pc_id']?>"><?php echo $row_main_class['pc_name']?></option>
                      <?php
} while ($row_main_class = mysql_fetch_assoc($main_class));
  $rows = mysql_num_rows($main_class);
  if($rows > 0) {
      mysql_data_seek($main_class, 0);
	  $row_main_class = mysql_fetch_assoc($main_class);
  }
?>
                    </select> 
                      / 
                      <span id="second_class"><select name="pc_level2" class="sform" id="pc_level2"><option value="0">無</option></select></span></td>
                  </tr>
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td width="20%" align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">分類名稱:</td>
                    <td width="386" bgcolor="#FFFFFF"><input name="pc_name" type="text" class="sform" id="pc_name" size="80"></td>
                    </tr>
                    <!--
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">圖檔1(790x80):</td>
                    <td bgcolor="#FFFFFF">&nbsp;<img src="icon_prev.gif" alt="圖片預覽" name="showImg" id="showImg" onClick='javascript:alert("圖片預覽");'>
                      <input name="Submit" type="button" class="sform_g" onClick="window.open('fupload.php?useForm=form1&amp;prevImg=showImg&amp;upUrl=../webimages/class&amp;ImgS=&amp;ImgW=&amp;ImgH=&amp;reItem=rePic','fileUpload','width=500,height=300')" value="準備上傳">
                      <input name="rePic" type="hidden" id="rePic" size="4"></td>
                  </tr>
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">圖檔1連結：</td>
                    <td bgcolor="#FFFFFF"><label for="pc_url"></label>
                      <input name="pc_url" type="text" class="sform" id="pc_url" size="80"></td>
                  </tr>
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">圖檔2(215x420):</td>
                    <td bgcolor="#FFFFFF">&nbsp;<img src="icon_prev.gif" alt="圖片預覽" name="showImg2" id="showImg2" onClick='javascript:alert("圖片預覽");'>
                      <input name="Submit2" type="button" class="sform_g" onClick="window.open('fupload.php?useForm=form1&amp;prevImg=showImg2&amp;upUrl=../webimages/class&amp;ImgS=&amp;ImgW=&amp;ImgH=&amp;reItem=rePic2','fileUpload','width=500,height=300')" value="準備上傳">
                      <input name="rePic2" type="hidden" id="rePic2" size="4"></td>
                  </tr>
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">圖檔2連結：</td>
                    <td bgcolor="#FFFFFF"><label for="pc_url2"></label>
                      <input name="pc_url2" type="text" class="sform" id="pc_url2" size="80"></td>
                  </tr>
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">圖檔3(720x225):</td>
                    <td bgcolor="#FFFFFF">&nbsp;<img src="icon_prev.gif" alt="圖片預覽" name="showImg3" id="showImg3" onClick='javascript:alert("圖片預覽");'>
                      <input name="Submit3" type="button" class="sform_g" onClick="window.open('fupload.php?useForm=form1&amp;prevImg=showImg3&amp;upUrl=../webimages/class&amp;ImgS=&amp;ImgW=&amp;ImgH=&amp;reItem=rePic3','fileUpload','width=500,height=300')" value="準備上傳">
                      <input name="rePic3" type="hidden" id="rePic3" size="4"></td>
                  </tr>
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">圖檔3連結：</td>
                    <td bgcolor="#FFFFFF"><label for="pc_url3"></label>
                      <input name="pc_url3" type="text" class="sform" id="pc_url3" size="80"></td>
                  </tr>
                  -->
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">排序:</td>
                    <td bgcolor="#FFFFFF"><input name="pc_order" type="text" class="sform" id="pc_order" size="5"></td>
                  </tr>
                  <!--
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">自動隨機推薦:</td>
                    <td bgcolor="#FFFFFF" class="text_cap"><input name="pc_top" type="radio" id="pc_top" value="Y" checked="CHECKED">
                      <label for="pc_hot2">是
                        <input name="pc_top" type="radio" id="pc_top" value="N">
                      </label>
                      否</td>
                  </tr>
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">統一banner:</td>
                    <td bgcolor="#FFFFFF" class="text_cap"><input name="pc_banner" type="radio" id="pc_top4" value="Y">
                      <label for="pc_hot3">是
                        <input name="pc_banner" type="radio" id="pc_top4" value="N" checked="CHECKED">
                      </label>
                      否</td>
                  </tr>
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">新品推薦:</td>
                    <td bgcolor="#FFFFFF" class="text_cap"><input name="pc_top1" type="text" class="sform" id="pc_top1">
                      (商品編號)</td>
                  </tr>
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">新品推薦:</td>
                    <td bgcolor="#FFFFFF" class="text_cap"><input name="pc_top2" type="text" class="sform" id="pc_top2">
(商品編號)</td>
                  </tr>
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">新品推薦:</td>
                    <td bgcolor="#FFFFFF" class="text_cap"><input name="pc_top3" type="text" class="sform" id="pc_top3">
(商品編號)</td>
                  </tr>
                  -->
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">顯示與否：</td>
                    <td bgcolor="#FFFFFF" class="text_cap"><input name="pc_online" type="radio" id="radio" value="Y" checked="CHECKED">
                      是 
                        <input type="radio" name="pc_online" id="radio2" value="N">
                        否</td>
                  </tr>
                  <tr bgcolor="#F3F3F1" class="t9">
                    <td colspan="2" align="right"><input name="status2" type="submit" class="sform_g" onClick="tmt_confirm('確定新增?');return document.MM_returnValue" value="儲存並新增">
                      <input name="Reset" type="reset" class="sform_b" id="Reset2" value="重設">
                      <input name="button" type="button" class="sform_r" id="button" onClick="history.back()" value="放棄新增"></td>
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
<script language="javascript">
	function getClass(level,pid){
	
		//alert(level+pid);
		$.ajax({
			url: 'getclass.php',
    		data: {level: level, parent: pid},
    		error: function(xhr) {  },
    		success: function(response) { 
			
			to2class = '<select name="pc_level2" class="sform" id="pc_level2"><option value="0">無</option>' + response + '</select>'
			$("#second_class").html(to2class);
			}
				});
				
}
</script>
<?php
mysql_free_result($main_class);
?>
