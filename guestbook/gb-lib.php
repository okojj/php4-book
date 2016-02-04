<?php
/*
	방명록
	2001.06 by Jungjoon Oh
*/
$admin_id="admin";	// 관리자 아이디
$admin_pw="12345";	// 관리자 비밀번호

$base_url="/guestbook";
$URL['admin'] = "$base_url/gb_admin.php";
$URL['list'] = "$base_url/gb_list.php";
$URL['delete'] = "$base_url/gb_delete.php";
$URL['write'] = "$base_url/gb_write.php";

$max_list=5;	// 한페이지에 보여줄 방명록 수

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
	require("header.htm");
	return;
}


/* 하단 출력 */
function print_footer()
{
	require("footer.htm");
	return;
}

/* 메세지 출력 */
function print_message ($msg)
{
	print_header();

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
	
	print_footer();
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
	   	if ($current_page == $i || (!$current_page && $i==1)) {
	   	   $pagelist.="<font color=WHITE style=\"background-color: RED\">[<b>$i</b>]</font> \n";
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
