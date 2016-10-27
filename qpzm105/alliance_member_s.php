<?php include('session_check.php'); ?>
<?php include_once('../bitly/bitly.php'); ?>
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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE alliance_member SET am_passwd=%s, am_name=%s, am_company=%s, am_company_code=%s, am_tel=%s, am_fax=%s, am_mobile=%s, am_email=%s, am_address=%s, am_weburl=%s, am_payway=%s, am_fa=%s, am_bank_name=%s, am_bank_brench=%s, am_bank_code=%s, am_bank_account=%s, am_last_modify=%s, am_memo=%s, am_ratio=%s WHERE am_id=%s",
                       GetSQLValueString(md5($_POST['am_passwd']), "text"),
                       GetSQLValueString($_POST['am_name'], "text"),
                       GetSQLValueString($_POST['am_company'], "text"),
                       GetSQLValueString($_POST['am_company_code'], "text"),
                       GetSQLValueString($_POST['am_tel'], "text"),
                       GetSQLValueString($_POST['am_fax'], "text"),
                       GetSQLValueString($_POST['am_mobile'], "text"),
                       GetSQLValueString($_POST['am_email'], "text"),
                       GetSQLValueString($_POST['am_address'], "text"),
                       GetSQLValueString($_POST['am_weburl'], "text"),
                       GetSQLValueString($_POST['am_payway'], "text"),
                       GetSQLValueString($_POST['am_fa'], "text"),
                       GetSQLValueString($_POST['am_bank_name'], "text"),
                       GetSQLValueString($_POST['am_bank_brench'], "text"),
                       GetSQLValueString($_POST['am_bank_code'], "text"),
                       GetSQLValueString($_POST['am_bank_account'], "text"),
                       GetSQLValueString($_POST['am_last_modify'], "date"),
                       GetSQLValueString($_POST['am_memo'], "text"),
                       GetSQLValueString($_POST['am_ratio'], "int"),
                       GetSQLValueString($_POST['am_id'], "int"));

  mysql_select_db($database_iwine, $iwine);
  $Result1 = mysql_query($updateSQL, $iwine) or die(mysql_error());

  $updateGoTo = "alliance_member_l.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_alliance_detail = "-1";
if (isset($_GET['am_id'])) {
  $colname_alliance_detail = $_GET['am_id'];
}
mysql_select_db($database_iwine, $iwine);
$query_alliance_detail = sprintf("SELECT * FROM alliance_member WHERE am_id = %s", GetSQLValueString($colname_alliance_detail, "int"));
$alliance_detail = mysql_query($query_alliance_detail, $iwine) or die(mysql_error());
$row_alliance_detail = mysql_fetch_assoc($alliance_detail);
$totalRows_alliance_detail = mysql_num_rows($alliance_detail);

$colname_ap_list = "-1";
if (isset($_GET['am_id'])) {
  $colname_ap_list = $_GET['am_id'];
}
mysql_select_db($database_iwine, $iwine);
$query_ap_list = sprintf("SELECT * FROM alliance_project LEFT JOIN alliance_case ON alliance_project.ap_ac_id = alliance_case.ac_id WHERE ap_am_id = %s ORDER BY ap_id DESC", GetSQLValueString($colname_ap_list, "int"));
$ap_list = mysql_query($query_ap_list, $iwine) or die(mysql_error());
$row_ap_list = mysql_fetch_assoc($ap_list);
$totalRows_ap_list = mysql_num_rows($ap_list);


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
function MM_goToURL() { //v3.0
  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
}

function dele(pid, mid){
	if(window.confirm('確定要刪除?')){
		window.location='alliance_project_d.php?ap_id='+pid+'&am_id='+mid;
	}
}
</script>
<script type="text/javascript" src="ckeditor/ckeditor.js"></script>
</head>

<body marginheight="0" marginwidth="0" bgcolor="#666666">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td align="center" valign="top" bgcolor="666666"><table width="100%" height="605" border="0" align="center" cellpadding="0" cellspacing="8">
      <tr>
        <td height="2" bgcolor="#FFFFFF"></td>
        </tr>
      <tr>
        <td height="40" align="center" valign="middle"><span class="capw"><font color="#FFFFFF">◎ 檢視盟友資料 ◎</font></span></td>
        </tr>
      <tr>
        <td height="2" bgcolor="#FFFFFF"></td>
        </tr>
      <tr>
        <td align="center"></td>
        </tr>
      <tr>
        <td align="center" valign="top"><div align="center">
          <form action="<?php echo $editFormAction; ?>" name="form1" method="POST">
            <table width="90%" border="0" cellspacing="0" cellpadding="3">
              <tr>
                <td bgcolor="#494949"><table width="100%" border="0" cellpadding="4" cellspacing="1" class="table">
                  <tr>
                    <td colspan="4" align="center" background="images/transp.gif" bgcolor="#999999" class="contnet_w">盟友基本資料</td>
                    </tr>
                  <tr>
                    <td background="images/transp.gif" bgcolor="#999999" class="contnet_w"><div align="right">盟友專屬代號:</div></td>
                    <td valign="middle" bgcolor="#FFFFFF" class="sform"><?php echo $row_alliance_detail['am_code']; ?></td>
                    <td valign="middle" background="images/transp.gif" bgcolor="#999999" class="contnet_w"><div align="right">加入時間:</div></td>
                    <td valign="middle" bgcolor="#FFFFFF" class="sform"><?php echo $row_alliance_detail['am_regist_datetime']; ?></td>
                  </tr>
                  <tr>
                    <td background="images/transp.gif" bgcolor="#999999" class="contnet_w"><div align="right">帳號:</div></td>
                    <td valign="middle" bgcolor="#FFFFFF" class="sform"><label for="am_account"><?php echo $row_alliance_detail['am_account']; ?></label></td>
                    <td valign="middle" background="images/transp.gif" bgcolor="#999999" class="contnet_w"><div align="right">修改密碼:</div></td>
                    <td valign="middle" bgcolor="#FFFFFF" class="sform"><label for="am_passwd"></label>
                      <input name="am_passwd" type="password" class="sform" id="am_passwd" value=""></td>
                  </tr>
                  <tr>
                    <td width="20%" background="images/transp.gif" bgcolor="#999999" class="contnet_w"><div align="right">姓名:</div></td>
                    <td width="30%" valign="middle" bgcolor="#FFFFFF" class="sform"><input name="am_name" type="text" class="sform" id="am_name" value="<?php echo $row_alliance_detail['am_name']; ?>"></td>
                    <td width="20%" valign="middle" background="images/transp.gif" bgcolor="#999999" class="contnet_w"><div align="right">公司名稱 / 統編:</div></td>
                    <td width="30%" valign="middle" bgcolor="#FFFFFF" class="sform"><label for="am_company"></label>
                      <input name="am_company" type="text" class="sform" id="am_company" value="<?php echo $row_alliance_detail['am_company']; ?>" size="25"> 
                      / 
                      <label for="am_company_code"></label>
                      <input name="am_company_code" type="text" class="sform" id="am_company_code" value="<?php echo $row_alliance_detail['am_company_code']; ?>" size="15"></td>
                  </tr>
                  <tr>
                    <td background="images/transp.gif" bgcolor="#999999" class="contnet_w"><div align="right">電話:</div></td>
                    <td valign="middle" bgcolor="#FFFFFF" class="sform"><label for="am_tel"></label>
                      <input name="am_tel" type="text" class="sform" id="am_tel" value="<?php echo $row_alliance_detail['am_tel']; ?>"></td>
                    <td valign="middle" background="images/transp.gif" bgcolor="#999999" class="contnet_w"><div align="right">手機:</div></td>
                    <td valign="middle" bgcolor="#FFFFFF" class="sform"><label for="am_mobile"></label>
                      <input name="am_mobile" type="text" class="sform" id="am_mobile" value="<?php echo $row_alliance_detail['am_mobile']; ?>"></td>
                  </tr>
                  <tr>
                    <td background="images/transp.gif" bgcolor="#999999" class="contnet_w"><div align="right">傳真:</div></td>
                    <td valign="middle" bgcolor="#FFFFFF" class="sform"><label for="am_fax"></label>
                      <input name="am_fax" type="text" class="sform" id="am_fax" value="<?php echo $row_alliance_detail['am_fax']; ?>"></td>
                    <td valign="middle" background="images/transp.gif" bgcolor="#999999" class="contnet_w"><div align="right">E-mail:</div></td>
                    <td valign="middle" bgcolor="#FFFFFF" class="sform"><label for="am_email"></label>
                      <input name="am_email" type="text" class="sform" id="am_email" value="<?php echo $row_alliance_detail['am_email']; ?>" size="40"></td>
                  </tr>
                  <tr>
                    <td background="images/transp.gif" bgcolor="#999999" class="contnet_w"><div align="right">地址:</div></td>
                    <td colspan="3" valign="middle" bgcolor="#FFFFFF" class="sform"><label for="am_address"></label>
                      <input name="am_address" type="text" class="sform" id="am_address" value="<?php echo $row_alliance_detail['am_address']; ?>" size="80"></td>
                  </tr>
                  <tr>
                    <td background="images/transp.gif" bgcolor="#999999" class="contnet_w"><div align="right">網站:</div></td>
                    <td colspan="3" valign="middle" bgcolor="#FFFFFF" class="sform"><label for="am_weburl">
                      <textarea name="am_weburl" id="am_weburl" cols="80" rows="5" class="ckeditor"><?php echo $row_alliance_detail['am_weburl']; ?></textarea>
                    </label></td>
                  </tr>
                  <tr>
                    <td background="images/transp.gif" bgcolor="#999999" class="contnet_w"><div align="right">付款方式:</div></td>
                    <td valign="middle" bgcolor="#FFFFFF" class="sform"><label for="am_payway"></label>
                      <select name="am_payway" class="sform" id="am_payway">
                        <option value="現金匯款" selected="selected" <?php if (!(strcmp("現金匯款", $row_alliance_detail['am_payway']))) {echo "selected=\"selected\"";} ?>>現金匯款</option>
                        <option value="支票支付" <?php if (!(strcmp("支票支付", $row_alliance_detail['am_payway']))) {echo "selected=\"selected\"";} ?>>支票支付</option>
                        <option value="PayPal" <?php if (!(strcmp("PayPal", $row_alliance_detail['am_payway']))) {echo "selected=\"selected\"";} ?>>PayPal</option>
                      </select></td>
                    <td valign="middle" background="images/transp.gif" bgcolor="#999999" class="contnet_w"><div align="right">請款應檢附單據類別:</div></td>
                    <td valign="middle" bgcolor="#FFFFFF" class="sform"><input <?php if (!(strcmp($row_alliance_detail['am_fa'],"Y"))) {echo "checked=\"checked\"";} ?> type="radio" name="am_fa" id="am_fa" value="Y">
                      統一發票
                      <input <?php if (!(strcmp($row_alliance_detail['am_fa'],"N"))) {echo "checked=\"checked\"";} ?> name="am_fa" type="radio" value="N">
                      個人身分證（執行業務所得）</td>
                  </tr>
                  <tr>
                    <td background="images/transp.gif" bgcolor="#999999" class="contnet_w"><div align="right">匯款銀行名:</div></td>
                    <td valign="middle" bgcolor="#FFFFFF" class="sform"><label for="am_bank_name"></label>
                      <input name="am_bank_name" type="text" class="sform" id="am_bank_name" value="<?php echo $row_alliance_detail['am_bank_name']; ?>"></td>
                    <td valign="middle" background="images/transp.gif" bgcolor="#999999" class="contnet_w"><div align="right">匯款銀行分行名稱:</div></td>
                    <td valign="middle" bgcolor="#FFFFFF" class="sform"><label for="am_bank_brench"></label>
                      <input name="am_bank_brench" type="text" class="sform" id="am_bank_brench" value="<?php echo $row_alliance_detail['am_bank_brench']; ?>"></td>
                  </tr>
                  <tr>
                    <td background="images/transp.gif" bgcolor="#999999" class="contnet_w"><div align="right">匯款銀行代號:</div></td>
                    <td valign="middle" bgcolor="#FFFFFF" class="sform"><label for="am_bank_code"></label>
                      <input name="am_bank_code" type="text" class="sform" id="am_bank_code" value="<?php echo $row_alliance_detail['am_bank_code']; ?>" size="10"></td>
                    <td valign="middle" background="images/transp.gif" bgcolor="#999999" class="contnet_w"><div align="right">匯款銀行帳號或PayPal帳號:</div></td>
                    <td valign="middle" bgcolor="#FFFFFF" class="sform"><label for="am_bank_account"></label>
                      <input name="am_bank_account" type="text" class="sform" id="am_bank_account" value="<?php echo $row_alliance_detail['am_bank_account']; ?>" size="30"></td>
                  </tr>
                  <?php if($row_Recordset1['p_package'] == 'Y'){ ?>
                  <?php } ?>
                  <tr>
                    <td background="images/transp.gif" bgcolor="#999999" class="contnet_w"><div align="right">備註:</div></td>
                    <td colspan="3" valign="middle" bgcolor="#FFFFFF"><textarea name="am_memo" id="am_memo" cols="60" rows="4"><?php echo $row_alliance_detail['am_memo']; ?></textarea>
                      <input name="am_id" type="hidden" id="am_id" value="<?php echo $row_alliance_detail['am_id']; ?>">
                      <input name="am_last_modify" type="hidden" id="am_last_modify" value="<?php echo date('Y-m-d H:i:s'); ?>"></td>
                  </tr>
                  <tr>
                    <td background="images/transp.gif" bgcolor="#999999" class="contnet_w"><div align="right">分潤比:</div></td>
                    <td colspan="3" valign="middle" bgcolor="#FFFFFF" class="sform"><label for="am_ratio"></label>
                      <input name="am_ratio" type="text" class="sform" id="am_ratio" value="<?php echo $row_alliance_detail['am_ratio']; ?>" size="5">
                      %</td>
                  </tr>
                  <tr>
                    <td background="images/transp.gif" bgcolor="#999999" class="contnet_w"><div align="right">上次登入時間:</div></td>
                    <td valign="middle" bgcolor="#FFFFFF" class="sform"><?php echo $row_alliance_detail['am_last_login_datetime']; ?>，已登入<?php echo $row_alliance_detail['am_last_login_times']; ?>次</td>
                    <td valign="middle" background="images/transp.gif" bgcolor="#999999" class="contnet_w"><div align="right">上次登入IP:</div></td>
                    <td valign="middle" bgcolor="#FFFFFF" class="sform"><?php echo $row_alliance_detail['am_last_login_ip']; ?></td>
                  </tr>
                  <tr>
                    <td colspan="4" align="center" background="images/transp.gif" bgcolor="#999999" class="contnet_w">
                    <input name="button3" type="submit" class="sform_b" id="button3" onClick="tmt_confirm('確定修改盟友資料?');return document.MM_returnValue" value="確定修改">                    <input name="button" type="button" class="sform_r" id="button" onClick="MM_goToURL('self','alliance_member_l.php');return document.MM_returnValue" value="回盟友列表">
                    </td>
                  </tr>
                </table></td>
              </tr>
            </table>
            <input type="hidden" name="MM_update" value="form1">
          </form>
        </div></td>
      </tr>
      <tr>
        <td height="30" align="center" valign="middle" class="text_w">參與行銷案件列表 <input name="button4" type="button" class="sform_b" id="button4" onClick="MM_goToURL('self','alliance_project_a.php?am_id=<?php echo $row_alliance_detail['am_id']; ?>&am_code=<?php echo $row_alliance_detail['am_code']; ?>');return document.MM_returnValue" value="新增參與案件">
          <input name="button6" type="button" class="sform_g" id="button6" onClick="MM_goToURL('self','alliance_order_analysis.php?am_id=<?php echo $row_alliance_detail['am_id']; ?>&am_code=<?php echo $row_alliance_detail['am_code']; ?>&am_ratio=<?php echo $row_alliance_detail['am_ratio']; ?>');return document.MM_returnValue" value="檢視行銷成果"></td>
        </tr>
      <tr>
        <td align="center" valign="top"><table width="95%" border="0" cellpadding="3" cellspacing="0">          
          <tr bgcolor="#FFFFFF">
            <td class="bg_cap">
              <table width="100%" border="0" cellpadding="5" cellspacing="1" id="product_list" class="display">
                <thead>
                <tr bgcolor="#DDDDDD" >
                  <th align="center" background="images/transp.gif" bgcolor="#999999" class="contnet_w">參與行銷案件ID</th>
                  <th align="center" background="images/transp.gif" bgcolor="#999999" class="contnet_w">參與行銷案件名稱</th>
                  <th align="center" background="images/transp.gif" bgcolor="#999999" class="contnet_w">專屬短網址</th>
                  <th align="center" background="images/transp.gif" bgcolor="#999999" class="contnet_w">盟友文章網址</th>
                  <th align="center" background="images/transp.gif" bgcolor="#999999" class="contnet_w">累積點擊數</th>
                  <th align="center" background="images/transp.gif" bgcolor="#999999" class="contnet_w">管理</th>
                  </tr>
                </thead>
                <tbody>                
                    <?php do { ?>
                      <tr>
                        <td align="center" bgcolor="#FFFFFF"><?php echo $row_ap_list['ac_id']; ?></td>
                        <td align="center" bgcolor="#FFFFFF"><?php echo $row_ap_list['ac_title']; ?></td>
                        <td align="center" bgcolor="#FFFFFF"><a href="<?php echo $row_ap_list['ap_url_short']; ?>" target="new"><?php echo $row_ap_list['ap_url_short']; ?></a></td>
                        <td align="center" bgcolor="#FFFFFF"><?php echo $row_ap_list['ap_post_url']; ?></td>
                        <td align="center" bgcolor="#FFFFFF"><?php $_clicks = bitly_v3_clicks($row_ap_list['ap_url_short']); echo $_clicks[0]['global_clicks']; ?></td>
                        <td align="center" bgcolor="#FFFFFF"><input name="button" type="button" class="sform_g" id="button" onClick="MM_goToURL('self','alliance_project_s.php?ap_id=<?php echo $row_ap_list['ap_id']; ?>&am_id=<?php echo $row_alliance_detail['am_id']; ?>');return document.MM_returnValue" value="檢視">
                          <input name="button5" type="submit" class="sform_b" id="button5" onClick="window.open('<?php echo $row_ap_list['ap_url_short']."+"; ?>');" value="點擊統計">
                          <input name="button2" type="submit" class="sform_r" id="button2" onClick="dele('<?php echo $row_ap_list['ap_id']; ?>','<?php echo $row_alliance_detail['am_id']; ?>');" value="刪除"></td>
                      </tr>
                      <?php } while ($row_ap_list = mysql_fetch_assoc($ap_list)); ?>
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
mysql_free_result($alliance_detail);

mysql_free_result($ap_list);
?>
