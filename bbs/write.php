<?php
/*
	�Խ��� (�����)
	2001.06 by Jungjoon Oh
*/
require("db-lib.php");
require("bbs-lib.php");


	if (!$name)
	{
		$errmsg.="* �̸��� �Է����ּ���\\n";
	}
	if (!$subject)
	{
		$errmsg.="* ������ �Է����ּ���.\\n";
	}
	if (!$note)
	{
		$errmsg.="* ������ �Է����ּ���.\\n";
	}
	if ($errmsg)
	{
		$errmsg="- �Ʒ��� ������ Ȯ���ϼ���\\n\\n" . $errmsg;
		print_alert($errmsg,'back');
	}

	/* Table �̸� ���� */
	$table_name="bbs_" . $db;
	
	$dbh=dbconnect();

	if ($m == 'reply')
	{
		$idx_next=$idx;

		/* replynum ��� */
		$query="select max(replynum) from $table_name where idx=$idx";
		$sth=dbquery($dbh,$query);
		list($replynum_next) = dbselect($sth);
		$replynum_next++;
	}
	else
	{
		$query="select max(idx) from $table_name";
		$sth=dbquery($dbh,$query);
		list($idx_next) = dbselect($sth);
		$idx_next++;
		$replynum_next=1;
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
		$userfile_name="[$idx_next-$replynum_next]$userfile_name";
		copy($userfile,"$upload_path/$db/$userfile_name");
	}
	
	/* Query ���� */
	$query="insert into $table_name "
	."(idx,replynum,name,email,url,hit,"
	."date,passwd,ip,type,filename,subject,note) values "
	."($idx_next,$replynum_next,'$name','$email','$url',0,"
	."sysdate(),'$passwd','$REMOTE_ADDR','$type','$userfile_name','$subject','$note')";

	$sth=dbquery($dbh,$query);
	
	if (!$sth)
	{
		$msg="������ �߻��Ͽ����ϴ�.<br><br>\n" . mysql_error();
		print_message($msg);
	}
	else
	{
		print_alert("����� �Ϸ�Ǿ����ϴ�.   ","url|$URL[list]?db=$db");
	}

?>