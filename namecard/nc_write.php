<?php
/*
	���԰��� (���Ե��)
	2001.06 by Jungjoon Oh
*/
require("db-lib.php");
require("nc-lib.php");

	$mem_id=$REMOTE_USER;


	if (!$nc_name)
	{
		$errmsg.="* �̸��� �Է����ּ���\\n";
	}
	if ( strlen($nc_note) > 200 )
	{
		$errmsg.="* ������ �ʹ� ��ϴ�. �ѱ�100�� ���� �Է��ϼ���.\\n";
	}

	if ($errmsg)
	{
		$errmsg="- �Ʒ��� ������ Ȯ���ϼ���\\n\\n" . $errmsg;
		print_alert($errmsg,'back');
	}


	$dbh=dbconnect();

	// Make Query
	$query="insert into namecard "
	."(nc_group,nc_id,nc_date,nc_name,nc_company,"
	."nc_depart,nc_title,nc_tel,nc_fax,nc_hp,nc_email,nc_url,"
	."nc_address,nc_relation,nc_note,nc_pub) values "
	."('$nc_group','$mem_id',sysdate(),'$nc_name','$nc_company',"
	."'$nc_depart','$nc_title','$nc_tel','$nc_fax','$nc_hp','$nc_email',"
	."'$nc_url','$nc_address','$nc_relation','$nc_note','$nc_pub')";

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
<tr><td><center><b>����� �Ϸ�Ǿ����ϴ�.</b></center><br><br>
    </td>
</tr>
<tr><td align=center><font size=2><b>
    <a href=\"$URL[list]\">[���]</a> &nbsp;&nbsp;&nbsp;
    <a href=\"$URL[write_form]\">[��ӵ��]</a> &nbsp;&nbsp;&nbsp;
    <a href=\"javascript:history.back();\">[����ȸ�� ���]</a> 
    </b></font>
    </td>
</tr>
</table>
";
		print_message($msg,"���Ե��");
	}

?>	
	   
