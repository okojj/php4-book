<?php
/*
	ȸ������ (ȸ�����)
	2001.06 by Jungjoon Oh
*/
require("mem-lib.php");
require("db-lib.php");

	if (!$id)
	{
		$errmsg.="* ID�� �Է����ּ���.\\n";
	}
	elseif (!check_id($id))
	{
		$errmsg.="* �̹� ������� ID�Դϴ�.\\n";	
	}
	if (!$name )
	{
		$errmsg.="* ������ �Է����ּ���.\\n";
	}
	if (!$idnum1 || !$idnum2 )
	{
		$errmsg.="* �ֹε�Ϲ�ȣ�� �Է����ּ���.\\n";
	}
	elseif (!check_idnum("$idnum1$idnum2"))
	{
		$errmsg.="* �̹� ��ϵ� �ֹε�Ϲ�ȣ�Դϴ�.\\n";	
	}

	if ($errmsg)
	{
		$errmsg="- �Ʒ��� ������ Ȯ���ϼ���\\n\\n" . $errmsg;
		print_alert($errmsg,'back');
	}


	$dbh=dbconnect();

	if ($zip1 && $zip2)
	{
		$zip="$zip1-$zip2";
	}
	

	// Make Query
	$query="insert into member_data "
	."(mem_id,mem_pw,mem_date,mem_name,mem_idnum,mem_email,"
	."mem_url,mem_tel,mem_hp,mem_addr1,mem_addr2,mem_zip) values "
	."('$id','$passwd',sysdate(),'$name','$idnum1-$idnum2','$email',"
	."'$url','$tel','$hp','$addr1','$addr2','$zip')";

	$sth=dbquery($dbh,$query);
	if (!$sth)
	{
		$msg="������ �߻��Ͽ����ϴ�.<br>\n" . mysql_error();
		print_message($msg,"����");
	}
	else
	{

		$msg="
<table width=500 align=center>
<tr><td><center><b>����� �Ϸ�Ǿ����ϴ�.</b></center><br><br>
    </td>
</tr>
</table>
";
		print_message($msg,"ȸ�����");
	}

?>	
	   
