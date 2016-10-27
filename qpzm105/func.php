<?php
// 用Java Script顯示訊息視窗，訊息為 $msg
	function msg_box($msg)
	{
		if ($msg != ""){
			echo '<script language="javascript">alert("'.$msg.'")</script>';
		}
		return "";
	}
	//上一頁跟下一頁
	function go_to($go)
	{     if($go==1 || $go == -1)
			echo '<script language="javascript">history.go('.$go.')</script>';
		   else
		   echo '<script language="javascript">window.location=("'.$go.'")</script>';		
	}
	
	function go_top($go)
	{     
		   echo '<script language="javascript">top.location=("'.$go.'")</script>';		
	}
	
	function win_close()
	{
		   echo '<script language="JavaScript">window.close();</script>';	
	}
	
	function winc_lose_re()
	{
		   echo '<script language="JavaScript" type="text/JavaScript">window.opener.location.reload();window.close();</script>';	
	}
// 轉址Re-Direction URL address至 $url
	Function go_url($url){
		echo "<meta http-equiv='refresh' content='0; url=http:$url'>";
	}

//***** PHP中限制文字顯示自訂函式開始 *****
function substr_utf8($str, $lenth)
{
    $start = 0;
    $len = strlen($str);
    $r = array();
    $n = 0;
    $m = 0;
    for($i = 0; $i < $len; $i++) {
    $x = substr($str, $i, 1);
    $a = base_convert(ord($x), 10, 2);
    $a = substr('00000000'.$a, -8);
    if ($n < $start){
        if (substr($a, 0, 1) == 0) {
        }elseif (substr($a, 0, 3) == 110) {
           $i += 1;
       }elseif (substr($a, 0, 4) == 1110) {
           $i += 2;
   }
   $n++;
   }else{
         if (substr($a, 0, 1) == 0) {
             $r[] = substr($str, $i, 1);
         }elseif (substr($a, 0, 3) == 110) {
             $r[] = substr($str, $i, 2);
             $i += 1;
         }elseif (substr($a, 0, 4) == 1110) {
            $r[] = substr($str, $i, 3);
            $i += 2;
         }else{
              $r[] = '';
         }
   if (++$m >= $lenth){
        break;
   }
}
}
return implode("",$r);
} 

//***** PHP中限制文字顯示自訂函式結束 *****

function get_client_ip() {
	global $_SERVER;
	if (isset($_SERVER['HTTP_VIA']) && isset($_SERVER['HTTP_X_FORWARDED_FOR'])){
			list($IP,$USE_DNS)=split(",",$_SERVER['HTTP_X_FORWARDED_FOR']);
			$PROXY=$_SERVER['REMOTE_ADDR'];
			
	} else {
			$IP = $_SERVER['REMOTE_ADDR'];
	}
	return $IP;
}
?>