<?php
/*
	�������� (�������)
	2001.06 by Jungjoon Oh
*/
require("db-lib.php");
require("poll-lib.php");

	if (!is_admin($PHP_AUTH_USER,$PHP_AUTH_PW))
	{
		header("Location: $URL[login]");
		exit;
	}


	if (!$pn)
	{
		$pn=1;
	}
	
	/* DB���� */
	$dbh=dbconnect();
	
	$start_num=($pn-1) * $max_list;
	$end_num=$pn * $max_list;

	/* ��ü ������ */
	$query="select count(poll_idx) from poll_data";
	$sth=dbquery($dbh,$query);
	list($total_count)=dbselect($sth);
	/* ������ ��� */
	list($pagelist,$page_count)=make_page_list("$URL[list]?m=list",$max_list,$total_count,$pn);
	$total_page=$page_count;
	$article_num = $total_count - ($pn * $max_list) + $max_list;

	print_header();
	echo "
<br>
<script language=JavaScript>
function result_window(idx)
{
	window.open('$URL[result]?m=view&idx='+idx, 'result','width=400,height=400,marginwidth=0,marginheight=0,resizable=1,scrollbars=1');  
}   
</script>
<table border=0 width=600 cellspacing=0 cellpadding=0>
<tr width=100%>
   <td colspan=8 align=right><font size=2>
    ��ü : <font color=RED>$total_count</font> &nbsp; 
    ���������� : <font color=RED>$pn / $total_page</font>
    </font>&nbsp;
   </td>
</tr>
<tr><td align=right>
<!--���� ���̺� ���� -->

<table border=1 bordercolor=white bordercolorlight=silver cellpadding=2 cellspacing=0 width=100%>
<tr bgcolor=#f6f6f6> 
  <th width=30><font size=2>��ȣ</font></th>
  <th><font size=2>����</font></th>
  <th width=45><font size=2>���׼�</font></th>
  <th width=80><font size=2>������</font></th>
  <th width=80><font size=2>������</font></th>
  <th width=85><font size=2>��Ÿ</font></th>
</tr>
";
	/* ������ $max_list ��ŭ �̾Ƽ� @LIST_DATA �� ����. */
	$query="select * from poll_data order by poll_idx desc limit $start_num,$max_list";
	$sth=dbquery($dbh,$query);
	$i=0;

	while ( $field = dbselect($sth) )
	{
	   list($poll_idx,$question,$sdate,$edate,$status,$answer_no,
	   $answer[1],$answer[2],$answer[3],$answer[4],$answer[5],
	   $answer[6],$answer[7],$answer[8],$answer[9],$answer[10]) = $field;

	   $answer_list="";
	   for ($i=1; $i<=$answer_no; $i++)
	   {
	   	$answer_list.="[$i]$answer[$i]\n";
	   }
	   if ($status==1)
	   {
	   	$edate_link="<a href=\"$URL[modify]?m=end&idx=$poll_idx&pn=$pn\">"
		."<span title=\"������ �����մϴ�.\">������</span></a>";
	   }
	   else
	   {
	   	$edate_link="<a href=\"$URL[modify]?m=start&idx=$poll_idx&pn=$pn\">"
	   	."<span title=\"������ �簳�մϴ�.\">$edate</span></a>";
	   }
	   	
	   	
	   echo "
<tr> 
  <td align=center><font size=2>$article_num</a></font></td>
  <td><font size=2>
      <a href=\"$URL[poll]?idx=$poll_idx\">
      <span title=\"$answer_list\">$question</span></a></font>
  </td>
  <td align=center><font size=2>$answer_no</font></td>
  <td align=center><font size=2>$sdate</font></td>
  <td align=center><font size=2>$edate_link</font></td>
  <td align=center><font size=2><a href=\"javascript:result_window($poll_idx);\">[���]</a>
  <a href=\"$URL[modify]?m=del&idx=$poll_idx\" 
  onClick=\"return confirm('������ �����Ͻðڽ��ϱ� ?  ');\">[����]</a>
  </font></td>
</tr>
";
		/* �۹�ȣ �ϳ��� ���� */
	   $article_num--;
	   $i++;
	} // while
	/* ����� ���� ��� */
	if ($i==0)
	{
		echo "
<tr> 
  <td colspan=6 align=center>
    <font size=2>��ϵ� ������ �����ϴ�.</font>
  </td>
</tr>
";
	}

	echo "
<tr>
   <td colspan=6 align=center><font size=2>$pagelist</font></td>
</tr>
</table>
<!-- ���� ���̺� �� -->

</td>
</tr>
<tr>
   <td colspan=5 align=right>
   <a href=\"$URL[new]\">$LINK[new]</a> &nbsp;
   </td>
</tr>
</table>
";

	dbclose($dbh);
	print_footer();
	exit;

?>
