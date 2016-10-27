<?php include('session_check.php'); ?>
<?php require_once('../Connections/iwine.php'); ?>
<?php
//資料預先處理開始
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
//資料預先處理結束
//搜尋這之php所需要資料 開始
mysql_select_db($database_iwine, $iwine);
$query_flash = "SELECT * FROM ad_fig ORDER BY b_position,b_order ASC";
$flash = mysql_query($query_flash, $iwine) or die(mysql_error());
$row_flash = mysql_fetch_assoc($flash);
$totalRows_flash = mysql_num_rows($flash);
//搜尋這之php所需要資料 結束

//--
//資料預先處理結束
//將修改資料回傳此區塊 此區塊工作將資料更新對應欄位
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}
$b_status = $_POST['b_status1'];
echo $_POST['b_status1'];

$b_id = $row_flash['b_id'];
echo $b_id;
//
if ((isset($_POST["b_status1"])) && ($_POST["b_status1"] != " ")) {
  $updateSQL = sprintf("UPDATE ad_fig SET b_status=%s WHERE b_id=%s",
                       GetSQLValueString($b_status, "text"),
                       GetSQLValueString($b_id, "int"));

  mysql_select_db($database_iwine, $iwine);
  $Result1 = mysql_query($updateSQL, $iwine) or die(mysql_error());

  $updateGoTo = "ads_l.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}
//將修改資料回傳此區塊 此區塊工作將資料更新對應欄位
//抓從ads_l.php POST過來的b_id
$colname_ad = "-1";
if (isset($_GET['b_id'])) {
  $colname_ad = $_GET['b_id'];
}
//結束
//
mysql_select_db($database_iwine, $iwine);
$query_ad = sprintf("SELECT * FROM ad_fig WHERE b_id = %s", GetSQLValueString($colname_ad, "int"));
$ad = mysql_query($query_ad, $iwine) or die(mysql_error());
$row_ad = mysql_fetch_assoc($ad);
$totalRows_ad = mysql_num_rows($ad);$colname_ad = "-1";

if (isset($_GET['b_id'])) {
  $colname_ad = $_GET['b_id'];
}

mysql_select_db($database_iwine, $iwine);
$query_ad = sprintf("SELECT * FROM ad_fig WHERE b_id = %s ORDER BY b_position ASC,b_order ASC", GetSQLValueString($colname_ad, "int"));
$ad = mysql_query($query_ad, $iwine) or die(mysql_error());
$row_ad = mysql_fetch_assoc($ad);
$totalRows_ad = mysql_num_rows($ad);
//--
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
	"aaSorting": [[ 0, "asc" ]],
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
		window.location='ads_d.php?b_id='+ids;
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
        <td height="40" align="center" valign="middle"><span class="capw"><font color="#FFFFFF">◎ 檢視AD Banner ◎</font></span></td>
      </tr>
      <tr>
        <td height="2" bgcolor="#FFFFFF"></td>
      </tr>
      <tr>
        <td align="center" valign="top"><table width="98%" border="0" cellpadding="3" cellspacing="0" bgcolor="white">
          <tr>
            <td><form name="form1" method="POST">
              <div align="center">
                <table width="100%" border="1" cellpadding="5" cellspacing="0" id="product_list" class="display">
                  <thead
                  <tr bgcolor="#DDDDDD" >
                    <th width="10%" align="center" background="images/transp.gif" bgcolor="#999999" class="contnet_w">位置</td>
                    <th align="center" background="images/transp.gif" bgcolor="#999999" class="contnet_w">圖檔</td>
                    <th width="40%" align="center" background="images/transp.gif" bgcolor="#999999" class="contnet_w">連結</td>
                    <th align="center" background="images/transp.gif" bgcolor="#999999" class="contnet_w">顯示與否</td>
                    <th align="center" background="images/transp.gif" bgcolor="#999999" class="contnet_w">排序</td>
                    <th align="center" background="images/transp.gif" bgcolor="#999999" class="contnet_w">點擊次數</td>
					<th align="center" background="images/transp.gif" bgcolor="#999999" class="contnet_w">ID</td>
                    <th width="15%" align="center" background="images/transp.gif" bgcolor="#999999" class="contnet_w">管理</td>
                    </tr>
                    </thead>
                    <tbody>
				      <?php if ($totalRows_flash > 0) { // Show if recordset not empty ?>
                  <?php do { ?>
                    <tr>
                      <td align="center" bgcolor="#FFFFFF">
					  <?php 
					  //echo $row_flash['b_position'];
					  switch($row_flash['b_position']){
					  case(1):
					  echo "B2";
					  break;
					  case(2):
					  echo "B3";
					  break;
					  case(3):
					  echo "B4";
					  break;
					  case(4):
					  echo "B6";
					  break;
					  case(5):
					  echo "B7";
					  break;
					  case(6):
					  echo "B5";
					  break;
					  case(7):
					  echo "B8";
					  break;
					  }
					  ?></td>
                      <td align="center" bgcolor="#FFFFFF"><?php /*start inputVar script*/ if (isset($row_flash['b_file'])){ ?>
                        <img src="../webimages/ad/<?php echo $row_flash['b_file']; ?>" width="150">
                        <?php } /*end inputVar script*/ ?></td>
                      <td align="center" bgcolor="#FFFFFF"><a href="<?php echo $row_flash['b_url']; ?>" target="_blank"><?php echo $row_flash['b_url']; ?></a></td>
                      <td align="center" bgcolor="#FFFFFF"><?php echo $row_flash['b_status']; ?><br>
					  <form name="b_status" method="post" action="ads_l.php">
					  <select name="b_status1" onchange="javascript:submit()">
						<option value="NULL"> </option>　						
						<option value="Y">開</option>
　						<option value="N">關</option>
					  </select></td>
					  </form>
                      <td align="center" bgcolor="#FFFFFF"><span><?php echo $row_flash['b_order']; ?></span></td>
                      <td align="center" bgcolor="#FFFFFF"><?php echo $row_flash['b_times']; ?></td>
					  <td align="center" bgcolor="#FFFFFF"><?php echo $row_flash['b_id']; ?></td>
                      <td align="center" bgcolor="#FFFFFF"><input name="button" type="button" class="sform_g" id="button" onClick="MM_goToURL('self','ads_s.php?b_id=<?php echo $row_flash['b_id']; ?>');return document.MM_returnValue" value="檢視或修改">
                        <input name="button2" type="button" class="sform_b" id="button2"  onClick="dele('<?php echo $row_flash['b_id']; ?>')" value="刪除"></td>
                    </tr>
                    <?php } while ($row_flash = mysql_fetch_assoc($flash)); ?>
                  <?php } // Show if recordset not empty ?>
  </tbody>

                </table>
              </div>
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
mysql_free_result($flash);
?>
