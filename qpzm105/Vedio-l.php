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
//透過sql 下達搜尋需要資料 start 這裡是找 vedio 
mysql_select_db($database_iwine, $iwine);
$query_news = "SELECT * FROM vedio where 1 ORDER BY creat_time DESC";
$news = mysql_query($query_news, $iwine) or die(mysql_error());
$row_news = mysql_fetch_assoc($news);
$totalRows_news = mysql_num_rows($news);
// end
// 上面丟資料比數過來
if (isset($_GET['totalRows_news'])) {
  $totalRows_news = $_GET['totalRows_news'];
} else {
  $all_news = mysql_query($query_news);
  $totalRows_news = mysql_num_rows($all_news);
}
$totalPages_news = ceil($totalRows_news/$maxRows_news)-1;//控制文章頁數

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
$(document).ready(function(){//搜尋功能
	$('#article_list').dataTable({//指定資料庫
	"bFilter": true,
	"aaSorting": [[ 0, "desc" ]],
	"iDisplayLength": 50,
	"oLanguage": {
      "sLengthMenu": "每頁顯示 _MENU_ 筆文章",
      "sZeroRecords": "無文章",
      "sInfo": "目前顯示 _START_ 到 _END_ 筆，共 _TOTAL_ 筆文章",
      "sInfoEmtpy": "無文章",
      "sInfoFiltered": "共有 _MAX_ 筆文章)",
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
		window.location='Vedio-d.php?p_id='+ids;//呼叫刪除的文章的檔案 傳過去的變數是p_id
	}
}

function MM_goToURL() { //v3.0 ???WTF
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
        <td height="40" align="center" valign="middle"><span class="capw"><font color="#FFFFFF">◎ 檢視影片文章內容 ◎</font></span></td>
        </tr>
      <tr>
        <td height="2" bgcolor="#FFFFFF"></td>
        </tr>
      <tr>
        <td align="center" valign="top"><table width="98%" border="0" cellpadding="3" cellspacing="0" bgcolor="494949">        
          <tr  bgcolor="#FFFFFF">
            <td>
            
            <table width="100%" border="0" cellpadding="5" cellspacing="1" id="article_list" class="display">
                <thead>
                <tr bgcolor="#DDDDDD" >
                  <th align="center" background="images/transp.gif" bgcolor="#999999" class="contnet_w">日期</th>
                  <!--<th align="center" background="images/transp.gif" bgcolor="#999999" class="contnet_w">分類</th>-->
                  <th align="center" background="images/transp.gif" bgcolor="#999999" class="contnet_w">標題</th>
                  <!--<th align="center" background="images/transp.gif" bgcolor="#999999" class="contnet_w">瀏覽數</th>-->
                  <!--<th align="center" background="images/transp.gif" bgcolor="#999999" class="contnet_w">發表者</th>-->
                  <th align="center" background="images/transp.gif" bgcolor="#999999" class="contnet_w">內容(部分)</th>
                  <!--<th align="center" background="images/transp.gif" bgcolor="#999999" class="contnet_w">顯示</th>-->
                  <!--<th align="center" background="images/transp.gif" bgcolor="#999999" class="contnet_w">熱門</th>-->
                  <!--<th align="center" background="images/transp.gif" bgcolor="#999999" class="contnet_w">排序</th>-->
                  <th width="15%" align="center" background="images/transp.gif" bgcolor="#999999" class="contnet_w">管理                    
                  </th>
                  </tr>
                  </thead>
                  <tbody>
                <?php do { ?>
                    <?php if ($totalRows_news > 0) { // Show if recordset not empty ?>
  <tr bgcolor="#DDDDDD" >
    <td align="center" bgcolor="#FFFFFF" class="text_cap"><?php echo $row_news['creat_time']; ?></td>
    <!--<td align="center" bgcolor="#FFFFFF" class="text_cap"><?php// echo $row_news['pc_name']; ?></td>-->
    <td align="center" bgcolor="#FFFFFF" class="text_cap"><?php echo $row_news['title']; ?></td>
    <!--<td align="center" bgcolor="#FFFFFF" class="text_cap"><?php//echo $row_news['view_counter']; ?></td>-->
    <!--<td align="center" bgcolor="#FFFFFF" class="text_cap"><?php//echo $row_news['n_name']; ?></td>-->
    <td align="center" bgcolor="#FFFFFF" class="text_cap"><?php echo substr_utf8(strip_tags($row_news['Article']),50); ?></td>
    <td align="center" bgcolor="#FFFFFF" class="contnet_w"><input name="button" type="button" class="sform_g" id="button" onClick="MM_goToURL('self','Video-s.php?id=<?php echo $row_news['id']; ?>');return document.MM_returnValue" value="檢視或修改">
      <input name="button2" type="submit" class="sform_b" id="button2" onClick="dele('<?php echo $row_news['id']; ?>')" value="刪除"></td>
  </tr>
  <?php } // Show if recordset not empty ?>
<?php } while ($row_news = mysql_fetch_assoc($news)); ?>
           </tbody>
           <tfoot>
			<tr bgcolor="#F3F3F1" >
  				<th colspan="12" align="center"></th>
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
mysql_free_result($news);
?>
