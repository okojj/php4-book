<?php
/*
  방명록 (방명록 등록)
  2001.06 by Jungjoon Oh
*/
require("db-lib.php");
require("gb-lib.php");

	if (!$gb_name)
	{
		$errmsg.="* 이름을 입력해주세요\\n";
	}
	if (!$gb_note)
	{
		$errmsg.="* 내용을 입력하세요.\\n";
	}
	if ( strlen($gb_note) > 1000 )
	{
		$errmsg.="* 내용이 너무 깁니다. 한글500자 내로 입력하세요.\\n";
	}

	if ($errmsg)
	{
		$errmsg="- 아래의 사항을 확인하세요\\n\\n" . $errmsg;
		print_alert($errmsg,'back');
	}

	$dbh=dbconnect();

	// Make Query
	$query="insert into guestbook "
	."(gb_date,gb_ip,gb_name,gb_email,gb_location,gb_url,gb_note) "
	."values (sysdate(),'$REMOTE_ADDR','$gb_name','$gb_email',"
	."'$gb_location','$gb_url','$gb_note')";

	$sth=dbquery($dbh,$query);
	if (!$sth)
	{
		$msg="에러가 발생하였습니다.\n" . mysql_error();
		print_alert($msg,'back');
	}
	else
	{

		$msg="
<table width=500 align=center>
<tr><td><hr size=1 noshade></td></tr>
<tr><td><center><b>등록이 완료되었습니다.</b></center><br><br>
    </td>
</tr>
<tr><td align=center><font size=2><b>
    <a href=\"$URL[list]\">[목록으로 돌아가기]</a>
    </b></font>
    </td>
</tr>
<tr><td><hr size=1 noshade></td></tr>
</table>
";
		print_message($msg);
	}

?>	
