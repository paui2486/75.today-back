<?php
//為了避免重復包含文件而造成錯誤，加了判斷函數是否存在的條件： 
if(!function_exists(pageft)){ 
    //定義函數pageft(),三個參數的含義為： 
    //$totle：資訊總數； 
    //$displaypg：每頁顯示資訊數，這裏設置默認是20； 
    //$url：分頁導航中的鏈結，除了加入不同的查詢資訊"page"外的部分都與這個URL相同。 
    //預設值本該設為本頁URL（即$_SERVER["REQUEST_URI"]），但設置預設值的右邊只能為常量，所以該預設值設為空字串，在函數內部再設置為本頁URL。 

    function pageft($totle,$displaypg=20,$url='',$page=1){ 
       
        global $page,$firstcount,$pagenav,$_SERVER; 
        
        $GLOBALS["displaypg"]=$displaypg; 
        if(!$page) $page=1; 
        
        if(!$url){ $url=$_SERVER["REQUEST_URI"];} 
        //URL分析： 
        $parse_url=parse_url($url); 
        $url_query=$parse_url["query"]; 
        if($url_query){ 
            
              $url_query=ereg_replace("(^|&)page=$page","",$url_query); 
              $url=str_replace($parse_url["query"],$url_query,$url); 

            //在URL後加page查詢資訊，但待賦值： 
            if($url_query) $url.="&page"; else $url.="page"; 
     }else { 
            $url.="?page"; 
    } 

    //頁碼計算： 
    $lastpg=ceil($totle/$displaypg); //最後頁，也是總頁數 
    $page=min($lastpg,$page); 
    $prepg=$page-1; //上一頁 
    $nextpg=($page==$lastpg ? 0 : $page+1); //下一頁 
    $firstcount=($page-1)*$displaypg; 
    //開始分頁導航條代碼： 
    $pagenav="顯示第 <B>".($totle?($firstcount+1):0)."</B>-<B>".min($firstcount+$displaypg,$totle)."</B> 條記錄，共 $totle 條記錄<BR>"; 
    //如果只有一頁則跳出函數： 
    if($lastpg<=1) return false; 
    $pagenav.=" <a href='$url=1'>首頁</a> 目前第 $page 頁，"; 
    if($prepg) $pagenav.=" <a href='$url=$prepg'>前頁</a> "; else $pagenav.=" 前頁 "; 
    if($nextpg) $pagenav.=" <a href='$url=$nextpg'>後頁</a> "; else $pagenav.=" 後頁 "; 
    $pagenav.=" <a href='$url=$lastpg'>尾頁</a> "; 
    //下拉跳轉列表，迴圈列出所有頁碼： 
    $pagenav.=" 到第 <select name='topage' size='1' onchange='window.location=\"$url=\"+this.value'>\n"; 
    for($i=1;$i<=$lastpg;$i++){ 
        if($i==$page) $pagenav.="<option value='$i' selected>$i</option>\n"; 
        else $pagenav.="<option value='$i'>$i</option>\n"; 
        } 
        $pagenav.="</select> 頁，共 $lastpg 頁"; 
    } 
} 
?>