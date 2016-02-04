<html>
<head><title>WHOIS Gateway</title></head>
<body>
<center>
<font size=4 face=verdana color=NAVY>PHP WHOIS Gateway</font>
<br><br>
<form action="whois.php" method=GET>
<table width=400>
<tr><td align=center><font size=2 color=NAVY>도메인 / IP :  
	<input type=text name=query size=15>
	<input type=submit value="    검색    ">
    </font>
    <br><br>
    </td>
</tr>
<tr><td><font size=2 color=NAVY><ul>
	<li>ojj.co.kr 또는 ojj.com 과 같이 www는 입력하지 마세요.
	<li>현재는 .kr도메인과 .com 도메인만 조회가 가능합니다.
	<li>국내 IP도 조회할수 있습니다. (예, 123.123.234.222)
	</ul>
	</font>
    </td>
</tr>

</table>
</form>

<?php

/*
	Whois Gateway
	2001.06 by Jungjoon Oh
*/

$whois_server1="whois.networksolutions.com";
$whois_server2="whois.nic.or.kr";


	if ($query)
	{
		search_whois($query);
	}


function search_whois ($query)
{
	
	if ( eregi(".com$",$query) || eregi(".net$",$query) 
	     || eregi(".org$",$query))
	{
		$server=$GLOBALS[whois_server1];
	}
	else
	{
		$server=$GLOBALS[whois_server2];
	}
	$fp = fsockopen($server, 43, &$errno, &$errstr);
	if(!$fp)
	{
		print_message("WHOIS 서버에 접속할수가 없습니다. 잠시후 다시 시도하세요");
		return;
	}

	set_socket_blocking($fp, 1);
	fputs($fp,"$query\n");
	
	while ($buf=fgets($fp,255))
	{
		$result.=$buf;
	}

	fclose($fp);
	
	echo "
<table cellspacing=0 width=600>
<tr bgcolor=#eaeaea><td height=30><font size=3><b>&nbsp; 검색결과 - 
    <a href=\"http://$query\" target=_new>$query</a></b></font></td></tr>
<tr><td><br>
	<pre>$result</pre>
    </td>
</tr>
</table>   	
";
}


/* 메세지 출력 */
function print_message ($msg)
{
	echo "
<table height=300>
<tr><td align=center><font color=NAVY><b>
    $msg
    </b></font>
    </td>
</tr>
</table>
	";
}

?>

<table width=600 align=center>
<tr><td align=center>
    <hr size=1 width=100% noshade>
    <font size=2><b>PHP WHOIS &nbsp; (c)Copyright by Oh, Jungjoon</b><br>
    <hr size=1 noshade>
    </td>
</tr>
</table>

</body>
</html>
