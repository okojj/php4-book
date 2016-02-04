<?php
/*
	회원관리 (우편번호검색)
	2001.06 by Jungjoon Oh
*/
$zipfile="zipcode.db";


	if ($query)
	{
		search($query,$zipfile);
	}
	else
	{
		search_form();
	}


function search($query,$zipfile)
{
	echo "
<html>
<head>
<SCRIPT language=\"JavaScript\">
function Copy(zip1,zip2,address)
{
	// copy
	opener.document.$GLOBALS[form].$GLOBALS[zip1].value = zip1;
	opener.document.$GLOBALS[form].$GLOBALS[zip2].value = zip2;
	opener.document.$GLOBALS[form].$GLOBALS[address].value = address;

	// focus
	opener.document.$GLOBALS[form].$GLOBALS[address].focus();

	// close this window
	this.close();

}
</SCRIPT>
<TITLE>우편번호검색</TITLE>
</head>
<body bgcolor=white text=#000000>
<font size=2>
<center>
<table cellspacing=2 cellpadding=1 width=100%>
<tr align=center BGCOLOR=#6090de><td><font size=2 color=WHITE><b>우편번호</b></font></td><td><font size=2 color=WHITE><b>주 소</b></font></td><td><font size=2 color=WHITE><b>확인</b></font></td></tr>
";

	$query=ereg_replace("-","",$query);
		
	/* DB 파일 열기 */
	$fp=fopen($zipfile,"r");
	
	while ( $line=fgets($fp,1024) )
	{
		if ( preg_match("/$query/",$line) )
		{
			$line=chop($line);
			list($zipcode,$address)=split("\|",$line);
			$zip1=substr($zipcode,0,3);
			$zip2=substr($zipcode,3,3);
			echo "<tr BGCOLOR=#C3E5FF><form><td align=center><font size=2 face=verdana>$zip1-$zip2</font></td>\n";
			echo "<td><font size=2>$address</font></td><td align=center><input type=\"button\" value=\"적용\" onClick=\"Copy('$zip1','$zip2','$address')\"></td></form></tr>\n";
		}
	}
	fclose($fp);

	echo "
</table>
</font>

<hr size=1><center>
<font size=2 color=red><b>검색이 완료되었습니다.</b></font></center>
<hr size=1>
<FORM action=zipcode.php method=post name=zipcode>
<input type=hidden name=mode value=search>

<input type=hidden name=form value=$form>
<input type=hidden name=zip1 value=$zip1>
<input type=hidden name=zip2 value=$zip2>
<input type=hidden name=address value=$address>

<font size=2 color=#404040>* 우편번호나 동/읍/면 이름을 입력하세요.<br>
검색어: <input type=text name=query size=15>
<input type=submit value=\"검색\">
</FORM>
</body>
</html>

";

}


##########################################################################
function search_form()
{

	echo "
<html>
<head>
<SCRIPT language=\"JavaScript\">
</SCRIPT>
<TITLE>우편번호검색</TITLE>
</head>
<body bgcolor=white text=#000000 onLoad=document.zipcode.query.focus()>
<center>
<TABLE Width=400 CelLSpacing=0 CellPadding=6 Border=1 BorderColor=Black>
<TR>
   <TD BGCOLOR=#6090de align=center><Font Size=2 Color=white>
<b>우편번호/주소 검색</b>
   </TD>
</TR>

<TR>
   <TD align=center> <Font Size=2>
   <BR><CENTER>
<FONT SIZE=2>찾고자 하는 주소의 동/읍/면 이름 또는 우편번호를 입력하세요.<br>(예:압구정동/단양읍/수산면/143-200/421200)</FONT>
<hr size=1>
<FORM action=\"zipcode.php\" method=post name=zipcode>
<input type=hidden name=mode value=search>

<input type=hidden name=form value=$GLOBALS[form]>
<input type=hidden name=zip1 value=$GLOBALS[zip1]>
<input type=hidden name=zip2 value=$GLOBALS[zip2]>
<input type=hidden name=address value=$GLOBALS[address]>

<font size=2 color=#404040>
검색어: <input type=text name=query size=15>
<input type=submit value=\"검색\">
</FORM>
      </TD>
   </TR>
   </TABLE>
</center>
</body>
</html>
";

}
