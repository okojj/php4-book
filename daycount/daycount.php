<?php

	// ���� ��¥ ����
	$today=time();
	
	// ������ ��¥ ��ȯ
	list($year,$month,$day)=split("-",$date);
	$d_day=mktime(0,0,0,$month,$day,$year);
	
	// ��¥ ���̸� �ϼ��� ��ȯ
	$daycount=intval(($today-$d_day) / 86400);

	if ($daycount > 0)
	{
		$daycount='+' . $daycount;
	}

	// ȭ�� ���
	echo "
	document.write('<table bordercolor=NAVY border=1 width=100 align=center cellspacing=0 cellpadding=0>');
	document.write('<tr><td align=center width=40%><font size=2 face=verdana><b>D$daycount</b></font></td>');
	document.write('</tr>');
	document.write('</table>');
	";

	exit;

?>
