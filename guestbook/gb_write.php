<?php
/*
  ���� (���� ���)
  2001.06 by Jungjoon Oh
*/
require("db-lib.php");
require("gb-lib.php");

	if (!$gb_name)
	{
		$errmsg.="* �̸��� �Է����ּ���\\n";
	}
	if (!$gb_note)
	{
		$errmsg.="* ������ �Է��ϼ���.\\n";
	}
	if ( strlen($gb_note) > 1000 )
	{
		$errmsg.="* ������ �ʹ� ��ϴ�. �ѱ�500�� ���� �Է��ϼ���.\\n";
	}

	if ($errmsg)
	{
		$errmsg="- �Ʒ��� ������ Ȯ���ϼ���\\n\\n" . $errmsg;
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
		$msg="������ �߻��Ͽ����ϴ�.\n" . mysql_error();
		print_alert($msg,'back');
	}
	else
	{

		$msg="
<table width=500 align=center>
<tr><td><hr size=1 noshade></td></tr>
<tr><td><center><b>����� �Ϸ�Ǿ����ϴ�.</b></center><br><br>
    </td>
</tr>
<tr><td align=center><font size=2><b>
    <a href=\"$URL[list]\">[������� ���ư���]</a>
    </b></font>
    </td>
</tr>
<tr><td><hr size=1 noshade></td></tr>
</table>
";
		print_message($msg);
	}

?>	
