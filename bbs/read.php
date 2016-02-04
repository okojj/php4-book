<?php
/*
	게시판 (글읽기)
	2001.06 by Jungjoon Oh
*/
require("db-lib.php");
require("bbs-lib.php");

	if (!$db)
	{
		print_alert("DB를 지정하셔야 합니다.",'back');
		exit;
	}
	/* 글번호 지정 여부 */
	if (!$idx)
	{
		header("Location: $URL[list]\n\n");
		exit;
	}
	/* Table 이름 지정 */
	$table_name="bbs_" . $db;

	$from_string="from=$from&pn=$pn";

	if ($from == 'search')
	{
		$from_string.="&k=$k&w=$w";
	}

	/* 데이터 가져오기 */
	$dbh=dbconnect();
	$query="select * from $table_name where idx=$idx and replynum=$rn";
	$sth=dbquery($dbh,$query);

	if (!$sth)
	{
		print_message("$query");
	}
	
	list($idx,$replynum,$name,$email,$url,$hit,$date,
	$passwd,$ip,$type,$filename,$subject,$note)=dbselect($sth);

	/* 존재하지 않을때 */
	if (!$idx)
	{
		print_alert("데이터가 존재하지 않습니다.",'stop');
		exit;
	}
	
	/* 조회수 증가 */
	$query="update $table_name set hit=hit+1 where idx=$idx and replynum=$rn";
	dbquery($dbh,$query);
	
	
	if ($email)
	{
		$name="<a href=\"mailto:$email\">$name</a>";
	}
	$button_line="
<a href=\"$URL[edit_form]?db=$db&idx=$idx&rn=$rn&from=$from&$from_string\">$BUTTON[edit]</a>
<a href=\"#\" onClick=\"openPasswdForm();\">$BUTTON[delete]</a>
<a href=\"$URL[write_form]?db=$db&m=reply&idx=$idx&dt=$dt&rn=$rn\">$BUTTON[reply]</a> 
<a href=\"$URL[write_form]?db=$db\">$BUTTON[write]</a> 
<a href=\"$URL[$from]?db=$db&$from_string\">$BUTTON[list]</a>
";
	/* 첨부파일 체크 */
	if ($filename)
	{
		$filesize=number_format(filesize("$upload_path/$db/$filename"));
		$attach_file="<tr><td colspan=2 bgcolor=#BBDDFF><font size=2>첨부파일:"
		."<a href=\"$URL[home]/upload/$db/$filename\">$filename</a> "
		."($filesize bytes)</font></td></tr>";
	}
	/* 답변 목록 체크 */
	$query="select $column from $table_name where idx=$idx order by replynum";
	$sth=dbquery($dbh,$query);
	$i=0;

	while ( $data = dbselect($sth) )
	{
	   list($r_idx,$r_replynum,$r_name,$r_email,$r_hit,$r_date,$r_subject)=$data;
	   /* 답변글 표시 */
	   if ($r_replynum != 1)
	   {
	   	$reply_tag="&nbsp;&nbsp;☞ ";
	   }
	   $reply_list.="<tr><td><font size=2>$reply_tag";
	   if ($rn == $r_replynum)
	   {
	   	$reply_list.="<font color=NAVY><b>$r_subject</b></font>";
	   }
	   else
	   {
	   	$reply_list.="<a href=\"$URL[read]?db=$db&idx=$r_idx"
	   	."&rn=$r_replynum&$from_string\">$r_subject</a>";
	   }
	   $reply_list.="</font></td><td align=right><font size=2>"
	   ."$r_name &nbsp;&nbsp; $r_date</font></td></tr>";
	   $i++;
	}
	if ($i == 1)
	{
	   $reply_list="";
	}
	else
	{
	   $reply_list="
<tr><td colspan=2 height=30 bgcolor=#BBDDFF><font size=2><b>답변목록</b></font></td>
</tr>
<tr><td colspan=2 height=70 bgcolor=#D0F0FF><table width=100%>$reply_list</table></td>
</tr>
";
	}
	/* 다음글 목록 */
	$query="select $column from $table_name where replynum=1 and idx>$idx"
	." order by idx";
	$sth=dbquery($dbh,$query);
	list($n_idx,$n_replynum,$n_name,$n_email,$n_hit,$n_date,$n_subject)=dbselect($sth);
	if ($n_idx)
	{
		$next_list.="<tr><td><font size=2>△ "
		."<a href=\"$URL[read]?db=$db&idx=$n_idx&rn=$n_replynum"
		."&$from_string\">$n_subject</a></font></td></tr>";
	}
	/* 이전글 목록 */
	$query="select $column from $table_name where replynum=1 and idx<$idx"
	." order by idx desc";
	$sth=dbquery($dbh,$query);
	list($n_idx,$n_replynum,$n_name,$n_email,$n_hit,$n_date,$n_subject)=dbselect($sth);
	if ($n_idx)
	{
		$next_list.="<tr><td><font size=2>▽ "
		."<a href=\"$URL[read]?db=$db&idx=$n_idx&rn=$n_replynum"
		."&$from_string\">$n_subject</a></font></td></tr>";
	}

	if ($next_list)
	{
	   $next_list="<table width=100%>$next_list</table>";
	}
	/* 결과 출력 */
	require($header);
	
	/* Text 형식일때 본문의 new-line을 <br>로 변환 */
	if ($type==1)
	{
		$note=htmlspecialchars($note);
		$note=nl2br($note);
	}
	/* 검색일때 일치하는 키워드는 빨간색으로 */
	if ($from == 'search')
	{
		$note=ereg_replace($k,"<font color=RED><b>$k</b></font>",$note);
	}

	echo "
<script language=JavaScript>
<!--
function openPasswdForm()
{
	if (confirm('정말로 삭제하시겠습니까 ?   '))
	{
	   window.open('$URL[delete]?m=form&db=$db&idx=$idx&rn=$rn&$from_string',
	   'passwdform','width=350,height=200,scrollbars=no,resizable=no');
	}
	return false;
}
-->
</script>


<br>
<table border=0 width=600 align=center cellspacing=0 cellpadding=5>
<tr><td>$button_line</td>
    <td align=right><font size=2>성명: $name, 조회: $hit</font></td>
</tr>
<tr><th colspan=2 height=30 bgcolor=#BBDDFF><font size=2>$subject</font></th>
</tr>
<tr><td colspan=2 height=200 valign=top bgcolor=#D0F0FF><font size=2>$note</font></td>
</tr>
$reply_list
$attach_file
<tr><td colspan=2><hr size=1 noshade</td>
</tr>
<tr><td valign=top>$next_list</td>
    <td align=right valign=top><font size=2>$date from $ip</font></td>
</tr>
<tr><td colspan=2 align=right>$button_line</td>
</tr>
</table>
";

	require($footer);
	exit;
?>
