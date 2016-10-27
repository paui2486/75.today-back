// JavaScript Document
function chkform(){

 
  myReg = /^.+@.+\..{2,3}$/
  mobileReg = /^[0][9]\d{8}$/
  telcode = /^[0][2-9]{1}/
  telno = /^[1-9]{7}/
  zipno = /^\d{3}/
  
  if( $("#m_name").val() == ""){alert('請輸入姓名!'); return; }  
  if( $("#m_account").val() =="" || !$("#m_account").val().match(myReg)){alert('請輸入正確格式之E-mail作為帳號!'); return; }
  if( $("#m_passwd").val() == ""){alert('請輸入密碼!'); return; }
  if( $("#m_passwd").val().length < 6 || $("#m_passwd").val().length >15 ){alert('請輸入6-15字元的密碼'); return;  }
  if( $("#m_passwd_confirm").val() == ""){alert('請再次確認密碼!'); return; }
  if( $("#m_passwd_confirm").val() != $("#m_passwd").val() ){alert('密碼確認不一致，請重新輸入!'); return; }
  if( $("#m_mobile").val() ==""){alert('請完整輸入行動電話號碼！'); return; }
  if( $("#m_zip").val() =="" || $("#m_county").val() =="county" || $("#m_city").val() =="city" || $("#m_address").val() ==""){alert('請輸入完整地址！'); return; }
  if( $("input[name='m_agree']:checked").val() =="N"){alert('您必須同意會員申請書內容才能成為會員喔!'); return;  }
  if( $("#capacha_code").val() ==""){alert('請輸入驗證碼!'); return; }
  
  $("#form1").submit();
}
