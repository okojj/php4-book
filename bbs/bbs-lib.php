<?php
/*
	게시판
	2001.06 by Jungjoon Oh
*/

$header="header.htm";
$footer="footer.htm";

$upload_path="/home/www/ojj/public_html/bbs/upload";

$URL['home'] = "/bbs";
$URL['write_form'] = "/bbs/write_form.php";
$URL['write'] = "/bbs/write.php";
$URL['list'] = "/bbs/list.php";
$URL['search'] = "/bbs/search.php";
$URL['read'] = "/bbs/read.php";
$URL['edit_form'] = "/bbs/edit_form.php";
$URL['edit'] = "/bbs/edit.php";
$URL['delete'] = "/bbs/delete.php";

$GROUP_NAME=array("","기업","언론사","정계","학교","개인","기타");

$BUTTON['write']="<img src=\"$URL[home]/icon/write.gif\" alt=\"등록\" border=0>";
$BUTTON['reply']="<img src=\"$URL[home]/icon/reply.gif\" alt=\"등록\" border=0>";
$BUTTON['next']="<img src=\"$URL[home]/icon/next.gif\" alt=\"다음페이지\" border=0>";
$BUTTON['prev']="<img src=\"$URL[home]/icon/prev.gif\" alt=\"이전페이지\" border=0>";
$BUTTON['edit']="<img src=\"$URL[home]/icon/modify.gif\" alt=\"수정\" border=0>";
$BUTTON['delete']="<img src=\"$URL[home]/icon/delete.gif\" alt=\"삭제\" border=0>";
$BUTTON['list']="<img src=\"$URL[home]/icon/list.gif\" alt=\"목록\" border=0>";
$BUTTON['disk']="<img src=\"$URL[home]/icon/disk.gif\" alt=\"첨부파일\" border=0>";
$BUTTON['home']="<img src=\"$URL[home]/icon/home.gif\" alt=\"HOME\" border=0>";

$max_list=15;
$column="idx,replynum,name,email,hit,DATE_FORMAT(date,'%Y/%m/%d'),subject,filename";

$admin_passwd="PassWord";

function check_passwd($db,$idx,$rn,$passwd)
{
	/* 데이타 확인 */
	$dbh=dbconnect();
	$table_name="bbs_" . $db;
	$query="select idx,replynum,passwd from $table_name where idx=$idx and replynum=$rn";
	$sth=dbquery($dbh,$query);
	if (!$sth)
	{
		print_message(mysql_error());
	}
	
	list($c_idx,$c_replynum,$c_passwd)=dbselect($sth);
	dbclose($dbh);

	/* 존재하지 않을때 */
	if (!$c_idx)
	{
		return -1;
	}
	/* 비밀번호 확인 */
	if (($passwd == $admin_passwd) || ($passwd == $c_passwd))
	{
		return 1;
	}
	return 0;
}


/* 메세지 출력 */
function print_message ($msg)
{
	require($GLOBALS[header]);

	echo "
<center>
<table height=300>
<tr><td align=center><font color=NAVY><b>
    $msg
    </b></font>
    </td>
</tr>
</table>
	";
	
	require($GLOBALS[footer]);
	exit;
}

/* alert 메세지 출력 */
function print_alert($msg,$next)
{
	echo "
<html>
<head>
</head>
<body bgcolor=#ffffff>

<script language=JavaScript>
<!--
	alert('$msg');
";

	if ($next == "close")
	{
	   echo "	window.close();\n";
	}
	elseif (substr($next,0,3) == "url")
	{
	   list($temp,$url)=explode("|",$next);
	   echo "	window.location='$url';\n";
	}
	elseif (substr($next,0,6) == "opener")
	{
	   list($temp,$url)=explode("|",$next);
	   echo "	opener.window.location='$url';
	                this.close();\n";
	}
	elseif ($_[1] == "stop")
	{
	   echo "";
	}
	else
	{
	   echo "	window.url=history.back();\n";
	}
	
	echo "
//-->
</script>
</body>
</html>
	";
	exit;
}

function make_page_list($url,$list_per_page,$last_number,$current_page)
{
	if (!isset($current_page))
	{
		$current_page=1;
	}
	
	$remainder=$last_number % $list_per_page;
	$page_count=($last_number-$remainder) / $list_per_page;
	if ($remainder)
	{
		$page_count++;
	}
	$page_range1=$current_page - ($current_page % 10);
	if (($current_page % 10) == 0)
	{
		$page_range1-=9;
	}
	else
	{
		$page_range1++;
	}
	$page_range2=$page_range1 + 9;
	   
	if ($page_range1 > 10)
	{
	   	$prev_page=$page_range1 - 10;
	   	$pagelist="<a href=\"$url&pn=1\">[1]</a>...\n";
	   	$pagelist.="<a href=\"$url&pn=$prev_page\">◀</a>\n";
	}
	for ($i=$page_range1; $i <= $page_count && $i<=$page_range2; $i++)
	{
	   if ($current_page == $i || (!$current_page && $i==1))
	   {
	   	$pagelist.="<font color=WHITE style=\"background-color: RED\">"
	   	."[<b>$i</b>]</font> \n";
	   }
	   else
	   {
		$pagelist.="<a href=\"$url&pn=$i\">[$i]</a> \n";
	   }
	}
	if ($i <= $page_count)
	{
	   	$next_page=$i;
	   	$pagelist.="<a href=\"$url&pn=$next_page\">▶</a>... \n";
	   	$pagelist.="<a href=\"$url&pn=$page_count\">[$page_count]</a>\n";
	}
	return array($pagelist,$page_count);
}
