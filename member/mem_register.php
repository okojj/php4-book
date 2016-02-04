<?php
/*
	회원관리 (회원등록)
	2001.06 by Jungjoon Oh
*/
require("mem-lib.php");
require("db-lib.php");

	if (!$id)
	{
		$errmsg.="* ID를 입력해주세요.\\n";
	}
	elseif (!check_id($id))
	{
		$errmsg.="* 이미 사용중인 ID입니다.\\n";	
	}
	if (!$name )
	{
		$errmsg.="* 성명을 입력해주세요.\\n";
	}
	if (!$idnum1 || !$idnum2 )
	{
		$errmsg.="* 주민등록번호를 입력해주세요.\\n";
	}
	elseif (!check_idnum("$idnum1$idnum2"))
	{
		$errmsg.="* 이미 등록된 주민등록번호입니다.\\n";	
	}

	if ($errmsg)
	{
		$errmsg="- 아래의 사항을 확인하세요\\n\\n" . $errmsg;
		print_alert($errmsg,'back');
	}


	$dbh=dbconnect();

	if ($zip1 && $zip2)
	{
		$zip="$zip1-$zip2";
	}
	

	// Make Query
	$query="insert into member_data "
	."(mem_id,mem_pw,mem_date,mem_name,mem_idnum,mem_email,"
	."mem_url,mem_tel,mem_hp,mem_addr1,mem_addr2,mem_zip) values "
	."('$id','$passwd',sysdate(),'$name','$idnum1-$idnum2','$email',"
	."'$url','$tel','$hp','$addr1','$addr2','$zip')";

	$sth=dbquery($dbh,$query);
	if (!$sth)
	{
		$msg="에러가 발생하였습니다.<br>\n" . mysql_error();
		print_message($msg,"에러");
	}
	else
	{

		$msg="
<table width=500 align=center>
<tr><td><center><b>등록이 완료되었습니다.</b></center><br><br>
    </td>
</tr>
</table>
";
		print_message($msg,"회원등록");
	}

?>	
	   
