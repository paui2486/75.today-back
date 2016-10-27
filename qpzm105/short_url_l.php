<?php include('session_check.php'); ?>
<?php require_once('../Connections/iwine.php'); ?>
<?php include_once('../bitly/bitly.php'); ?>
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
$query_su_list = "SELECT * FROM short_url ORDER BY su_id DESC";
$su_list = mysql_query($query_su_list, $iwine) or die(mysql_error());
$row_su_list = mysql_fetch_assoc($su_list);
$totalRows_su_list = mysql_num_rows($su_list);
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>iWine - 後台管理系統</title>
<link href="css.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="js/jquery-1.7.2.min.js"></script>
<style type="text/css" title="currentStyle">
			@import "demo_page.css";
			@import "demo_table.css";
		</style>
<script type="text/javascript" src="js/jquery.dataTables.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	$('#product_list').dataTable({
	"bFilter": true,
	"aaSorting": [[ 0, "desc" ]],
	"iDisplayLength": 25,
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
function tmt_confirm(msg){
	document.MM_returnValue=(confirm(unescape(msg)));
}

function dele(pid){
	if(window.confirm('確定要刪除?')){
		window.location='short_url_d.php?su_id='+pid;
	}
}
function MM_goToURL() { //v3.0
  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
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
        <td height="40" align="center" valign="middle"><span class="capw"><font color="#FFFFFF">◎ 短網址管理 ◎</font></span></td>
        </tr>
      <tr>
        <td height="2" bgcolor="#FFFFFF"></td>
        </tr>
      <tr>
        <td align="center" valign="top"><table width="95%" border="0" cellpadding="3" cellspacing="0">          
          <tr bgcolor="#FFFFFF">
            <td class="bg_cap">
              <table width="100%" border="0" cellpadding="5" cellspacing="1" id="product_list" class="display">
                <thead>
                  <tr bgcolor="#DDDDDD" >
                    <th align="center" background="images/transp.gif" bgcolor="#999999" class="contnet_w">ID</th>
                    <th align="center" background="images/transp.gif" bgcolor="#999999" class="contnet_w">短網址名稱</th>
                    <th align="center" background="images/transp.gif" bgcolor="#999999" class="contnet_w">原有網址(點擊無統計)</th>
                    <th align="center" background="images/transp.gif" bgcolor="#999999" class="contnet_w">短網址(點擊可統計)</th>
                    <th align="center" background="images/transp.gif" bgcolor="#999999" class="contnet_w">說明</th>
                    <th align="center" background="images/transp.gif" bgcolor="#999999" class="contnet_w">管理</th>
                    </tr>
                  </thead>
                <tbody>
                  <?php do { ?>
                    <tr>
                      <td align="center" bgcolor="#FFFFFF"><?php echo $row_su_list['su_id']; ?></td>
                      <td align="center" bgcolor="#FFFFFF"><?php echo $row_su_list['su_title']; ?></td>
                      <td align="center" bgcolor="#FFFFFF"><a href="<?php echo $row_su_list['su_url']; ?>" target="new"><?php echo $row_su_list['su_url']; ?></a></td>
                      <td align="center" bgcolor="#FFFFFF"><a href="<?php echo $row_su_list['su_url_short']; ?>" target="new"><?php echo $row_su_list['su_url_short']; ?></a></td>
                      <td align="left" bgcolor="#FFFFFF"><?php echo $row_su_list['su_memo']; ?></td>
                      <td align="center" bgcolor="#FFFFFF"><input name="button" type="button" class="sform_g" id="button" onClick="MM_goToURL('self','short_url_s.php?su_id=<?php echo $row_su_list['su_id']; ?>');return document.MM_returnValue" value="編輯">
                        <input name="button5" type="submit" class="sform_b" id="button5" onClick="window.open('<?php echo $row_su_list['su_url_short']."+"; ?>');" value="點擊統計">
                        <input name="button2" type="submit" class="sform_r" id="button2" onClick="dele('<?php echo $row_su_list['su_id']; ?>')" value="刪除"></td>
                      </tr>
                    <?php } while ($row_su_list = mysql_fetch_assoc($su_list)); ?>
                  </tbody>
                <tfoot>
                  <tr bgcolor="#F3F3F1" >
                    <th colspan="10" align="center">
                      </th>
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
mysql_free_result($su_list);
?>
