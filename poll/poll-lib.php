<?php
/*
	설문조사
	2001.06 by Jungjoon Oh
*/

$header="header.htm";
$footer="footer.htm";

$URL['home'] = "/poll";
$URL['poll'] = "$URL[home]/poll.php";
$URL['result'] = "$URL[home]/result.php";
$URL['new'] = "$URL[home]/new.php";
$URL['list'] = "$URL[home]/list.php";
$URL['modify'] = "$URL[home]/modify.php";
$URL['edit'] = "$URL[home]/edit.php";
$URL['delete'] = "$URL[home]/delete.php";
$URL['login'] = "$URL[home]/login.php";

$LINK['admin']="<img src=\"$URL[home]/icon/admin.gif\" border=0>";
$LINK['new']="<img src=\"$URL[home]/icon/write.gif\" border=0>";
$LINK['list']="[지난설문목록]";
$LINK['edit']="[수정]";
$LINK['delete']="[삭제]";
$LINK['poll']="[설문조사]";

$max_list=5;
$column="idx,replynum,name,email,hit,DATE_FORMAT(date,'%Y/%m/%d'),subject,filename";

$admin_id="admin";	// 관리자 아이디
$admin_pw="12345";	// 관리자 비밀번호


/* 관리자 모드 체크 */
function is_admin($auth_user,$auth_pw)
{
	if ($auth_user==$GLOBALS[admin_id] 
	    && $auth_pw==$GLOBALS[admin_pw])
	{
		return 1;
	}
	return 0;

}

/* 헤더 출력 */
function print_header()
{
	require($GLOBALS[header]);
	return;
}

/* 하단 출력 */
function print_footer()
{
	require($GLOBALS[footer]);
	return;
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
