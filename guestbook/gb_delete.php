<?php
/*
  방명록 (방명록 삭제)
  2001.06 by Jungjoon Oh
*/
require("db-lib.php");
require("gb-lib.php");

	$isAdmin=is_admin($PHP_AUTH_USER,$PHP_AUTH_PW);

	if (!$isAdmin)
	{
		print_alert("관리자만 삭제할 수 있습니다.  ",'back');
	}
	
	
	if (!$idx)
	{
		header("Location: $URL[list]\n\n");
		exit;
	}
		
	// 데이타 확인
	$dbh=dbconnect();
	$query="select gb_index from guestbook where gb_index=$idx";
	$sth=dbquery($dbh,$query);
	if (!$sth)
	{
		print_alert(mysql_error(),'back');
	}
	
	list($gb_index)=dbselect($sth);

	// 존재하지 않을때
	if (!$gb_index)
	{
		print_alert("데이터가 존재하지 않습니다.",'stop');
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
		print_alert("삭제가 완료되었습니다.   ","url|$URL[list]");
	}		
	exit;

?>
