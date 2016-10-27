<!DOCTYPE html>
<html lang="zh_tw">
  <head>
    <meta charset="utf-8">
    </head>
    <body>
<form action="http://admin.iwine.com.tw/qpzm105/api/modify_password_mutimembertype.php" method="post">
mem_type :<br>
<input type="radio" id="member" name="mem_type" value="member">member/一般會員<br>
<input type="radio" id="bar" name="mem_type" value="bar">bar/bar會員<br>
<input type="radio" id="wine_supplier" name="mem_type" value="wine_supplier">wine_supplier/一般會員<br>
member_id<input type="text" id="member_id" name="member_id"  value="170"><br>
舊密碼<input type="text" id="old_passwd" name="old_passwd"><br>
新密碼<input type="text" id="new_passwd" name="new_passwd"><br>
<input type="submit">
</form>
</body>
</html>