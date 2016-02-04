<?php
/*
  방명록 (방명록 목록)
  2001.06 by Jungjoon Oh
*/
require("db-lib.php");
require("gb-lib.php");

	if (!isset($pn))
	{
		$pn=1;
	}
	
	$isAdmin=is_admin($PHP_AUTH_USER,$PHP_AUTH_PW);

	/* CONNECT DB */
	$dbh=dbconnect();
	
	$start_num=($pn-1) * $max_list;
	$end_num=$pn * $max_list;

	// 전체 등록수 검색
	$query="select count(gb_index) from guestbook";
	$sth=dbquery($dbh,$query);
	list($total_count)=dbselect($sth);

	// 데이터 $max_list 만큼 뽑아서 출력. 
	$query="select * from guestbook order by gb_index desc "
	."limit $start_num,$max_list";
	
	$sth=dbquery($dbh,$query);

	// 헤더 출력
	print_header();

	list($pagelist,$page_count)=make_page_list("$URL[list]?m=list",$max_list,$total_count,$pn);

	echo "<br><center><font size=2 face=verdana>$pagelist</font></center>";

	$count=$total_count-$start_num;
	while ( $field = dbselect($sth) )
	{
		$gb_index=$field[0];
		$gb_date=$field[1];
		$gb_ip=$field[2];
		$gb_name=$field[3];
		$gb_email=$field[4];
		$gb_location=$field[5];
		$gb_url=$field[6];
		$gb_note=nl2br($field[7]);
		if ($isAdmin==1)
		{
			$delete_link="[<a href=\"$URL[delete]?idx=$gb_index\""
			." onClick=\"return confirm('정말로 삭제하시겠습니까 ?')\">삭제</a>]";
		}
		echo "
<table border=0 width=500 align=center cellspacing=2 cellpadding=6>
<tr><td><font size=2>No. <font color=RED>$count</font>
    </font></td>
    <td align=right><font size=2>$delete_link</font></td>
</tr>
<tr><td bgcolor=#B3D9FF align=right width=100><font size=2>
    <b>이름</b> &nbsp;</font></td>
    <td bgcolor=#D0F0FF width=400><font size=2>$gb_name</font></td>
</tr>
<tr><td bgcolor=#B3D9FF align=right><font size=2>
    <b>날짜</b> &nbsp;</font></td>
    <td bgcolor=#D0F0FF><font size=2>$gb_date</font></td>
</tr>
<tr><td bgcolor=#B3D9FF align=right><font size=2>
    <b>E-Mail</b> &nbsp;</font></td>
    <td bgcolor=#D0F0FF><font size=2><a href=\"mailto:$gb_email\">
    $gb_email</a></font></td>
</tr>
<tr><td bgcolor=#B3D9FF align=right><font size=2>
    <b>사는곳</b> &nbsp;</font></td>
    <td bgcolor=#D0F0FF><font size=2>$gb_location</font></td>
</tr>
<tr><td bgcolor=#B3D9FF align=right><font size=2>
    <b>홈페이지</b> &nbsp;</font></td>
    <td bgcolor=#D0F0FF><font size=2><a href=\"$gb_url\">
    $gb_url</a></font></td>
</tr>
<tr><td bgcolor=#B3D9FF align=right><font size=2>
    <b>한마디</b> &nbsp;</font></td>
    <td bgcolor=#D0F0FF><font size=2>$gb_note</font></td>
</tr>
<tr><td colspan=2 align=right><font size=1 face=verdana>
    IP:$gb_ip</font>
    </td>
</tr>
</table>
<br>
";

		$count--;
	}

	dbclose($dbh);

	echo "<center><font size=2 face=verdana>$pagelist</font></center><br>";

	print_footer();
?>
