<?php
/*
	ȸ������ (ȸ�����)
	2001.06 by Jungjoon Oh
*/
require("mem-lib.php");
require("db-lib.php");

	
	if ($id)
	{
	    if (strlen($id) < 3)
	    {
	    	print_msg("ID�� 3���� �̻� �Է��� �ּ���.",'check_id',-1);
	    }
	    elseif ( check_id($id) )
	    {
	    	print_msg("<font color=RED>$id</font>�� ��� �����մϴ�.",'check_id',1);
	    }
	    else
	    {
	    	print_msg("<font color=RED>$id</font>�� �̹� ����ϰ� �ֽ��ϴ�.",'check_id',2);
	    }
	}
	elseif ($idnum != '-')
	{
	    if ( check_idnum($idnum) )
	    {
	    	print_msg("<font color=RED>$idnum</font>�� ��� �����մϴ�.",'check_idnum',1);
	    }
	    else
	    {
		print_msg("<font color=RED>$idnum</font>�� �̹� ��ϵǾ� �ֽ��ϴ�.",'check_idnum',2);
	    
	    }
	}
	else {
	   	print_msg("������ �Է��Ͻ� �Ŀ� ��ư�� ��������.    ",'check_id','');
	}
	exit;
	

function print_msg($message,$name,$value)
{
	echo "
<html>
<head>
<title>�ߺ� Ȯ��</title>
</head>
<body>
<center>
<font color=BLUE size=2><b>$message</b></font>

<form name=f>
<input type=button name=close OnClick='window.close();' value=\" �ݱ� \">
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

