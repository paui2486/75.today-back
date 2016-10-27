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
  $insertSQL = sprintf("INSERT INTO Product (p_code, p_name, p_subtitle, p_product1, p_product2, p_product3, p_product4, p_product5, p_p1_code, p_p2_code, p_p3_code, p_p4_code, p_p5_code, p_p1_soldout, p_p2_soldout, p_p3_soldout, p_p4_soldout, p_p5_soldout, p_p1_limit, p_p2_limit, p_p3_limit, p_p4_limit, p_p5_limit, p_p1_limit_num, p_p2_limit_num, p_p3_limit_num, p_p4_limit_num, p_p5_limit_num, p_package, p_package_per, p_package_num, p_pb1, p_pb2, p_pb3, p_pb4, p_pb5, p_pb6, p_pb7, p_pb8, p_pb9, p_pb10, p_pb1_price, p_pb2_price, p_pb3_price, p_pb4_price, p_pb5_price, p_pb6_price, p_pb7_price, p_pb8_price, p_pb9_price, p_pb10_price, p_pb1_soldout, p_pb2_soldout, p_pb3_soldout, p_pb4_soldout, p_pb5_soldout, p_pb6_soldout, p_pb7_soldout, p_pb8_soldout, p_pb9_soldout, p_pb10_soldout, p_pb1_limit, p_pb2_limit, p_pb3_limit, p_pb4_limit, p_pb5_limit, p_pb6_limit, p_pb7_limit, p_pb8_limit, p_pb9_limit, p_pb10_limit, p_pb1_limit_num, p_pb2_limit_num, p_pb3_limit_num, p_pb4_limit_num, p_pb5_limit_num, p_pb6_limit_num, p_pb7_limit_num, p_pb8_limit_num, p_pb9_limit_num, p_pb10_limit_num, p_pb1_url, p_pb2_url, p_pb3_url, p_pb4_url, p_pb5_url, p_pb6_url, p_pb7_url, p_pb8_url, p_pb9_url, p_pb10_url, p_pa1, p_pa2, p_pa3, p_pa4, p_pa5, p_pa6, p_pa7, p_pa8, p_pa9, p_pa10, p_pa1_soldout, p_pa2_soldout, p_pa3_soldout, p_pa4_soldout, p_pa5_soldout, p_pa6_soldout, p_pa7_soldout, p_pa8_soldout, p_pa9_soldout, p_pa10_soldout, p_pa1_limit, p_pa2_limit, p_pa3_limit, p_pa4_limit, p_pa5_limit, p_pa6_limit, p_pa7_limit, p_pa8_limit, p_pa9_limit, p_pa10_limit, p_pa1_limit_num, p_pa2_limit_num, p_pa3_limit_num, p_pa4_limit_num, p_pa5_limit_num, p_pa6_limit_num, p_pa7_limit_num, p_pa8_limit_num, p_pa9_limit_num, p_pa10_limit_num, p_unit, p_price1, p_price2, p_login_price, p_noship_way, p_noship_num, p_noship_price, p_ship_price, p_discount_ratio, p_description, p_memo_online, p_memo, p_other, p_online, p_file1, p_file2, p_start_time, p_end_time, p_stock_num, p_order, p_outside, p_outside_url, p_trans_url, p_card, p_webatm, p_atm, p_paynow, p_atm_cathy, p_hang_price, p_type, p_city, p_telphone, p_address, p_gmap, p_act_start, p_act_end, p_time_info) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['p_code'], "text"),
                       GetSQLValueString($_POST['p_name'], "text"),
                       GetSQLValueString($_POST['p_subtitle'], "text"),
                       GetSQLValueString($_POST['p_product1'], "text"),
                       GetSQLValueString($_POST['p_product2'], "text"),
                       GetSQLValueString($_POST['p_product3'], "text"),
                       GetSQLValueString($_POST['p_product4'], "text"),
                       GetSQLValueString($_POST['p_product5'], "text"),
                       GetSQLValueString($_POST['p_p1_code'], "text"),
                       GetSQLValueString($_POST['p_p2_code'], "text"),
                       GetSQLValueString($_POST['p_p3_code'], "text"),
                       GetSQLValueString($_POST['p_p4_code'], "text"),
                       GetSQLValueString($_POST['p_p5_code'], "text"),
                       GetSQLValueString(isset($_POST['p_p1_soldout']) ? "Y" : "", "defined","'Y'","'N'"),
                       GetSQLValueString(isset($_POST['p_p2_soldout']) ? "Y" : "", "defined","'Y'","'N'"),
                       GetSQLValueString(isset($_POST['p_p3_soldout']) ? "Y" : "", "defined","'Y'","'N'"),
                       GetSQLValueString(isset($_POST['p_p4_soldout']) ? "Y" : "", "defined","'Y'","'N'"),
                       GetSQLValueString(isset($_POST['p_p5_soldout']) ? "Y" : "", "defined","'Y'","'N'"),
                       GetSQLValueString(isset($_POST['p_p1_limit']) ? "Y" : "", "defined","'Y'","'N'"),
                       GetSQLValueString(isset($_POST['p_p2_limit']) ? "Y" : "", "defined","'Y'","'N'"),
                       GetSQLValueString(isset($_POST['p_p3_limit']) ? "Y" : "", "defined","'Y'","'N'"),
                       GetSQLValueString(isset($_POST['p_p4_limit']) ? "Y" : "", "defined","'Y'","'N'"),
                       GetSQLValueString(isset($_POST['p_p5_limit']) ? "Y" : "", "defined","'Y'","'N'"),
                       GetSQLValueString($_POST['p_p1_limit_num'], "int"),
                       GetSQLValueString($_POST['p_p2_limit_num'], "int"),
                       GetSQLValueString($_POST['p_p3_limit_num'], "int"),
                       GetSQLValueString($_POST['p_p4_limit_num'], "int"),
                       GetSQLValueString($_POST['p_p5_limit_num'], "int"),
                       GetSQLValueString($_POST['p_package'], "text"),
					   GetSQLValueString($_POST['p_package_per'], "int"),
                       GetSQLValueString($_POST['p_package_num'], "int"),
                       GetSQLValueString($_POST['p_pb1'], "text"),
                       GetSQLValueString($_POST['p_pb2'], "text"),
                       GetSQLValueString($_POST['p_pb3'], "text"),
                       GetSQLValueString($_POST['p_pb4'], "text"),
                       GetSQLValueString($_POST['p_pb5'], "text"),
					   GetSQLValueString($_POST['p_pb6'], "text"),
                       GetSQLValueString($_POST['p_pb7'], "text"),
                       GetSQLValueString($_POST['p_pb8'], "text"),
                       GetSQLValueString($_POST['p_pb9'], "text"),
                       GetSQLValueString($_POST['p_pb10'], "text"),
                       GetSQLValueString($_POST['p_pb1_price'], "int"),
                       GetSQLValueString($_POST['p_pb2_price'], "int"),
                       GetSQLValueString($_POST['p_pb3_price'], "int"),
                       GetSQLValueString($_POST['p_pb4_price'], "int"),
                       GetSQLValueString($_POST['p_pb5_price'], "int"),
					   GetSQLValueString($_POST['p_pb6_price'], "int"),
                       GetSQLValueString($_POST['p_pb7_price'], "int"),
                       GetSQLValueString($_POST['p_pb8_price'], "int"),
                       GetSQLValueString($_POST['p_pb9_price'], "int"),
                       GetSQLValueString($_POST['p_pb10_price'], "int"),
                       GetSQLValueString(isset($_POST['p_pb1_soldout']) ? "true" : "", "defined","'Y'","'N'"),
                       GetSQLValueString(isset($_POST['p_pb2_soldout']) ? "true" : "", "defined","'Y'","'N'"),
                       GetSQLValueString(isset($_POST['p_pb3_soldout']) ? "true" : "", "defined","'Y'","'N'"),
                       GetSQLValueString(isset($_POST['p_pb4_soldout']) ? "true" : "", "defined","'Y'","'N'"),
                       GetSQLValueString(isset($_POST['p_pb5_soldout']) ? "true" : "", "defined","'Y'","'N'"),
					   GetSQLValueString(isset($_POST['p_pb6_soldout']) ? "true" : "", "defined","'Y'","'N'"),
                       GetSQLValueString(isset($_POST['p_pb7_soldout']) ? "true" : "", "defined","'Y'","'N'"),
                       GetSQLValueString(isset($_POST['p_pb8_soldout']) ? "true" : "", "defined","'Y'","'N'"),
                       GetSQLValueString(isset($_POST['p_pb9_soldout']) ? "true" : "", "defined","'Y'","'N'"),
                       GetSQLValueString(isset($_POST['p_pb10_soldout']) ? "true" : "", "defined","'Y'","'N'"),
                       GetSQLValueString(isset($_POST['p_pb1_limit']) ? "true" : "", "defined","'Y'","'N'"),
                       GetSQLValueString(isset($_POST['p_pb2_limit']) ? "true" : "", "defined","'Y'","'N'"),
                       GetSQLValueString(isset($_POST['p_pb3_limit']) ? "true" : "", "defined","'Y'","'N'"),
                       GetSQLValueString(isset($_POST['p_pb4_limit']) ? "true" : "", "defined","'Y'","'N'"),
                       GetSQLValueString(isset($_POST['p_pb5_limit']) ? "true" : "", "defined","'Y'","'N'"),
					   GetSQLValueString(isset($_POST['p_pb6_limit']) ? "true" : "", "defined","'Y'","'N'"),
                       GetSQLValueString(isset($_POST['p_pb7_limit']) ? "true" : "", "defined","'Y'","'N'"),
                       GetSQLValueString(isset($_POST['p_pb8_limit']) ? "true" : "", "defined","'Y'","'N'"),
                       GetSQLValueString(isset($_POST['p_pb9_limit']) ? "true" : "", "defined","'Y'","'N'"),
                       GetSQLValueString(isset($_POST['p_pb10_limit']) ? "true" : "", "defined","'Y'","'N'"),
                       GetSQLValueString($_POST['p_pb1_limit_num'], "int"),
                       GetSQLValueString($_POST['p_pb2_limit_num'], "int"),
                       GetSQLValueString($_POST['p_pb3_limit_num'], "int"),
                       GetSQLValueString($_POST['p_pb4_limit_num'], "int"),
                       GetSQLValueString($_POST['p_pb5_limit_num'], "int"),
					   GetSQLValueString($_POST['p_pb6_limit_num'], "int"),
                       GetSQLValueString($_POST['p_pb7_limit_num'], "int"),
                       GetSQLValueString($_POST['p_pb8_limit_num'], "int"),
                       GetSQLValueString($_POST['p_pb9_limit_num'], "int"),
                       GetSQLValueString($_POST['p_pb10_limit_num'], "int"),
                       GetSQLValueString($_POST['p_pb1_url'], "text"),
                       GetSQLValueString($_POST['p_pb2_url'], "text"),
                       GetSQLValueString($_POST['p_pb3_url'], "text"),
                       GetSQLValueString($_POST['p_pb4_url'], "text"),
                       GetSQLValueString($_POST['p_pb5_url'], "text"),
					   GetSQLValueString($_POST['p_pb6_url'], "text"),
                       GetSQLValueString($_POST['p_pb7_url'], "text"),
                       GetSQLValueString($_POST['p_pb8_url'], "text"),
                       GetSQLValueString($_POST['p_pb9_url'], "text"),
                       GetSQLValueString($_POST['p_pb10_url'], "text"),
                       GetSQLValueString($_POST['p_pa1'], "text"),
                       GetSQLValueString($_POST['p_pa2'], "text"),
                       GetSQLValueString($_POST['p_pa3'], "text"),
                       GetSQLValueString($_POST['p_pa4'], "text"),
                       GetSQLValueString($_POST['p_pa5'], "text"),
					   GetSQLValueString($_POST['p_pa6'], "text"),
                       GetSQLValueString($_POST['p_pa7'], "text"),
                       GetSQLValueString($_POST['p_pa8'], "text"),
                       GetSQLValueString($_POST['p_pa9'], "text"),
                       GetSQLValueString($_POST['p_pa10'], "text"),
                       GetSQLValueString(isset($_POST['p_pa1_soldout']) ? "Y" : "", "defined","'Y'","'N'"),
                       GetSQLValueString(isset($_POST['p_pa2_soldout']) ? "Y" : "", "defined","'Y'","'N'"),
                       GetSQLValueString(isset($_POST['p_pa3_soldout']) ? "Y" : "", "defined","'Y'","'N'"),
                       GetSQLValueString(isset($_POST['p_pa4_soldout']) ? "Y" : "", "defined","'Y'","'N'"),
                       GetSQLValueString(isset($_POST['p_pa5_soldout']) ? "Y" : "", "defined","'Y'","'N'"),
					   GetSQLValueString(isset($_POST['p_pa6_soldout']) ? "Y" : "", "defined","'Y'","'N'"),
                       GetSQLValueString(isset($_POST['p_pa7_soldout']) ? "Y" : "", "defined","'Y'","'N'"),
                       GetSQLValueString(isset($_POST['p_pa8_soldout']) ? "Y" : "", "defined","'Y'","'N'"),
                       GetSQLValueString(isset($_POST['p_pa9_soldout']) ? "Y" : "", "defined","'Y'","'N'"),
                       GetSQLValueString(isset($_POST['p_pa10_soldout']) ? "Y" : "", "defined","'Y'","'N'"),
                       GetSQLValueString(isset($_POST['p_pa1_limit']) ? "Y" : "", "defined","'Y'","'N'"),
                       GetSQLValueString(isset($_POST['p_pa2_limit']) ? "Y" : "", "defined","'Y'","'N'"),
                       GetSQLValueString(isset($_POST['p_pa3_limit']) ? "Y" : "", "defined","'Y'","'N'"),
                       GetSQLValueString(isset($_POST['p_pa4_limit']) ? "Y" : "", "defined","'Y'","'N'"),
                       GetSQLValueString(isset($_POST['p_pa5_limit']) ? "Y" : "", "defined","'Y'","'N'"),
					   GetSQLValueString(isset($_POST['p_pa6_limit']) ? "Y" : "", "defined","'Y'","'N'"),
                       GetSQLValueString(isset($_POST['p_pa7_limit']) ? "Y" : "", "defined","'Y'","'N'"),
                       GetSQLValueString(isset($_POST['p_pa8_limit']) ? "Y" : "", "defined","'Y'","'N'"),
                       GetSQLValueString(isset($_POST['p_pa9_limit']) ? "Y" : "", "defined","'Y'","'N'"),
                       GetSQLValueString(isset($_POST['p_pa9_limit']) ? "Y" : "", "defined","'Y'","'N'"),
                       GetSQLValueString($_POST['p_pa1_limit_num'], "int"),
                       GetSQLValueString($_POST['p_pa2_limit_num'], "int"),
                       GetSQLValueString($_POST['p_pa3_limit_num'], "int"),
                       GetSQLValueString($_POST['p_pa4_limit_num'], "int"),
                       GetSQLValueString($_POST['p_pa5_limit_num'], "int"),
					   GetSQLValueString($_POST['p_pa6_limit_num'], "int"),
                       GetSQLValueString($_POST['p_pa7_limit_num'], "int"),
                       GetSQLValueString($_POST['p_pa8_limit_num'], "int"),
                       GetSQLValueString($_POST['p_pa9_limit_num'], "int"),
                       GetSQLValueString($_POST['p_pa10_limit_num'], "int"),
                       GetSQLValueString($_POST['p_unit'], "text"),
                       GetSQLValueString($_POST['p_price1'], "int"),
                       GetSQLValueString($_POST['p_price2'], "int"),
                       GetSQLValueString($_POST['p_login_price'], "text"),
					   GetSQLValueString($_POST['p_noship_way'], "text"),
                       GetSQLValueString($_POST['p_noship_num'], "int"),
					   GetSQLValueString($_POST['p_noship_price'], "int"),
                       GetSQLValueString($_POST['p_ship_price'], "int"),
                       GetSQLValueString($_POST['p_discount_ratio'], "int"),
                       GetSQLValueString($_POST['p_description'], "text"),
					   GetSQLValueString($_POST['p_memo_online'], "text"),
                       GetSQLValueString($_POST['p_memo'], "text"),
					   GetSQLValueString($_POST['p_other'], "text"),
                       GetSQLValueString($_POST['p_online'], "text"),
                       GetSQLValueString($_POST['rePic'], "text"),
                       GetSQLValueString($_POST['rePic2'], "text"),
                       GetSQLValueString($_POST['p_start_time'], "date"),
                       GetSQLValueString($_POST['p_end_time'], "date"),
                       GetSQLValueString($_POST['p_stock_num'], "int"),
                       GetSQLValueString($_POST['p_order'], "text"),
                       GetSQLValueString($_POST['p_outside'], "text"),
                       GetSQLValueString($_POST['p_outside_url'], "text"),
					   GetSQLValueString($_POST['p_trans_url'], "text"),
                       GetSQLValueString($_POST['p_card'], "text"),
                       GetSQLValueString($_POST['p_webatm'], "text"),
                       GetSQLValueString($_POST['p_atm'], "text"),
                       GetSQLValueString($_POST['p_paynow'], "text"),
                       GetSQLValueString($_POST['p_atm_cathy'], "text"),
					   GetSQLValueString($_POST['p_hang_price'], "int"),
                       GetSQLValueString($_POST['p_type'], "text"),
                       GetSQLValueString($_POST['p_city'], "text"),
                       GetSQLValueString($_POST['p_telphone'], "text"),
                       GetSQLValueString($_POST['p_address'], "text"),
                       GetSQLValueString($_POST['p_gmap'], "text"),
                       GetSQLValueString($_POST['p_act_start'], "date"),
                       GetSQLValueString($_POST['p_act_end'], "date"),
                       GetSQLValueString($_POST['p_time_info'], "text"));

  mysql_select_db($database_iwine, $iwine);
  $Result1 = mysql_query($insertSQL, $iwine) or die(mysql_error());
  
  msg_box('新增成功！');
  go_to('groupbuy_l.php');
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
<script type="text/javascript" src="js/jquery-1.7.2.min.js"></script>
<style type="text/css">@import "js/jquery.datepick.package-3.6.1/jquery.datepick.css";</style> 
<script type="text/javascript" src="js/jquery.datepick.package-3.6.1/jquery.datepick.js"></script>
<script type="text/javascript" src="js/jquery.datepick.package-3.6.1/jquery.datepick.pack.js"></script>
<script type="text/javascript" src="js/jquery.datepick.package-3.6.1/jquery.datepick-zh-TW.js"></script>
<script type="text/javascript" src="ckeditor/ckeditor.js"></script>
</head>

<body marginheight="0" marginwidth="0" bgcolor="#666666">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td align="center" valign="top" bgcolor="666666"><table width="100%" height="1277" border="0" align="center" cellpadding="0" cellspacing="8">
      <tr>
        <td height="2" bgcolor="#FFFFFF"></td>
        </tr>
      <tr>
        <td height="40" align="center" valign="middle"><span class="capw"><font color="#FFFFFF">◎ 新增國內團購內容 ◎</font></span></td>
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
                    <td width="15%" align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">團購專案名稱:</td>
                    <td bgcolor="#FFFFFF" class="text_cap2"><input name="p_name" type="text" class="sform" id="p_name" size="80">**請使用<font color=#ff3366><b>全型</b></font>文字與符號</td>
                  </tr>
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">團購副標題:</td>
                    <td bgcolor="#FFFFFF" class="text_cap2"><input name="p_subtitle" type="text" class="sform" id="p_subtitle" size="100">
                      (勿超過125個字)</td>
                  </tr>
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">團購編號:</td>
                    <td bgcolor="#FFFFFF" class="text_cap2"><input name="p_code" type="text" class="sform" id="p_code"></td>
                    </tr>
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">團購類型:</td>
                    <td bgcolor="#FFFFFF" class="text_cap2"><input type="radio" name="p_type" id="radio" value="act">
                      活動
                        <input name="p_type" type="radio" id="radio2" value="prod" checked>
                        商品</td>
                  </tr>
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">活動地點:</td>
                    <td bgcolor="#FFFFFF" class="text_cap2">
                    <select name="p_city" class="sform" id="p_city">
                        <option value="台北市" checked="checked">台北市</option>
                        <option value="基隆市">基隆市</option>
                        <option value="新北市">新北市</option>
                        <option value="宜蘭縣">宜蘭縣</option>
                        <option value="新竹市">新竹市</option>
                        <option value="新竹縣">新竹縣</option>
                        <option value="桃園縣">桃園縣</option>
                        <option value="苗栗縣">苗栗縣</option>
                        <option value="台中市">台中市</option>
                        <option value="彰化縣">彰化縣</option>
                        <option value="南投縣">南投縣</option>
                        <option value="嘉義市">嘉義市</option>
                        <option value="嘉義縣">嘉義縣</option>
                        <option value="雲林縣">雲林縣</option>
                        <option value="台南市">台南市</option>
                        <option value="高雄市">高雄市</option>
                        <option value="屏東縣">屏東縣</option>
                        <option value="台東縣">台東縣</option>
                        <option value="花蓮縣">花蓮縣</option>
                        <option value="澎湖縣">澎湖縣</option>
                        <option value="金門縣">金門縣</option>
                        <option value="連江縣">連江縣</option>
                      </select>
                      <label for="b_position">*活動類型團購必選</label>
                    </td>
                  </tr>
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">活動地址:</td>
                    <td bgcolor="#FFFFFF" class="text_cap2"><input name="p_address" type="text" class="sform" id="p_address">
                    <label for="b_position">*活動類型團購必填，影響網頁顯示</label></td>
                    </tr>
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">gmap:</td>
                    <td bgcolor="#FFFFFF" class="text_cap2"><input name="p_gmap" type="text" class="sform" id="p_gmap" size="100">
                    <label for="b_position">*活動類型團購必填，影響網頁顯示</label></td>
                    </tr>
                <tr bgcolor="#DDDDDD" class="t9">
                    <td align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">電話:</td>
                    <td bgcolor="#FFFFFF" class="text_cap2"><input name="p_telphone" type="text" class="sform" id="p_telphone">
                    <label for="b_position">*活動類型團購必填，影響網頁顯示</label></td>
                    </tr>
                    <tr bgcolor="#DDDDDD" class="t9">
                    <td align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">活動日期:</td>
                    <td bgcolor="#FFFFFF" class="text_cap2">
                    <input name="p_act_date" type="text" class="sform" id="p_act_date" value="點選選擇日期" size="15"/>
                    </td>
                  </tr>
                    <tr bgcolor="#DDDDDD" class="t9">
                    <td align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">活動時間:</td>
                    <td bgcolor="#FFFFFF" class="text_cap2">
                    <input name="p_act_start" type="text" class="sform" id="p_act_start">開始至
                    <input name="p_act_edn" type="text" class="sform" id="p_act_edn">結束。
                    進場時間說明 <input name="p_time_info" type="text" class="sform" id="p_time_info">
                    <label for="b_position">*活動類型團購必填，影響網頁顯示</label></td>
                    </tr>
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">外部團購:</td>
                    <td bgcolor="#FFFFFF" class="text_cap2"><input type="radio" name="p_outside" id="radio" value="Y">
                      是 
                        <input name="p_outside" type="radio" id="radio2" value="N" checked>
                        否</td>
                  </tr>
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">外部團購連結:</td>
                    <td bgcolor="#FFFFFF" class="text_cap2"><input name="p_outside_url" type="text" class="sform" id="p_outside_url" size="80"></td>
                  </tr>
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">轉址至團購專案ID:</td>
                    <td bgcolor="#FFFFFF" class="text_cap2"><input name="p_trans_url" type="text" class="sform" id="p_trans_url" size="10"></td>
                  </tr>
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">團購商品名1:(不得空白)</td>
                    <td bgcolor="#FFFFFF" class="text_cap2"><input name="p_product1" type="text" class="sform" id="p_product1" size="50">
                      商品代號
                        <input name="p_p1_code" type="text" class="sform" id="p_p1_code">                        <input name="p_p1_soldout" type="checkbox" id="p_p1_soldout">
缺貨中
<input name="p_p1_limit" type="checkbox" id="p_p1_limit" value="Y">
限量
<label for="p_p1_limit_num"></label>
<input name="p_p1_limit_num" type="text" id="p_p1_limit_num" size="5">
份</td>
                  </tr>
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">團購商品名2:</td>
                    <td bgcolor="#FFFFFF" class="text_cap2"><input name="p_product2" type="text" class="sform" id="p_product2" size="50">
商品代號
<input name="p_p2_code" type="text" class="sform" id="p_p2_code">
<input name="p_p2_soldout" type="checkbox" id="p_p2_soldout">
缺貨中 
<input name="p_p2_limit" type="checkbox" id="p_p2_limit" value="Y">
限量
<label for="p_p2_limit_num"></label>
<input name="p_p2_limit_num" type="text" id="p_p2_limit_num" size="5">
份</td>
                  </tr>
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">團購商品名3:</td>
                    <td bgcolor="#FFFFFF" class="text_cap2"><input name="p_product3" type="text" class="sform" id="p_product3" size="50">
商品代號
<input name="p_p3_code" type="text" class="sform" id="p_p3_code">
<input name="p_p3_soldout" type="checkbox" id="p_p3_soldout">
缺貨中 
<input name="p_p3_limit" type="checkbox" id="p_p3_limit" value="Y">
限量
<label for="p_p3_limit_num"></label>
<input name="p_p3_limit_num" type="text" id="p_p3_limit_num" size="5">
份</td>
                  </tr>
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">團購商品名4:</td>
                    <td bgcolor="#FFFFFF" class="text_cap2"><input name="p_product4" type="text" class="sform" id="p_product4" size="50">
商品代號
<input name="p_p4_code" type="text" class="sform" id="p_p4_code">
<input name="p_p4_soldout" type="checkbox" id="p_p4_soldout">
缺貨中 
<input name="p_p4_limit" type="checkbox" id="p_p4_limit" value="Y">
限量
<label for="p_p4_limit_num"></label>
<input name="p_p4_limit_num" type="text" id="p_p4_limit_num" size="5">
份</td>
                  </tr>
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">團購商品名5:</td>
                    <td bgcolor="#FFFFFF" class="text_cap2"><input name="p_product5" type="text" class="sform" id="p_product5" size="50">
商品代號
<input name="p_p5_code" type="text" class="sform" id="p_p5_code">
<input name="p_p5_soldout" type="checkbox" id="p_p5_soldout">
缺貨中 
<input name="p_p5_limit" type="checkbox" id="p_p5_limit" value="Y">
限量
<label for="p_p5_limit_num"></label>
<input name="p_p5_limit_num" type="text" id="p_p5_limit_num" size="5">
份</td>
                  </tr>
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">加購商品:</td>
                    <td bgcolor="#FFFFFF" class="text_cap2"><p>商品一
                        <input name="p_pb1" type="text" class="sform" id="p_pb1">
                        售價
                        <input name="p_pb1_price" type="text" id="p_pb1_price" size="10">
                        <input name="p_pb1_soldout" type="checkbox" id="p_pb1_soldout">
                        缺貨中
                        <input name="p_pb1_limit" type="checkbox" id="p_pb1_limit" value="Y">
                        限量
                        <label for="p_pb1_limit_num"></label>
                        <input name="p_pb1_limit_num" type="text" id="p_pb1_limit_num" size="5">
                        份，連結：
                        <input name="p_pb1_url" type="text" class="sform" id="p_pb1_url" size="40">
                    </p>
                      <p>商品二
                        <input name="p_pb2" type="text" class="sform" id="p_pb2">
                        售價
                        <input name="p_pb2_price" type="text" id="p_pb2_price" size="10">
                        <input name="p_pb2_soldout" type="checkbox" id="p_pb2_soldout">
                        缺貨中
                        <input name="p_pb2_limit" type="checkbox" id="p_pb2_limit" value="Y">
                        限量
                        <label for="p_pb2_limit_num"></label>
                        <input name="p_pb2_limit_num" type="text" id="p_pb2_limit_num" size="5">
                        份，連結：
                        <input name="p_pb2_url" type="text" class="sform" id="p_pb2_url" size="40">
                      </p>
                      <p>商品三
                        <input name="p_pb3" type="text" class="sform" id="p_pb3">
                        售價
                        <input name="p_pb3_price" type="text" id="p_pb3_price" size="10">
                        <input name="p_pb3_soldout" type="checkbox" id="p_pb3_soldout">
                        缺貨中
                        <input name="p_pb3_limit" type="checkbox" id="p_pb3_limit" value="Y">
                        限量
                        <label for="p_pb3_limit_num"></label>
                        <input name="p_pb3_limit_num" type="text" id="p_pb3_limit_num" size="5">
                        份，連結：
                        <input name="p_pb3_url" type="text" class="sform" id="p_pb3_url" size="40">
                      </p>
                      <p>商品四
                        <input name="p_pb4" type="text" class="sform" id="p_pb4">
                        售價
                        <input name="p_pb4_price" type="text" id="p_pb4_price" size="10">
                        <input name="p_pb4_soldout" type="checkbox" id="p_pb4_soldout">
                        缺貨中
                        <input name="p_pb4_limit" type="checkbox" id="p_pb4_limit" value="Y">
                        限量
                        <label for="p_pb4_limit_num"></label>
                        <input name="p_pb4_limit_num" type="text" id="p_pb4_limit_num" size="5">
                        份，連結：
                        <input name="p_pb4_url" type="text" class="sform" id="p_pb4_url" size="40">
                      </p>
                      <p>商品五
                        <input name="p_pb5" type="text" class="sform" id="p_pb5">
                        售價
                        <input name="p_pb5_price" type="text" id="p_pb5_price" size="10">
                        <input name="p_pb5_soldout" type="checkbox" id="p_pb5_soldout">
                        缺貨中
                        <input name="p_pb5_limit" type="checkbox" id="p_pb5_limit" value="Y">
                        限量
                        <label for="p_pb5_limit_num"></label>
                        <input name="p_pb5_limit_num" type="text" id="p_pb5_limit_num" size="5">
                        份，連結：
                        <input name="p_pb5_url" type="text" class="sform" id="p_pb5_url" size="40">
                      </p>
                      <p>商品六
                        <input name="p_pb6" type="text" class="sform" id="p_pb6">
                        售價
                        <input name="p_pb6_price" type="text" id="p_pb6_price" size="10">
                        <input name="p_pb6_soldout" type="checkbox" id="p_pb6_soldout">
                        缺貨中
                        <input name="p_pb6_limit" type="checkbox" id="p_pb6_limit" value="Y">
                        限量
                        <label for="p_pb6_limit_num"></label>
                        <input name="p_pb6_limit_num" type="text" id="p_pb6_limit_num" size="5">
                        份，連結：
                        <input name="p_pb6_url" type="text" class="sform" id="p_pb6_url" size="40">
                    </p>
                      <p>商品七
                        <input name="p_pb7" type="text" class="sform" id="p_pb7">
                        售價
                        <input name="p_pb7_price" type="text" id="p_pb7_price" size="10">
                        <input name="p_pb7_soldout" type="checkbox" id="p_pb7_soldout">
                        缺貨中
                        <input name="p_pb7_limit" type="checkbox" id="p_pb7_limit" value="Y">
                        限量
                        <label for="p_pb7_limit_num"></label>
                        <input name="p_pb7_limit_num" type="text" id="p_pb7_limit_num" size="5">
                        份，連結：
                        <input name="p_pb7_url" type="text" class="sform" id="p_pb7_url" size="40">
                      </p>
                      <p>商品八
                        <input name="p_pb8" type="text" class="sform" id="p_pb8">
                        售價
                        <input name="p_pb8_price" type="text" id="p_pb8_price" size="10">
                        <input name="p_pb8_soldout" type="checkbox" id="p_pb8_soldout">
                        缺貨中
                        <input name="p_pb8_limit" type="checkbox" id="p_pb8_limit" value="Y">
                        限量
                        <label for="p_pb8_limit_num"></label>
                        <input name="p_pb8_limit_num" type="text" id="p_pb8_limit_num" size="5">
                        份，連結：
                        <input name="p_pb8_url" type="text" class="sform" id="p_pb8_url" size="40">
                      </p>
                      <p>商品九
                        <input name="p_pb9" type="text" class="sform" id="p_pb9">
                        售價
                        <input name="p_pb9_price" type="text" id="p_pb9_price" size="10">
                        <input name="p_pb9_soldout" type="checkbox" id="p_pb9_soldout">
                        缺貨中
                        <input name="p_pb9_limit" type="checkbox" id="p_pb9_limit" value="Y">
                        限量
                        <label for="p_pb9_limit_num"></label>
                        <input name="p_pb9_limit_num" type="text" id="p_pb9_limit_num" size="5">
                        份，連結：
                        <input name="p_pb9_url" type="text" class="sform" id="p_pb9_url" size="40">
                      </p>
                      <p>商品十
                        <input name="p_pb10" type="text" class="sform" id="p_pb10">
                        售價
                        <input name="p_pb10_price" type="text" id="p_pb10_price" size="10">
                        <input name="p_pb10_soldout" type="checkbox" id="p_pb10_soldout">
                        缺貨中
                        <input name="p_pb10_limit" type="checkbox" id="p_pb10_limit" value="Y">
                        限量
                        <label for="p_pb10_limit_num"></label>
                        <input name="p_pb10_limit_num" type="text" id="p_pb10_limit_num" size="5">
                        份，連結：
                        <input name="p_pb10_url" type="text" class="sform" id="p_pb10_url" size="40">
                      </p>
                      </td>
                  </tr>
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">自由組合商品:</td>
                    <td bgcolor="#FFFFFF" class="text_cap2"><p>
                      <input name="p_package" type="radio" id="radio6" value="N" checked="CHECKED">
                      關閉
                      <input type="radio" name="p_package" id="radio5" value="Y">
                      啟用，每購買
                      <input name="p_package_per" type="text" class="sform" id="p_package_per" value="1" size="5">
                      份團購商品可選擇
<input name="p_package_num" type="text" class="sform" id="p_package_num" value="0" size="5">
                      個自由組合商品。</p>
                      <p>商品一
                        <input name="p_pa1" type="text" class="sform" id="p_pa1">
                        <input name="p_pa1_soldout" type="checkbox" id="p_pa1_soldout">
                        缺貨中
  <input name="p_pa1_limit" type="checkbox" id="p_pa1_limit" value="Y">
                        限量
  <label for="p_pa1_limit_num"></label>
  <input name="p_pa1_limit_num" type="text" id="p_pa1_limit_num" size="5">
                        份</p>
                      <p>商品二
                        <input name="p_pa2" type="text" class="sform" id="p_pa2">
                        <input name="p_pa2_soldout" type="checkbox" id="p_pa2_soldout">
                        缺貨中
  <input name="p_pa2_limit" type="checkbox" id="p_pa2_limit" value="Y">
                        限量
  <label for="p_pa2_limit_num"></label>
  <input name="p_pa2_limit_num" type="text" id="p_pa2_limit_num" size="5">
                        份</p>
                      <p>商品三
                        <input name="p_pa3" type="text" class="sform" id="p_pa3">
                        <input name="p_pa3_soldout" type="checkbox" id="p_pa3_soldout">
                        缺貨中
  <input name="p_pa3_limit" type="checkbox" id="p_pa3_limit" value="Y">
                        限量
  <label for="p_pa3_limit_num"></label>
  <input name="p_pa3_limit_num" type="text" id="p_pa3_limit_num" size="5">
                        份</p>
                      <p>商品四
                        <input name="p_pa4" type="text" class="sform" id="p_pa4">
                        <input name="p_pa4_soldout" type="checkbox" id="p_pa4_soldout">
                        缺貨中
  <input name="p_pa4_limit" type="checkbox" id="p_pa4_limit" value="Y">
                        限量
  <label for="p_pa4_limit_num"></label>
  <input name="p_pa4_limit_num" type="text" id="p_pa4_limit_num" size="5">
                        份</p>
                      <p>商品五
                        <input name="p_pa5" type="text" class="sform" id="p_pa5">
                        <input name="p_pa5_soldout" type="checkbox" id="p_pa5_soldout">
                        缺貨中
  <input name="p_pa5_limit" type="checkbox" id="p_pa5_limit" value="Y">
                        限量
  <label for="p_pa5_limit_num"></label>
  <input name="p_pa5_limit_num" type="text" id="p_pa5_limit_num" size="5">
                        份</p>
                      <p>商品六
                        <input name="p_pa6" type="text" class="sform" id="p_pa6">
                        <input name="p_pa6_soldout" type="checkbox" id="p_pa6_soldout">
                        缺貨中
  <input name="p_pa6_limit" type="checkbox" id="p_pa6_limit" value="Y">
                        限量
  <label for="p_pa6_limit_num"></label>
  <input name="p_pa6_limit_num" type="text" id="p_pa6_limit_num" size="5">
                        份</p>
                      <p>商品七
                        <input name="p_pa7" type="text" class="sform" id="p_pa7">
                        <input name="p_pa7_soldout" type="checkbox" id="p_pa7_soldout">
                        缺貨中
  <input name="p_pa7_limit" type="checkbox" id="p_pa7_limit" value="Y">
                        限量
  <label for="p_pa7_limit_num"></label>
  <input name="p_pa7_limit_num" type="text" id="p_pa7_limit_num" size="5">
                        份</p>
                      <p>商品八
                        <input name="p_pa8" type="text" class="sform" id="p_pa8">
                        <input name="p_pa8_soldout" type="checkbox" id="p_pa8_soldout">
                        缺貨中
  <input name="p_pa8_limit" type="checkbox" id="p_pa8_limit" value="Y">
                        限量
  <label for="p_pa8_limit_num"></label>
  <input name="p_pa8_limit_num" type="text" id="p_pa8_limit_num" size="5">
                        份</p>
                      <p>商品九
                        <input name="p_pa9" type="text" class="sform" id="p_pa9">
                        <input name="p_pa9_soldout" type="checkbox" id="p_pa9_soldout">
                        缺貨中
  <input name="p_pa9_limit" type="checkbox" id="p_pa9_limit" value="Y">
                        限量
  <label for="p_pa9_limit_num"></label>
  <input name="p_pa9_limit_num" type="text" id="p_pa9_limit_num" size="5">
                        份</p>
                      <p>商品十
                        <input name="p_pa10" type="text" class="sform" id="p_pa10">
                        <input name="p_pa10_soldout" type="checkbox" id="p_pa10_soldout">
                        缺貨中
  <input name="p_pa10_limit" type="checkbox" id="p_pa10_limit" value="Y">
                        限量
  <label for="p_pa10_limit_num"></label>
  <input name="p_pa10_limit_num" type="text" id="p_pa10_limit_num" size="5">
                        份</p>
                      </td>
                  </tr>
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">商品單位:</td>
                    <td bgcolor="#FFFFFF" class="text_cap2"><input name="p_unit" type="text" class="sform" id="p_unit">
                      (例如：本，包，克，200g ....等)</td>
                  </tr>
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">定價:</td>
                    <td bgcolor="#FFFFFF" class="text_cap2"><input name="p_price1" type="text" class="sform" id="p_price1" size="20">元</td>
                  </tr>
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">團購價:</td>
                    <td bgcolor="#FFFFFF" class="text_cap2"><input name="p_price2" type="text" class="sform" id="p_price2" size="20">
                    元，是否登入會員才顯示團購價？
                      <input name="p_login_price" type="radio" id="radio3" value="Y">
                      是 
                      <input name="p_login_price" type="radio" id="radio4" value="N" checked="CHECKED">
                      否</td>
                    </tr>
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">折扣數:</td>
                    <td bgcolor="#FFFFFF" class="text_cap2"><input name="p_discount_ratio" type="text" class="sform" id="p_discount_ratio" size="5">
                      折</td>
                  </tr>
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">運費:</td>
                    <td bgcolor="#FFFFFF" class="text_cap2"><input name="p_ship_price" type="text" class="sform" id="p_ship_price" value="0" size="20">
元</td>
                  </tr>
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">免運條件:</td>
                    <td bgcolor="#FFFFFF" class="text_cap2"><p>
                      <input name="p_noship_way" type="radio" id="p_noship_way2" value="2" checked="CHECKED">
                      購買團購主商品
                      <input name="p_noship_num" type="text" class="sform" id="p_noship_num" value="1" size="5">
                      件（含）免運費
                      ，或 
                      <input type="radio" name="p_noship_way" id="p_noship_way1" value="1">
                      購買金額滿
                      <input name="p_noship_price" type="text" class="sform" id="p_noship_price" value="1" size="5">
                      元（含）免運費
                    </p></td>
                  </tr>
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">團購商品介紹:</td>
                    <td bgcolor="#FFFFFF" class="text_cap2"><textarea name="p_description" id="p_description" cols="45" rows="5" class="ckeditor"></textarea></td>
                  </tr>
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">備註說明:</td>
                    <td bgcolor="#FFFFFF" class="text_cap2"><textarea name="p_memo" id="p_memo" cols="45" rows="5" class="ckeditor"></textarea></td>
                  </tr>
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">體驗分享:</td>
                    <td bgcolor="#FFFFFF" class="text_cap2"><textarea name="p_other" id="p_other" cols="45" rows="5" class="ckeditor"></textarea></td>
                  </tr>
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">小圖片(250x158):</td>
                    <td bgcolor="#FFFFFF" class="text_cap2">&nbsp;<img src="icon_prev.gif" alt="圖片預覽" name="showImg" id="showImg" onClick='javascript:alert("圖片預覽");'>
                      <input type="button" name="Submit" value="準備上傳" onClick="window.open('fupload.php?useForm=form1&amp;prevImg=showImg&amp;upUrl=../webimages/products&amp;ImgS=&amp;ImgW=&amp;ImgH=&amp;reItem=rePic','fileUpload','width=400,height=180')">
                      <input name="rePic" type="hidden" id="rePic" size="4"></td>
                    </tr>
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">大圖片(695x290):</td>
                    <td bgcolor="#FFFFFF" class="text_cap2">&nbsp;<img src="icon_prev.gif" alt="圖片預覽" name="showImg2" id="showImg2" onClick='javascript:alert("圖片預覽");'>
                      <input type="button" name="Submit2" value="準備上傳" onClick="window.open('fupload.php?useForm=form1&amp;prevImg=showImg2&amp;upUrl=../webimages/products&amp;ImgS=&amp;ImgW=&amp;ImgH=&amp;reItem=rePic2','fileUpload','width=400,height=180')">
                      <input name="rePic2" type="hidden" id="rePic2" size="4"></td>
                    </tr>
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">排序:</td>
                    <td bgcolor="#FFFFFF" class="text_cap2"><input name="p_order" type="text" class="sform" id="p_order" size="5"></td>
                  </tr>
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">備貨量:</td>
                    <td bgcolor="#FFFFFF" class="text_cap2"><input name="p_stock_num" type="text" class="sform" id="p_stock_num" value="0"></td>
                  </tr>
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">團購期間:</td>
                    <td bgcolor="#FFFFFF" class="text_cap2"><input name="p_start_time" type="text" class="sform" id="p_start_time" value="點選選擇日期" size="15"/>
                      至
                      <input name="p_end_time" type="text" class="sform" id="p_end_time" value="點選選擇日期" size="15"/></td>
                  </tr>
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">上架:</td>
                    <td bgcolor="#FFFFFF" class="text_cap2"><input type="radio" name="p_online" id="p_online" value="Y">
                      是
                      <input name="p_online" type="radio" id="p_online" value="N" checked>
                      否</td>
                  </tr>
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">信用卡:</td>
                    <td bgcolor="#FFFFFF" class="text_cap2"><input name="p_card" type="radio" id="p_card" value="Y">
                      是
                      <input name="p_card" type="radio" id="p_card" value="N" checked="CHECKED">
                      否</td>
                  </tr>
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">WebATM:</td>
                    <td bgcolor="#FFFFFF" class="text_cap2"><input name="p_webatm" type="radio" id="p_webatm" value="Y">
                      是
                      <input name="p_webatm" type="radio" id="p_webatm" value="N" checked="CHECKED">
                      否</td>
                  </tr>
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">一般匯款:</td>
                    <td bgcolor="#FFFFFF" class="text_cap2"><input name="p_atm_cathy" type="radio" id="p_atm_cathy" value="Y">
                      是
                      <input name="p_atm_cathy" type="radio" id="p_atm_cathy" value="N" checked="CHECKED">
                      否</td>
                  </tr>
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">超商付款:</td>
                    <td bgcolor="#FFFFFF" class="text_cap2"><input name="p_atm" type="radio" id="p_atm" value="Y">
                      是
                      <input name="p_atm" type="radio" id="p_atm" value="N" checked="CHECKED">
                      否</td>
                  </tr>
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">貨到付款:</td>
                    <td bgcolor="#FFFFFF" class="text_cap2"><input name="p_paynow" type="radio" id="p_paynow" value="Y">
                      是，手續費
                        <input name="p_hang_price" type="text" class="sform" id="p_hang_price" value="80" size="5">
                        元
                        <input name="p_paynow" type="radio" id="p_paynow" value="N" checked="CHECKED">
                      否</td>
                  </tr>
                  <tr bgcolor="#DDDDDD" class="t9">
                    <td align="right" background="images/transp.gif" bgcolor="#999999" class="contnet_w">開啟備註:</td>
                    <td bgcolor="#FFFFFF" class="text_cap2"><input name="p_memo_online" type="radio" id="p_memo_online" value="Y" checked="CHECKED">
                      是
                      <input name="p_memo_online" type="radio" id="p_memo_online" value="N">
                      否</td>
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
<script type="text/javascript">
// BeginWebWidget jQuery_UI_Calendar: sdate1
jQuery("#p_act_date").datepick({dateFormat: 'yy-mm-dd'});
// EndWebWidget jQuery_UI_Calendar: sdate1
</script>
