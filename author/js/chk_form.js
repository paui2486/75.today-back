// JavaScript Document
function chksubmit(){

if(!$("input[@name='c_class']:checked").val()){alert('請選取問題類別!'); return;}
if($("#c_email").val() ==""){alert('請填寫聯絡email!'); return;}
if($("#c_cont").val() ==""){alert('請填寫問題內容!'); return;}
$("#form_service").submit();

}