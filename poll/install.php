<?php
/*
	�������� (��ġ)
	2001.06 by Jungjoon Oh
*/
require("db-lib.php");
require("poll-lib.php");

$sql_file1="./sql/poll_data.sql";
$sql_file2="./sql/poll_result.sql";

	/* DB ���� */
	$dbh=dbconnect();


	/* ù��° ���̺� */
	$fp=fopen($sql_file1,"r");
	while ($line=fgets($fp,1024))
	{
		$query1.=$line;
		$i++;
	}
	fclose($fp);
	$sth=dbquery($dbh,$query1);
	if (!$sth)
	{
		print_message(mysql_error());
	}

	/* �ι�° ���̺� */
        $fp=fopen($sql_file2,"r");
        while ($line=fgets($fp,1024))
        {
                $query2.=$line;
                $i++;
        }
        fclose($fp);

	$sth=dbquery($dbh,$query2);
	if (!$sth)
	{
		print_message(mysql_error());
	}
	else
	{
		print_alert("DB ��ġ�� �Ϸ�Ǿ����ϴ�.   ","url|$URL[poll]");
	}
?>
