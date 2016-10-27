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

$colname_admin = "-1";
if (isset($_GET['id'])) {
  $colname_admin = $_GET['id'];
}
mysql_select_db($database_iwine, $iwine);
$query_admin = sprintf("SELECT * FROM admin_account WHERE id = %s", GetSQLValueString($colname_admin, "int"));
$admin = mysql_query($query_admin, $iwine) or die(mysql_error());
$row_admin = mysql_fetch_assoc($admin);
$totalRows_admin = mysql_num_rows($admin);

?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>iWine - 後台管理系統</title>

<link href="css.css" rel="stylesheet" type="text/css">
<script type="text/javascript">
<!--
function dele(ids){
	if(window.confirm('確定要刪除?')){
		window.location='account_d.php?n_id='+ids;
	}
}

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function YY_checkform() { //v4.71
//copyright (c)1998,2002 Yaromat.com
  var a=YY_checkform.arguments,oo=true,v='',s='',err=false,r,o,at,o1,t,i,j,ma,rx,cd,cm,cy,dte,at;
  for (i=1; i<a.length;i=i+4){
    if (a[i+1].charAt(0)=='#'){r=true; a[i+1]=a[i+1].substring(1);}else{r=false}
    o=MM_findObj(a[i].replace(/\[\d+\]/ig,""));
    o1=MM_findObj(a[i+1].replace(/\[\d+\]/ig,""));
    v=o.value;t=a[i+2];
    if (o.type=='text'||o.type=='password'||o.type=='hidden'){
      if (r&&v.length==0){err=true}
      if (v.length>0)
      if (t==1){ //fromto
        ma=a[i+1].split('_');if(isNaN(v)||v<ma[0]/1||v > ma[1]/1){err=true}
      } else if (t==2){
        rx=new RegExp("^[\\w\.=-]+@[\\w\\.-]+\\.[a-zA-Z]{2,4}$");if(!rx.test(v))err=true;
      } else if (t==3){ // date
        ma=a[i+1].split("#");at=v.match(ma[0]);
        if(at){
          cd=(at[ma[1]])?at[ma[1]]:1;cm=at[ma[2]]-1;cy=at[ma[3]];
          dte=new Date(cy,cm,cd);
          if(dte.getFullYear()!=cy||dte.getDate()!=cd||dte.getMonth()!=cm){err=true};
        }else{err=true}
      } else if (t==4){ // time
        ma=a[i+1].split("#");at=v.match(ma[0]);if(!at){err=true}
      } else if (t==5){ // check this 2
            if(o1.length)o1=o1[a[i+1].replace(/(.*\[)|(\].*)/ig,"")];
            if(!o1.checked){err=true}
      } else if (t==6){ // the same
            if(v!=MM_findObj(a[i+1]).value){err=true}
      }
    } else
    if (!o.type&&o.length>0&&o[0].type=='radio'){
          at = a[i].match(/(.*)\[(\d+)\].*/i);
          o2=(o.length>1)?o[at[2]]:o;
      if (t==1&&o2&&o2.checked&&o1&&o1.value.length/1==0){err=true}
      if (t==2){
        oo=false;
        for(j=0;j<o.length;j++){oo=oo||o[j].checked}
        if(!oo){s+='* '+a[i+3]+'\n'}
      }
    } else if (o.type=='checkbox'){
      if((t==1&&o.checked==false)||(t==2&&o.checked&&o1&&o1.value.length/1==0)){err=true}
    } else if (o.type=='select-one'||o.type=='select-multiple'){
      if(t==1&&o.selectedIndex/1==0){err=true}
    }else if (o.type=='textarea'){
      if(v.length<a[i+1]){err=true}
    }
    if (err){s+='* '+a[i+3]+'\n'; err=false}
  }
  if (s!=''){alert('請完整填入下列資訊:\t\t\t\t\t\n\n'+s)}
  document.MM_returnValue = (s=='');
}
function tmt_confirm(msg){
	document.MM_returnValue=(confirm(unescape(msg)));
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
        <td height="40" align="center" valign="middle" class="contnet_w">◎ 系統帳號權限設定 ◎</td>
        </tr>
      <tr>
        <td height="2" bgcolor="#FFFFFF"></td>
        </tr>
      <tr>
        <td align="center" valign="top">
          <table width="75%" border="0" cellspacing="0" cellpadding="3">
            <tr>
              <td bgcolor="#494949"><table width="100%" border="0" cellpadding="5" cellspacing="1">
                <tr bgcolor="#DDDDDD">
                  <td align="center" background="images/transp.gif" bgcolor="#999999" class="contnet_w">帳號</td>
                  <td align="left" bgcolor="#FFFFFF"><?php echo $row_admin['account_pid']; ?></td>
                  <td align="center" background="images/transp.gif" bgcolor="#999999" class="contnet_w">密碼</td>
                  <td align="left" bgcolor="#FFFFFF">*************</td>
                  </tr>
                <tr bgcolor="#DDDDDD">
                  <td align="center" background="images/transp.gif" bgcolor="#999999" class="contnet_w">姓名</td>
                  <td align="left" bgcolor="#FFFFFF"><?php echo $row_admin['name']; ?></td>
                  <td align="center" background="images/transp.gif" bgcolor="#999999" class="contnet_w">部門</td>
                  <td align="left" bgcolor="#FFFFFF"><?php echo $row_admin['dep']; ?></td>
                  </tr>
                <tr bgcolor="#DDDDDD">
                  <td align="center" background="images/transp.gif" bgcolor="#999999" class="contnet_w">e-mail</td>
                  <td colspan="3" align="left" bgcolor="#FFFFFF"><?php echo $row_admin['email']; ?></td>
                  </tr>
                <tr bgcolor="#DDDDDD">
                  <td align="center" background="images/transp.gif" bgcolor="#999999" class="contnet_w">權限</td>
                  <td colspan="3" align="left" bgcolor="#FFFFFF">
                  <FORM METHOD="POST" name="form2" ACTION="permission_u.php?id=<?php echo $row_admin['id']; ?>">
                  <INPUT TYPE="hidden" NAME="total_id">
				  
		<link rel="STYLESHEET" type="text/css" href="../js/codebase/dhtmlxtree.css">
		<script  src="../js/codebase/dhtmlxcommon.js"></script>
		<script  src="../js/codebase/dhtmlxtree.js"></script>
		<div id="treeboxbox_tree"></div>
		<script>
		tree = new dhtmlXTreeObject("treeboxbox_tree", "100%", "100%", 0);
		//tree.setSkin('dhx_skyblue');
		tree.setImagePath("../js/codebase/imgs/csh_bluebooks/");
		tree.enableCheckBoxes(1);
		tree.enableThreeStateCheckboxes(true);
		//tree.enableSmartXMLParsing(true);
		tree.setXMLAutoLoading("permission_xml.php?id=<?php echo $row_admin['id']; ?>&<?=mktime()?>");
		tree.loadXML("permission_xml.php?id=<?php echo $row_admin['id']; ?>&<?=mktime()?>");
		</script>
				  <div align="center"><input name="status2" type="submit" class="sform_g" onClick="chkdata();" value="確定修改">
				    <input name="button" type="button" class="sform_b" id="button" onClick="window.location=('account_l.php')" value="回上頁">
                   </div>
				  </FORM>
                  </td>
                </tr>
                <tr bgcolor="#F3F3F1">
                  <td colspan="4" align="center"></td>
                </tr>
                </table></td>
              </tr>
            </table>
        </td>
      </tr>
    </table></td>
  </tr>
</table>
</body>
</html>
<SCRIPT LANGUAGE="JavaScript">
<!--
function chkdata(){
	document.forms['form2'].elements['total_id'].value=tree.getAllChecked();
	document.forms['form2'].submit();
}
//-->
</SCRIPT>
<?php
mysql_free_result($admin);
?>
