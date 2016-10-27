<!DOCTYPE html>
<html lang="zh_tw">
  <head>
    <meta charset="utf-8">
    </head>
<body>
<form action="http://admin.iwine.com.tw/qpzm105/api/register_member_mutimembertype.php" method="post">
    email帳號<input type="text" id="account" name="account" value="draq@test.com.tw"><br>
    密碼<input type="password" id="passwd" name="passwd" value="123456"><br>
    <hr>
    mem_type : <input type="radio" id="member" name="mem_type" value="member">member/一般會員<br>
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
    <hr>
    mem_type : <input type="radio" id="bar" name="mem_type" value="bar">bar/bar會員<br>
    bar 名稱 company_name<input type="text" id="company_name" name="company_name" value="company_name"><br>
    地址 address<input type="text" id="address" name="address" value="address"><br>
    電話 telphone<input type="text" id="telphone" name="telphone" value="telphone"><br>
    負責人 owner<input type="text" id="owner" name="owner" value="owner"><br>
    酒吧類型 category<select name="category" id="category" >
                          <option value="Lounge Bar">1. Lounge Bar</option>
                          <option value="餐廳酒吧">2. 餐廳酒吧</option>
                          <option value="日式酒吧">3. 日式酒吧</option>
                          <option value="夜店酒吧">4. 夜店酒吧</option>
                          <option value="音樂酒吧">5. 音樂酒吧</option>
                          <option value="運動酒吧">6. 運動酒吧</option>                                            
                          <option value="啤酒酒吧">7. 啤酒酒吧</option>                      
                          <option value="其他">8. 其他</option>                                                
                        </select><br>
    聯絡人 contact<input type="text" id="contact" name="contact" value="contact"><br>
    
    傳真 fax<input type="text" id="fax" name="fax" value="fax"><br>
    
    統一編號 vat_num<input type="text" id="vat_num" name="vat_num" value="vat_num"><br>
    email<input type="text" id="email" name="email" value="email"><br>
    營業時間 open_time<input type="text" id="open_time" name="open_time" value="open_time"><br>
    消費方式 cons_pattems<input type="text" id="cons_pattems" name="cons_pattems" value="cons_pattems"><br>
    主打商品 products<input type="text" id="products" name="products" value="products"><br>
    pic1<input type="file" id="pic1" name="pic1" value="pic1"><br>
    開瓶費 corkage_fee<input type="text" id="corkage_fee" name="corkage_fee" value="0"><br>
    葡萄酒杯種類 glass_type<select name="glass_type" id="glass_type" >
                          <option value="5種以下">1. 5種以下</option>
                          <option value="6-10種">2. 6-10種</option>
                          <option value="11種以上">3. 11種以上</option>                              
                        </select>
    
    <br>
    <hr>
    <input type="submit">
</form>
</body>
</html>