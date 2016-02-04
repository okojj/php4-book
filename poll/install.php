<?php
/*
	설문조사 (설치)
	2001.06 by Jungjoon Oh
*/
require("db-lib.php");
require("poll-lib.php");

$sql_file1="./sql/poll_data.sql";
$sql_file2="./sql/poll_result.sql";

	/* DB 접속 */
	$dbh=dbconnect();


	/* 첫번째 테이블 */
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

	/* 두번째 테이블 */
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
		print_alert("DB 설치가 완료되었습니다.   ","url|$URL[poll]");
	}
?>
