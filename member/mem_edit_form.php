<?php
/*
	ȸ������ (ȸ������ ������)
	2001.06 by Jungjoon Oh
*/

require("db-lib.php");
require("mem-lib.php");


	if (!$MemberID)
	{
		header("Location: login.php?url=mem_edit_form.php");
		exit;
	}
	
	// ����Ÿ ��������
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

	// �������� ������
	if (!$mem_id)
	{
		print_alert("�������� �ʴ� ID �Դϴ�.",'back');
		exit;
	}
	
	list($mem_zip1,$mem_zip2)=split("-",$mem_zip);
	
?>


<html>
<head>
<title>ȸ������</title>

<script language="JavaScript">
<!--
function OpenZipcode(){
        window.open("zip/zipcode.php?form=f&zip1=zip1&zip2=zip2&address=addr1","ZipWin","width=480,height=200,toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=yes");
}

function checkForm(form)
{
	var msg="";

	if(form.passwd.value==""){
		msg+="- ��й�ȣ�� �Է��ϼ���.\n\n";
	}
	if(form.passwd2.value==""){
		msg+="- ��й�ȣ Ȯ���� �Է��ϼ���.\n\n";
	}
	else if(form.passwd.value!=form.passwd2.value){
		msg+="- Ȯ�κ�й�ȣ�� �ٸ��ϴ�. �Ȱ��� �Է��ϼ���.   \n\n";
	}
	if(form.email.value==""){
		msg+="- E-mail�� �Է��ϼ���.\n\n";
  	}
	if(form.tel.value==""){
		msg+="- ��ȭ��ȣ�� �Է��ϼ���.\n\n";
  	}
	if(form.zip1.value=="" || form.zip2.value==""){
		msg+="- �����ȣ�� �Է��ϼ���.\n\n";
  	}
	if(form.addr1.value=="" || form.addr2.value==""){
		msg+="- �ּҸ� �Է��ϼ���.\n\n";
  	}
  	if (msg)
  	{
  		alert("* �Ʒ� ������ Ȯ���Ͻñ� �ٶ��ϴ�.            \n\n\n" + msg);
  		return false;
  	}
  	
	return confirm('���� ������ �����Ͻðڽ��ϱ� ?   ');
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
<tr><Td bgcolor="#E1EEF5" align="center"><font color="black" face="����"><b>ȸ������ ����</b></font></td></tr>
</table>&nbsp;<br>
<table width="550" cellpadding="0" cellspacing=2>
    <tr>
      <td colspan=2><ul>
        <li><font size=2>������ �׸��� �Է��Ͻ� �Ŀ�
        &quot;<strong><font size=2 color="#FF0000">����</font></strong>&quot;��ư�� ��������.</font></li>
        <li><font size=2><strong><font color="#FF0000">* </font></strong>�� �ʼ� �Է� �����Դϴ�.</font></li>
        <li><font size=2>��Ͽ� ���� ������ �߻��ϰų� ���ǻ����� ������, <a href="mailto:help@ojj.co.kr">������</a>
            ���Է� �����ּ���.</font></li>
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
      <td bgcolor="#E1EEF5" bordercolor="#3366CC"><font size=2><strong>&nbsp; ����� ID
        <font color="#FF0000">*</font></strong></font></td>
      <td bgcolor="#FCFCFC"><font size=2><?echo $mem_id?></font></td>
    </tr>
    <tr>
      <td bgcolor="#E1EEF5" width="25%" bordercolor="#3366CC"><font size=2><strong>&nbsp; ��й�ȣ <font color="#FF0000">*</font></strong></font></td>
      <td bgcolor="#FCFCFC"><table border="0" width="100%" cellspacing="0" cellpadding="0">
        <tr>
          <td width="25%"><font size=3>
          <input type="password" name="passwd" value="<?echo $mem_pw?>" size="8" maxlength="8"></font></td>
          <td width="25%" bgcolor="#E1EEF5"><font size=2><strong>&nbsp; ��й�ȣ Ȯ��</strong></font></td>
          <td width="25%">&nbsp;<font size=3>
          <input type="password" name="passwd2" value="<?echo $mem_pw?>" size="8" maxlength="8"></font></td>
        </tr>
      </table>
      </td>
    </tr>
    <tr>
      <td bgcolor="#E1EEF5" bordercolor="#3366CC"><strong><font size=2>&nbsp; ��&nbsp; ��<font color="#FF0000">*</font></strong></font></td>
      <td bgcolor="#FCFCFC"><font size=2><input type="text" name="name" value="<?echo $mem_name?>" size=15 maxlength=10></font></td>
    </tr>
    <tr>
      <td bgcolor="#E1EEF5" bordercolor="#3366CC"><font size=2><strong>&nbsp; �ֹε�Ϲ�ȣ<font color="#FF0000">*</font></strong></font></td>
      <td bgcolor="#FCFCFC"><font size=2><?echo $mem_idnum?></font></td>
    </tr>
    <tr>
      <td bgcolor="#E1EEF5" bordercolor="#3366CC"><font size=2><strong>&nbsp; E-mail</strong></font><font size=2><strong>
        <font color="#FF0000">*</font></strong></font></td>
      <td bgcolor="#FCFCFC"><font size=3><input type="text" name="email" value="<?echo $mem_email?>" size=35 maxlength="50"></font>
        <font style="font-size:9pt;"><a href="http://www.empal.com" target="_new">���� �̸���</a></font>
      </td>
    </tr>
    <tr>
      <td bgcolor="#E1EEF5" bordercolor="#3366CC"><font size=2><strong>&nbsp; Ȩ������</strong></font></td>
      <td bgcolor="#FCFCFC"><font size=3><input type="text" name="url" value="<?echo $mem_url?>" size=35 value="http://" maxlength="100"></font></td>
    </tr>
    <tr>
      <td bgcolor="#E1EEF5" bordercolor="#3366CC"><font size=2><strong>&nbsp; ��&nbsp; ȭ<font color="#FF0000">*</font></strong></font></td>
      <td bgcolor="#FCFCFC"><font size=3><input type="text" name="tel" size=15 value="<?echo $mem_tel?>" maxlength=20></font></td>
    </tr>
    <tr>
      <td bgcolor="#E1EEF5" bordercolor="#3366CC"><font size=2><strong>&nbsp; �̵����</strong></font></td>
      <td bgcolor="#FCFCFC"><font size=3><input type="text" name="hp" value="<?echo $mem_hp?>" size=15 maxlength=20></font></td>
    </tr>
    <tr>
      <td bgcolor="#E1EEF5" rowspan=2 bordercolor="#3366CC"><font size=2><strong>&nbsp; �ּ� <font color="#FF0000">*</font></strong></font></td>
      <td bgcolor="#FCFCFC"><font color=#003399 style="font-size:9pt;">* <b>�����ȣ ã��</b> ��ư�� ������ �Է��ϼ���</font><br>
      <font size=3><input type="text" name="zip1" value="<?echo $mem_zip1?>" size=3 maxlength=10 onFocus="document.f.zip_button1.focus();">
      - <input type="text" name="zip2" value="<?echo $mem_zip2?>" size=3 maxlength=10 onFocus="document.f.zip_button1.focus();">
      <input type="button" name="zip_button1" value=" �����ȣã�� " onclick="OpenZipcode()"></font></td>
    </tr>
    <tr>
      <td bgcolor="#FCFCFC"><font size=3>
      <input type="text" name="addr1" value="<?echo $mem_addr1?>" size=40 maxlength=70 onFocus="document.f.addr2.focus();"><br>
      <input type="text" name="addr2" value="<?echo $mem_addr2?>" size=40 maxlength=70></font> <font size=2 color=#003399 style="font-size:9pt;">* ������ �ּ�</font></td>
    </tr>
    <tr>
      <td colspan=2 align="center"><hr size=1 noshade color="#004080">
      </td>
    </tr>
    <tr>
      <td colspan=2 align="center" height=46>
      <input name="ok" type="submit" value="          ����          "> <input type="reset" value="  �ٽ� "></td>
    </tr>
  </table>
  </center></div>
</form>
</body>
</html>
