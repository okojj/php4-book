<?php
/*
	회원관리 (회원등록)
	2001.06 by Jungjoon Oh
*/
require("mem-lib.php");
require("db-lib.php");

	
	if ($id)
	{
	    if (strlen($id) < 3)
	    {
	    	print_msg("ID를 3글자 이상 입력해 주세요.",'check_id',-1);
	    }
	    elseif ( check_id($id) )
	    {
	    	print_msg("<font color=RED>$id</font>는 사용 가능합니다.",'check_id',1);
	    }
	    else
	    {
	    	print_msg("<font color=RED>$id</font>는 이미 사용하고 있습니다.",'check_id',2);
	    }
	}
	elseif ($idnum != '-')
	{
	    if ( check_idnum($idnum) )
	    {
	    	print_msg("<font color=RED>$idnum</font>는 사용 가능합니다.",'check_idnum',1);
	    }
	    else
	    {
		print_msg("<font color=RED>$idnum</font>는 이미 등록되어 있습니다.",'check_idnum',2);
	    
	    }
	}
	else {
	   	print_msg("내용을 입력하신 후에 버튼을 누르세요.    ",'check_id','');
	}
	exit;
	

function print_msg($message,$name,$value)
{
	echo "
<html>
<head>
<title>중복 확인</title>
</head>
<body>
<center>
<font color=BLUE size=2><b>$message</b></font>

<form name=f>
<input type=button name=close OnClick='window.close();' value=\" 닫기 \">
</center>

<SCRIPT LANGUAGE=JavaScript>
	document.f.close.focus();
	opener.document.f.$name.value='$value';
</SCRIPT>

</body>
</html>
";
	exit;
}

