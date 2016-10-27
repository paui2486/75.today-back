<?php
include('session_check.php');
?>
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
$query_menu_group = "SELECT * FROM menu_group ORDER BY group_order ASC";
$menu_group = mysql_query($query_menu_group, $iwine) or die(mysql_error());
$row_menu_group = mysql_fetch_assoc($menu_group);
$totalRows_menu_group = mysql_num_rows($menu_group);

?>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>iWine - 後台管理系統</title>
<link href="css.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/jquery-1.7.2.min.js"></script>
<STYLE type=text/css>

body{SCROLLBAR-FACE-COLOR: #4d4d4d;

         SCROLLBAR-HIGHLIGHT-COLOR: #8f8f8f;

         SCROLLBAR-SHADOW-COLOR: #2c2c2c;

         SCROLLBAR-3DLIGHT-COLOR: #4d4d4d;

         SCROLLBAR-ARROW-COLOR: #000000;

         SCROLLBAR-TRACK-COLOR: #000000;

         SCROLLBAR-DARKSHADOW-COLOR: #2c2c2c;
 
	     margin-top: 0px
}
</STYLE>
<script type="text/javascript">
$(document).ready( function () {
		$("<?php for($i=1;$i<=$totalRows_menu_group;$i++){ ?>#menu_cont<?php echo $i; ?>,<?php } ?>").hide();

<?php for($i=1;$i<=$totalRows_menu_group;$i++){ ?>							 
		$("#menu<?php echo $i; ?>").click( function () {
						 $("#menu_cont<?php echo $i; ?>").toggle("normal"); });
<?php } ?>
							 });
</script>
</head>
<body marginheight="0" marginwidth="0" bgcolor="#2c2c2c" class="bg_cap">
<div align="center">
<table width="190" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="65" align="center" valign="middle"><img src="images/logo.jpg" width="160" height="160"></td>
  </tr>
  <tr>
    <td align="center" valign="top"><table width="186" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td height="25" align="center" class="text_name"><p><strong>後台管理系統 V1.0</strong></p></td>
      </tr>
      <tr>
        <td align="center"><img src="images/cap01.gif" width="186" height="39" /></td>
      </tr>
      <tr>
        <td align="center" valign="top" background="images/capbg.gif">
        <table width="186" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td align="center">
            	<table width="158" border="0" cellspacing="0" cellpadding="0">
              		<tr>
                		<td height="50" valign="middle" class="text_name"><?php echo $_SESSION['ADMIN_NAME']; ?> 您好~<br>歡迎使用後台管理系統</td>
              		</tr>
              	</table>
            </td>
          </tr>
<?
    $num = 0;
?>	
<?php if($totalRows_menu_group > 0){ ?>		
<?php do { ?>        
<?php 
        $num++;
		$menu_group_id = $row_menu_group['id'];
		
mysql_select_db($database_iwine, $iwine);
$query_menu_detail = "select menu_detail.* from menu_detail inner join acl_mapping on acl_mapping.menu_detail_id=menu_detail.id where group_id='$menu_group_id' and admin_account_id='".$_SESSION['ADMIN_ID']."'  order by menu_detail_order";
$menu_detail = mysql_query($query_menu_detail, $iwine) or die(mysql_error());
$row_menu_detail = mysql_fetch_assoc($menu_detail);
$totalRows_menu_detail = mysql_num_rows($menu_detail);
?> 
		        
            <tr>
              <td width="186" height="29" align="right" background="images/cap-tdbg.gif"><table width="150" height="23" border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td height="18" valign="bottom" id="menu<?php echo $num; ?>"><a href="#" class="text_cap2" ><?php echo $row_menu_group['group_name']; ?></a></td>
                  </tr>
              </table></td>
            </tr>

            <tr>
              <td align="center">
			  
              	<div id="menu_cont<?php echo $num; ?>">
                	
                    <table width="158" border="0" cellspacing="0" cellpadding="0">
				  <?php if($totalRows_menu_detail > 0){ ?>
                  <?php do { ?>
                  		<tr>
                    		<td><span class="text_w"><img src="images/cap-point1.gif" width="24" height="24" vspace="3" align="absmiddle"><a href="<?php echo $row_menu_detail['menu_detail_path']; ?>" target="<?php echo $row_menu_detail['menu_detail_target']; ?>"><?php echo $row_menu_detail['menu_detail_name']; ?></a></span></td>
                  		</tr>
				  <?php } while ($row_menu_detail = mysql_fetch_assoc($menu_detail)); ?>
				  <?php }else{ ?>
                  		<tr>
                    		<td><span class="text_w"><img src="images/cap-point1.gif" width="24" height="24" vspace="3" align="absmiddle"><a href="#">無權限</span></td>
                  		</tr>
                  <?php } ?> 
                    </table>
              </div>
			  
                
              </td>
            </tr>
            <?php } while ($row_menu_group = mysql_fetch_assoc($menu_group)); ?>
            <?php } ?>
      
      <tr>
        <td align="center" valign="top"><img src="images/capend.gif" width="186" height="29" /></td>
      </tr>
    </table></td>
  </tr>
</table>
</td>
</tr>
</table>
</body>
</html>