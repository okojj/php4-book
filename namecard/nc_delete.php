<?php
/*
	���԰��� (���Լ�����)
	2001.06 by Jungjoon Oh
*/

require("db-lib.php");
require("nc-lib.php");

	$mem_id=$REMOTE_USER;

	if (!$idx)
	{
		header("Location: $URL[list]\n\n");
		exit;
	}
		
	// ����Ÿ Ȯ��
	$dbh=dbconnect();
	$query="select nc_index,nc_id from namecard where nc_index=$idx";
	$sth=dbquery($dbh,$query);
	if (!$sth)
	{
		print_alert(mysql_error(),'back');
	}
	
	list($nc_index,$nc_id)=dbselect($sth);

	// �������� ������
	if (!$nc_index)
	{
		print_alert("�����Ͱ� �������� �ʽ��ϴ�.",'stop');
		exit;
	}
	// ����� ����� �ƴҶ� 
	if ($mem_id != $nc_id)
	{
		print_alert("������ ����� ����� ������ �� �ֽ��ϴ�.   ",'back');
		exit;
	}

	$query="delete from namecard where nc_index=$nc_index";

	// Delete
	$sth=dbquery($dbh,$query);
	if (!$sth)
	{
		print_alert(mysql_error(),'back');
	}
	else
	{
		print_alert("������ �Ϸ�Ǿ����ϴ�.   ","url|$url");
	}		
	exit;

?>
