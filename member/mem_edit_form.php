<?php
/*
	회원관리 (회원정보 수정폼)
	2001.06 by Jungjoon Oh
*/

require("db-lib.php");
require("mem-lib.php");


	if (!$MemberID)
	{
		header("Location: login.php?url=mem_edit_form.php");
		exit;
	}
	
	// 데이타 가져오기
	$dbh=dbconnect();
	$query="select * from member_data where mem_id='$MemberID'";
	$sth=dbquery($dbh,$query);
	if (!$sth)
	{
		print_alert(mysql_error(),'back');
	}
	
	$data=dbselect($sth);
	for ($i=0; $i<=11; $i++)
	{
		$data[$i]=ereg_replace("\"","'",$data[$i]);
	}
	
	list($mem_id,$mem_pw,$mem_date,$mem_name,$mem_idnum,$mem_email,
	$mem_url,$mem_tel,$mem_hp,$mem_addr1,$mem_addr2,$mem_zip)=$data;

	// 존재하지 않을때
	if (!$mem_id)
	{
		print_alert("존재하지 않는 ID 입니다.",'back');
		exit;
	}
	
	list($mem_zip1,$mem_zip2)=split("-",$mem_zip);
	
?>


<html>
<head>
<title>회원가입</title>

<script language="JavaScript">
<!--
function OpenZipcode(){
        window.open("zip/zipcode.php?form=f&zip1=zip1&zip2=zip2&address=addr1","ZipWin","width=480,height=200,toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=yes");
}

function checkForm(form)
{
	var msg="";

	if(form.passwd.value==""){
		msg+="- 비밀번호를 입력하세요.\n\n";
	}
	if(form.passwd2.value==""){
		msg+="- 비밀번호 확인을 입력하세요.\n\n";
	}
	else if(form.passwd.value!=form.passwd2.value){
		msg+="- 확인비밀번호가 다릅니다. 똑같이 입력하세요.   \n\n";
	}
	if(form.email.value==""){
		msg+="- E-mail을 입력하세요.\n\n";
  	}
	if(form.tel.value==""){
		msg+="- 전화번호를 입력하세요.\n\n";
  	}
	if(form.zip1.value=="" || form.zip2.value==""){
		msg+="- 우편번호를 입력하세요.\n\n";
  	}
	if(form.addr1.value=="" || form.addr2.value==""){
		msg+="- 주소를 입력하세요.\n\n";
  	}
  	if (msg)
  	{
  		alert("* 아래 사항을 확인하시기 바랍니다.            \n\n\n" + msg);
  		return false;
  	}
  	
	return confirm('위의 내용대로 변경하시겠습니까 ?   ');
}
//-->
</script>
</head>

<body>
<br><br>

<form method="POST" action="mem_edit.php" name="f" onSubmit="return checkForm(document.f);">
<input type="hidden" name="m" value="edit">
<center>
<table border=0 cellpadding=1 cellspacing=1 width="550" height="30" bgcolor="#003399">
<tr><Td bgcolor="#E1EEF5" align="center"><font color="black" face="굴림"><b>회원정보 수정</b></font></td></tr>
</table>&nbsp;<br>
<table width="550" cellpadding="0" cellspacing=2>
    <tr>
      <td colspan=2><ul>
        <li><font size=2>수정할 항목을 입력하신 후에
        &quot;<strong><font size=2 color="#FF0000">변경</font></strong>&quot;버튼을 누르세요.</font></li>
        <li><font size=2><strong><font color="#FF0000">* </font></strong>는 필수 입력 사항입니다.</font></li>
        <li><font size=2>등록에 관해 문제가 발생하거나 문의사항이 있으면, <a href="mailto:help@ojj.co.kr">관리자</a>
            에게로 연락주세요.</font></li>
        </ul>
        </td>
    </tr>
    <tr>
      <td colspan=2><hr size=1 noshade color="#004080">
      </td>
    </tr>
    <tr>
      <td colspan=2></td>
    </tr>
    <tr>
      <td bgcolor="#E1EEF5" bordercolor="#3366CC"><font size=2><strong>&nbsp; 사용자 ID
        <font color="#FF0000">*</font></strong></font></td>
      <td bgcolor="#FCFCFC"><font size=2><?echo $mem_id?></font></td>
    </tr>
    <tr>
      <td bgcolor="#E1EEF5" width="25%" bordercolor="#3366CC"><font size=2><strong>&nbsp; 비밀번호 <font color="#FF0000">*</font></strong></font></td>
      <td bgcolor="#FCFCFC"><table border="0" width="100%" cellspacing="0" cellpadding="0">
        <tr>
          <td width="25%"><font size=3>
          <input type="password" name="passwd" value="<?echo $mem_pw?>" size="8" maxlength="8"></font></td>
          <td width="25%" bgcolor="#E1EEF5"><font size=2><strong>&nbsp; 비밀번호 확인</strong></font></td>
          <td width="25%">&nbsp;<font size=3>
          <input type="password" name="passwd2" value="<?echo $mem_pw?>" size="8" maxlength="8"></font></td>
        </tr>
      </table>
      </td>
    </tr>
    <tr>
      <td bgcolor="#E1EEF5" bordercolor="#3366CC"><strong><font size=2>&nbsp; 성&nbsp; 명<font color="#FF0000">*</font></strong></font></td>
      <td bgcolor="#FCFCFC"><font size=2><input type="text" name="name" value="<?echo $mem_name?>" size=15 maxlength=10></font></td>
    </tr>
    <tr>
      <td bgcolor="#E1EEF5" bordercolor="#3366CC"><font size=2><strong>&nbsp; 주민등록번호<font color="#FF0000">*</font></strong></font></td>
      <td bgcolor="#FCFCFC"><font size=2><?echo $mem_idnum?></font></td>
    </tr>
    <tr>
      <td bgcolor="#E1EEF5" bordercolor="#3366CC"><font size=2><strong>&nbsp; E-mail</strong></font><font size=2><strong>
        <font color="#FF0000">*</font></strong></font></td>
      <td bgcolor="#FCFCFC"><font size=3><input type="text" name="email" value="<?echo $mem_email?>" size=35 maxlength="50"></font>
        <font style="font-size:9pt;"><a href="http://www.empal.com" target="_new">무료 이메일</a></font>
      </td>
    </tr>
    <tr>
      <td bgcolor="#E1EEF5" bordercolor="#3366CC"><font size=2><strong>&nbsp; 홈페이지</strong></font></td>
      <td bgcolor="#FCFCFC"><font size=3><input type="text" name="url" value="<?echo $mem_url?>" size=35 value="http://" maxlength="100"></font></td>
    </tr>
    <tr>
      <td bgcolor="#E1EEF5" bordercolor="#3366CC"><font size=2><strong>&nbsp; 전&nbsp; 화<font color="#FF0000">*</font></strong></font></td>
      <td bgcolor="#FCFCFC"><font size=3><input type="text" name="tel" size=15 value="<?echo $mem_tel?>" maxlength=20></font></td>
    </tr>
    <tr>
      <td bgcolor="#E1EEF5" bordercolor="#3366CC"><font size=2><strong>&nbsp; 이동통신</strong></font></td>
      <td bgcolor="#FCFCFC"><font size=3><input type="text" name="hp" value="<?echo $mem_hp?>" size=15 maxlength=20></font></td>
    </tr>
    <tr>
      <td bgcolor="#E1EEF5" rowspan=2 bordercolor="#3366CC"><font size=2><strong>&nbsp; 주소 <font color="#FF0000">*</font></strong></font></td>
      <td bgcolor="#FCFCFC"><font color=#003399 style="font-size:9pt;">* <b>우편번호 찾기</b> 버튼을 눌러서 입력하세요</font><br>
      <font size=3><input type="text" name="zip1" value="<?echo $mem_zip1?>" size=3 maxlength=10 onFocus="document.f.zip_button1.focus();">
      - <input type="text" name="zip2" value="<?echo $mem_zip2?>" size=3 maxlength=10 onFocus="document.f.zip_button1.focus();">
      <input type="button" name="zip_button1" value=" 우편번호찾기 " onclick="OpenZipcode()"></font></td>
    </tr>
    <tr>
      <td bgcolor="#FCFCFC"><font size=3>
      <input type="text" name="addr1" value="<?echo $mem_addr1?>" size=40 maxlength=70 onFocus="document.f.addr2.focus();"><br>
      <input type="text" name="addr2" value="<?echo $mem_addr2?>" size=40 maxlength=70></font> <font size=2 color=#003399 style="font-size:9pt;">* 나머지 주소</font></td>
    </tr>
    <tr>
      <td colspan=2 align="center"><hr size=1 noshade color="#004080">
      </td>
    </tr>
    <tr>
      <td colspan=2 align="center" height=46>
      <input name="ok" type="submit" value="          변경          "> <input type="reset" value="  다시 "></td>
    </tr>
  </table>
  </center></div>
</form>
</body>
</html>
