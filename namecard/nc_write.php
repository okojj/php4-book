<?php
/*
	명함관리 (명함등록)
	2001.06 by Jungjoon Oh
*/
require("db-lib.php");
require("nc-lib.php");

	$mem_id=$REMOTE_USER;


	if (!$nc_name)
	{
		$errmsg.="* 이름을 입력해주세요\\n";
	}
	if ( strlen($nc_note) > 200 )
	{
		$errmsg.="* 설명이 너무 깁니다. 한글100자 내로 입력하세요.\\n";
	}

	if ($errmsg)
	{
		$errmsg="- 아래의 사항을 확인하세요\\n\\n" . $errmsg;
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
		$msg="에러가 발생하였습니다.\n" . mysql_error();
		print_alert($msg,'back');
	}
	else
	{

		$msg="
<table width=500 align=center>
<tr><td><center><b>등록이 완료되었습니다.</b></center><br><br>
    </td>
</tr>
<tr><td align=center><font size=2><b>
    <a href=\"$URL[list]\">[목록]</a> &nbsp;&nbsp;&nbsp;
    <a href=\"$URL[write_form]\">[계속등록]</a> &nbsp;&nbsp;&nbsp;
    <a href=\"javascript:history.back();\">[같은회사 등록]</a> 
    </b></font>
    </td>
</tr>
</table>
";
		print_message($msg,"명함등록");
	}

?>	
	   
