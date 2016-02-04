<?php
/*
	�������� (�űԵ��)
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
		print_alert("�������� �ʴ� �������Դϴ�.   ",'back');
		exit;
	}

	/* ���� ���� */
	$query="delete from poll_data where poll_idx=$idx";
	$sth=dbquery($dbh,$query);
	/* ��� ���� */
	$query="delete from poll_result where poll_idx=$idx";
	$sth=dbquery($dbh,$query);
	
	if (!$sth)
	{
		$msg="������ �߻��Ͽ����ϴ�.<br><br>\n" . mysql_error();
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
		print_alert("�������� �ʴ� �������Դϴ�.   ",'back');
		exit;
	}
	elseif ($status != 1)
	{
		print_alert("�̹� ������ �����Դϴ�.   ",'back');
		exit;
	}

	/* ���� ���� */
	$query="update poll_data set edate=now(),status='0' where poll_idx=$idx";
	$sth=dbquery($dbh,$query);
	if (!$sth)
	{
		$msg="������ �߻��Ͽ����ϴ�.<br><br>\n" . mysql_error();
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
		print_alert("�������� �ʴ� �������Դϴ�.   ",'back');
		exit;
	}
	elseif ($status==1)
	{
		print_alert("���� �������Դϴ�.   ",'back');
		exit;
	}

	/* ���� �簳 */
	$query="update poll_data set status='1' where poll_idx=$idx";
	$sth=dbquery($dbh,$query);
	if (!$sth)
	{
		$msg="������ �߻��Ͽ����ϴ�.<br><br>\n" . mysql_error();
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