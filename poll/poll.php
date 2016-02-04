<?php
/*
	설문조사 (현재설문)
	2001.06 by Jungjoon Oh
*/
require("db-lib.php");
require("poll-lib.php");

	/* DB 접속 */
	$dbh=dbconnect();

	$query="select * from poll_data where status='1' ";
	if ($idx)
	{
		$query.=" and poll_idx=$idx";
	}
	else
	{
		$query.=" order by poll_idx desc";
	}
	$sth=dbquery($dbh,$query);

	list($poll_idx,$question,$sdate,$edate,$status,$answer_no,
	$answer[1],$answer[2],$answer[3],$answer[4],$answer[5],
	$answer[6],$answer[7],$answer[8],$answer[9],$answer[10]) = dbselect($sth);
	
	print_header();
	
	if (!$poll_idx)
	{
	   echo "<br><br><font size=2>현재 진행중인 설문이 없습니다.</font><br><br>"
	   ."<a href=\"$URL[list]\">$LINK[admin]</a>";
	}
	else
	{
	   $idx=$poll_idx;
	   echo "
<script language=JavaScript>

function check_form(form) 
{ 
	if (form.m.value=='vote')
	{
	   check_val=-1;
	   for (i=0; i<form.answer.length; i++)
	   {
	   	if (form.answer[i].checked)
	    	{
	    	   check_val+=1;
	    	}
	   }
	
	   if (check_val==-1)
	   {
		alert('문항중에 하나를 선택하세요   ');
		return false;
	   }
	}
	result_window();
	return true;
}

function result_window()
{
	window.open('', 'result','width=400,height=400,marginwidth=0,marginheight=0,resizable=1,scrollbars=1');  
}   

</script>

<form action=\"$URL[result]\" name=f target=result onSubmit='return check_form(document.f);'>
<input type=hidden name=idx value=$idx>
<input type=hidden name=m value=''>
<table width=350>
<tr><td>
<!--메인 테이블 시작-->
<table border=1 bordercolor=white bordercolorlight=silver cellpadding=3 cellspacing=0 width=100%>
<tr><td bgcolor=f6f6f6><font size=2><b>$question</b></font></td></tr>
";
	   for ($i=1; $i<=$answer_no; $i++)
	   {
	   	echo "<tr><td><font size=2>$i.<input type=radio name=answer value=$i>$answer[$i]</font></td></tr>\n";
	   }
	   echo "
</table>
<!--메인 테이블 끝-->
</td>
</tr>
<tr><td align=center>
    <input type=submit value='  투표하기  ' onClick=\"document.f.m.value='vote';\">
    <input type=submit value='  결과보기  ' onClick=\"document.f.m.value='view';\">
</td></tr>
<tr><td align=right><a href=\"$URL[list]\">$LINK[admin]</a>&nbsp;&nbsp;</td></tr>
</table>

";
	}
	
	print_footer();

?>
