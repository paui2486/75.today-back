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
$query_bar = "SELECT * FROM bar ORDER BY id ASC";
$bar = mysql_query($query_bar, $iwine) or die(mysql_error());
$row_bar = mysql_fetch_assoc($bar);
$totalRows_bar = mysql_num_rows($bar);
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>iWine - 後台管理系統</title>

<link href="css.css" rel="stylesheet" type="text/css">
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
	"aaSorting": [[ 7, "desc" ]],
	"oLanguage": {
      "sLengthMenu": "每頁顯示 _MENU_ 筆酒館資料",
      "sZeroRecords": "無酒館資料",
      "sInfo": "目前顯示 _START_ 到 _END_ 筆，共 _TOTAL_ 筆酒館資料",
      "sInfoEmtpy": "無酒館資料",
      "sInfoFiltered": "共有 _MAX_ 筆酒館資料)",
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
		window.location='winebar_d.php?id='+ids;
	}
}
function MM_goToURL() { //v3.0
  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
}
//-->
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
        <td height="40" align="center" valign="middle"><span class="capw"><font color="#FFFFFF">◎ 檢視酒館資訊 ◎</font></span></td>
        </tr>
      <tr>
        <td height="2" bgcolor="#FFFFFF"></td>
        </tr>
      <tr>
        <td align="center" valign="top"><br><table width="95%" border="0" cellpadding="3" cellspacing="0">          
          <tr bgcolor="#FFFFFF">
            <td>
              <table width="100%" border="0" cellpadding="5" cellspacing="1" id="product_list" class="display">
                <thead>
                <tr bgcolor="#DDDDDD" >
                  <th align="center" background="images/transp.gif" bgcolor="#999999" class="contnet_w">bar 名稱</th>
                  <th align="center" background="images/transp.gif" bgcolor="#999999" class="contnet_w">審核狀態</th>
                  <th align="center" background="images/transp.gif" bgcolor="#999999" class="contnet_w">bar 分類</th>
                  <th align="center" background="images/transp.gif" bgcolor="#999999" class="contnet_w">聯絡人</th>
                  <th align="center" background="images/transp.gif" bgcolor="#999999" class="contnet_w">電話</th>
                  <th align="center" background="images/transp.gif" bgcolor="#999999" class="contnet_w">管理</th>
                  </tr>
                </thead>
                <tbody>
				<?php if ($totalRows_bar > 0) { // Show if recordset not empty ?>
                  <?php do { ?>
                    <tr>
                        <td align="center" bgcolor="#FFFFFF"><?php echo $row_bar['company_name']; ?></td>
                        <td align="center" bgcolor="#FFFFFF">
							<?php 
								if($row_bar['active'] == 1) echo "通過";
								else echo "審核中";
							?>
                        </td>
                        <td align="center" bgcolor="#FFFFFF"><?php echo $row_bar['category']; ?></td>
                        <td align="center" bgcolor="#FFFFFF"><?php echo $row_bar['contact']; ?></td>
                        <td align="center" bgcolor="#FFFFFF"><?php echo $row_bar['telphone']; ?></td>
                        <td align="center" bgcolor="#FFFFFF">
                            <input name="button" type="button" class="sform_g" id="button" onClick="MM_goToURL('self','winebar_s.php?id=<?php echo $row_bar['id']; ?>');return document.MM_returnValue" value="檢視或修改">
                            <input name="button2" type="submit" class="sform_b" id="button2" value="刪除" onClick="dele('<?php echo $row_bar['id']; ?>');"></td>                   
                    </tr>
                    <?php } while ($row_bar = mysql_fetch_assoc($bar)); ?>
					<?php } // Show if recordset not empty ?>
                </tbody>
                  <tfoot>
					<tr bgcolor="#F3F3F1" >
  						<th colspan="13" align="center">
						</th>
                	</tr>
                  </tfoot>
                </table>
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
mysql_free_result($bar);
?>
