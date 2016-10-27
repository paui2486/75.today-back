<?php header('content-type: application/json; charset=utf-8');

require_once('../../Connections/iwine.php');
require_once('function/funcs.php');
mysql_select_db($database_iwine, $iwine);

if (!function_exists("GetSQLValueString")) {
    function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") {
        if (PHP_VERSION < 6) { $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue; }
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

function SendResetPwdEmail( $newpassword, $member_email, $member_name){
    require_once('../../../web/PHPMailer/class.phpmailer.php');
    $mail = new PHPMailer(); // defaults to using php "mail()"
    
    $body = "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">
    <html xmlns=\"http://www.w3.org/1999/xhtml\">
    <head>
    <meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />
    <title></title>
    </head>

    <body>
    <table width=\"780\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
      <tr>
        <td height=\"150\" align=\"center\" valign=\"middle\"><table width=\"600\" border=\"0\" cellspacing=\"0\" cellpadding=\"5\">
          <tr>
            <td><p>親愛的 ".$member_name." 會員 您好：</p>
              <p> 以下是系統為您重新設定的密碼資料（大小寫視為不同），請先以此密碼登入後，再進入『資料修改』重新設定您自己熟悉的密碼，謝謝！</p>
              <p>您的新密碼是：<span color=\"red\">".$newpassword."</span>(大小寫視為不同）</p></td>
            </tr>
        </table></td>
      </tr>
    </table>
    </body>
    </html>
    ";
    $mail->AddReplyTo("mail.service@ww1.iwine.tw","iWine");
    $mail->SetFrom('mail.service@ww1.iwine.tw',"iWine");
    $address = $member_email;
    $mail->AddAddress($address, $member_name);
    $mail->Subject    = "iWine 密碼通知信";
    $mail->AltBody    = "請使用可支援HTML格式的讀信軟體!"; // optional, comment out and test
    $mail->MsgHTML($body);
    $mail->CharSet="utf-8";
    $mail->Encoding = "base64";
    //設置郵件格式為HTML
    $mail->IsHTML(true);

    if($mail->Send()) { return true;} 
    else { return false; }
} 

$data = array();
if (isset($_POST['account'])) {
    $member_email = $_POST['account'];
    $query_member = sprintf("SELECT * FROM member WHERE m_account = %s", htmlspecialchars(GetSQLValueString($member_email, "text")));

    mysql_select_db($database_iwine, $iwine);
    $member = mysql_query($query_member, $iwine) or die(mysql_error());
    $totalRows_member = mysql_num_rows($member);
    
    if($totalRows_member == 1){
        $row_member = mysql_fetch_assoc($member);
        $newpassword = GetNewPassword();
        $_passwd_md5 = md5($newpassword);
        $_passwd_id = $row_member['m_id'];
        $insertSQL = sprintf("UPDATE member SET m_passwd_md5 = %s WHERE m_id = %s", GetSQLValueString($_passwd_md5, "text"),GetSQLValueString($_passwd_id, "int"));
        mysql_select_db($database_iwine, $iwine);
        $Result1 = mysql_query($insertSQL, $iwine) or die(mysql_error());

        $send_result = SendResetPwdEmail($newpassword, $row_member['m_email'], $row_member['m_name'] );
        if($send_result){
            $code = 100;
            $status = "success";
        }else{
            $code = 199;
            $status = "send mail error";
        }
        
        mysql_free_result($row_member);
    }else{
        $code = 199;
        $status = "member query result = ".$totalRows_member;
    }
    
}else{
    $code = 199;
    $status = 'no post member email.';
}

$data['code'] = $code;
$data['status'] = $status;


print json_encode($data);
?>
