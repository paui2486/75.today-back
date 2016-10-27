<?php


?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>iWine - 達人上稿平台登入</title>
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	background-image:  url(images/transp.gif);
}
font1 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	font-style: normal;
	line-height: 14px;
	color: #666666;
}
td {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	font-style: normal;
	line-height: 14px;
	color: #333333;
}
textarea {
	background-color: F5F9FD;
	border: 1px dotted #666666;
}
input {
	border: 1px solid #336699;
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	font-style: normal;
	line-height: 14px;
	color: #003366;
	background-color: #FFFFFF;
}
a:link {
	color: #333333;
	text-decoration: none;
}
a:visited {
	text-decoration: none;
	color: #333333;
}
a:hover {
	text-decoration: none;
	color: #006699;
}
a:active {
	text-decoration: none;
}
.table {
	border: 1px solid #000000;
}
-->
</style>
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
</script>
</head>

<body>
<p>&nbsp;</p>
<p><br>
</p>
<form name="form1" method="POST" action="login_check.php">
  <table width="457" align="center" cellpadding="5" cellspacing="0" bgcolor="#FFFFFF" class="table">
    <tr>
      <td colspan="3" align="center" bgcolor="#FFFFFF"><img src="http://shop-admin.iwine.today/qpzm105/images/logo.jpg" width="160" height="160"></td>
    </tr>
    <tr>
      <td colspan="3" bgcolor="#FFFFFF"> <div align="center">iWine - 達人上稿平台登入</div></td>
    </tr>
    <tr>
      <td width="116" rowspan="5" align="center" bgcolor="#FFFFFF"><img src="http://shop-admin.iwine.today/qpzm105/images/j_login_lock.jpg" width="116" height="97"></td>
      <td width="52" bgcolor="#FFFFFF"><div align="right">電子信箱</div></td>
      <td width="191" bgcolor="#FFFFFF"><input type="text" name="mem_id" id="mem_id"></td>
    </tr>
    <tr>
      <td bgcolor="#FFFFFF"><div align="right">密碼</div></td>
      <td bgcolor="#FFFFFF"><input type="password" name="mem_passwd" id="mem_passwd"></td>
    </tr>
    <tr>
      <td bgcolor="#FFFFFF"><div align="right">驗證碼</div></td>
      <td bgcolor="#FFFFFF"><input name="capacha_code" type="text" id="capacha_code" /><br></td>
    </tr>
    <tr>
      <td valign="top" bgcolor="#FFFFFF">&nbsp;</td>
      <td bgcolor="#FFFFFF"><img src="securimage/securimage_show.php" alt="CAPTCHA Image" align="absmiddle" id="captcha" /><a href="#" onClick="document.getElementById('captcha').src = './securimage/securimage_show.php?' + Math.random(); return false">更換</a></td>
    </tr>
    <tr>
      <td colspan="2" bgcolor="#FFFFFF"><div align="center">
        <input type="submit" name="button" id="button" value="送出">
        <input type="reset" name="button2" id="button2" value="重設">
        </div></td>
    </tr>
    <tr align="right">
      <td height="22" colspan="3" bgcolor="#FFFFFF">&nbsp;</td>
    </tr>
  </table>
</form>

</body>
</html>
