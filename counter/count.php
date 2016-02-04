<?php

include("db.php");

	// ���� ��¥ ����
	$today_date=date("Y-m-d",time());

	// ID�� �������� �ʾ��� ��
	if (!$id)
	{
		ShowCounter(0,0,$align,$border,$width);
		exit;
	}

	// DB ����
	$dbh=dbconnect();
	$query="select * from counter where uid='$id'";
	$sth=dbquery($dbh,$query);
	list ($uid,$total,$today,$date) = dbselect($sth);
	
	// ID�� �������� ���� ���
	if (!$uid)
	{
		// Counter�� �ʱ�ȭ �ϰ� ������ ����
		$total=1;
		$today=1;
		$query="insert into counter (uid,total,today,date) "
		."values ('$id',$total,$today,'$today_date')";
		dbquery($dbh,$query);
	}
	else
	{
		// Counter ���� �� ����
		$total++;
		if ($date == $today_date)
		{
			$today++;
		}
		else
		{
			$today=1;
		}
		// Counter ����
		$query="update counter set total=$total,today=$today,"
		      ."date='$today_date' where uid='$id'";
		dbquery($dbh,$query);
	}	
	// Log ���
	$query="insert into counter_log (uid,ip,datetime,referer) values"
	      ."('$id','$REMOTE_ADDR',now(),'$HTTP_REFERER')";
	dbquery($dbh,$query);
	
	// ��� ���
	ShowCounter($total,$today,$align,$border,$width);

	dbclose($dbh);
	exit;


function ShowCounter ($total,$today,$align,$border,$width)
{
	if (!isset($align))
	{
		$align="center";
	}
	if (!isset($border))
	{
		$border=1;
	}
	if (!isset($width))
	{
		$width=100;
	}
	$total=number_format($total);
	$today=number_format($today);

	echo "
	document.write('<table bordercolor=NAVY border=$border width=$width align=$align cellspacing=0 cellpadding=0>');
	document.write('<tr><td width=40%><font size=1>Total</font></td>');
	document.write('    <td align=right><font size=1 face=verdana>$total</font></td>');
	document.write('</tr>');
	document.write('<tr><td><font size=1>Today</font></td>');
    	document.write('    <td align=right><font size=1 face=verdana>$today</font></td>');
	document.write('</tr>');
	document.write('</table>');
	";

	return;
}
?>