
<!DOCTYPE html>
<html lang="zh_tw">
  <head>
    <meta charset="utf-8">
    </head>
<body>
新增 iwine stand board test form<hr>
<form action="http://admin.iwine.com.tw/qpzm105/api/board_add.php" method="post">
    member_id<input type="text" id="member_id" name="member_id" value="170"><br>
    bar_id<input type="text" id="bar_id" name="bar_id" value="170"><br>
    message<input type="text" id="message" name="message" value="AAA"><br>
    match_method<input type="text" id="match_method" name="match_method" value="相認方式"><br>
    quota<input type="text" id="quota" name="quota" value="20"><br>
    line_id<input type="text" id="line_id" name="line_id" value="A123"><br>
    telphone<input type="text" id="telphone" name="telphone" value="0912123123"><br>
    <?php 
        // $now_timestamp = date_timestamp_get(date_create()); 
        $now = (time()*1000);
        echo $now;
        ?>
    dating_time<input type="text" id="dating_time" name="dating_time" value="<?php echo $now; ?>"><br>
    
    <input type="submit">
</form>
</body>
</html>