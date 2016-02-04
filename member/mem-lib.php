<?php
/*
	회원관리
	2001.06 by Jungjoon Oh
*/

$home_url="http://www.ojj.pe.kr";

/* id 중복 검사 */
function check_id($id)
{
	if ( !preg_match("/^[0-9A-Za-z]*$/",$id) )
	{
		print_msg("영문과 숫자로만 입력하세요",'check_id',-1);
	}

	$dbh = dbconnect();
	
	$query="select mem_id from member_data where mem_id='$id'";
        $sth=dbquery($dbh,$query);
        if (!$sth)
        {
                print_msg(mysql_error());
        }
        list($mem_id)=dbselect($sth);
	dbclose($dbh);
	
	if ($mem_id == $id)
	{
		return false;
	}
	else
	{
		return true;
	}
}

/* 주민번호 중복 검사 */
function check_idnum($idnum)
{
	if ( !check_idnum_syntax($idnum) )
	{
		print_msg("주민등록가 잘못되었습니다.<br>정확히 입력하세요.",'check_idnum',-1);
	}

	$dbh = dbconnect();
	$idnum2=substr($idnum,0,6) . "-" . substr($idnum,6,7);
	$query="select mem_idnum from member_data where mem_idnum='$idnum2'";
        $sth=dbquery($dbh,$query);
        if (!$sth)
        {
                print_msg(mysql_error());
        }
        list($mem_idnum)=dbselect($sth);
	dbclose($dbh);
	
	if ($mem_idnum == $idnum2)
	{
		return false;
	}
	else
	{
		return true;
	}
}


function check_idnum_syntax($idnum)
{ 
	$checknum = "234567892345"; 

	for ($i=0; $i<12 ;$i++)
	{ 
		$sum = $sum + (substr($idnum,$i,1) * substr($checknum,$i,1));
	}

	$checknum2 = 11 - ($sum % 11); 
	$gender=substr($idnum,6,1);
	if ($gender!='1' && $gender!='2' && $gender!='3' && $gender!='4')
	{
		return false;
	}

	if (substr($idnum, -1,1) == substr($checknum2,-1,1)) 
	{ 
		return true;
	}
	else
	{	
		return false;
	}
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

function print_message($message,$title)
{
	echo "
<html>
<head>
<title>$title</title>
</head>
<body>
<center>
<table border=0 width=85% height=90%>
<tr><td align=center bgcolor=#DDDDDD>
    <font color=BLUE size=2><b>$message</b></font>
    </td>
</tr>
</table>
</body>
</html>
";
	exit;
}

