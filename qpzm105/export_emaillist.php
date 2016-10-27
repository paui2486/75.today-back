<?php include('session_check.php'); ?>
<?php require_once('../Connections/iwine.php'); ?>
<?php
include('func/func.php');
include('../func/pagination.php');
if (!function_exists("GetSQLValueString")) {
    function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") {
    if (PHP_VERSION < 6) { $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue; }

        $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);
        switch ($theType) {
            case "text": $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL"; break;    
            case "long":
            case "int": $theValue = ($theValue != "") ? intval($theValue) : "NULL"; break;
            case "double": $theValue = ($theValue != "") ? doubleval($theValue) : "NULL"; break;
            case "date": $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL"; break;
            case "defined": $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue; break;
        }
        return $theValue;
    }
}
//上傳檔案
if($_POST['act'] == 'import'){
    $_today = date('Y-m-d H:i:s');
    $now_timestamp = date_timestamp_get(date_create());
    $filetype = end(explode('.', $_FILES['file']['name']));
    //僅限 .csv
    if( $filetype == 'csv'){
        
        $newfile = "email_list_".$now_timestamp.".".$filetype;
        $newfile_target = "../upload/email/".$newfile;
        $insert_count = 0;
        //儲存新檔於 admin/upload/email當中
        if (move_uploaded_file($_FILES["file"]["tmp_name"], $newfile_target)){
            //讀取新檔寫入 db
            $fp = fopen($newfile_target, "r");
            while ( $row_data = fgetcsv($fp, $newfile_target) ) {
                $data = trim($row_data[0]);
                if(strlen($data) > 0 && ($data <> "e-mail" || $data <> "email" || $data <> "E-mail" || $data <> "電子郵件" )){
                    $check_sql = sprintf("SELECT e_email from email_list where e_email = %s", GetSQLValueString($data, "text"));
                    $check = mysql_query($check_sql, $iwine) or die(mysql_error());
                    $totalRows_check = mysql_num_rows($check);
                    if($totalRows_check==0){
                        $insert_sql = sprintf("INSERT INTO email_list (e_email, update_time) VALUES (%s, %s)", GetSQLValueString($data, "text"),GetSQLValueString($_today, "date"));
                        mysql_select_db($database_iwine, $iwine);
                        $Result1 = mysql_query($insert_sql, $iwine) or die(mysql_error());
                        $insert_count +=1;
                    }
                }
            }
            fclose($fp);
            echo "<script type=\"text/javascript\">alert(\"匯入了 $insert_count 比資料\");</script>";
        }
    }else{
        echo "<script type=\"text/javascript\">alert(\"僅能匯入 .csv檔案資料\");</script>";
    }
}
mysql_select_db($database_iwine, $iwine);
$query_all = "SELECT COUNT(*) AS counter FROM email_list";
$mail_all = mysql_query($query_all, $iwine) or die(mysql_error());
$row_all = mysql_fetch_assoc($mail_all);
$totalRows_mail = $row_all['counter'];
if($_GET['page']){
    $page = $_GET['page'];
}else{
    $page = 1;
}
pageft($totalRows_mail,100,'export_emaillist.php',$page); 

mysql_select_db($database_iwine, $iwine);
$query_mail = "SELECT * FROM email_list order by e_email Asc limit $firstcount, $displaypg";
$mail = mysql_query($query_mail, $iwine) or die(mysql_error());
// $row_mail = mysql_fetch_assoc($mail);
$totalRows_display = mysql_num_rows($mail);

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
    // $('#product_list').dataTable({
    // "bFilter": true,
    // "aaSorting": [[ 7, "asc" ]],
    // "oLanguage": {
      // "sLengthMenu": "每頁顯示 _MENU_ 筆email list資料",
      // "sZeroRecords": "無email list資料",
      // "sInfo": "目前顯示 _START_ 到 _END_ 筆，共 _TOTAL_ 筆email list資料",
      // "sInfoEmtpy": "無email list資料",
      // "sInfoFiltered": "共有 _MAX_ 筆email list資料)",
      // "sProcessing": "正在載入中...",
      // "sSearch": "搜尋",
      // "sUrl": "", //多语言配置文件，可将oLanguage的设置放在一个txt文件中，例：Javascript/datatable/dtCH.txt
      // "oPaginate": {
          // "sFirst":    "第一頁",
          // "sPrevious": " 上一頁 ",
          // "sNext":     " 下一頁 ",
          // "sLast":     " 最後一頁 "
      // }
  // }, 
      // "aLengthMenu": [[10, 25, 50, 75, 100, -1], ["10", "25", "50", "75", "100", "全部"]]  //设置每页显示记录的下拉菜单
   // });
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
        <td height="40" align="center" valign="middle"><span class="capw"><font color="#FFFFFF">◎ 檢視電子報訂閱 E-mail ◎</font></span></td>
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
                <tr>
                    <td>
                    <?php 
                       
                        echo  $pagenav."<br>";
                    ?>
                    </td>
                    <td align="right">
                        <a href="emaillist_export.php"><font color="red">匯出 excel 檔案</font></a>
                        <form action="" method="POST" enctype="multipart/form-data">
                            <font color="red">匯入名單檔案：<input type="file" name="file" id="file">
                            <input type="hidden" name="act" value="import">
                            <input type="submit" value="匯入">*僅限.csv檔案</font>
                        </form>
                    </td>
                </tr>
                <tr bgcolor="#DDDDDD" >
                  <th align="center" background="images/transp.gif" bgcolor="#999999" class="contnet_w">E-mail</th>
                  <th align="center" background="images/transp.gif" bgcolor="#999999" class="contnet_w">訂閱時間</th>
                  <!--th align="center" background="images/transp.gif" bgcolor="#999999" class="contnet_w">管理</th-->
                  </tr>
                </thead>
                <tbody>
                <?php if ($totalRows_mail > 0) { // Show if recordset not empty ?>
                  <?php while ($row_mail = mysql_fetch_assoc($mail)) { ?>
                    <tr>
                        <td align="center" bgcolor="#FFFFFF"><?php echo $row_mail['e_email']; ?></td>
                        <td align="center" bgcolor="#FFFFFF">
                            <?php 
                                echo $row_mail['update_time'];
                                //if($row_mail['e_check'] == 'Y') echo "訂閱";
                                //else echo "不訂閱";
                            ?>
                        </td>
                        <!--td align="center" bgcolor="#FFFFFF">
                            <!--input name="button" type="button" class="sform_g" id="button" onClick="MM_goToURL('self','winebar_s.php?id=<?php //echo $row_mail['id']; ?>');return document.MM_returnValue" value="檢視或修改"-->
                            <!--input name="button2" type="submit" class="sform_b" id="button2" value="刪除" onClick="dele('<?php //echo $row_mail['id']; ?>');"></td-->                   
                        <!--/tr-->
                    <?php }; ?>
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
mysql_free_result($mail);
mysql_free_result($mail_all);
?>
