<?php
/*
	게시판 (글삭제)
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
	if (!$idx || !$rn)
	{
		header("Location: $URL[list]\n\n");
		exit;
	}
	/* 비밀번호 입력폼 */
	if ($m == 'form')
	{
		$from_string="pn=$pn";
		if ($from == 'search')
		{
			$from_string.="&k=$k&w=$w";
		}
		$back_url="$URL[$from]?db=$db&from=$from&" . $from_string;
		passwd_form($db,$idx,$rn,$back_url);
		exit;
	}

	/* Table 이름 지정 */
	$table_name="bbs_" . $db;

	/* 데이타 가져오기 */
	$dbh=dbconnect();
	$query="select idx,passwd,filename from $table_name where idx=$idx and replynum=$rn";
	$sth=dbquery($dbh,$query);
	if (!$sth)
	{
		print_alert(mysql_error(),'back');
	}
	
	list($d_idx,$d_passwd,$d_filename)=dbselect($sth);

	/* 존재하지 않을때 */
	if (!$idx)
	{
		print_alert("데이터가 존재하지 않습니다.",'stop');
	}
	elseif ( ($passwd != $d_passwd) && $passwd != $admin_passwd )
	{
		print_alert("비밀번호가 일치하지 않습니다.   ",'back');
	}
	
	/* 파일 등록 여부 확인 */
	if ($d_filename)
	{
		unlink("$upload_path/$db/$d_filename");
	}
	
	/* 글 삭제 */
	$query="delete from $table_name where idx=$idx";

	/* 첫번째 글이 아닌경우 */
	if ($rn != 1)
	{
		$query.=" and replynum=$rn";
	}
	$sth=dbquery($dbh,$query);
	if (!$sth)
	{
		print_alert(mysql_error(),'back');
	}
	else
	{
		print_alert("삭제가 완료되었습니다.   ","opener|$url");
	}		
	exit;


function passwd_form($db,$idx,$rn,$back_url)
{
	global $URL;
	
	echo "
<html>
<head><title>비밀번호 확인</title>
<script language=JavaScript>
function check_form()
{
	if (document.pwform.passwd.value =='')
	{
		alert('비밀번호를 입력하세요.    ');
		return false;
	}
	return true;
}
</script>
</head>

<body onLoad='document.pwform.passwd.focus();'>
<center>
<font size=2 color=NAVY>글 작성시 입력했던 비밀번호를 입력하세요.</font>
<form method=POST name=pwform action='$URL[delete]' onSubmit='return check_form();'>
<input type=hidden name=db value='$db'>
<input type=hidden name=idx value='$idx'>
<input type=hidden name=rn value='$rn'>
<input type=hidden name=url value='$back_url'>
<TABLE BORDER=0 CELLPADDING=1 CELLSPACING=1 WIDTH=300>
<TR><TD ALIGN=center VALIGN=middle>
    <FONT SIZE=2><B>비밀번호</B></FONT> 
    <INPUT TYPE=password NAME=passwd SIZE=15 MAXLENGTH=10>
    </TD>
</TR>
<TR><TD>&nbsp;</TD></TR>
<TR><TD ALIGN=center VALIGN=middle>
    <INPUT TYPE=submit VALUE=' 삭제하기 '>
    <INPUT TYPE=button NAME=exitBtn VALUE=' 취소 '><br><br>
    <font size=2 color=RED>주의 : 답변이 있는 글은 답변까지 모두 지워집니다.</font>
    </TD>
</TR>
</TABLE>
</body>
</html>
";

}

?>
