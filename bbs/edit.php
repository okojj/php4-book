<?php
/*
	�Խ��� (�ۼ���)
	2001.06 by Jungjoon Oh
*/

require("db-lib.php");
require("bbs-lib.php");

	if (!$db)
	{
		print_alert("DB�� �����ϼž� �մϴ�.",'back');
		exit;
	}
	/* �۹�ȣ ���� ���� */
	if (!$idx || !$rn)
	{
		header("Location: $URL[list]\n\n");
		exit;
	}

	/* Table �̸� ���� */
	$table_name="bbs_" . $db;
		
	/* ����Ÿ �������� */
	$dbh=dbconnect();
	$query="select idx,passwd,filename from $table_name where idx=$idx and replynum=$rn";
	$sth=dbquery($dbh,$query);
	if (!$sth)
	{
		print_alert(mysql_error(),'back');
	}
	
	list($e_idx,$e_passwd,$e_filename)=dbselect($sth);

	/* �������� ������ */
	if (!$idx)
	{
		print_alert("�����Ͱ� �������� �ʽ��ϴ�.",'stop');
	}
	elseif ($passwd != $e_passwd)
	{
		print_alert("��й�ȣ�� ��ġ���� �ʽ��ϴ�.   ",'back');
	}

	if ($userfile_name)
	{
		if (!$userfile_size)
		{
			print_alert("���� ���ε� ����",'back');
			exit;
		}
		/* Ȯ���� �˻� */
		$file_ext=strrchr($userfile_name,".");
		$file_ext=ereg_replace("\.","",$file_ext);
		$file_ext=strtolower($file_ext);

		if ($file_ext == 'php' || $file_ext == 'php3' || 
		    $file_ext == 'phtml' || $file_ext == 'inc')
		{
			print_alert("PHP ���α׷� �ҽ��� �ø��� �����ϴ�.  ",'back');
			
		}
		$userfile_name="[$idx-$rn]$userfile_name";
		copy($userfile,"$upload_path/$db/$userfile_name");
		if ($e_filename)
		{
			unlink("$upload_path/$db/$e_filename");
		}
		$query_userfile="filename='$userfile_name',";
	}
	
	/* Query ���� */
	$query="update $table_name set "
	."name='$name', email='$email', url='$url', type='$type'," 
	. $query_userfile . " subject='$subject', note='$note' "
	."where idx='$idx' and replynum='$rn'";

	$sth=dbquery($dbh,$query);
	
	if (!$sth)
	{
		$msg="������ �߻��Ͽ����ϴ�.<br><br>\n" . mysql_error();
		print_message($msg);
	}
	else
	{

		print_alert("������ �Ϸ�Ǿ����ϴ�.   ","url|$return_url");
	}

?>	