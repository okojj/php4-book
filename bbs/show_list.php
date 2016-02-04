<?php
/*
	게시판 (글목록 출력)
	2001.06 by Jungjoon Oh
*/
	require($header);
	
	list($pagelist,$page_count)=make_page_list("$URL[$from]?m=$m&db=$db&$from_string",$max_list,$total_count,$pn);
	$total_page=$page_count;	

	echo "
<br>
<table width=700 border=0 cellspacing=1 cellpadding=4 bgcolor=#FFFFFF align=center>
    <tr bgcolor=#FFFFFF width=100%>
       <td colspan=8 align=right><font size=2>
        전체 : <font color=RED>$total_count</font> &nbsp; 
        현재페이지 : <font color=RED>$pn / $total_page</font></font>
       </td>
    </tr>
    <tr bgcolor=#BBDDFF> 
      <th width=50><font size=2>번호</font></th>
      <th><font size=2>제목</font></th>
      <th width=100><font size=2>글쓴이</font></th>
      <th width=80><font size=2>날짜</font></th>
      <th width=50><font size=2>조회</font></th>
    </tr>
";

	if (!$LIST_DATA)
	{
		echo "
    <tr bgcolor=#F0F0F0> 
      <td colspan=8 align=center>
        <font size=2>등록된 데이터가 없습니다.</font>
      </td>
   </tr>
";
	}
	else
	{
	   $article_num = $total_count - ($pn * $max_list) + $max_list;
	   
	   foreach ($LIST_DATA as $list)
	   {
		list($idx,$replynum,$name,$email,$hit,$date,$subject,$filename)=explode("|",$list);
		if ($email)
		{
			$name="<a href=\"mailto:$email\">$name</a>";
		}
		$subject_space="";
		if ($replynum > 1)
		{
			$subject_space.="&nbsp;&nbsp;☞";
		}
		if ($filename)
		{
			$filelink=" $BUTTON[disk]";
		}
		else
		{
			$filelink="";
		}
		if ($k)
		{
		   if ($w == 'subject' || $w == 'both')
		   {
			$subject=ereg_replace($k,"<font color=RED><b>$k</b></font>",$subject);
		   }
		   elseif ($w == 'name')
		   {
		   	$name=ereg_replace($k,"<font color=RED><b>$k</b></font>",$name);
		   }
		}

		echo "
    <tr bgcolor=#F0F0F0> 
      <td align=center><font size=2>$article_num</a></font></td>
      <td><font size=2>$subject_space
          <a href=\"$URL[read]?db=$db&idx=$idx&rn=$replynum&$from_string\">
          $subject</a>$filelink</font>
      </td>
      <td align=center><font size=2>$name</font></td>
      <td align=center><font size=2>$date</font>
      </td>
      <td align=center><font size=2>$hit</font></td>
    </tr>
";
		/* 글번호 하나씩 감소 */
		$article_num--;

	   } /* foreach */
	}

	echo "
    <tr bgcolor=#FFFFFF>
       <td colspan=5 align=center><font size=2>$pagelist</a>
       </td>
    </tr>
    <tr bgcolor=#FFFFFF>
       <td colspan=2><a href=\"$URL[home]\">
       $BUTTON[home]</a> &nbsp;</td>
       <td colspan=3 align=right><a href=\"$URL[write_form]?db=$db\">
       $BUTTON[write]</a> &nbsp;</td>
    </tr>
</table>
<script language=JavaScript>
<!--
function checkForm(form)
{
	if(form.k.value==''){
		alert('검색어를 입력하세요.     ');
		form.k.focus();
		return false;
	}
	return true;
}
//-->
</script>

<table width=700 align=center>
<form action=\"$URL[search]\" method=GET name=f onSubmit=\"return checkForm(document.f);\">
<input type=hidden name=db value=$db>
<tr><td colspan=2><hr size=1></td></tr>
<tr><td width=30% align=right><font size=2><b>검 색 어:</b></font></td>
    <td width=70%>
        <input type=text name=k value=\"$k\" size=21 maxlength=20>
	<select name=\"w\">
	<option value=subject>제목</option>
	<option value=name>글쓴이</option>
	<option value=note>내용</option>
	<option value=both>제목+내용</option>
	<input type=submit value=\"  검색  \">
    </td>
</tr>
</form>
</table>
";
	require($footer);
	exit;

?>
