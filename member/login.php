<?php
/*
	ȸ������ (�α���)
	2001.06 by Jungjoon Oh
*/
require("mem-lib.php");
require("db-lib.php");


	if (!$url)
	{
		$url=$home_url;
	}

	if ($logout == 1)
	{
		logout($url);
	}
	elseif ($id && $passwd)
	{
		
		login($id,$passwd,$url);
	}
	else
	{
		login_form($url);
	}
	exit;


function logout($url)
{
	/* ��Ű ���� */
	setcookie("MemberID","", time() - 3600);
	
	print_alert("�α׾ƿ��Ǿ����ϴ�.    ","url|$url");
	exit;
}


function login ($id,$passwd,$url)
{
	$dbh = dbconnect();

	$query="select mem_id,mem_pw from member_data where mem_id='$id'";
        $sth=dbquery($dbh,$query);
        if (!$sth)
        {
                print_msg(mysql_error());
        }
        list($mem_id,$mem_pw)=dbselect($sth);
	dbclose($dbh);
	
	if (!$mem_id)
	{
		print_alert("�ش� ID�� �����ϴ�.  ",'back');
	}
	elseif ($mem_pw != $passwd)
	{
		print_alert("��й�ȣ�� Ʋ���ϴ�.  ",'back');
	}
	else
	{
		setcookie("MemberID",$mem_id);
		header("Location: $url");
	}
	return;
}

/* �α��� ȭ�� */
function login_form($url)
{
	echo "
<html>
<head><title>�α���</title></head>

<body>
<br><br><br>
<center>

<form method=POST action=\"login.php\" name=login_form>
<input type=hidden name=url value=\"$url\">
<table cellspacing=0 cellpadding=0 border=0 width=570 bgcolor=#ebebeb>
<tr><td colspan=3 height=10>&nbsp;</td></tr>
<tr>
    <td width=10>&nbsp;</td>
    <td>        <table border=0 width=450 align=center bgcolor=#ebebeb>
	   	<tr> 
        	<td width=450 align=center height=120>
        	<font size=2 color=NAVY>���̵�� ��й�ȣ�� �Է��ϼ���.</font> 
            	<table border=0 width=450 cellpadding=3 cellspacing=0>
                <tr> 
                  <td colspan=3 height=25 align=left>
                </tr>
                <tr> 
			<td width=15>&nbsp;</td>
                	<td width=110 align=right height=35 bgcolor=white><font size=2 color=#FFFFFF> 
                    	<strong><font color=black>����� ID</font>&nbsp;&nbsp;&nbsp;&nbsp; </strong></font></td>
                  	<td width=280 height=35 valign=bottom bgcolor=white>
                    	<input type=text name=id size=15>
                  	</td>
                </tr>
                <tr>
			<td width=15>&nbsp;</td>
                  	<td width=110 align=right height=35 valign=middle bgcolor=white><font size=2 color=#FFFFFF> 
                   		<strong><font color=black>��й�ȣ</font>&nbsp;&nbsp;&nbsp;&nbsp; </strong></font></td>
                  	<td width=280 height=35 valign=top bgcolor=white> 
                    	<input type=password name=passwd size=15>
                    	&nbsp;&nbsp;
                    	<input type=submit value=\"      �α���      \">
                 	</td>
                </tr>
             </table><br>
			</td>
         </tr>
         <tr> 
         	<td width=100%><ul>
                <li><font size=2 color=#003366>ó�����̽��ϱ� ? ���� <a href=register_form.htm>���</a>�ϼ���.</font></li>
                </ul>
            </td>
          </tr>
        </table>

	<script language=JavaScript>
		document.login_form.id.focus();
	</script>
	  
	</td>
	<td width=10>&nbsp;</td>
</tr>
<tr><td colspan=3 height=10>&nbsp;</td></tr>
</table>
</form>

</body>
</html>
";

}

?>
