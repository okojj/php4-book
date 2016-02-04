<?php
/*
	명함관리 (명함목록출력)
	2001.06 by Jungjoon Oh
*/

	print_header("명함 목록");
	print_location_bar($location_bar);

	list($pagelist,$page_count)=make_page_list("$URL[list]?m=$m&group=$group&id=$id&where=$where&k=$keyword",$max_list,$total_count,$pn);
	$total_page=$page_count;	

	echo "
<br>
<table width=700 border=0 cellspacing=1 cellpadding=4 bgcolor=#FFFFFF align=center>
    <tr bgcolor=#FFFFFF width=100%>
       <td colspan=8 align=right><font size=2>
       <font color=BLUE>* 이름이나 회사명을 클릭하시면 자세한 내용을 볼수있습니다.</font> &nbsp; &nbsp; &nbsp; &nbsp; 
        전체 : <font color=RED>$total_count</font> &nbsp; 
        현재페이지 : <font color=RED>$pn / $total_page</font></font>
       </td>
    </tr>
    <tr bgcolor=#BBDDFF> 
      <th><font size=2>번호</font></th>
      <th><font size=2>분류</font></th>
      <th><font size=2>이름</font></th>
      <th><font size=2>회사</font></th>
      <th><font size=2>부서</font></th>
      <th><font size=2>직함</font></th>
      <th><font size=2>전화</font></th>
      <th><font size=2>등록일</font></th>
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
		list($nc_index,$nc_id,$nc_group,$nc_name,$nc_company,$nc_depart,$nc_title,$nc_tel,$nc_date,$nc_email)=explode("|",$list);
		if ($nc_email)
		{
			$nc_name="<a href=\"mailto:$nc_email\">$nc_name</a>";
		}

		echo "
    <tr bgcolor=#F0F0F0> 
      <td align=center><font size=2>
          <a href=\"$URL[read]?m=read&idx=$nc_index&$from_string\">
          $article_num</a></font></td>
      <td align=center><font size=2>$GROUP_NAME[$nc_group]</font></td>
      <td align=center><font size=2>$nc_name</font>
      </td>
      <td align=center><font size=2>
          <a href=\"$URL[read]?m=read&idx=$nc_index&$from_string\">
          $nc_company</a></font>
      </td>
      <td align=center><font size=2>$nc_depart</font></td>
      <td align=center><font size=2>$nc_title</font></td>
      <td align=center><font size=2>$nc_tel</font></td>
      <td align=center><font size=2>$nc_date</font></td>
    </tr>
";
		// 글번호 하나씩 감소
		$article_num--;

	   } // foreach
	}

	echo "
    <tr bgcolor=#FFFFFF>
       <td colspan=8 align=center><font size=2>$pagelist</a>
       </td>
    </tr>
    <tr bgcolor=#FFFFFF>
       <td colspan=8 align=right><a href=\"$URL[write_form]\">
       $BUTTON[write]</a> &nbsp;
       </td>
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
<tr><td colspan=2><hr size=1</td></tr>
<tr><td width=30% align=right><font size=2><b>검 색 어:</b></font></td>
    <td width=70%>
        <input type=text name=k value=\"$k\" size=21 maxlength=20>
	<input type=submit value=\"  검색  \">
	<select name=\"group\">
	<option value=\"\">분류</option>
	<option value=1>기업</option>
	<option value=2>언론사</option>
	<option value=3>정계</option>
	<option value=4>학교</option>
	<option value=5>개인</option>
	<option value=9>기타</option>
    </td>
</tr>
<tr><td align=right><font size=2><b>검색대상:</b></font></td>
    <td><font size=2>
        <input type=radio name=where value=\"name\" checked>이름 &nbsp; 
        <input type=radio name=where value=\"company\">회사명 &nbsp; 
        <input type=radio name=where value=\"depart\">부서명 &nbsp; 
        <input type=radio name=where value=\"title\">직함 &nbsp; 
        <input type=radio name=where value=\"id\">등록자ID
        </font>
    </td>
</tr>
</form>
</table>
";
	print_footer();
	exit;

?>
