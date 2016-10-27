<!DOCTYPE html>
<html lang="zh_tw">
  <head>
    <meta charset="utf-8">
    </head>
<body>
<form action="http://admin.iwine.com.tw/qpzm105/api/register_member.php" method="post">
    email帳號<input type="text" id="account" name="account" value="draq@test.com.tw"><br>
    密碼<input type="password" id="passwd" name="passwd" value="123456"><br>
    姓 名<input type="text" id="name" name="name" value="測試名稱"><br>
    生 日<input type="text" id="bir_year" name="bir_year" value="1988" size="4">年
    <input type="text" id="bir_month" name="bir_month" value="4" size="4">月
    <input type="text" id="bir_date" name="bir_date" value="20" size="4">日
    <br>
    手機<input type="text" id="mobile" name="mobile" value="0912123456"><br>
    縣市<input type="text" id="county" name="county" value="台北市" size="4"> 鄉鎮縣市
    <input type="text" size="4" id="district" name="district" value="信義區"> 郵遞區號
    <input type="text" id="zipcode" name="zipcode" value="100" size="4"><br>
    地址<input id="address" name="address" type="text" value="某路某號某樓">
    <br>
    <input type="submit">
</form>
</body>
</html>