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
		print_alert("������ ����� ����� �����Ҽ��ֽ��ϴ�.   ",'back');
		exit;
	}

	$query="update namecard set "
	."nc_group='$nc_group',"
	."nc_name='$nc_name',"
	."nc_company='$nc_company',"
	."nc_depart='$nc_depart',"
	."nc_title='$nc_title',"
	."nc_tel='$nc_tel',"
	."nc_fax='$nc_fax',"
	."nc_hp='$nc_hp',"
	."nc_email='$nc_email',"
	."nc_url='$nc_url',"
	."nc_address='$nc_address',"
	."nc_relation='$nc_relation',"
	."nc_note='$nc_note',"
	."nc_pub='$nc_pub' "
	."where nc_index=$nc_index";

	// Update
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
