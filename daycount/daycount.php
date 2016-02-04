<?php

	// 현재 날짜 저장
	$today=time();
	
	// 지정한 날짜 변환
	list($year,$month,$day)=split("-",$date);
	$d_day=mktime(0,0,0,$month,$day,$year);
	
	// 날짜 차이를 일수로 변환
	$daycount=intval(($today-$d_day) / 86400);

	if ($daycount > 0)
	{
		$daycount='+' . $daycount;
	}

	// 화면 출력
	echo "
	document.write('<table bordercolor=NAVY border=1 width=100 align=center cellspacing=0 cellpadding=0>');
	document.write('<tr><td align=center width=40%><font size=2 face=verdana><b>D$daycount</b></font></td>');
	document.write('</tr>');
	document.write('</table>');
	";

	exit;

?>
