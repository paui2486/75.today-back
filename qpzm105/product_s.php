<?php include('session_check.php'); ?>
<?php require_once('../Connections/iwine.php'); ?>
<?php //include('func.php'); ?>
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
/*
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form2")) {
  $insertSQL = sprintf("INSERT INTO Product_spec (ps_p_id, ps_code, ps_spec, ps_order) VALUES (%s, %s, %s, %s)",
                       GetSQLValueString($_POST['ps_p_id'], "int"),
                       GetSQLValueString($_POST['ps_code'], "text"),
                       GetSQLValueString($_POST['ps_spec'], "text"),
                       GetSQLValueString($_POST['ps_order'], "int"));

  mysql_select_db($database_iwine, $iwine);
  $Result1 = mysql_query($insertSQL, $iwine) or die(mysql_error());
  
  //msg_box('新增規格成功！');
  $goto_url = "product_s.php?p_id=".$_POST['ps_p_id'];
  go_to($goto_url);
}
*/
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE Product_shop SET p_code=%s, p_name=%s, p_subtitle=%s, p_price1=%s, p_price2=%s, p_price3=%s, p_description=%s, p_memo=%s, p_storage=%s, p_update_time=%s, p_online=%s, p_file1=%s, p_file2=%s, p_file3=%s, p_file4=%s, p_file5=%s, p_class=%s, p_start_time=%s, p_end_time=%s, p_type=%s, p_spec=%s, p_order=%s, p_gift=%s, p_index=%s WHERE p_id=%s",
                       GetSQLValueString($_POST['p_code'], "text"),
                       GetSQLValueString($_POST['p_name'], "text"),
                       GetSQLValueString($_POST['p_subtitle'], "text"),
                       GetSQLValueString($_POST['p_price1'], "int"),
                       GetSQLValueString($_POST['p_price2'], "int"),
                       GetSQLValueString($_POST['p_price3'], "int"),
                       GetSQLValueString($_POST['p_description'], "text"),
					   GetSQLValueString($_POST['p_memo'], "text"),
                       GetSQLValueString($_POST['p_storage'], "int"),
                       GetSQLValueString($_POST['p_update_time'], "date"),
                       GetSQLValueString($_POST['p_online'], "text"),
                       GetSQLValueString($_POST['rePic'], "text"),
                       GetSQLValueString($_POST['rePic2'], "text"),
                       GetSQLValueString($_POST['rePic3'], "text"),
                       GetSQLValueString($_POST['rePic4'], "text"),
                       GetSQLValueString($_POST['rePic5'], "text"),
                       GetSQLValueString($_POST['p_class'], "int"),
                       GetSQLValueString($_POST['p_start_time'], "date"),
                       GetSQLValueString($_POST['p_end_time'], "date"),
                       GetSQLValueString($_POST['p_type'], "text"),
                       GetSQLValueString($_POST['p_spec'], "text"),
                       GetSQLValueString($_POST['p_order'], "text"),
                       GetSQLValueString($_POST['p_gift'], "int"),
					   GetSQLValueString($_POST['p_index'], "text"),
                       GetSQLValueString($_POST['p_id'], "int"));

  mysql_select_db($database_iwine, $iwine);
  $Result1 = mysql_query($updateSQL, $iwine) or die(mysql_error());
  
  go_to('win_close_re.php');
}

mysql_select_db($database_iwine, $iwine);
$query_Product_class = "SELECT * FROM Product_Class ORDER BY pc_order ASC";
$Product_class = mysql_query($query_Product_class, $iwine) or die(mysql_error());
$row_Product_class = mysql_fetch_assoc($Product_class);
$totalRows_Product_class = mysql_num_rows($Product_class);

mysql_select_db($database_iwine, $iwine);
$query_Product_type = "SELECT * FROM Product_Type ORDER BY py_order ASC";
$Product_type = mysql_query($query_Product_type, $iwine) or die(mysql_error());
$row_Product_type = mysql_fetch_assoc($Product_type);
$totalRows_Product_type = mysql_num_rows($Product_type);

$colname_Product = "-1";
if (isset($_GET['p_id'])) {
  $colname_Product = $_GET['p_id'];
}
mysql_select_db($database_iwine, $iwine);
$query_Product = sprintf("SELECT * FROM Product_shop LEFT JOIN Product_Class ON Product_shop.p_class = Product_Class.pc_id WHERE p_id = %s", GetSQLValueString($colname_Product, "int"));
$Product = mysql_query($query_Product, $iwine) or die(mysql_error());
$row_Product = mysql_fetch_assoc($Product);
$totalRows_Product = mysql_num_rows($Product);

/*
mysql_select_db($database_iwine, $iwine);
$query_Product_free = "SELECT * FROM Product_shop WHERE p_type = '5' ORDER BY p_code ASC";
$Product_free = mysql_query($query_Product_free, $iwine) or die(mysql_error());
$row_Product_free = mysql_fetch_assoc($Product_free);
$totalRows_Product_free = mysql_num_rows($Product_free);

$ps_p_id = $row_Product['p_id'];

mysql_select_db($database_iwine, $iwine);
$query_Recordset1 = "SELECT * FROM Product_spec WHERE ps_p_id = '$ps_p_id' ORDER BY ps_order ASC";
$Recordset1 = mysql_query($query_Recordset1, $iwine) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
*/
include("ckeditor/ckeditor.php") ; 
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
<script type="text/javascript">
function tmt_confirm(msg){
	document.MM_returnValue=(confirm(unescape(msg)));
}
</script>
<script type="text/javascript" src="js/jquery-1.7.2.min.js"></script>
<style type="text/css">@import "js/jquery.datepick.package-3.6.1/jquery.datepick.css";</style> 
<script type="text/javascript" src="js/jquery.datepick.package-3.6.1/jquery.datepick.js"></script>
<script type="text/javascript" src="js/jquery.datepick.package-3.6.1/jquery.datepick.pack.js"></script>
<script type="text/javascript" src="js/jquery.datepick.package-3.6.1/jquery.datepick-zh-TW.js"></script>
<script type="text/javascript" src="ckeditor/ckeditor.js"></script>
<script language="javascript">
function getClass(level,pid){
	
	if( pid != "-1" ){
	
		$.ajax({
			url: 'getclass.php',
    		data: {level: level, parent: pid},
    		error: function(xhr) {  },
    		success: function(response) { 
			
			if( level == 1 ){
			//alert(pid)
			to2class = '<select name="pc_class2" class="sform" id="pc_class2" onChange="getClass(\'2\',this.value)"><option value="-1">無</option>' + response + '</select>';
			$("#second_class").html(to2class);
			$("#p_class").val(pid);
			} 
			
			if ( level == 2 ) {
			//alert(pid)
			to2class = '<select name="pc_class3" class="sform" id="pc_class3" onChange="setClass(this.value)"><option value="-1">無</option>' + response + '</select>';
			$("#third_class").html(to2class);
			$("#p_class").val(pid);
			}
			
			}
				});
	}else{
		  to2class = '<select name="pc_class2" class="sform" id="pc_class2" onChange="getClass(\'2\',this.value)"><option value="-1">無</option></select>';
		  $("#second_class").html(to2class);
		  to3class = '<select name="pc_class3" class="sform" id="pc_class3" onChange="setClass(this.value)"><option value="-1">無</option</select>';
		  $("#third_class").html(to3class);
		  $("#p_class").val('0');
		  $("#p_class1").attr("value",'-1');
	}
}

function setClass(pid){
	  if( pid != "-1" ){
			//alert(pid)
			$("#p_class").val(pid);
	  }else{
		  to2class = '<select name="pc_class2" class="sform" id="pc_class2" onChange="getClass(\'2\',this.value)"><option value="-1">無</option></select>';
		  $("#second_class").html(to2class);
		  to3class = '<select name="pc_class3" class="sform" id="pc_class3" onChange="setClass(this.value)"><option value="-1">無</option</select>';
		  $("#third_class").html(to3class);
		  $("#p_class").val('0');
		  $("#p_class1").attr("value",'-1');
	}
}

function delspec(ids,pids){
	if(window.confirm('確定要刪除?')){
		window.location='spec_d.php?ps_id='+ids+'&p_id='+pids;
	}
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
        <td height="40" align="center" valign="middle"><span class="capw"><font color="#FFFFFF">◎ 修改商品內容 ◎</font></span></td>
        </tr>
      <tr>
        <td height="2" bgcolor="#FFFFFF"></td>
        </tr>
      <!--
      <tr>
        <td align="center" valign="top"><form name="form2" method="POST" action="<?php echo $editFormAction; ?>">
          <p class="contnet_w">編輯商品規格選項          </p>
          <table width="60%" border="0" cellpadding="5" cellspacing="1">
            <tr class="text_w">
              <td align="center" bgcolor="#999999">貨號</td>
              <td align="center" bgcolor="#999999">規格敘述</td>
              <td align="center" bgcolor="#999999">排序</td>
              <td align="center" bgcolor="#999999">管理</td>
            </tr>
            <?php if ($totalRows_Recordset1 > 0) { // Show if recordset not empty ?>
              <?php do { ?>
            <tr>
              <td align="center" bgcolor="#FFFFFF" class="text_cap"><?php echo $row_Recordset1['ps_code']; ?></td>
              <td align="center" bgcolor="#FFFFFF" class="text_cap"><?php echo $row_Recordset1['ps_spec']; ?></td>
              <td align="center" bgcolor="#FFFFFF" class="text_cap"><?php echo $row_Recordset1['ps_order']; ?></td>
              <td align="center" bgcolor="#FFFFFF"><input name="button2" type="button" class="sform_b" id="button2" onClick="delspec('<?php echo $row_Recordset1['ps_id']; ?>','<?php echo $row_Product['p_id']; ?>');" value="刪除"></td>
            </tr>
            <?php } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?>
              <?php } // Show if recordset not empty ?>
            <?php if ($totalRows_Recordset1 == 0) { // Show if recordset empty ?>
  <tr>
    <td colspan="4" align="center" bgcolor="#FFFFFF" class="text_cap">本商品目前無規格選項</td>
  </tr>
  <?php } // Show if recordset empty ?>
<tr>
              <td align="center" bgcolor="#FFFFFF"><input name="ps_code" type="text" class="sform" id="ps_code"></td>
              <td align="center" bgcolor="#FFFFFF"><input name="ps_spec" type="text" class="sform" id="ps_spec" size="50"></td>
              <td align="center" bgcolor="#FFFFFF"><input name="ps_order" type="text" class="sform" id="ps_order" size="10">
                <input name="ps_p_id" type="hidden" id="ps_p_id" value="<?php echo $row_Product['p_id']; ?>"></td>
              <td align="center" bgcolor="#FFFFFF"><input name="button3" type="submit" class="sform_g" id="button3" value="新增"></td>
            </tr>
        </table>
          <input type="hidden" name="MM_insert" value="form2">
        </form></td>
      </tr>
      -->
      <tr>
        <td align="center" valign="top"><table width="90%" border="0" cellpadding="3" cellspacing="0" bgcolor="494949">
          <tr>
            <td><form action="<?php echo $editFormAction; ?>" name="form1" method="POST">
              <div align="center">
                <table width="100%" border="0" cellpadding="5" cellspacing="1" class="table">
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">目前商品所屬分類:</td>
                    <td bgcolor="#FFFFFF" class="text_cap">
                    <?php 
if($row_Product['pc_level1'] <> 0){
	
$pid = $row_Product['pc_level1'];

mysql_select_db($database_iwine, $iwine);
$query_class1 = "SELECT * FROM Product_Class WHERE pc_id = '$pid'";
$class1 = mysql_query($query_class1, $iwine) or die(mysql_error());
$row_class1 = mysql_fetch_assoc($class1);
$totalRows_class1 = mysql_num_rows($class1);

echo $row_class1['pc_name']." / ";
}
if($row_Product['pc_level2'] <> 0){
	
$pid2 = $row_Product['pc_level2'];

mysql_select_db($database_iwine, $iwine);
$query_class2 = "SELECT * FROM Product_Class WHERE pc_id = '$pid2'";
$class2 = mysql_query($query_class2, $iwine) or die(mysql_error());
$row_class2 = mysql_fetch_assoc($class2);
$totalRows_class2 = mysql_num_rows($class2);

echo  $row_class2['pc_name']." / ";
}

$pid3 = $row_Product['p_class'];

mysql_select_db($database_iwine, $iwine);
$query_class3 = "SELECT * FROM Product_Class WHERE pc_id = '$pid3'";
$class3 = mysql_query($query_class3, $iwine) or die(mysql_error());
$row_class3 = mysql_fetch_assoc($class3);
$totalRows_class3 = mysql_num_rows($class3);

echo  $row_class3['pc_name'];
?>
                    </td>
                  </tr>
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">修改商品分類:</td>
                    <td bgcolor="#FFFFFF"><select name="p_class1" class="sform" id="p_class1" onChange="getClass('1',this.value)" >
                      <option value="-1">主分類</option>
                      <?php
do {  
?>
<option value="<?php echo $row_Product_class['pc_id']?>"><?php echo $row_Product_class['pc_name']?></option>
                      <?php
} while ($row_Product_class = mysql_fetch_assoc($Product_class));
  $rows = mysql_num_rows($Product_class);
  if($rows > 0) {
      mysql_data_seek($Product_class, 0);
	  $row_Product_class = mysql_fetch_assoc($Product_class);
  }
?>
                    </select>
/ <span id="second_class">
<select name="p_class2" class="sform" id="p_class2" onChange="getClass('2',this.value)" >
</select>
</span> / <span id="third_class">
<select name="p_class3" class="sform" id="p_class3">
</select>
</span>
<input name="p_class" id="p_class" type="hidden" value="<?php echo $row_Product['p_class']; ?>"></td>
                    </tr>
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">商品屬性:</td>
                    <td bgcolor="#FFFFFF"><select name="p_type" class="sform" id="p_class_lucky3">
                      <option value="1" <?php if (!(strcmp(1, $row_Product['p_type']))) {echo "selected=\"selected\"";} ?>>請選擇商品屬性</option>
                      <?php
do {  
?>
  <option value="<?php echo $row_Product_type['py_id']?>"<?php if (!(strcmp($row_Product_type['py_id'], $row_Product['p_type']))) {echo "selected=\"selected\"";} ?>><?php echo $row_Product_type['py_name']?></option>
                      <?php
} while ($row_Product_type = mysql_fetch_assoc($Product_type));
  $rows = mysql_num_rows($Product_type);
  if($rows > 0) {
      mysql_data_seek($Product_type, 0);
	  $row_Product_type = mysql_fetch_assoc($Product_type);
  }
?>
                      </select></td>
                  </tr>
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td width="15%" align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">商品名稱:</td>
                    <td bgcolor="#FFFFFF"><input name="p_name" type="text" class="sform" id="p_name" value="<?php echo $row_Product['p_name']; ?>" size="50"></td>
                    </tr>
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">商品副標題:</td>
                    <td bgcolor="#FFFFFF" class="text_cap"><input name="p_subtitle" type="text" class="sform" id="p_subtitle" value="<?php echo $row_Product['p_subtitle']; ?>" size="80">
                      (勿超過100字)</td>
                  </tr>
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">商品貨號:</td>
                    <td bgcolor="#FFFFFF" class="t9"><input name="p_code" type="text" class="sform" id="p_code" value="<?php echo $row_Product['p_code']; ?>">
                      <span class="text_cap">（必填，必須為唯一值）</span></td>
                    </tr>
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">定價:</td>
                    <td bgcolor="#FFFFFF" class="text_cap"><input name="p_price1" type="text" class="sform" id="p_price1" value="<?php echo $row_Product['p_price1']; ?>" size="20">元</td>
                  </tr>
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">會員價:</td>
                    <td bgcolor="#FFFFFF" class="text_cap"><input name="p_price2" type="text" class="sform" id="p_price2" value="<?php echo $row_Product['p_price2']; ?>" size="20">                      元（必填，一般售價）</td>
                    </tr>
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">優惠價:</td>
                    <td bgcolor="#FFFFFF" class="text_cap"><input name="p_price3" type="text" class="sform" id="p_price3" value="<?php echo $row_Product['p_price3']; ?>" size="20">
                      元（在優惠期間的優惠價）</td>
                  </tr>
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">商品介紹:</td>
                    <td bgcolor="#FFFFFF"><textarea name="p_spec" id="p_spec" cols="45" rows="5" class="ckeditor"><?php echo $row_Product['p_spec']; ?></textarea></td>
                  </tr>
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">商品注意事項:</td>
                    <td bgcolor="#FFFFFF"><textarea name="p_description" id="p_description" cols="45" rows="5" class="ckeditor"><?php echo $row_Product['p_description']; ?></textarea></td>
                  </tr>
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">商品試用心得:</td>
                    <td bgcolor="#FFFFFF"><textarea name="p_memo" id="p_memo" cols="45" rows="5" class="ckeditor"><?php echo $row_Product['p_memo']; ?></textarea></td>
                  </tr>
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">列表小圖片(288x215):</td>
                    <td bgcolor="#FFFFFF"><img src="<?php if($row_Product['p_file1']<>""){ echo "../webimages/shop/".$row_Product['p_file1'];}else{ echo "icon_prev.gif";} ?>" alt="圖片預覽" name="showImg" id="showImg" onClick='javascript:alert("圖片預覽");'><br>
                      <input name="Submit" type="button" class="sform_g" onClick="window.open('fupload.php?useForm=form1&amp;prevImg=showImg&amp;upUrl=../webimages/shop&amp;ImgS=&amp;ImgW=&amp;ImgH=&amp;reItem=rePic','fileUpload','width=500,height=300')" value="重新上傳">
                      <input name="rePic" type="text" class="sform" id="rePic" value="<?php echo $row_Product['p_file1']; ?>" size="20">
                      (欄位留白可刪除圖片)</td>
                  </tr>
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">主圖片(400x400):</td>
                    <td bgcolor="#FFFFFF"><img src="<?php if($row_Product['p_file2']<>""){ echo "../webimages/shop/".$row_Product['p_file2'];}else{ echo "icon_prev.gif";} ?>" alt="圖片預覽" name="showImg2" id="showImg2" onClick='javascript:alert("圖片預覽");'><br>
                      <input name="Submit4" type="button" class="sform_g" onClick="window.open('fupload.php?useForm=form1&amp;prevImg=showImg2&amp;upUrl=../webimages/shop&amp;ImgS=&amp;ImgW=&amp;ImgH=&amp;reItem=rePic2','fileUpload','width=500,height=300')" value="重新上傳">
                      <input name="rePic2" type="text" class="sform" id="rePic2" value="<?php echo $row_Product['p_file2']; ?>" size="20">
                      (欄位留白可刪除圖片)</td>
                  </tr>
                  <!--
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">圖片3(400x400):</td>
                    <td bgcolor="#FFFFFF"><img src="<?php if($row_Product['p_file3']<>""){ echo "../webimages/shop/".$row_Product['p_file3'];}else{ echo "icon_prev.gif";} ?>" alt="圖片預覽" name="showImg3" id="showImg3" onClick='javascript:alert("圖片預覽");'><br>
                      <input name="Submit5" type="button" class="sform_g" onClick="window.open('fupload.php?useForm=form1&amp;prevImg=showImg3&amp;upUrl=../webimages/shop&amp;ImgS=&amp;ImgW=&amp;ImgH=&amp;reItem=rePic3','fileUpload','width=500,height=300')" value="重新上傳">
                      <input name="rePic3" type="text" class="sform" id="rePic3" value="<?php echo $row_Product['p_file3']; ?>" size="20">
                      (欄位留白可刪除圖片)</td>
                  </tr>
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">圖片4(400x400):</td>
                    <td bgcolor="#FFFFFF"><img src="<?php if($row_Product['p_file4']<>""){ echo "../webimages/shop/".$row_Product['p_file4'];}else{ echo "icon_prev.gif";} ?>" alt="圖片預覽" name="showImg4" id="showImg4" onClick='javascript:alert("圖片預覽");'><br>
                      <input name="Submit2" type="button" class="sform_g" onClick="window.open('fupload.php?useForm=form1&amp;prevImg=showImg4&amp;upUrl=../webimages/shop&amp;ImgS=&amp;ImgW=&amp;ImgH=&amp;reItem=rePic4','fileUpload','width=500,height=300')" value="重新上傳">
                      <input name="rePic4" type="text" class="sform" id="rePic4" value="<?php echo $row_Product['p_file4']; ?>" size="20">
                      (欄位留白可刪除圖片)</td>
                  </tr>
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">圖片5(400x400):</td>
                    <td bgcolor="#FFFFFF"><img src="<?php if($row_Product['p_file5']<>""){ echo "../webimages/shop/".$row_Product['p_file5'];}else{ echo "icon_prev.gif";} ?>" alt="圖片預覽" name="showImg5" id="showImg5" onClick='javascript:alert("圖片預覽");'><br>
                      <input name="Submit3" type="button" class="sform_g" onClick="window.open('fupload.php?useForm=form1&amp;prevImg=showImg5&amp;upUrl=../webimages/shop&amp;ImgS=&amp;ImgW=&amp;ImgH=&amp;reItem=rePic5','fileUpload','width=500,height=300')" value="重新上傳">
                      <input name="rePic5" type="text" class="sform" id="rePic5" value="<?php echo $row_Product['p_file5']; ?>" size="20">
                      (欄位留白可刪除圖片)</td>
                  </tr>
                  -->
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">排序:</td>
                    <td bgcolor="#FFFFFF"><input name="p_order" type="text" class="sform" id="p_order" value="<?php echo $row_Product['p_order']; ?>" size="5">
                      <input name="p_update_time" type="hidden" id="p_date" value="<?php echo date('Y-m-d'); ?>"></td>
                  </tr>
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">庫存:</td>
                    <td bgcolor="#FFFFFF"><input name="p_storage" type="text" class="sform" id="p_storage" value="<?php echo $row_Product['p_storage']; ?>">
                      <input name="p_ori_storage" type="hidden" id="p_ori_storage" value="<?php echo $_GET['stock']; ?>"></td>
                  </tr>
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">優惠期間:</td>
                    <td bgcolor="#FFFFFF"><input name="p_start_time" type="text" class="sform" id="p_start_time" value="<?php echo $row_Product['p_start_time']; ?>" size="15"/>
                      至
                      <input name="p_end_time" type="text" class="sform" id="p_end_time" value="<?php echo $row_Product['p_end_time']; ?>" size="15"/></td>
                    </tr>
                  <!--
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">隨附贈品:</td>
                    <td bgcolor="#FFFFFF"><select name="p_gift" class="sform" id="p_gift">
                      <option value="0" <?php if (!(strcmp(0, $row_Product['p_gift']))) {echo "selected=\"selected\"";} ?>>無</option>
                      <?php
do {  
?>
                      <option value="<?php echo $row_Product_free['p_id']?>"<?php if (!(strcmp($row_Product_free['p_id'], $row_Product['p_gift']))) {echo "selected=\"selected\"";} ?>><?php echo $row_Product_free['p_code']?> <?php echo $row_Product_free['p_name']; ?></option>
                      <?php
} while ($row_Product_free = mysql_fetch_assoc($Product_free));
  $rows = mysql_num_rows($Product_free);
  if($rows > 0) {
      mysql_data_seek($Product_free, 0);
	  $row_Product_free = mysql_fetch_assoc($Product_free);
  }
?>
                    </select></td>
                  </tr>
                  -->
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">上架:</td>
                    <td bgcolor="#FFFFFF" class="text_cap"><input <?php if (!(strcmp($row_Product['p_online'],"Y"))) {echo "checked=\"checked\"";} ?> type="radio" name="p_online" id="p_online" value="Y">
                      是
                      <input <?php if (!(strcmp($row_Product['p_online'],"N"))) {echo "checked=\"checked\"";} ?> name="p_online" type="radio" id="p_online" value="N">
                      否
                      <input name="p_id" type="hidden" id="p_id" value="<?php echo $row_Product['p_id']; ?>"></td>
                    </tr>
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">首頁顯示:</td>
                    <td bgcolor="#FFFFFF" class="text_cap"><input  <?php if (!(strcmp($row_Product['p_index'],"Y"))) {echo "checked=\"checked\"";} ?> type="radio" name="p_index" id="p_online2" value="Y">
                      是
                      <input  <?php if (!(strcmp($row_Product['p_index'],"N"))) {echo "checked=\"checked\"";} ?> name="p_index" type="radio" id="p_online2" value="N">
                      否                      </td>
                  </tr>
                  <tr bgcolor="#F3F3F1" class="t9">
                    <td colspan="2" align="right"><input name="status2" type="submit" class="sform_b" onClick="tmt_confirm('確定要修改?');return document.MM_returnValue" value="儲存修改">
                      <input name="Reset" type="reset" class="sform_b" id="Reset2" value="重設">
                      <input name="button" type="button" class="sform_r" id="button" onClick="window.close()" value="不儲存，關閉視窗"></td>
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
mysql_free_result($Product_class);

mysql_free_result($Product_type);

mysql_free_result($Product);

mysql_free_result($Product_free);

mysql_free_result($Recordset1);
?>
<script type="text/javascript">
// BeginWebWidget jQuery_UI_Calendar: sdate1
jQuery("#p_start_time").datepick({dateFormat: 'yy-mm-dd'});
// EndWebWidget jQuery_UI_Calendar: sdate1
</script>
<script type="text/javascript">
// BeginWebWidget jQuery_UI_Calendar: sdate1
jQuery("#p_end_time").datepick({dateFormat: 'yy-mm-dd'});
// EndWebWidget jQuery_UI_Calendar: sdate1
                          </script>
