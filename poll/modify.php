<?php
/*
	설문조사 (신규등록)
	2001.06 by Jungjoon Oh
*/

require("db-lib.php");
require("poll-lib.php");

	if ($m == 'end')
	{
		set_end($idx);
	}
	elseif ($m == 'start')
	{
		set_start($idx);
	}
	elseif ($m == 'del')
	{
		delete_poll($idx);
	}
	
function delete_poll($idx)
{
	global $URL,$pn;
	
	$dbh=dbconnect();
	$query="select poll_idx from poll_data where poll_idx=$idx";
	$sth=dbquery($dbh,$query);
	list($poll_idx,$status)=dbselect($sth);
	if (!$poll_idx)
	{
		print_alert("존재하지 않는 데이터입니다.   ",'back');
		exit;
	}

	/* 설문 삭제 */
	$query="delete from poll_data where poll_idx=$idx";
	$sth=dbquery($dbh,$query);
	/* 결과 삭제 */
	$query="delete from poll_result where poll_idx=$idx";
	$sth=dbquery($dbh,$query);
	
	if (!$sth)
	{
		$msg="에러가 발생하였습니다.<br><br>\n" . mysql_error();
		print_message($msg);
	}
	else
	{
		header("Location: $URL[list]");
		exit;
	}
	dbclose($dbh);
	exit;
}

function set_end($idx)
{
	global $URL,$pn;
	
	$dbh=dbconnect();
	$query="select poll_idx,status from poll_data where poll_idx=$idx";
	$sth=dbquery($dbh,$query);
	list($poll_idx,$status)=dbselect($sth);
	if (!$poll_idx)
	{
		print_alert("존재하지 않는 데이터입니다.   ",'back');
		exit;
	}
	elseif ($status != 1)
	{
		print_alert("이미 마감된 설문입니다.   ",'back');
		exit;
	}

	/* 설문 마감 */
	$query="update poll_data set edate=now(),status='0' where poll_idx=$idx";
	$sth=dbquery($dbh,$query);
	if (!$sth)
	{
		$msg="에러가 발생하였습니다.<br><br>\n" . mysql_error();
		print_message($msg);
	}
	else
	{
		header("Location: $URL[list]?pn=$pn");
		exit;
	}
	dbclose($dbh);
	exit;
}


function set_start($idx)
{
	global $URL,$pn;
	
	$dbh=dbconnect();
	$query="select poll_idx,status from poll_data where poll_idx=$idx";
	$sth=dbquery($dbh,$query);
	list($poll_idx,$edate)=dbselect($sth);
	if (!$poll_idx)
	{
		print_alert("존재하지 않는 데이터입니다.   ",'back');
		exit;
	}
	elseif ($status==1)
	{
		print_alert("현재 설문중입니다.   ",'back');
		exit;
	}

	/* 설문 재개 */
	$query="update poll_data set status='1' where poll_idx=$idx";
	$sth=dbquery($dbh,$query);
	if (!$sth)
	{
		$msg="에러가 발생하였습니다.<br><br>\n" . mysql_error();
		print_message($msg);
	}
	else
	{
		header("Location: $URL[list]?pn=$pn");
		exit;
	}
	dbclose($dbh);
	exit;
}
?>

?>