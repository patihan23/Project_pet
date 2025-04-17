function check_login()
{
	if(document.form_login.mem_username.value == "")
	{
		alert('กรุณากรอกชื่อผู้ใช้งาน (Enter Username) !!!');
		document.form_login.mem_username.focus();
		return false;
	}
	if(document.form_login.mem_password.value == "")
	{
		alert('กรุณากรอกรหัสผ่าน (Enter Password) !!!');
		document.form_login.mem_password.focus();		
		return false;
	}
	document.form_login.submit();
}