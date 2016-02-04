<?php
/*
	명함관리 (명함수정폼)
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
		
	// 데이타 확인
	$dbh=dbconnect();
	$query="select nc_index,nc_id from namecard where nc_index=$idx";
	$sth=dbquery($dbh,$query);
	if (!$sth)
	{
		print_alert(mysql_error(),'back');
	}
	
	list($nc_index,$nc_id)=dbselect($sth);

	// 존재하지 않을때
	if (!$nc_index)
	{
		print_alert("데이터가 존재하지 않습니다.",'stop');
		exit;
	}
	// 등록한 사람이 아닐때 
	if ($mem_id != $nc_id)
	{
		print_alert("명함을 등록한 사람만 삭제할 수 있습니다.   ",'back');
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
		print_alert("삭제가 완료되었습니다.   ","url|$url");
	}		
	exit;

?>
