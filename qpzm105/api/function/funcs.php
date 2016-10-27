<?php 

function get_location($address){
    $location = array();
    $prepAddr = str_replace(' ','+',$address);
    $geocode=file_get_contents('http://maps.google.com/maps/api/geocode/json?address='.$prepAddr.'&sensor=false');
    $output= json_decode($geocode);
    $location['latitude'] = $output->results[0]->geometry->location->lat;
    $location['longitude'] = $output->results[0]->geometry->location->lng;
    return $location;
}

function GetNewPassword(){
    //$random預設為10，更改此數值可以改變亂數的位數
    $random=12;
    //FOR回圈以$random為判斷執行次數
    for ($i=1;$i<=$random;$i=$i+1)
    {
        //亂數$c設定三種亂數資料格式大寫、小寫、數字，隨機產生
        $c=rand(1,3);
        //在$c==1的情況下，設定$a亂數取值為97-122之間，並用chr()將數值轉變為對應英文，儲存在$b
        if($c==1){$a=rand(97,122);$b=chr($a);}
        //在$c==2的情況下，設定$a亂數取值為65-90之間，並用chr()將數值轉變為對應英文，儲存在$b
        if($c==2){$a=rand(65,90);$b=chr($a);}
        //在$c==3的情況下，設定$b亂數取值為0-9之間的數字
        if($c==3){$b=rand(0,9);}
        //使用$randoma連接$b
        $result=$result.$b;
    }
    return $result;
}

?>