<?php
/*
  ���� (���� ����)
  2001.06 by Jungjoon Oh
*/
require("db-lib.php");
require("gb-lib.php");

	$isAdmin=is_admin($PHP_AUTH_USER,$PHP_AUTH_PW);

	if (!$isAdmin)
	{
		print_alert("�����ڸ� ������ �� �ֽ��ϴ�.  ",'back');
	}
	
	
	if (!$idx)
	{
		header("Location: $URL[list]\n\n");
		exit;
	}
		
	// ����Ÿ Ȯ��
	$dbh=dbconnect();
	$query="select gb_index from guestbook where gb_index=$idx";
	$sth=dbquery($dbh,$query);
	if (!$sth)
	{
		print_alert(mysql_error(),'back');
	}
	
	list($gb_index)=dbselect($sth);

	// �������� ������
	if (!$gb_index)
	{
		print_alert("�����Ͱ� �������� �ʽ��ϴ�.",'stop');
		exit;
	}

	$query="delete from guestbook where gb_index=$idx";

	// Delete
	$sth=dbquery($dbh,$query);
	if (!$sth)
	{
		print_alert(mysql_error(),'back');
	}
	else
	{
		print_alert("������ �Ϸ�Ǿ����ϴ�.   ","url|$URL[list]");
	}		
	exit;

?>
