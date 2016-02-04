<?php
/*
	���԰���
	2001.06 by Jungjoon Oh
*/

$URL['nc_home'] = "/namecard";
$URL['write_form'] = "$base_url/namecard/nc_write_form.php";
$URL['write'] = "$base_url/namecard/nc_write.php";
$URL['list'] = "$base_url/namecard/nc_list.php";
$URL['search'] = "$base_url/namecard/nc_search.php";
$URL['read'] = "$base_url/namecard/nc_read.php";
$URL['edit_form'] = "$base_url/namecard/nc_edit_form.php";
$URL['edit'] = "$base_url/namecard/nc_edit.php";
$URL['delete'] = "$base_url/namecard/nc_delete.php";

$GROUP_NAME=array("","���","��л�","����","�б�","����","��Ÿ");

$BUTTON['write']="<img src=\"$URL[nc_home]/images/write.gif\" alt=\"���\" border=0>";
$BUTTON['next']="<img src=\"$URL[nc_home]/images/next.gif\" alt=\"����������\" border=0>";
$BUTTON['prev']="<img src=\"$URL[nc_home]/images/prev.gif\" alt=\"����������\" border=0>";
$BUTTON['edit']="<img src=\"$URL[nc_home]/images/modify.gif\" alt=\"����\" border=0>";
$BUTTON['delete']="<img src=\"$URL[nc_home]/images/delete.gif\" alt=\"����\" border=0>";
$BUTTON['list']="<img src=\"$URL[nc_home]/images/list.gif\" alt=\"���\" border=0>";
$max_list=5;
$column="nc_index,nc_id,nc_group,nc_name,nc_company,nc_depart,"
       ."nc_title,nc_tel,nc_date,nc_email";


/* ��� ��� */
function print_header($title)
{
	echo "
<html>
<head><title>$title</title>
</head>

<body>
	";
	return;
}


/* Location Bar ��� (���� ��ġ) */
function print_location_bar ($location)
{
	global $URL;
	
	echo "
<table align=center border=0 width=700 height=36 cellspacing=0 cellpadding=0>
<tr bgcolor=#F0F0F0><td>
    <font size=2 face=����>&nbsp; <b><a href=\"$URL[home]\" target=\"_top\">
    HOME</a> >> <a href=\"$URL[list]\">���԰���</a> >> $location</b></font>
    </td>
</tr>
</table>
	";
	return;
}


/* �ϴ� ��� */
function print_footer()
{
	echo "
<br>
<center>
<hr size=1 width=90% noshade>
<font size=2>Copyright 2001 by Oh Jung Joon</font>
</BODY>
</HTML>
	";
	return;
}

/* �޼��� ��� */
function print_message ($msg,$location)
{
	print_header($location);
	print_location_bar($location);

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

/* alert �޼��� ��� */
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
	   	$pagelist.="<a href=\"$url&pn=$prev_page\">��</a>\n";
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
	   	$pagelist.="<a href=\"$url&pn=$next_page\">��</a>... \n";
	   	$pagelist.="<a href=\"$url&pn=$page_count\">[$page_count]</a>\n";
	}
	return array($pagelist,$page_count);
}
