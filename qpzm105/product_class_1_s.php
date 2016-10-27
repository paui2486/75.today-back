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
  $updateSQL = sprintf("UPDATE Product_Class SET pc_name=%s, pc_order=%s, pc_fig=%s, pc_fig2=%s, pc_fig3=%s, pc_top=%s, pc_top1=%s, pc_top2=%s, pc_top3=%s, pc_online=%s, pc_banner=%s, pc_url=%s, pc_url2=%s, pc_url3=%s, pc_level1=%s, pc_level2=%s WHERE pc_id=%s",
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
                       GetSQLValueString($_POST['pc_level2'], "int"),
                       GetSQLValueString($_POST['pc_id'], "int"));

  mysql_select_db($database_iwine, $iwine);
  $Result1 = mysql_query($updateSQL, $iwine) or die(mysql_error());

  $updateGoTo = "product_class_1_l.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_Recordset1 = "-1";
if (isset($_GET['pc_id'])) {
  $colname_Recordset1 = $_GET['pc_id'];
}
mysql_select_db($database_iwine, $iwine);
$query_Recordset1 = sprintf("SELECT * FROM Product_Class WHERE pc_id = %s", GetSQLValueString($colname_Recordset1, "int"));
$Recordset1 = mysql_query($query_Recordset1, $iwine) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

$level_1 = $row_Recordset1['pc_level2'];

mysql_select_db($database_iwine, $iwine);
$query_mainclass = "SELECT * FROM Product_Class WHERE pc_level1 = 0 ORDER BY pc_order ASC";
$mainclass = mysql_query($query_mainclass, $iwine) or die(mysql_error());
$row_mainclass = mysql_fetch_assoc($mainclass);
$totalRows_mainclass = mysql_num_rows($mainclass);

mysql_select_db($database_iwine, $iwine);
$query_secondclass = "SELECT * FROM Product_Class WHERE pc_id = '$level_1' ORDER BY pc_order ASC";
$secondclass = mysql_query($query_secondclass, $iwine) or die(mysql_error());
$row_secondclass = mysql_fetch_assoc($secondclass);
$totalRows_secondclass = mysql_num_rows($secondclass);
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
<link href="css.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="js/jquery-1.7.2.min.js"></script>
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
</head>

<body marginheight="0" marginwidth="0" bgcolor="#666666">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td align="center" valign="top" bgcolor="666666"><table width="100%" height="605" border="0" align="center" cellpadding="0" cellspacing="8">
      <tr>
        <td height="2" bgcolor="#FFFFFF"></td>
        </tr>
      <tr>
        <td height="40" align="center" valign="middle"><span class="capw"><font color="#FFFFFF">◎ 檢視或修改商品分類 ◎</font></span></td>
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
                    <td align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">唯一ID值:</td>
                    <td bgcolor="#FFFFFF" class="text_cap"><?php echo $row_Recordset1['pc_id']; ?> (不可修改)</td>
                  </tr>
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">上層分類:</td>
                    <td bgcolor="#FFFFFF"><select name="pc_level1" class="sform" id="pc_level1" onChange="getClass('1',this.value)" >
                      <option value="0" <?php if (!(strcmp(0, $row_Recordset1['pc_level1']))) {echo "selected=\"selected\"";} ?>>無</option>
                      <?php
do {  
?>
                      <option value="<?php echo $row_mainclass['pc_id']?>"<?php if (!(strcmp($row_mainclass['pc_id'], $row_Recordset1['pc_level1']))) {echo "selected=\"selected\"";} ?>><?php echo $row_mainclass['pc_name']?></option>
                      <?php
} while ($row_mainclass = mysql_fetch_assoc($mainclass));
  $rows = mysql_num_rows($mainclass);
  if($rows > 0) {
      mysql_data_seek($mainclass, 0);
	  $row_mainclass = mysql_fetch_assoc($mainclass);
  }
?>
                    </select>
                      /
                      <span id="second_class">
                      <select name="pc_level2" class="sform" id="pc_level2">
                      <?php if($totalRows_secondclass>0){ ?>
                        <option value="<?php echo $row_secondclass['pc_id']; ?>" selected="selected"><?php echo $row_secondclass['pc_name']; ?></option>
                      <?php }else{ ?>
                        <option value="0" selected="selected">無</option>
                      <?php } ?>
                      </select></span></td>
                  </tr>
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td width="20%" align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">分類名稱:</td>
                    <td width="386" bgcolor="#FFFFFF"><input name="pc_name" type="text" class="sform" id="pc_name" value="<?php echo $row_Recordset1['pc_name']; ?>" size="80"></td>
                    </tr>
                  <!--
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">圖檔1(790x80):</td>
                    <td bgcolor="#FFFFFF">&nbsp;<img src="<?php if($row_Recordset1['pc_fig']<>""){ echo "../webimages/class/".$row_Recordset1['pc_fig'];}else{ echo "icon_prev.gif";} ?>" alt="圖片預覽" name="showImg" id="showImg" onClick='javascript:alert("圖片預覽");'><br>
                      <input name="Submit" type="button" class="sform_g" onClick="window.open('fupload.php?useForm=form1&amp;prevImg=showImg&amp;upUrl=../webimages/class&amp;ImgS=&amp;ImgW=&amp;ImgH=&amp;reItem=rePic','fileUpload','width=500,height=300')" value="重新上傳">
                      <input name="rePic" type="text" class="sform" id="rePic" value="<?php echo $row_Recordset1['pc_fig']; ?>" size="20">
                      (欄位留白可刪除圖片)</td>
                  </tr>
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">圖檔1連結:</td>
                    <td bgcolor="#FFFFFF" class="sform"><label for="pc_url"></label>
                      <input name="pc_url" type="text" class="sform" id="pc_url" value="<?php echo $row_Recordset1['pc_url']; ?>" size="80"></td>
                  </tr>
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">圖檔2(215x420):</td>
                    <td bgcolor="#FFFFFF">&nbsp;<img src="<?php if($row_Recordset1['pc_fig2']<>""){ echo "../webimages/class/".$row_Recordset1['pc_fig2'];}else{ echo "icon_prev.gif";} ?>" alt="圖片預覽" name="showImg2" id="showImg2" onClick='javascript:alert("圖片預覽");'><br>
                      <input name="Submit2" type="button" class="sform_g" onClick="window.open('fupload.php?useForm=form1&amp;prevImg=showImg2&amp;upUrl=../webimages/class&amp;ImgS=&amp;ImgW=&amp;ImgH=&amp;reItem=rePic2','fileUpload','width=500,height=300')" value="重新上傳">
                      <input name="rePic2" type="text" class="sform" id="rePic2" value="<?php echo $row_Recordset1['pc_fig2']; ?>" size="20">
                      (欄位留白可刪除圖片)</td>
                  </tr>
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">圖檔2連結:</td>
                    <td bgcolor="#FFFFFF" class="sform"><label for="pc_url2"></label>
                      <input name="pc_url2" type="text" class="sform" id="pc_url2" value="<?php echo $row_Recordset1['pc_url2']; ?>" size="80"></td>
                  </tr>
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">圖檔3(720x225):</td>
                    <td bgcolor="#FFFFFF">&nbsp;<img src="<?php if($row_Recordset1['pc_fig3']<>""){ echo "../webimages/class/".$row_Recordset1['pc_fig3'];}else{ echo "icon_prev.gif";} ?>" alt="圖片預覽" name="showImg3" id="showImg3" onClick='javascript:alert("圖片預覽");'><br>
                      <input name="Submit3" type="button" class="sform_g" onClick="window.open('fupload.php?useForm=form1&amp;prevImg=showImg3&amp;upUrl=../webimages/class&amp;ImgS=&amp;ImgW=&amp;ImgH=&amp;reItem=rePic3','fileUpload','width=500,height=300')" value="重新上傳">
                      <input name="rePic3" type="text" class="sform" id="rePic3" value="<?php echo $row_Recordset1['pc_fig3']; ?>" size="20">
                      (欄位留白可刪除圖片)</td>
                  </tr>
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">圖檔3連結:</td>
                    <td bgcolor="#FFFFFF" class="sform"><label for="pc_url3"></label>
                      <input name="pc_url3" type="text" class="sform" id="pc_url3" value="<?php echo $row_Recordset1['pc_url3']; ?>" size="80"></td>
                  </tr>
                  -->
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">排序:</td>
                    <td bgcolor="#FFFFFF"><input name="pc_order" type="text" class="sform" id="pc_order" value="<?php echo $row_Recordset1['pc_order']; ?>" size="5">
                      <input name="pc_id" type="hidden" id="pc_id" value="<?php echo $row_Recordset1['pc_id']; ?>"></td>
                  </tr>
                  <!--
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">自動隨機推薦:</td>
                    <td bgcolor="#FFFFFF" class="text_cap"><input    <?php if (!(strcmp($row_Recordset1['pc_top'],"Y"))) {echo "checked=\"checked\"";} ?> name="pc_top" type="radio" id="pc_top" value="Y">
                      是
                        <input    <?php if (!(strcmp($row_Recordset1['pc_top'],"N"))) {echo "checked=\"checked\"";} ?> name="pc_top" type="radio" id="pc_top" value="N">
                      
                      否</td>
                  </tr>
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">統一banner:</td>
                    <td bgcolor="#FFFFFF" class="text_cap"><input   <?php if (!(strcmp($row_Recordset1['pc_banner'],"Y"))) {echo "checked=\"checked\"";} ?> name="pc_banner" type="radio" id="pc_top4" value="Y">
                      是
                      <input   <?php if (!(strcmp($row_Recordset1['pc_banner'],"N"))) {echo "checked=\"checked\"";} ?> name="pc_banner" type="radio" id="pc_top4" value="N">
                      否</td>
                  </tr>
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">新品推薦:</td>
                    <td bgcolor="#FFFFFF" class="text_cap"><input name="pc_top1" type="text" class="sform" id="pc_top1" value="<?php echo $row_Recordset1['pc_top1']; ?>">
                      (商品編號)</td>
                  </tr>
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">新品推薦:</td>
                    <td bgcolor="#FFFFFF" class="text_cap"><input name="pc_top2" type="text" class="sform" id="pc_top2" value="<?php echo $row_Recordset1['pc_top2']; ?>">
                      (商品編號)</td>
                  </tr>
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">新品推薦:</td>
                    <td bgcolor="#FFFFFF" class="text_cap"><input name="pc_top3" type="text" class="sform" id="pc_top3" value="<?php echo $row_Recordset1['pc_top3']; ?>">
                      (商品編號)</td>
                  </tr>
                  -->
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">顯示與否：</td>
                    <td bgcolor="#FFFFFF" class="text_cap"><input <?php if (!(strcmp($row_Recordset1['pc_online'],"Y"))) {echo "checked=\"checked\"";} ?> name="pc_online" type="radio" id="radio" value="Y">
                      是
                      <input <?php if (!(strcmp($row_Recordset1['pc_online'],"N"))) {echo "checked=\"checked\"";} ?> type="radio" name="pc_online" id="radio2" value="N">
                      否</td>
                  </tr>
                  <tr bgcolor="#F3F3F1" class="t9">
                    <td colspan="2" align="right"><input name="status2" type="submit" class="sform_g" onClick="tmt_confirm('確定要修改?');return document.MM_returnValue" value="修改並儲存">
                      <input name="Reset" type="reset" class="sform_b" id="Reset2" value="重設">
                      <input name="button" type="button" class="sform_r" id="button" onClick="history.back()" value="放棄修改"></td>
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

mysql_free_result($mainclass);

mysql_free_result($secondclass);
?>
