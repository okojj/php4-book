<?php
/*
	ȸ������ (ȸ������ ����)
	2001.06 by Jungjoon Oh
*/

require("db-lib.php");
require("mem-lib.php");

	if (!$MemberID)
	{
		header("Location: member_edit_form.php");
		exit;
	}
		
	// ����Ÿ Ȯ��
	$dbh=dbconnect();
	$query="select mem_id from member_data where mem_id='$MemberID'";
	$sth=dbquery($dbh,$query);
	if (!$sth)
	{
		print_alert(mysql_error(),'back');
	}
	
	list($mem_id)=dbselect($sth);

	// �������� ������
	if (!$mem_id)
	{
		print_alert("�������� �ʴ� ID �Դϴ�.",'back');
		exit;
	}

	$query="update member_data set "
	."mem_pw='$passwd',"
	."mem_name='$name',"
	."mem_email='$email',"
	."mem_url='$url',"
	."mem_tel='$tel',"
	."mem_hp='$hp',"
	."mem_addr1='$addr1',"
	."mem_addr2='$addr2',"
	."mem_zip='$zip1-$zip2' "
	."where mem_id='$MemberID'";

	// Update
	$sth=dbquery($dbh,$query);
	if (!$sth)
	{
		print_alert(mysql_error(),'back');
	}
	else
	{
		print_alert("������ �Ϸ�Ǿ����ϴ�.   ","url|mem_edit_form.php");
	}		
	exit;

?>
