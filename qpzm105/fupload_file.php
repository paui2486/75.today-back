<?php include('session_check.php'); ?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=big5">
<title>iWine - 後台管理系統</title>
<script language="JavaScript">
<!--
//檢查上傳物件 checkFileUpload(表單名稱,檔案類型,是否需要上傳,檔案大小,圖片最小寬度,圖片最小高度,圖片最大寬度,圖片最大高度,儲存寬度的表單名稱,儲存高度的表單名稱)
function checkFileUpload(form,extensions,requireUpload,sizeLimit,minWidth,minHeight,maxWidth,maxHeight,saveWidth,saveHeight) {
  document.MM_returnValue = true;
  if (extensions != '') var re = new RegExp("\.(" + extensions.replace(/,/gi,"|") + ")$","i");
  for (var i = 0; i<form.elements.length; i++) {
    field = form.elements[i];
    if (field.type.toUpperCase() != 'FILE') continue;
    if (field.value == '') {
      if (requireUpload) {alert('Please chose file to upload！');document.MM_returnValue = false;field.focus();break;}
    } else {
      if(extensions != '' && !re.test(field.value)) {
        alert('Wrong file type！\n ' + extensions + '。\nplease chose new one。');
        document.MM_returnValue = false;field.focus();break;
      }
    document.PU_uploadForm = form;
    re = new RegExp(".(gif|jpg|png|bmp|jpeg)$","i");
    if(re.test(field.value) && (sizeLimit != '' || minWidth != '' || minHeight != '' || maxWidth != '' || maxHeight != '' || saveWidth != '' || saveHeight != '')) {
      setTimeout('if (document.MM_returnValue) document.PU_uploadForm.submit()',500);
      checkImageDimensions(field.value,sizeLimit,minWidth,minHeight,maxWidth,maxHeight,saveWidth,saveHeight);
    } } }
}

function showImageDimensions() {
  if ((this.minWidth != '' && this.width > this.minWidth) || (this.minHeight != '' && this.height < this.minHeight)) {
    alert('您所上傳的圖片尺寸太小了！\n上傳的圖片大小至少要 ' + this.minWidth + ' x ' + this.minHeight); return;}
  if ((this.maxWidth != '' && this.width > this.maxWidth) || (this.maxHeight != '' && this.height > this.maxHeight)) {
    alert('您所上傳的圖片尺寸為 '+ this.width + ' x ' + this.height+' 太大了！\n上傳的圖片大小不可超過 ' + this.maxWidth + ' x ' + this.maxHeight); return;}
  if (this.sizeLimit != '' && this.fileSize/1000 > this.sizeLimit) {
    alert('Files size is '+this.fileSize/1000+' KB,！\nit should be smaller than ' + this.sizeLimit + ' KB'); return;}
  if (this.saveWidth != '') document.PU_uploadForm[this.saveWidth].value = this.width;
  if (this.saveHeight != '') document.PU_uploadForm[this.saveHeight].value = this.height;
  document.MM_returnValue = true;
}

function checkImageDimensions(fileName,sizeLimit,minWidth,minHeight,maxWidth,maxHeight,saveWidth,saveHeight) { //v2.0
  document.MM_returnValue = false; var imgURL = 'file:///' + fileName, img = new Image();
  img.sizeLimit = sizeLimit; img.minWidth = minWidth; img.minHeight = minHeight; img.maxWidth = maxWidth; img.maxHeight = maxHeight;
  img.saveWidth = saveWidth; img.saveHeight = saveHeight;
  img.onload = showImageDimensions; img.src = imgURL;
}
//-->
</script>
<style type="text/css">
<!--
form {
	margin: 0px;
}
.formword {
	font-family: "Georgia", "Times New Roman", "Times", "serif";
	font-size: 8pt;
}
-->
</style>
<style type="text/css">
<!--
.box {
	border: 1px dotted #333333;
}
-->
</style>

</head>
<body bgcolor="#EEEEEE" text="#333333" leftmargin="2" topmargin="2" marginwidth="2" marginheight="2">
<script language="JavaScript" type="text/JavaScript">
var windowW = 400;
var windowH = 180;
windowX = Math.ceil( (window.screen.width  - windowW) / 2 );
windowY = Math.ceil( (window.screen.height - windowH) / 2 );
window.resizeTo( Math.ceil( windowW ) , Math.ceil( windowH ) );
window.moveTo( Math.ceil( windowX ) , Math.ceil( windowY ) );
</script>
<form ACTION="fupaction_file.php" METHOD="POST" name="form1" enctype="multipart/form-data" onSubmit="checkFileUpload(this,'',true,'<?php if (isset($HTTP_GET_VARS['ImgS'])){ echo $HTTP_GET_VARS['ImgS'];}?>','','','<?php if (isset($HTTP_GET_VARS['ImgW'])){ echo $HTTP_GET_VARS['ImgW'];}?>','<?php if (isset($HTTP_GET_VARS['ImgH'])){ echo $HTTP_GET_VARS['ImgH'];}?>','','');return document.MM_returnValue">
  <table width="100%" height="100%" border="0" cellpadding="4" cellspacing="0">
    <tr> 
      <td height="20"><table width="100%" border="0" cellpadding="4" cellspacing="0" bgcolor="#999999">
          <tr valign="baseline" class="formword"> 
            <td align="left"><font color="#FFFFFF">選擇上傳檔案：</font></td>
            <td><font color="#FFFFFF"><?php // if (isset($HTTP_GET_VARS['ImgS'])){ 
			//echo ' 檔案大小不得超過 '.$HTTP_GET_VARS['ImgS'].'KB'	;
			//}?>
			</font></td>
          </tr>
        </table>
        
      </td>
    </tr>
    <tr> 
      <td height="20" align="center"> 
        <table border="0" cellpadding="4" cellspacing="0">
          <tr> 
            <td><input name="file" type="file" class="formword" id="file" size="40"></td>
          </tr>
        </table>
        <input name="Submit" type="submit" class="formword" value="開始上傳">
        <input name="close" type="button" class="formword" onClick="window.close();" value="關閉視窗">
        <input name="useForm" type="hidden" id="useForm" value="<?php echo $HTTP_GET_VARS['useForm']; ?>">
        <input name="upUrl" type="hidden" id="upUrl" value="<?php echo $HTTP_GET_VARS['upUrl']; ?>"> 
        <input name="prevImg" type="hidden" id="prevImg" value="<?php echo $HTTP_GET_VARS['prevImg']; ?>">
        <input name="reItem" type="hidden" id="reItem" value="<?php echo $HTTP_GET_VARS['reItem']; ?>">
      </td>
    </tr>
    <tr> 
      <td height="20" align="center"> 
        <table width="100%" border="0" cellpadding="4" cellspacing="0" bgcolor="#FFFFFF" class="box">
          <tr valign="baseline" class="formword"> 
            <td align="center">&nbsp;</td>
          </tr>
      </table> </td>
    </tr>
  </table>
</form>
</body>
</html>

