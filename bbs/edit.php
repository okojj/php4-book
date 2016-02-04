<?php
/*
	게시판 (글수정)
	2001.06 by Jungjoon Oh
*/

require("db-lib.php");
require("bbs-lib.php");

	if (!$db)
	{
		print_alert("DB를 지정하셔야 합니다.",'back');
		exit;
	}
	/* 글번호 지정 여부 */
	if (!$idx || !$rn)
	{
		header("Location: $URL[list]\n\n");
		exit;
	}

	/* Table 이름 지정 */
	$table_name="bbs_" . $db;
		
	/* 데이타 가져오기 */
	$dbh=dbconnect();
	$query="select idx,passwd,filename from $table_name where idx=$idx and replynum=$rn";
	$sth=dbquery($dbh,$query);
	if (!$sth)
	{
		print_alert(mysql_error(),'back');
	}
	
	list($e_idx,$e_passwd,$e_filename)=dbselect($sth);

	/* 존재하지 않을때 */
	if (!$idx)
	{
		print_alert("데이터가 존재하지 않습니다.",'stop');
	}
	elseif ($passwd != $e_passwd)
	{
		print_alert("비밀번호가 일치하지 않습니다.   ",'back');
	}

	if ($userfile_name)
	{
		if (!$userfile_size)
		{
			print_alert("파일 업로드 실패",'back');
			exit;
		}
		/* 확장자 검색 */
		$file_ext=strrchr($userfile_name,".");
		$file_ext=ereg_replace("\.","",$file_ext);
		$file_ext=strtolower($file_ext);

		if ($file_ext == 'php' || $file_ext == 'php3' || 
		    $file_ext == 'phtml' || $file_ext == 'inc')
		{
			print_alert("PHP 프로그램 소스는 올릴수 없습니다.  ",'back');
			
		}
		$userfile_name="[$idx-$rn]$userfile_name";
		copy($userfile,"$upload_path/$db/$userfile_name");
		if ($e_filename)
		{
			unlink("$upload_path/$db/$e_filename");
		}
		$query_userfile="filename='$userfile_name',";
	}
	
	/* Query 생성 */
	$query="update $table_name set "
	."name='$name', email='$email', url='$url', type='$type'," 
	. $query_userfile . " subject='$subject', note='$note' "
	."where idx='$idx' and replynum='$rn'";

	$sth=dbquery($dbh,$query);
	
	if (!$sth)
	{
		$msg="에러가 발생하였습니다.<br><br>\n" . mysql_error();
		print_message($msg);
	}
	else
	{

		print_alert("수정이 완료되었습니다.   ","url|$return_url");
	}

?>	