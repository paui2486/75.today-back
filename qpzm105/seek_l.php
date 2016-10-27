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

mysql_select_db($database_iwine, $iwine);
$query_adopt = "SELECT * FROM seek_detail ORDER BY ap_id DESC";
$adopt = mysql_query($query_adopt, $iwine) or die(mysql_error());
$row_adopt = mysql_fetch_assoc($adopt);
$totalRows_adopt = mysql_num_rows($adopt);
?>
<?php
//***** PHP中限制文字顯示自訂函式開始 *****
function cutword($cutstring,$cutno){
 if(strlen($cutstring) > $cutno) { 
  for($i=0;$i<$cutno;$i++) { 
   $ch=substr($cutstring,$i,1); 
   if(ord($ch)>127) $i++; 
  } 
 $cutstring= substr($cutstring,0,$i)."..."; 
 } 
return $cutstring; 
}
//***** PHP中限制文字顯示自訂函式結束 *****
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
<style type="text/css" title="currentStyle">
			@import "demo_page.css";
			@import "demo_table.css";
		</style>

<script type="text/javascript" src="js/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="js/jquery.dataTables.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	$('#seek_list').dataTable({
	"bFilter": true,
	"aaSorting": [[ 1, "desc" ]],
	"oLanguage": {
      "sLengthMenu": "每頁顯示 _MENU_ 筆資料",
      "sZeroRecords": "無資料",
      "sInfo": "目前顯示 _START_ 到 _END_ 筆，共 _TOTAL_ 筆資料",
      "sInfoEmtpy": "無資料",
      "sInfoFiltered": "共有 _MAX_ 筆資料)",
      "sProcessing": "正在載入中...",
      "sSearch": "搜尋",
      "sUrl": "", //多语言配置文件，可将oLanguage的设置放在一个txt文件中，例：Javascript/datatable/dtCH.txt
      "oPaginate": {
          "sFirst":    "第一頁",
          "sPrevious": " 上一頁 ",
          "sNext":     " 下一頁 ",
          "sLast":     " 最後一頁 "
      }
  }, 
      "aLengthMenu": [[10, 25, 50, 75, 100, -1], ["10", "25", "50", "75", "100", "全部"]]  //设置每页显示记录的下拉菜单
   });
});	
</script>
<script type="text/javascript">
<!--
function dele(ids){
	if(window.confirm('確定要刪除?')){
		window.location='seek_d.php?ap_id='+ids;
	}
}

function MM_goToURL() { //v3.0
  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
}
//-->
</script>
<script type="text/javascript">
function tmt_confirm(msg){
	document.MM_returnValue=(confirm(unescape(msg)));
}
</script>
<style type="text/css">
<!--
a:link {
	text-decoration: none;
}
a:visited {
	text-decoration: none;
}
a:hover {
	text-decoration: none;
}
a:active {
	text-decoration: none;
}
-->
</style>
</head>

<body marginheight="0" marginwidth="0" bgcolor="#666666">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td align="center" valign="top" bgcolor="666666"><table width="100%" height="605" border="0" align="center" cellpadding="0" cellspacing="8">
      <tr>
        <td height="2" bgcolor="#FFFFFF"></td>
        </tr>
      <tr>
        <td height="40" align="center" valign="middle"><span class="capw"><font color="#FFFFFF">◎ 檢視協尋資訊 ◎</font></span></td>
        </tr>
      <tr>
        <td height="2" bgcolor="#FFFFFF"></td>
        </tr>
      <tr>
        <td align="center" valign="top"><table width="95%" border="0" cellpadding="3" cellspacing="0" bgcolor="494949">        
          <tr  bgcolor="#FFFFFF">
            <td>
            
            <table width="100%" border="0" cellpadding="5" cellspacing="1" id="seek_list" class="display">
                <thead>
                <tr bgcolor="#DDDDDD" >
                  <th align="center" background="images/transp.gif" bgcolor="#999999" class="contnet_w">ID</th>
                  <th align="center" background="images/transp.gif" bgcolor="#999999" class="contnet_w">編號</th>
                  <th align="center" background="images/transp.gif" bgcolor="#999999" class="contnet_w">公告日期</th>
                  <th align="center" background="images/transp.gif" bgcolor="#999999" class="contnet_w">走失或尋獲日期</th>
                  <th align="center" background="images/transp.gif" bgcolor="#999999" class="contnet_w">分類</th>
                  <th align="center" background="images/transp.gif" bgcolor="#999999" class="contnet_w">所在地</th>
                  <th align="center" background="images/transp.gif" bgcolor="#999999" class="contnet_w">名字</th>
                  <th align="center" background="images/transp.gif" bgcolor="#999999" class="contnet_w">品種</th>
                  <th align="center" background="images/transp.gif" bgcolor="#999999" class="contnet_w">年齡</th>
                  <th align="center" background="images/transp.gif" bgcolor="#999999" class="contnet_w">性別</th>
                  <th align="center" background="images/transp.gif" bgcolor="#999999" class="contnet_w">聯絡人</th>
                  <th align="center" background="images/transp.gif" bgcolor="#999999" class="contnet_w">聯絡電話</th>
                  <th align="center" background="images/transp.gif" bgcolor="#999999" class="contnet_w">狀態</th>
                  <th align="center" background="images/transp.gif" bgcolor="#999999" class="contnet_w">顯示</th>
                  <th width="15%" align="center" background="images/transp.gif" bgcolor="#999999" class="contnet_w">管理                    
                  </th>
                  </tr>
                  </thead>
                  <tbody>
                <?php do { ?>
                    <?php if ($totalRows_adopt > 0) { // Show if recordset not empty ?>
  <tr bgcolor="#DDDDDD" >
    <td align="center" bgcolor="#FFFFFF" class="text_cap"><?php echo $row_adopt['ap_id']; ?></td>
    <td align="center" bgcolor="#FFFFFF" class="text_cap"><?php echo $row_adopt['ap_code']; ?></td>
    <td align="center" bgcolor="#FFFFFF" class="text_cap"><?php echo $row_adopt['ap_date']; ?></td>
    <td align="center" bgcolor="#FFFFFF" class="text_cap"><?php echo $row_adopt['ap_date2']; ?></td>
    <td align="center" bgcolor="#FFFFFF" class="text_cap">
	<?php 
	switch($row_adopt['ap_class']){ 
	case '1':
		echo "找主人";
		break;
	case '2':
		echo "找毛寶貝";
		break;
	}		
	?>
    </td>
    <td align="center" bgcolor="#FFFFFF" class="text_cap"><?php echo $row_adopt['ap_county']; ?><?php echo $row_adopt['ap_city']; ?></td>
    <td align="center" bgcolor="#FFFFFF" class="text_cap"><?php echo $row_adopt['ap_name']; ?></td>
    <td align="center" bgcolor="#FFFFFF" class="text_cap"><?php echo $row_adopt['ap_breed']; ?></td>
    <td align="center" bgcolor="#FFFFFF" class="text_cap"><?php echo $row_adopt['ap_age']; ?></td>
    <td align="center" bgcolor="#FFFFFF" class="text_cap"><?php echo $row_adopt['ap_sex']; ?></td>
    <td align="center" bgcolor="#FFFFFF" class="text_cap"><?php echo $row_adopt['ap_m_name']; ?></td>
    <td align="center" bgcolor="#FFFFFF" class="text_cap"><?php echo $row_adopt['ap_m_tel']; ?></td>
    <td align="center" bgcolor="#FFFFFF" class="text_cap">
    <?php 
	switch($row_adopt['ap_status']){ 
	case '1':
		echo "等待主人中";
		break;
	case '2':
		echo "新待毛寶貝中";
		break;
	case '3':
		echo "已回到溫暖的家";
		break;
	}		
	?>
    </td>
    <td align="center" bgcolor="#FFFFFF" class="text_cap"><?php echo $row_adopt['ap_show']; ?></td>
    <td align="center" bgcolor="#FFFFFF" class="contnet_w"><input name="button" type="button" class="sform_g" id="button" onClick="MM_goToURL('self','seek_s.php?ap_id=<?php echo $row_adopt['ap_id']; ?>');return document.MM_returnValue" value="檢視或修改">
      <input name="button2" type="submit" class="sform_b" id="button2" onClick="dele('<?php echo $row_adopt['ap_id']; ?>')" value="刪除"></td>
  </tr>
  <?php } // Show if recordset not empty ?>
<?php } while ($row_adopt = mysql_fetch_assoc($adopt)); ?>
           </tbody>
           <tfoot>
			<tr bgcolor="#F3F3F1" >
  				<th colspan="18" align="center"></th>
            </tr>
           </tfoot>
                </table>
              </td>
            </tr>
          </table>           
            </td>
      </tr>
    </table></td>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($adopt);
?>
