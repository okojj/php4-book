#!/usr/bin/perl
#############################################################################
#			Simple Whois			- 2001년 3월 오정준 #
#############################################################################
$|=1;

$whois_server1="whois.networksolutions.com";
$whois_server2="whois.nic.or.kr";

$cgi_url="swhois.cgi";

	&parse_form;

	local(@value);
	
	if (!$FORM{'domain'} && !$FORM{'query'})
	{
		&whois_form;
		exit;
	}

	if ($FORM{'domain'})
	{
		&print_connecting($FORM{'domain'});
		exit;	
	}	

	$fulldomain=uc($FORM{'query'});
	$fulldomain=~ s/ +//g;
	if ($fulldomain =~ '.KR')
	{
		$whois_server=$whois_server2;
	}
	else
	{
		$whois_server=$whois_server1;
	}
	&print_result;
	exit;

sub print_connecting
{
	print "Content-type:text/html;charset=euc-kr\n\n";
	print qq~
<html>
<head>
<meta http-equiv="Refresh" Content="0;url=$cgi_url?query=$_[0]">
<title>조회중입니다. 잠시만 기다리세요...</title>
</head>
<body>
<center>
<br><br><br><br><br>
<font size=2 color=BLUE><b>$_[0]</b> 을 조회중입니다. 잠시만 기다리세요...</font>
</center>
</body>
</html>
~;
	exit;
}
sub print_result
{
	print "Content-type:text/html;charset=euc-kr\n\n";
	print qq~
<html>
<head><title>검색 결과</title></head>
<body>
<center>
<table cellspacing=0 width=500>
<tr><td><pre>
~;
	$query_string=$fulldomain . "\@" . $whois_server;
   	@result=`whois $query_string`;
	print qq~
<form>
<table width=700>
<tr bgcolor=#eaeaea><td><font size=4><b>&nbsp; <a href="http://www.$fulldomain">$fulldomain</a> 검색결과</b></font></td></tr>
<tr><td><pre>
~;
   	foreach $line (@result)
   	{
      	   print $line;
   	}
   	print qq~
	</pre>
    </td>
</tr>
<tr><td align=center><input type=button value="                    Close                    " onclick="window.close();"></td></tr>
</table>   	
<table width=600 align=center>
<tr><td align=center>
    <hr size=1 width=100% noshade>
    <font size=2><b>Tpage Global WHOIS &nbsp; (c)Copyright by Oh, Jungjoon</b><br>
    <hr size=1 noshade>
    </td>
</tr>
</table>
</body></html>
~;

	return;
}

sub whois_form
{
	print "Content-type:text/html\n\n";
	print qq~
<html>
<head>
<title>Tpage Global - Whois</title>
</head>
<body>
<center>
<form action="$cgi_url" method=GET>
<input type=text name="query" size=20>
<input type=submit value=" Search !">
<br>
<font size=2>
입력 예) tpage.co.kr
</font>
</body>
</html>
~;
	exit;	
}


# 파싱
sub parse_form {

	$_ = $ENV{'REQUEST_METHOD'};
	if (/POST/) {
		read(STDIN, $buffer, $ENV{'CONTENT_LENGTH'});
		$ENV{'QUERY_STRING'} = $buffer;
	}
	else {
		$buffer = $ENV{'QUERY_STRING'};
	}
	@pairs = split(/&/, $buffer);
	foreach $pair (@pairs) {
		($name, $value) = split(/=/, $pair);
		$value =~ tr/+/ /;
		$value =~ s/%([a-fA-F0-9][a-fA-F0-9])/pack("C", hex($1))/eg;
		$FORM{$name} = $value;
	}
}
