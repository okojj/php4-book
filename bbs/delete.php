<?php
/*
	�Խ��� (�ۻ���)
	2001.06 by Jungjoon Oh
*/

require("db-lib.php");
require("bbs-lib.php");

	if (!$db)
	{
		print_alert("DB�� �����ϼž� �մϴ�.",'back');
		exit;
	}
	/* �۹�ȣ ���� ���� */
	if (!$idx || !$rn)
	{
		header("Location: $URL[list]\n\n");
		exit;
	}
	/* ��й�ȣ �Է��� */
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

	/* Table �̸� ���� */
	$table_name="bbs_" . $db;

	/* ����Ÿ �������� */
	$dbh=dbconnect();
	$query="select idx,passwd,filename from $table_name where idx=$idx and replynum=$rn";
	$sth=dbquery($dbh,$query);
	if (!$sth)
	{
		print_alert(mysql_error(),'back');
	}
	
	list($d_idx,$d_passwd,$d_filename)=dbselect($sth);

	/* �������� ������ */
	if (!$idx)
	{
		print_alert("�����Ͱ� �������� �ʽ��ϴ�.",'stop');
	}
	elseif ( ($passwd != $d_passwd) && $passwd != $admin_passwd )
	{
		print_alert("��й�ȣ�� ��ġ���� �ʽ��ϴ�.   ",'back');
	}
	
	/* ���� ��� ���� Ȯ�� */
	if ($d_filename)
	{
		unlink("$upload_path/$db/$d_filename");
	}
	
	/* �� ���� */
	$query="delete from $table_name where idx=$idx";

	/* ù��° ���� �ƴѰ�� */
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
		print_alert("������ �Ϸ�Ǿ����ϴ�.   ","opener|$url");
	}		
	exit;


function passwd_form($db,$idx,$rn,$back_url)
{
	global $URL;
	
	echo "
<html>
<head><title>��й�ȣ Ȯ��</title>
<script language=JavaScript>
function check_form()
{
	if (document.pwform.passwd.value =='')
	{
		alert('��й�ȣ�� �Է��ϼ���.    ');
		return false;
	}
	return true;
}
</script>
</head>

<body onLoad='document.pwform.passwd.focus();'>
<center>
<font size=2 color=NAVY>�� �ۼ��� �Է��ߴ� ��й�ȣ�� �Է��ϼ���.</font>
<form method=POST name=pwform action='$URL[delete]' onSubmit='return check_form();'>
<input type=hidden name=db value='$db'>
<input type=hidden name=idx value='$idx'>
<input type=hidden name=rn value='$rn'>
<input type=hidden name=url value='$back_url'>
<TABLE BORDER=0 CELLPADDING=1 CELLSPACING=1 WIDTH=300>
<TR><TD ALIGN=center VALIGN=middle>
    <FONT SIZE=2><B>��й�ȣ</B></FONT> 
    <INPUT TYPE=password NAME=passwd SIZE=15 MAXLENGTH=10>
    </TD>
</TR>
<TR><TD>&nbsp;</TD></TR>
<TR><TD ALIGN=center VALIGN=middle>
    <INPUT TYPE=submit VALUE=' �����ϱ� '>
    <INPUT TYPE=button NAME=exitBtn VALUE=' ��� '><br><br>
    <font size=2 color=RED>���� : �亯�� �ִ� ���� �亯���� ��� �������ϴ�.</font>
    </TD>
</TR>
</TABLE>
</body>
</html>
";

}

?>
