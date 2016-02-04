<?php
/*
	�������� (��������� ���)
	2001.06 by Jungjoon Oh
*/
require("db-lib.php");
require("poll-lib.php");

	if (!$idx)
	{
		print_alert("idx�� �������� �ʾҽ��ϴ�.  ",'back');
	}

	if ($m=='view')
	{
		view_result($idx);
		exit;
	}

	/* ���ϴ� ��ǥ ������ */
	$dbh=dbconnect();
	$query="select poll_idx,status,answer_no from poll_data"
	." where poll_idx=$idx";
	$sth=dbquery($dbh,$query);
	list($poll_idx,$status,$answer_no) = dbselect($sth);
	if (!$poll_idx)
	{
		print_alert("�߸��� idx �Դϴ�.($query)  ",'close');
	}
	elseif ($status != 1)
	{
		print_alert("�̹� ����� �����Դϴ�.   ","url|$URL[result]?m=view&idx=$idx");
	}
	elseif ($answer_no < $answer)
	{
		print_alert("�߸��� �亯�Դϴ�.    ",'close');
	}

	/* ��ǥ ���� ���� */
	$query="insert into poll_result (poll_idx,answer,ip,date) "
	."values ($idx,$answer,'$REMOTE_ADDR',now())";
	$sth=dbquery($dbh,$query);
	if (!$sth)
	{
		$msg="������ �߻��Ͽ����ϴ�.<br><br>\n" . mysql_error();
		print_message($msg);
	}
	else
	{
		header("Location: $URL[result]?m=view&idx=$idx");
	}

function view_result($idx)
{
	global $URL;
	
	$dbh=dbconnect();

	/* ���� ���� �̱� */
	$query="select * from poll_data where poll_idx=$idx";
	$sth=dbquery($dbh,$query);
	list($poll_idx,$question,$sdate,$edate,$status,$answer_no,
	$answer[1],$answer[2],$answer[3],$answer[4],$answer[5],
	$answer[6],$answer[7],$answer[8],$answer[9],$answer[10]) = dbselect($sth);

	if (!$poll_idx)
	{
	   print_alert("�߸��� ������ȣ�Դϴ�.   ",'back');
	   exit;
	}

	/* ��� �̱� */
	$query="select answer,count(answer) from poll_result where poll_idx=$idx group by answer";
	$sth=dbquery($dbh,$query);
	while (list($answer_num,$count)=dbselect($sth))
	{
		$RESULT[$answer_num]=$count;
		$sum+=$count;
	}

	/* ��� ȭ�� ��� */
	print_header();
	
	echo "
<table border=1 bordercolor=white bordercolorlight=silver cellpadding=3 cellspacing=0 width=350>
<tr><td colspan=2 bgcolor=f6f6f6 align=center><font size=2><b>���� ���</b><br><br>$question</b></font></td></tr>
";
	   for ($i=1; $i<=$answer_no; $i++)
	   {
	   	$result_count=$RESULT[$i];
	   	if (!$result_count)
	   		$result_count=0;
	   	if ($sum)
	   	{
		   $ratio=round(($result_count/$sum) * 100,0);
	   	   $width=$ratio * 2;
	   	}
		else
		{
		   $sum=0;
		   $ratio=0;
		   $width=0;
		}

	   	
	   	echo "
<tr><td width=300><font size=2>$i. $answer[$i]<br>
        &nbsp;&nbsp;&nbsp;&nbsp;<img src=\"$URL[home]/icon/bar$i.gif\" width='$width' height=10> ($result_count)</font></td>
    <td width=50 align=right><font size=2 color=NAVY>$ratio%</font></td>
</tr>\n";
	   }
	   echo "
<tr><td colspan=2 bgcolor=f6f6f6 align=right><font size=2>�� ��ǥ �� : $sum</font>
</td></tr>
</table>
<center>
<input type=button value=\"   ��   ��   \" onClick=\"window.close();\">
<!--a href=\"javascript:this.close();\">[�ݱ�]</a-->
";
	print_footer();
}
?>
