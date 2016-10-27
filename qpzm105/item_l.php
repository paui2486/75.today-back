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
$query_item_list = "SELECT * FROM item ORDER BY p_id ASC";
$item_list = mysql_query($query_item_list, $iwine) or die(mysql_error());
$row_item_list = mysql_fetch_assoc($item_list);
$totalRows_item_list = mysql_num_rows($item_list);
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
	"aaSorting": [[ 0, "desc" ]],
	"oLanguage": {
      "sLengthMenu": "每頁顯示 _MENU_ 筆團購資料",
      "sZeroRecords": "無團購資料",
      "sInfo": "目前顯示 _START_ 到 _END_ 筆，共 _TOTAL_ 筆團購資料",
      "sInfoEmtpy": "無會員商品資料",
      "sInfoFiltered": "共有 _MAX_ 筆團購資料)",
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
		window.location='item_d.php?id='+ids;
	}
}
function MM_goToURL() { //v3.0
  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
}
//-->
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
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
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
        <td height="40" align="center" valign="middle"><span class="capw"><font color="#FFFFFF">◎ 檢視加購商品資訊 ◎</font></span></td>
        </tr>
      <tr>
        <td height="2" bgcolor="#FFFFFF"></td>
        </tr>
      <tr>
        <td align="center" valign="top"><br><table width="98%" border="0" cellpadding="3" cellspacing="0">          
          <tr bgcolor="#FFFFFF">
            <td>
              <table width="100%" border="0" cellpadding="5" cellspacing="1" id="product_list" class="display">
                <thead>
                <tr bgcolor="#DDDDDD" >
                  <th align="center" background="images/transp.gif" bgcolor="#999999" class="contnet_w">商品ID</th>
                  <th align="center" background="images/transp.gif" bgcolor="#999999" class="contnet_w">商品名稱</th>
                  <th align="center" background="images/transp.gif" bgcolor="#999999" class="contnet_w">商品代號</th>
                  <th align="center" background="images/transp.gif" bgcolor="#999999" class="contnet_w">原價</th>
                  <th align="center" background="images/transp.gif" bgcolor="#999999" class="contnet_w">團購價</th>
                  <th align="center" background="images/transp.gif" bgcolor="#999999" class="contnet_w">商品連結</th>
                  <th align="center" background="images/transp.gif" bgcolor="#999999" class="contnet_w">管理</th>
                  </tr>
                </thead>
                <tbody>                
                    <?php if ($totalRows_item_list > 0) { // Show if recordset not empty ?>
					<?php do { ?>
                      <tr>
                        <td align="center" bgcolor="#FFFFFF" class="text_cap2"><?php echo $row_item_list['p_id']; ?></td>
                        <td align="center" bgcolor="#FFFFFF" class="text_cap2"><?php echo $row_item_list['p_name']; ?></td>
                        <td align="center" bgcolor="#FFFFFF" class="text_cap2"><?php echo $row_item_list['p_code']; ?></td>
                        <td align="center" bgcolor="#FFFFFF" class="text_cap2"><?php echo $row_item_list['p_price1']; ?></td>
                        <td align="center" bgcolor="#FFFFFF" class="text_cap2"><?php echo $row_item_list['p_price2']; ?></td>
                        <td align="center" bgcolor="#FFFFFF" class="text_cap2"><a href="javascript:MM_openBrWindow('../item.php?p_id=<?php echo $row_item_list['p_id']; ?>','item','scrollbars=yes,width=800,height=600')">item.php?p_id=<?php echo $row_item_list['p_id']; ?></a></td>
                        <td align="center" bgcolor="#FFFFFF"><input name="button" type="button" class="sform_g" id="button" onClick="MM_goToURL('self','item_s.php?p_id=<?php echo $row_item_list['p_id']; ?>');return document.MM_returnValue" value="編輯">                      
                          <input name="button2" type="submit" class="sform_b" id="button2" onClick="dele('<?php echo $row_item_list['p_id']; ?>')" value="刪除"></td>
                      </tr>                      
                    <?php } while ($row_item_list = mysql_fetch_assoc($item_list)); ?>
					<?php } // Show if recordset not empty ?>
                </tbody>
                  <tfoot>
					<tr bgcolor="#F3F3F1" >
  						<th colspan="11" align="center">
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
mysql_free_result($item_list);
?>