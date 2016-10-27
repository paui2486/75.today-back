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

$currentPage = $_SERVER["PHP_SELF"];

mysql_select_db($database_iwine, $iwine);
$query_flash = "SELECT * FROM alliance_contact WHERE c_status > '0' ORDER BY c_datetime DESC";
$flash = mysql_query($query_flash, $iwine) or die(mysql_error());
$row_flash = mysql_fetch_assoc($flash);
$totalRows_flash = mysql_num_rows($flash);
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>iWine - 後台管理系統</title>
<style type="text/css" title="currentStyle">
			@import "demo_page.css";
			@import "demo_table.css";
		</style>
<script type="text/javascript" src="js/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="js/jquery.dataTables.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	$('#product_list').dataTable({
	"bFilter": true,
	"aaSorting": [[ 0, "desc" ]],
	"oLanguage": {
      "sLengthMenu": "每頁顯示 _MENU_ 筆資料",
      "sZeroRecords": "無資料",
      "sInfo": "目前顯示 _START_ 到 _END_ 筆，共 _TOTAL_ 筆資料",
      "sInfoEmtpy": "無會員商品資料",
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
      "aLengthMenu": [[10, 30, 50, 75, 100, -1], ["10", "30", "50", "75", "100", "全部"]]  //设置每页显示记录的下拉菜单
   });
});	

function dele(ids){
	if(window.confirm('確定要刪除?')){
		window.location='alliance_contact_d.php?c_id='+ids;
	}
}

function MM_goToURL() { //v3.0
  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
}
</script>

<link href="css.css" rel="stylesheet" type="text/css">

</head>

<body marginheight="0" marginwidth="0" bgcolor="#666666">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td align="center" valign="top" bgcolor="666666"><table width="100%" height="605" border="0" align="center" cellpadding="0" cellspacing="8">
      <tr>
        <td height="2" bgcolor="#FFFFFF"></td>
        </tr>
      <tr>
        <td height="40" align="center" valign="middle"><span class="capw"><font color="#FFFFFF">◎ 檢視歷史盟友聯絡事項 ◎</font></span></td>
        </tr>
      <tr>
        <td height="2" bgcolor="#FFFFFF"></td>
        </tr>
      <tr>
        <td align="center" valign="top"><table width="90%" border="0" cellpadding="3" cellspacing="0" bgcolor="white">
          <tr>
            <td>
              <div align="center">
                <table width="100%" border="0" cellpadding="5" cellspacing="1" id="product_list" class="display">
                <thead>
                  <tr bgcolor="#DDDDDD" >
                    <th align="center" background="images/transp.gif" bgcolor="#999999" class="contnet_w">時間</td>
                    <th align="center" background="images/transp.gif" bgcolor="#999999" class="contnet_w">聯絡人姓名</td>
                    <th align="center" background="images/transp.gif" bgcolor="#999999" class="contnet_w">聯絡人電話</td>
                    <th align="center" background="images/transp.gif" bgcolor="#999999" class="contnet_w">連絡人E-mail</td>
                    <th align="center" background="images/transp.gif" bgcolor="#999999" class="contnet_w">聯絡主題分類</td>
                    <th align="center" background="images/transp.gif" bgcolor="#999999" class="contnet_w">處理情形</td>
                    <th align="center" background="images/transp.gif" bgcolor="#999999" class="contnet_w">管理</td>
                    </tr>
                 </thead>
                <tbody>
                  <?php do { ?>
                    <?php if ($totalRows_flash > 0) { // Show if recordset not empty ?>
                      <tr class="text_cap2" >
                        <td align="center" bgcolor="#FFFFFF"><?php echo $row_flash['c_datetime']; ?></td>
                        <td align="center" bgcolor="#FFFFFF"><?php echo $row_flash['c_name']; ?></td>
                        <td align="center" bgcolor="#FFFFFF"><?php echo $row_flash['c_tel']; ?></td>
                        <td align="center" bgcolor="#FFFFFF"><?php echo $row_flash['c_email']; ?></td>
                        <td align="center" bgcolor="#FFFFFF"><?php echo $row_flash['c_class']; ?></td>
                        <td align="center" bgcolor="#FFFFFF"><?php if($row_flash['c_status']==1){echo "已回覆";}else{echo "處理中";} ?></td>
                        <td align="center" bgcolor="#FFFFFF"><input name="button" type="button" class="sform_g" id="button" onClick="window.open('alliance_contact_s.php?c_id=<?php echo $row_flash['c_id']; ?>&page=1');return document.MM_returnValue" value="檢視完整內容">
                          <input name="button2" type="button" class="sform_b" id="button2"  onClick="dele('<?php echo $row_flash['c_id']; ?>')" value="刪除"></td>
                        </tr>
                      <?php } // Show if recordset not empty ?>
					  <?php } while ($row_flash = mysql_fetch_assoc($flash)); ?>
                      </tbody>
  
                      </table></td>
                    </tr>
                  </table>
                </div>
              </td>
            </tr>
          </table></td>
      </tr>
    </table></td>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($flash);
?>
