<?php
/*
	게시판 (등록폼)
	2001.06 by Jungjoon Oh
*/
require("db-lib.php");
require("bbs-lib.php");


	if (!$name)
	{
		$errmsg.="* 이름을 입력해주세요\\n";
	}
	if (!$subject)
	{
		$errmsg.="* 제목을 입력해주세요.\\n";
	}
	if (!$note)
	{
		$errmsg.="* 내용을 입력해주세요.\\n";
	}
	if ($errmsg)
	{
		$errmsg="- 아래의 사항을 확인하세요\\n\\n" . $errmsg;
		print_alert($errmsg,'back');
	}

	/* Table 이름 지정 */
	$table_name="bbs_" . $db;
	
	$dbh=dbconnect();

	if ($m == 'reply')
	{
		$idx_next=$idx;

		/* replynum 계산 */
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
		$userfile_name="[$idx_next-$replynum_next]$userfile_name";
		copy($userfile,"$upload_path/$db/$userfile_name");
	}
	
	/* Query 생성 */
	$query="insert into $table_name "
	."(idx,replynum,name,email,url,hit,"
	."date,passwd,ip,type,filename,subject,note) values "
	."($idx_next,$replynum_next,'$name','$email','$url',0,"
	."sysdate(),'$passwd','$REMOTE_ADDR','$type','$userfile_name','$subject','$note')";

	$sth=dbquery($dbh,$query);
	
	if (!$sth)
	{
		$msg="에러가 발생하였습니다.<br><br>\n" . mysql_error();
		print_message($msg);
	}
	else
	{
		print_alert("등록이 완료되었습니다.   ","url|$URL[list]?db=$db");
	}

?>