<?php
/*
	명함관리 (명함수정폼)
	2001.06 by Jungjoon Oh
*/

require("db-lib.php");
require("nc-lib.php");

	$mem_id=$REMOTE_USER;

	$from_string="group=$group&id=$id&pn=$pn";

	if (!$idx)
	{
		header("Location: $URL[list]\n\n");
		exit;
	}
	if ($from == 'search')
	{
		$from_string.="&k=$k&where=$where";
	}

	$back_url="$URL[read]?idx=$idx&from=$from&" . $from_string;
		
	// 데이터 가져오기
	$dbh=dbconnect();
	$query="select * from namecard where nc_index=$idx and "
	."(nc_id='$mem_id' or nc_pub='1')";
	$sth=dbquery($dbh,$query);

	if (!$sth)
	{
		print_alert(mysql_error(),'back');
	}
	
	list($nc_index,$nc_group,$nc_id,$nc_date,$nc_name,$nc_company,
	$nc_depart,$nc_title,$nc_tel,$nc_fax,$nc_hp,$nc_email,$nc_url,
	$nc_address,$nc_relation,$nc_note,$nc_pub)=dbselect($sth);

	// 존재하지 않을때
	if (!$nc_index)
	{
		print_alert("데이터가 존재하지 않습니다.",'stop');
		exit;
	}
	
	print_header("명함조회");
	print_location_bar("명함조회");

	$button_line="
    <table border=0 width=100%>
    <tr><td>
	    <a href=\"$URL[edit_form]?idx=$nc_index&from=$from&$from_string\">$BUTTON[edit]</a>
	    <a href=\"$URL[delete]?idx=$nc_index&from=$from&$from_string\"
	    onClick=\"return confirm('[$nc_name]님의 명함을 정말로 삭제하시겠습니까 ?   ');\">
	    $BUTTON[delete]</a> 
	</td>
	<td align=right>
	    <a href=\"$URL[write_form]\">$BUTTON[write]</a> 
	    <a href=\"$URL[list]?m=$from&$from_string\">$BUTTON[list]</a> &nbsp;
	</td>
    </tr>
    </table>
";

?>

<br>
<table width="700" border="0" cellspacing="1" cellpadding="4" bgcolor="#FFFFFF" align="center">
    <tr bgcolor="#FFFFFF">
       <td colspan=4>
	<? echo $button_line ?>
       </td>
    </tr>
    <tr><th width="17%" bgcolor="#BBDDFF"><font size=2>일련번호</font></th>
        <td width="33%" bgcolor="#F0F0F0"><font size=2><?echo $nc_index?></font></td>
	<th width="17%" bgcolor="#BBDDFF"><font size=2>등록일</font></th>
        <td width="33%" bgcolor="#F0F0F0"><font size=2><?echo $nc_date?></font></td>
    </tr>
    <tr><th bgcolor="#BBDDFF"><font size=2>이름</font></th>
        <td bgcolor="#F0F0F0"><font size=2><?echo $nc_name?></font></td>
	<th bgcolor="#BBDDFF"><font size=2>회사이름</font></th>
        <td bgcolor="#F0F0F0"><font size=2><?echo $nc_company?></font></td>
    </tr>
    <tr><th bgcolor="#BBDDFF"><font size=2>부서</font></th>
        <td bgcolor="#F0F0F0"><font size=2><?echo $nc_depart?></font></td>
	<th bgcolor="#BBDDFF"><font size=2>직함</font></th>
        <td bgcolor="#F0F0F0"><font size=2><?echo $nc_title?></font></td>
    </tr>
    <tr><th bgcolor="#BBDDFF"><font size=2>전화</font></th>
        <td bgcolor="#F0F0F0"><font size=2><?echo $nc_tel?></font></td>
	<th bgcolor="#BBDDFF"><font size=2>이동통신</font></th>
        <td bgcolor="#F0F0F0"><font size=2><?echo $nc_hp?></font></td>
    </tr>
    <tr><th bgcolor="#BBDDFF"><font size=2>FAX</font></th>
        <td bgcolor="#F0F0F0"><font size=2><?echo $nc_fax?></font></td>
	<th bgcolor="#BBDDFF"><font size=2>E-mail</font></th>
        <td bgcolor="#F0F0F0"><font size=2><?echo $tag_email?></font></td>
    </tr>
    <tr><th bgcolor="#BBDDFF"><font size=2>주소</font></th>
        <td bgcolor="#F0F0F0" colspan=3><font size=2><?echo $nc_address?></font></td>
    </tr>
    <tr><th bgcolor="#BBDDFF"><font size=2>홈페이지</font></th>
        <td bgcolor="#F0F0F0" colspan=3><font size=2><?echo $tag_url?></font></td>
    </tr>
    <tr><th bgcolor="#BBDDFF"><font size=2>기타내용</font></th>
        <td bgcolor="#F0F0F0" colspan=3><font size=2><?echo $nc_note?></font></td>
    </tr>
    <tr><th bgcolor="#BBDDFF"><font size=2>등록자</font></th>
        <td bgcolor="#F0F0F0"><font size=2><?echo $nc_id?></font></td>
	<th bgcolor="#BBDDFF"><font size=2>등록자와의 관계</font></th>
        <td bgcolor="#F0F0F0"><font size=2><?echo $nc_relation?></font></td>
    </tr>
   <tr bgcolor="#FFFFFF">
       <td colspan=4>
	<? echo $button_line ?>
       </td>
    </tr>
</table>

<?php

	print_footer();
	exit;
?>
