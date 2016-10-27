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
$query_Product_List = "SELECT * FROM Product_shop LEFT JOIN Product_Class ON Product_shop.p_class = Product_Class.pc_id LEFT JOIN Product_Type ON Product_shop.p_type = Product_Type.py_id";
$Product_List = mysql_query($query_Product_List, $iwine) or die(mysql_error());
$row_Product_List = mysql_fetch_assoc($Product_List);
$totalRows_Product_List = mysql_num_rows($Product_List);

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
	"aaSorting": [[ 8, "desc" ]],
	"oLanguage": {
      "sLengthMenu": "每頁顯示 _MENU_ 個商品",
      "sZeroRecords": "無商品資料",
      "sInfo": "目前顯示 _START_ 到 _END_ 筆，共 _TOTAL_ 個商品",
      "sInfoEmtpy": "無商品資料",
      "sInfoFiltered": "共有 _MAX_ 個商品)",
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
		window.location='product_d.php?p_id='+ids;
	}
}
//-->
</script>
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
function MM_goToURL() { //v3.0
  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
}

function form1_reset(){
$('#keyword').val("");
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
        <td height="40" align="center" valign="middle"><span class="capw"><font color="#FFFFFF">◎ 檢視商品內容 ◎</font></span></td>
        </tr>
      <tr>
        <td height="2" bgcolor="#FFFFFF"></td>
        </tr>
      <!--
      <tr>
        <td height="30" align="center"><form name="form1" method="get" action="">
          <span class="contnet_w"> 輸入關鍵字搜尋商品</span>
          <input name="keyword" type="text" class="sform" id="keyword" value="<?php //echo $_GET['keyword']; ?>">
          <input name="button3" type="submit" class="sform_b" id="button3" value="搜尋">
          <input name="button4" type="button" class="sform_g" id="button4" onClick="form1_reset()" value="清除">
        </form></td>
      </tr>
      -->
      <tr>
        <td align="center" valign="top"><table width="98%" border="0" cellpadding="3" cellspacing="0">
          
          <tr bgcolor="#FFFFFF">
            <td class="text_cap"><div align="center">
              <table width="100%" border="0" cellpadding="5" cellspacing="1" id="product_list" class="display">
                <thead>
                <tr class="text_cap">
                  <th align="center" bgcolor="#666666">商品ID</th>
                  <th align="center" bgcolor="#666666">商品分類</th>
                  <th align="center" bgcolor="#666666">商品貨號</th>
                  <th align="center" bgcolor="#666666">商品名稱</th>
                  <th align="center" bgcolor="#666666">原價</th>
                  <th align="center" bgcolor="#666666">會員價</th>
                  <th align="center" bgcolor="#666666">優惠價</th>
                  <th align="center" bgcolor="#666666">商品屬性</th>
                  <th align="center" bgcolor="#666666">最近更新</th>
                  <th width="5%" align="center" bgcolor="#666666">排序</th>
                  <th width="5%" align="center" bgcolor="#666666">上架</th>
                  <th width="5%" align="center" bgcolor="#666666">首頁顯示</th>
                  <th width="5%" align="center" bgcolor="#666666">庫存</th>
                  <th width="15%" align="center" bgcolor="#666666">管理</th>
                  </tr>
                  </thead>
                  <tbody>
                   <?php if ($totalRows_Product_List > 0) { // Show if recordset not empty ?> 
                   <?php do { ?>
  <tr>
    <td align="center" ><?php echo $row_Product_List['p_id']; ?></td>
    <td align="center" >
    <?php 
if($row_Product_List['pc_level1'] <> 0){
	
$pid = $row_Product_List['pc_level1'];

mysql_select_db($database_iwine, $iwine);
$query_class1 = "SELECT * FROM Product_Class WHERE pc_id = '$pid'";
$class1 = mysql_query($query_class1, $iwine) or die(mysql_error());
$row_class1 = mysql_fetch_assoc($class1);
$totalRows_class1 = mysql_num_rows($class1);

echo $row_class1['pc_name']." / ";
}
if($row_Product_List['pc_level2'] <> 0){
	
$pid2 = $row_Product_List['pc_level2'];

mysql_select_db($database_iwine, $iwine);
$query_class2 = "SELECT * FROM Product_Class WHERE pc_id = '$pid2'";
$class2 = mysql_query($query_class2, $iwine) or die(mysql_error());
$row_class2 = mysql_fetch_assoc($class2);
$totalRows_class2 = mysql_num_rows($class2);

echo  $row_class2['pc_name']." / ";
}

$pid3 = $row_Product_List['p_class'];

mysql_select_db($database_iwine, $iwine);
$query_class3 = "SELECT * FROM Product_Class WHERE pc_id = '$pid3'";
$class3 = mysql_query($query_class3, $iwine) or die(mysql_error());
$row_class3 = mysql_fetch_assoc($class3);
$totalRows_class3 = mysql_num_rows($class3);

echo  $row_class3['pc_name'];
?>
    </td>
    <td align="center" ><?php echo $row_Product_List['p_code']; ?></td>
    <td align="center" ><?php echo $row_Product_List['p_name']; ?></td>
    <td align="center" ><?php echo $row_Product_List['p_price1']; ?></td>
    <td align="center" ><?php echo $row_Product_List['p_price2']; ?></td>
    <td align="center" ><?php echo $row_Product_List['p_price3']; ?></td>
    <td align="center" ><?php echo $row_Product_List['py_name']; ?></td>
    <td align="center" ><?php echo $row_Product_List['p_update_time']; ?></td>
    <td align="center" ><?php echo $row_Product_List['p_order']; ?></td>
    <td align="center" ><?php echo $row_Product_List['p_online']; ?></td>
    <td align="center" ><?php echo $row_Product_List['p_index']; ?></td>
    <td align="center" ><?php echo $row_Product_List['p_storage']; ?></td>
    <td align="center" ><input name="button" type="button" class="sform_g" id="button" onClick="window.open('product_s.php?p_id=<?php echo $row_Product_List['p_id']; ?>');return true;" value="檢視或修改">
      <input name="button2" type="submit" class="sform_r" id="button2" value="刪除" onClick="dele('<?php echo $row_Product_List['p_id']; ?>');">
      <input name="button3" type="submit" class="sform_b" id="button3" onClick="MM_goToURL('self','product_a2.php?p_id=<?php echo $row_Product_List['p_id']; ?>');return document.MM_returnValue" value="複製"></td>
  </tr>
  <?php } while ($row_Product_List = mysql_fetch_assoc($Product_List)); ?>
  <?php } // Show if recordset not empty ?>                 
  <?php if ($totalRows_Product_List == 0) { // Show if recordset empty ?>
  <tr bgcolor="#F3F3F1" >
    <td colspan="14" align="center" class="text_cap">查無商品資料！</td>
  </tr>
  <?php } // Show if recordset empty ?>
</tbody>
<tfoot>
<tr bgcolor="#F3F3F1" >
  <th colspan="14" align="center">
<?php /* ?>
  <!-- 
  <table border="0">
    <tr>
      <td><?php if ($pageNum_Product_List > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_Product_List=%d%s&keyword=%s", $currentPage, 0, $queryString_Product_List, $_GET['keyword']); ?>"><img src="images/i-01.gif" border="0"></a>
        <?php } // Show if not first page ?></td>
      <td><?php if ($pageNum_Product_List > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_Product_List=%d%s&keyword=%s", $currentPage, max(0, $pageNum_Product_List - 1, $_GET['keyword']), $queryString_Product_List); ?>"><img src="images/i-03.gif" border="0"></a>
        <?php } // Show if not first page ?></td>
      <td class="text_cap"><?php  $tp = $totalPages_Product_List+1;for($i=1;$i<=$tp;$i++){ ?>
        <a href="<?php printf("%s?pageNum_Product_List=%d%s&keyword=%s", $currentPage, max(0, $i - 1), $queryString_Product_List, $_GET['keyword']); ?>">
          <?php if($i == $pageNum_Product_List + 1 ){ echo "<u>".$i."</u>";}else{echo $i;} ?>
          </a>
        <?php }?></td>
      <td><?php if ($pageNum_Product_List < $totalPages_Product_List) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_Product_List=%d%s&keyword=%s", $currentPage, min($totalPages_Product_List, $pageNum_Product_List + 1), $queryString_Product_List, $_GET['keyword']); ?>"><img src="images/i-04.gif" border="0"></a>
        <?php } // Show if not last page ?></td>
      <td><?php if ($pageNum_Product_List < $totalPages_Product_List) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_Product_List=%d%s&keyword=%s", $currentPage, $totalPages_Product_List, $queryString_Product_List, $_GET['keyword']); ?>"><img src="images/i-02.gif" border="0"></a>
        <?php } // Show if not last page ?></td>
    </tr>
  </table>--><?php */ ?></th>
                </tr></tfoot>
                </table>
              </div></td>
            </tr>
          </table></td>
        </tr>
    </table></td>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($Product_List);
?>
